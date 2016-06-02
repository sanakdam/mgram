<?php
namespace App\Http\Controllers;
use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
	public function postCreatePost(Request $request) {
		$this->validate($request, [
			'body' => 'max:1000',
		]);

		$user = Auth::user();
		$post = new Post();
		$post->body = $request['body'];

		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$post->image = $user->username . '-' . $file->getClientOriginalName() . '.jpg';
			$file->move('posts', $post->image);
		}

		$message = 'There was an error';
		if ($request->user()->posts()->save($post)) {
			$message = 'Post successfully created';
		}
		return redirect()->route('dashboard')->with(['message' => $message]);
	}

	public function getDashboard() {
		$user = Auth::user();
		$posts = Post::whereIn('user_id', $user->getDashboardPostIds())->get();
		return view('dashboard', compact('posts'));
	}

	public function getAdminDashboard() {
		return view('adminDashboard');
	}

	public function getDeletePost($post_id) {
		$post = Post::where('id', $post_id)->first();
		$post->delete();
		return redirect()->back()->with(['message' => 'Successfully deleted!']);
	}

	public function postEditPost(Request $request) {
		$this->validate($request, [
			'body' => 'required',
		]);
		$post = Post::find($request['postId']);
		if (Auth::user() != $post->user) {
			return redirect()->back();
		}
		$post->body = $request['body'];
		$post->update();
		return response()->json(['new_body' => $post->body], 200);
	}

	public function toggleLike(Request $request) {
		$post = Post::find($request->get('postId'));

		$action = 'Like';
		if ($post->isLiked()) {
			$post->likes()->detach(auth()->user()->id);
		} else {
			$post->likes()->attach(auth()->user()->id);
			$action = 'Unlike';
		}

		return json_encode([
			'like_count' => $post->likes()->count(),
			'action_text' => $action,
		]);
	}

	public function postCommentPost(Request $request) {
		$this->validate($request, [
			'comment_body' => 'required',
		]);

		Comment::create([
			'post_id' => $request->get('postId'),
			'comment_body' => $request->get('comment_body'),
			'user_id' => auth()->user()->id,
		]);

		return redirect()->route('dashboard');
	}

	public function report(Request $request) {
		$user = auth()->user();
		$report = new Report($request->except(['_token']));
		$user->reports()->save($report);
		return redirect()->back();
	}
}
?>