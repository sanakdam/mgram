@extends('layouts.master')

@section('title')
    Uploads
@endsection

@section('content')
    <section class="uploads" id="uploads">
        <div class="new-post">
            <div class="panel-body">
                <form action="{{ route('post.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="sr-only" for="image">Image (only.jpg)</label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="body" id="body" placeholder="Caption"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Create Post</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
            </div>
        </div>
    </section>
@endsection