@extends('layouts.master')

@section('title')
	Dashboard
@endsection

@section('content')
	@include('includes.message-block')
	<section class="new-post">
			<header><h3>What do you have to say?</h3></header>
			<form action="{{ route('post.create') }}" method="post">
				<div class="form-group">
					<textarea class="form-control" name="body" id="new-post" rows="3" placeholder="Your Post"></textarea>
					<input type="file" name="image" class="form-control" id="image">
					<button type="submit" class="btn btn-danger">Create Post</button>
				</div>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
	</section>

	<section class="posts">
				<header><h3>What other people say ...</h3></header>
				@foreach($posts as $post)
					<article class="panel panel-default post" data-postid="{{ $post['id'] }}">
						<p>{{ $post['body'] }}</p>
						<div class="info">

							<p class="like_count">{{$post['like_count']}} Like</p>
							Posted by {{$post['username']}} on {{$post['created_at']}}

						</div>

						<div class="interaction">
							<a class="like" role="button">
							{{ ($post['is_liked']) ? 'Unlike' : 'Like' }}
							</a>
							@if(auth()->user()->id == $post['user_id'])
								|
								<a class="edit" href="#">Edit</a> |
								<a href="{{ route('post.delete', ['post_id' => $post['id']]) }}">Delete</a>
							@endif
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
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-danger" id="modal-save">Save changes</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script type="text/javascript">
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('edit') }}';
		var urlLike = '{{ route('like') }}';
		var urlUnlike = '{{ route('unlike') }}';
	</script>
@endsection