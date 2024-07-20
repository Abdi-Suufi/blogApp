@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-8 offset-md-2">
            <div class="card mt-4">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <small>by {{ $post->user->name }}</small>
                </div>
                <div class="card-body">
                    <p>{{ $post->body }}</p>
                </div>
                @auth
                @if(auth()->user()->is_admin)
                <div class="card-footer">
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection