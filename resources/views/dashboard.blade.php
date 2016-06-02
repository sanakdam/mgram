@extends('layouts.master')

@section('title')
	Dashboard
@endsection

@section('content')
	<section class="posts" id="posts">
		<header><h3></h3></header>
		@foreach($posts as $post)
			<article class="panel-primary post" data-postid="{{ $post->id }}">
				<div class="panel-heading">
					@if(file_exists(public_path() . "/uploads/" . $post->user->username . '-' .  $post->user->id . '.jpg') == null)
						<img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/nobody.jpg" alt="">
					@else
						<img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/{{ $post->user->username . '-' .  $post->user->id . '.jpg' }}" alt="">
					@endif

					<a style="padding-left: 10px; font-size: 18px; font-style: bold; font-family: sans-serif; color: white" href="{{ route('profile', ['username' => $post->user->username]) }}"> {{ $post->user->username }} </a>
				</div>

				<div class="panel panel-footer">
					@if($post->image)
						<img class="img-responsive" src="/posts/{{ $post->image }}" alt="">
					@else
						<p></p>
					@endif
					<p>{{ $post->body }}</p>
					<div class="info">
						<p class="like_count">{{ $post->likes()->count() }} Like</p>
						Posted on {{ $post->created_at }}
					</div>

					<div class="interaction">
						<table class="table">
							<thead>
								@if($post->is_liked)
									<th><a href="{{ route('like') }}"><i class="fa fa-heart-o" aria-hidden="true"></i> Unlike</a></th>
								@else
									<th><a href="{{ route('like') }}"><i class="fa fa-heart" aria-hidden="true"></i> Unlike</a></th>
								@endif

								@if(auth()->user()->id == $post->user_id)
									<th><a class="edit" href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></th>
									<th><a href="{{ route('post.delete', ['post_id' => $post->id]) }}"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></th>
								@endif
									<th><a class="report" data-id="{{ $post->id }}" href="#"><i class="fa fa-flag" aria-hidden="true"></i> Report</a></th>
							</thead>
						</table>



						<form action="{{ route('comment.create') }}" method="post">
							<div class="form-group">
								<input type="hidden" name="postId" value="{{ $post->id }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<input class="form-control" type="text" name="comment_body" id="comment_body" placeholder="Post comment">
							</div>
						</form>
					</div>

					@foreach($post->comments as $comment)
						<p><a href="{{ route('profile', ['username' => $comment->user->username]) }}">{{ $comment->user->username  }}</a> {{$comment['comment_body'] }}</p>
					@endforeach
				</div>
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

	<div class="modal fade" tabindex="-1" role="dialog" id="report-modal">
		<div class="modal-dialog">
			<form class="modal-content" method="post" id="report-form" action="{{ url('report') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Report Post</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="post-body">Report the Post</label>
						<textarea class="form-control" name="reason" rows="5" placeholder="Reason"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Report</button>
				</div>
			</form><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script type="text/javascript">
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('edit') }}';
		var urlLike = '{{ route('like') }}';
	</script>
@endsection