@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    @include('includes.message-block')
    <div class="panel">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group">
                    <label class="sr-only" for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" placeholder="Username" value="{{Request::old('username')}}" required>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password" {{Request::old('password')}} required>
                </div>
                <button type="submit" class="btn btn-danger">Signin</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>

            <h3>Sign Up</h3>
            <form action="{{ route('signup') }}" method="post">
                <div class="form-group">
                    <label class="sr-only" for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" placeholder="Username" value="{{ Request::old('username') }}" required>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="Email" value="{{ Request::old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password" value="{{ Request::old('password') }}" required>
                </div>
                <button type="submit" class="btn btn-danger">Signup</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
    </div>
@endsection