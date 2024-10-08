@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-white">Admin Panel</h1>

    <style>
        .table-bordered td,
        .table-bordered th {
            border-color: black !important; /* Override the default border color from bootstrap css*/
        }
    </style>
    
    <table class="table table-bordered table-striped bg-danger text-white">
        <thead>
            <tr>
                <th>Profile Picture</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/50' }}" alt="Profile Picture" class="img-thumbnail" style="width: 50px; height: 50px;">
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.viewUserPosts', $user->id) }}" class="btn btn-info btn-sm">View Posts</a>
                    <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm">Delete User</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection