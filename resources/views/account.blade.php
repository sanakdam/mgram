@extends('layouts.master')

@section('title')
	Account
@endsection

@section('content')
	<section class="new-post">
			<header><h3>Your Account</h3></header>
			<form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" name="username" class="form-control" id="username" placeholder="Username" value="{{ $user->username }}">
				</div>
				<div class="form-group">
					<input type="text" name="full_name" class="form-control" id="full_name" placeholder="Full name" value="{{ $user->full_name }}">
				</div>
				 <div class="form-group">
			        <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Date of Birth" value="{{ $user->birth_date }}">
			    </div>
				<div class="form-group">
					<input type="text" name="site" class="form-control" id="site" placeholder="Sites" value="{{ $user->site }}">
				</div>
				<div class="form-group">
					<input type="text" name="bio" class="form-control" id="bio" placeholder="Your bio" value="{{ $user->bio }}">
				</div>
				<div class="form-group">
					<label for="image">Image (only.jpg)</label>
					<input type="file" name="image" class="form-control" id="image">
				</div>
				<button type="submit" class="btn btn-danger">Save Account</button>
				<input type="hidden" value="{{ Session::token() }}" name="_token">
			</form>
	</section>

		<div class="text-center">
			<br>
			@if(file_exists(public_path() . "/uploads/" . $user->username . '-' .  $user->id . '.jpg') == null)
	            <img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/nobody.jpg" alt="">
	        @else
				<img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/{{ $user->username . '-' . $user->id . '.jpg' }}" alt="">
	        @endif


	        		<h1>{{ $user->full_name }}</h1>
	        		<h4>{{ $user->birth_date }}</h4>
		        	<h4><a style="color: #CE433F;" href="{{ $user->site }}"> {{ $user->site }} </a></h4>
		        	<h4>{{ $user->bio }}</h4>
		</div>
@endsection