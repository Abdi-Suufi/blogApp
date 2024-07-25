@extends('layouts.app')

@section('content')
<div class="container" style="background-color: rgba(111, 2, 4, 0.8);">
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
            <div class="card m-4 bg-danger text-white" style="border: 2px solid black;">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <!-- User profile picture and name linking to their profile page -->
                    <a href="{{ route('users.profile', $post->user->id) }}">
                        <img src="{{ $post->user->profile_picture ? Storage::url($post->user->profile_picture) : 'https://via.placeholder.com/50' }}" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        <small>by {{ $post->user->name }}</small>
                    </a>
                    <br>
                    <small>{{ $post->created_at->format('F j, Y, g:i a') }}</small>
                </div>
                <div class="card-body">
                    <p>{{ $post->body }}</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div>
                        <!-- Like/Unlike functionality -->
                        <form action="{{ $post->isLiked() ? route('posts.unlike', $post) : route('posts.like', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            @if ($post->isLiked())
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning btn-sm">Unlike</button>
                            @else
                            <button type="submit" class="btn btn-primary btn-sm">Like</button>
                            @endif
                        </form>
                        <span> Likes: {{ $post->likes->count() }}</span>
                    </div>
                    @auth
                    @if(auth()->user()->id === $post->user_id || auth()->user()->is_admin)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm">Delete post</button>
                    </form>
                    @endif
                    @endauth
                </div>
                <!-- Comments Section -->
                <div class="card-body">
                    @forelse ($post->comments as $comment)
                    <div class="comment mb-3">
                        <div class="d-flex align-items-center">
                            <!-- Commenter profile picture and name linking to their profile page -->
                            <a href="{{ route('users.profile', $comment->user->id) }}">
                                <img src="{{ $comment->user->profile_picture ? Storage::url($comment->user->profile_picture) : 'https://via.placeholder.com/30' }}" alt="Profile Picture" class="img-thumbnail rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                <strong>{{ $comment->user->name }}</strong>
                            </a>
                            &nbsp;&nbsp;
                            <span class="ms-2 text-light">{{ $comment->created_at->format('F j, Y, g:i a') }}</span>
                        </div>
                        <p class="mt-2">{{ $comment->body }}</p>
                    </div>
                    @empty
                    <p>No comments yet.</p>
                    @endforelse
                </div>
                @auth
                <div class="card-footer">
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" rows="2" class="form-control" placeholder="Add a comment..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Commit</button>
                    </form>
                </div>
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