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
			'body' => 'required|max:1000',
		]);
		$post = new Post();
		$post->body = $request['body'];
		$message = 'There was an error';
		if ($request->user()->posts()->save($post)) {
			$message = 'Post successfully created';
		}

		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$filename = $post->user()->username . '-' . $post->id . '.jpg';

			$file->move('posts', $filename);

		}

		return redirect()->route('dashboard')->with(['message' => $message]);
	}

	public function getDashboard() {
		$list = Post::orderBy('created_at', 'desc')->get();
		$posts = $list->map(function ($post) {
			return [
				'id' => $post->id,
				'body' => $post->body,
				'username' => $post->user->username,
				'created_at' => $post->created_at,
				'is_liked' => $post->isLiked(),
				'comment_body' => $post->comment(),
				'user_id' => $post->user_id,
				'like_count' => $post->likes()->count(),
			];
		});

		$listcomment = Comment::orderBy('created_at', 'asc')->get();
		$comments = $listcomment->map(function ($comment) {
			return [
				'id' => $comment->id,
				'comment_body' => $comment->comment_body,
				'user_id' => $comment->user_id,
				'post_id' => $comment->post_id,
				'created_at' => $comment->created_at,
			];
		});
		return view('dashboard', ['posts' => $posts, 'comments' => $comments]);
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

		$comment = Comment::create([
			'post_id' => $request->get('postId'),
			'comment_body' => $request->get('comment_body'),
			'user_id' => auth()->user()->id,
		]);
		return redirect()->route('dashboard');
	}
}
?>