@extends('layouts.app')

@section('content')
<div class="container" style="background-color: rgba(0, 0, 0, 0.3);">
    <!-- Flash messages -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Posts list -->
    <div class="row">
        @forelse ($posts as $post)
        <div class="col-md-8 offset-md-2">
            <div class="card m-4">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <small>by {{ $post->user->name }}</small>
                </div>
                <div class="card-body">
                    <p>{{ $post->body }}</p>
                </div>
                @auth
                @if(auth()->user()->id === $post->user_id || auth()->user()->is_admin)
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
        @empty
        <div class="col-md-8 offset-md-2">
            <div class="alert alert-info text-center">
                Be the first to post something!
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection