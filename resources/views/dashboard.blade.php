@extends('layouts.master')

@section('title')
	Dashboard
@endsection

@section('content')
	@include('includes.message-block')

	<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs nav-justified" role="tablist">
		    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/reload.png"></a></li>
		    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/avatar.png"></a></li>
		    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/chat-1.png"></a></li>
		    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/settings.png"></a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="home">
		    	<section class="new-post">
					<form action="{{ route('post.create') }}" method="post">
						<div class="form-group">
							<textarea class="form-control" name="body" id="new-post" rows="3" placeholder="Your Post"></textarea>
						</div>
						<button type="submit" class="btn btn-danger">Create Post</button>
						<input type="hidden" name="_token" value="{{ Session::token() }}">
					</form>
				</section>

				<section class="posts" id="posts">
							<header><h3>What other people say ...</h3></header>
							@foreach($posts as $post)
								<article style="padding-bottom: 5px;" class="panel panel-danger post" data-postid="{{ $post['id'] }}">
									<header style="padding-top: 10px;">
										@if(file_exists(public_path() . "/uploads/" . auth()->user()->username . '-' .  auth()->user()->id . '.jpg') == null)
											<img stylze="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/nobody.jpg" alt="">
										@else
				                        	<img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/{{ $post['username'] . '-' . $post['user_id'] . '.jpg' }}" alt="">
				                        @endif

				                        <a style="padding-left: 10px; font-size: 18px; font-style: bold; font-family: sans-serif; color: #CE433F;" href="#">{{ $post['username'] }}</a>
				                    </header>
				                    <p>{{ $post['body'] }}</p>
									<div class="info">

										<p class="like_count">{{$post['like_count']}} Like</p>
										Posted by {{$post['username']}} on {{$post['created_at']}}
										<i class="glyphicon glyphicon-pencil"></i>
									</div>

									<div class="interaction">
										<a class="like" role="button">
										{{ ($post['is_liked']) ? 'Unlike' : 'Like' }}
										</a>
										@if(auth()->user()->id == $post['user_id'])
											<a style="padding: 10px;" class="edit" href="#"><img width="15px" height="15px" src="/src/icons/edit.png"></a>

											<a href="{{ route('post.delete', ['post_id' => $post['id']]) }}"><img width="15px" height="15px" src="/src/icons/cancel.png"></a>
										@endif

										<form style="padding-top: 10px;" action="{{ route('comment.create') }}" method="post">
											<input class="comment form-control" style="padding-left: 5px; width: 337px;" type="text" name="comment_body" id="comment_body" placeholder="Post comment">
										</form>
									</div>

									@foreach($comments as $comment)
										<p>{{ $comment['comment_body'] }}</p>
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
		    <div role="tabpanel" class="tab-pane" id="profile">
		    	<div class="text-center">
		    		<h2></h2>
                    <p>
                    	@if(file_exists(public_path() . "/uploads/" . auth()->user()->username . '-' .  auth()->user()->id . '.jpg') == null)
                    		<img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/nobody.jpg" alt="">
                        @else
                        	<img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/{{ auth()->user()->username . '-' . auth()->user()->id . '.jpg' }}" alt="">
                        @endif
                    </p>
                    <h3>{{ auth()->user()->username }}</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec enim sapien. Aliquam erat volutpat.
                    </p>
                </div>
		    </div>


		    <div role="tabpanel" class="tab-pane" id="messages">...</div>
		    <div role="tabpanel" class="tab-pane" id="settings">...</div>
		  </div>

	</div>

	<script type="text/javascript">
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('edit') }}';
		var urlLike = '{{ route('like') }}';
	</script>
@endsection