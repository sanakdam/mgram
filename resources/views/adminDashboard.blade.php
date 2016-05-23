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
		    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/avatar.png"></a></li>
		    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/chat-1.png"></a></li>
		    <li role="presentation"><a href="#heart" aria-controls="heart" role="tab" data-toggle="tab"><img width="20px" height="20px" src="/src/icons/heart.png"></a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="home">

		    <div role="tabpanel" class="tab-pane" id="profile">

		    </div>


		    <div role="tabpanel" class="tab-pane" id="messages">...</div>
		    <div role="tabpanel" class="tab-pane" id="heart">
		    </div>
		  </div>

	</div>
@endsection