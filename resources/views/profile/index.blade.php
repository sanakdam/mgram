@extends('layouts.master')

@section('content')
    <div class="well row">
        <div class="col-xs-3">
            gambar
        </div>
        <div class="col-xs-9">
            <a href="{{ url('/follow/' . $user->id) }}" class="btn btn-primary">
                {{ $user->isFollowed() ? 'Unfollow' : 'Follow' }}
            </a>
        </div>
    </div>
@endsection