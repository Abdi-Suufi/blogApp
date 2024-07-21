@extends('layouts.app')

@section('content')
<div class="container" style="background-color: rgba(0, 0, 0, 0.3);">
    <!-- Flash messages -->
    @if (session('success'))
    <div class="alert alert-success m-1">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger m-1">
        {{ session('error') }}
    </div>
    @endif

    <!-- Posts list -->
    <div class="row">
        @forelse ($posts as $post)
        <div class="col-md-8 offset-md-2">
            <div class="card m-4 bg-dark border-white text-white">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <img src="{{ $post->user->profile_picture ? Storage::url($post->user->profile_picture) : 'https://via.placeholder.com/50' }}" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    <small>by {{ $post->user->name }}</small>
                    <br>
                    <small>{{ $post->created_at->format('F j, Y, g:i a') }}</small>
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