<!-- resources/views/settings.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Settings</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Name</button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('settings.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
        </div>
    </div>
</div>
@endsection