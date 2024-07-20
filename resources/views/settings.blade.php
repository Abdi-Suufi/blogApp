<!-- resources/views/settings.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Settings</h1>
    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
        </div>

        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
        </div>

        @if (Auth::user()->profile_picture)
        <div class="form-group">
            <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="Profile Picture" width="150">
        </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>

    <form method="POST" action="{{ route('settings.destroy') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">Delete Account</button>
    </form>
</div>
@endsection