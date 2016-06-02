@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('content')
    <section class="text-center">
        <h2>{{ $user->username }}</h2>
        <p>
            @if(file_exists(public_path() . "/uploads/" . auth()->user()->username . '-' .  auth()->user()->id . '.jpg') == null)
                <img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/nobody.jpg" alt="">
            @else
                <img style="width: 300px; height: 300px;" class="img-responsive img-thumbnail img-circle" src="/uploads/{{ auth()->user()->username . '-' . auth()->user()->id . '.jpg' }}" alt="">
            @endif
        </p>

        @if(Auth::user()->username != $user->username )
            <a href="{{ url('/follow/' . $user->id) }}" class="btn btn-primary">
                {{ $user->isFollowed() ? 'Unfollow' : 'Follow' }}
            </a>
        @endif
        <h1>{{ $user->full_name }}</h1>
        @if($user->birth_date != null)
            <h4>{{ $user->birth_date }}</h4>
        @endif
        <h4><a style="color: #CE433F;" href="{{ $user->site }}"> {{ auth()->user()->site }} </a></h4>
        <h4>{{ $user->bio }}</h4>
    </section>

    <section class="posts panel" id="posts">
        <header><h3></h3></header>
        @foreach($user->posts as $post)
            @if($post->image)
                <article class="panel-primary post" data-postid="{{ $post->id }}">
                    <div style="padding-bottom: 35px" class="panel-heading">
                        @if(file_exists(public_path() . "/uploads/" . $post->user->username . '-' .  $post->user->id . '.jpg') == null)
                            <img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/nobody.jpg" alt="">
                        @else
                            <img style="width: 30px; height: 30px; float: left;" class="img-responsive img-circle" src="/uploads/{{ $post->user->username . '-' .  $post->user->id . '.jpg' }}" alt="">
                        @endif

                        <a style="padding-left: 10px; font-size: 18px; font-style: bold; font-family: sans-serif; color: white; float: left;" href="{{ route('profile', ['username' => $post->user->username]) }}"> {{ $post->user->username }} </a>
                    </div>

                    <div class="panel panel-footer">
                        <img class="img-responsive" src="/posts/{{ $post->image }}" alt="">
                        <p class="like_count">{{ $post->likes()->count() }} Like</p>
                    </div>
                </article>
            @endif
        @endforeach
    </section>
@endsection