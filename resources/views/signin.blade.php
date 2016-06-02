@extends('layouts.master')

@section('title')
    SignIn
@endsection

@section('content')
    <div class="panel">
        <div class="panel-body">
            <h3>Sign In</h3>
            <form role="form" action="{{ route('userSignup') }}" method="post">

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label class="sr-only" for="username">Username</label>

                    <div>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}">

                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="sr-only" for="password">Password</label>

                    <input class="form-control" type="password" name="password" id="password" placeholder="Password">

                    <div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> SignIn
                    </button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </div>
            </form>
        </div>
    </div>
@endsection