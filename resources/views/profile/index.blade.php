@extends('layouts.master')

@section('content')
    <div class="text-center">
        <h2>{{ $user->username }}</h2>
        <p>
            @if(file_exists(public_path() . "/uploads/" . auth()->user()->username . '-' .  auth()->user()->id . '.jpg') == null)
                <img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/nobody.jpg" alt="">
            @else
                <img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/{{ auth()->user()->username . '-' . auth()->user()->id . '.jpg' }}" alt="">
            @endif
        </p>

        <a href="{{ url('/follow/' . $user->id) }}" class="btn btn-primary">
            {{ $user->isFollowed() ? 'Unfollow' : 'Follow' }}
        </a>
        <h1>{{ auth()->user()->full_name }}</h1>
        <h4>{{ auth()->user()->birth_date }}</h4>
        <h4><a style="color: #CE433F;" href="{{ auth()->user()->site }}"> {{ auth()->user()->site }} </a></h4>
        <h4>{{ auth()->user()->bio }}</h4>
    </p>
@endsection