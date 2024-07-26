@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">{{ $user->name }}'s Posts</h1>

    @if($posts->isEmpty())
    <p class="text-center">This user has no posts.</p>
    @else
    <table class="table table-bordered table-striped bg-danger text-white">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ Str::limit($post->body, 100) }}</td>
                <td>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm">Delete Post</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('admin.panel') }}" class="btn btn-secondary mt-4">Back to Admin Panel</a>
</div>
@endsection