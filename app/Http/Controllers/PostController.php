<?php
namespace App\Http\Controllers;
use App\Like;
use App\Post;
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
				'is_liked' => $post->is_liked(),
				'user_id' => $post->user_id,
				'like_count' => $post->like_count(),
			];
		});
		return view('dashboard', ['posts' => $posts]);
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

	public function postLikePost(Request $request) {
		$post_id = $request['postId'];
		$post = Post::find($post_id);

		if ($post->is_liked()) {
			return null;
		}

		$like = Like::Create([
			'post_id' => $post_id,
			'user_id' => auth()->user()->id,
			'like' => '1',
		]);

		$post = Post::find($post_id);

		return json_encode(['like_count' => $post->like_count()]);
	}

	public function postUnlikePost(Request $request) {
		$post_id = $request['postId'];

		$like = Like::where('post_id', $post_id)
			->where('user_id', auth()->user()->id)
			->first();

		$like->delete();

		$post = Post::find($like->post_id);

		return json_encode(['like_count' => $post->like_count()]);
	}

}
?>