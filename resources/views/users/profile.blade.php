@extends('layouts.app')


@section('content')
<div class="container text-white" style="background-color: rgba(111, 2, 4, 0.8);">
    <h1 class="text-center mb-4">{{ $user->name }}'s Profile</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Picture and Bio -->
            <div class="text-center mb-4">
                <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->bio }}</p>
                <p><strong>Followers:</strong> {{ $user->followersCount() }}</p>

                <!-- Follow/Unfollow Button -->
                @auth
                @if (Auth::user()->id !== $user->id)
                <form action="{{ Auth::user()->isFollowing($user) ? route('users.unfollow', $user) : route('users.follow', $user) }}" method="POST" style="display: inline;">
                    @csrf
                    @if (Auth::user()->isFollowing($user))
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                    @else
                    <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                    @endif
                </form>
                @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection