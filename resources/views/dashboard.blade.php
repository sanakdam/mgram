@extends('layouts.master')

@section('title')
	Dashboard
@endsection

@section('content')
	@include('includes.message-block')

	<div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-justified" role="tablist">
			<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/house.png"></a></li>
			<li role="presentation"><a href="#uploads" aria-controls="uploads" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/upload.png"></a></li>
			<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/chat-1.png"></a></li>
			<li role="presentation"><a href="#heart" aria-controls="heart" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/heart.png"></a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home">
				<section class="posts" id="posts">
					<header><h3>What other people say ...</h3></header>
					@foreach($posts as $post)
						<article style="padding-bottom: 5px;" class="panel panel-danger post" data-postid="{{ $post->id }}">
							<header style="padding-top: 10px;">
								@if(file_exists(public_path() . "/uploads/" . $post->user->username . '-' .  $post->user->id . '.jpg') == null)
									<img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/nobody.jpg" alt="">
								@else
									<img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/{{ $post->user->username . '-' .  $post->user->id . '.jpg' }}" alt="">
								@endif

								<a style="padding-left: 10px; font-size: 18px; font-style: bold; font-family: sans-serif; color: #CE433F;" href="{{ route('profile', ['username' => $post->user->username]) }}"> {{ $post->user->username }} </a>
							</header>
							@if(file_exists(public_path() . "/posts/" . $post->image))
								<img class="img-responsive" src="/posts/{{ $post->image }}" alt="">
							@endif
							<p>{{ $post['body'] }}</p>
							<div class="info">
								<p class="like_count">{{ $post->like_count }} Like</p>
								Posted by {{ $post->user->username }} on {{ $post->created_at }}
							</div>

							<div class="interaction">
								<a style="color: #CE433F" class="like" role="button">
									{{ ($post->is_liked) ? 'Unlike' : 'Like' }}
								</a>
								@if(auth()->user()->id == $post->user_id)
									<a style="padding: 10px;" class="edit" href="#"><img width="15px" height="15px" src="/src/icons/edit.png"></a>

									<a href="{{ route('post.delete', ['post_id' => $post->id]) }}"><img width="15px" height="15px" src="/src/icons/cancel.png"></a>
								@endif

								<form style="padding-top: 10px;" action="{{ route('comment.create') }}" method="post">
									<input type="hidden" name="postId" value="{{ $post->id }}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									<input class="comment form-control" style="padding-left: 5px; width: 337px;" type="text" name="comment_body" id="comment_body" placeholder="Post comment">
								</form>
							</div>

							@foreach($post->comments as $comment)
									<p><a href="#profile">{{ $post->user->username  }}</a> {{$comment['comment_body'] }}</p>
							@endforeach
						</article>
					@endforeach
				</section>

				<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Edit Post</h4>
							</div>
							<div class="modal-body">
								<form>
									<div class="form-group">
										<label for="post-body">Edit the Post</label>
										<textarea class="form-control" name="post-body" id="post-body" rows="5" placeholder="Your Post"></textarea>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-danger" id="modal-save">Save changes</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>

			<div role="tabpanel" class="tab-pane" id="uploads">
				<section class="new-post">
					<form action="{{ route('post.create') }}" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<textarea name="body" id="body" placeholder="Your Post"></textarea>
						</div>
						<div class="form-group">
							<label for="image">Image (only.jpg)</label>
							<input type="file" name="image" class="form-control" id="image">
						</div>
						<button type="submit" class="btn btn-danger">Create Post</button>
						<input type="hidden" name="_token" value="{{ Session::token() }}">
					</form>
				</section>
			</div>
			<div role="tabpanel" class="tab-pane" id="messages">
				Report + message
			</div>
			<div role="tabpanel" class="tab-pane" id="heart">
				Menampilkan siapa saja yang ngelike postingan
			</div>
		</div>

	</div>

	<script type="text/javascript">
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('edit') }}';
		var urlLike = '{{ route('like') }}';
	</script>
@endsection