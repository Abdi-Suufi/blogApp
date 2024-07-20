<!-- resources/views/settings.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Settings</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-row align-items-center">
                    <!-- Profile Picture -->
                    <div class="col-md-4 text-center mb-3">
                        <label for="profile_picture">
                            <img src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="img-thumbnail clickable-img" id="profile_picture_preview" style="cursor: pointer; max-width: 100%; max-height: 150px;">
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" style="display: none;">
                    </div>

                    <!-- Name Field -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-primary">Update Settings</button>

                        <!-- Conditionally Display Delete Button -->
                        @if (!Auth::user()->is_admin)
                        <form method="POST" action="{{ route('settings.destroy') }}" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </form>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('profile_picture_preview').addEventListener('click', function() {
        document.getElementById('profile_picture').click();
    });
</script>
@endsection
@endsection