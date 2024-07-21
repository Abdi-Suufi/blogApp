@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Settings</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Update Settings Form -->
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
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Settings</button>

                            <!-- Hidden Delete Account Form -->
                            @if (!Auth::user()->is_admin)
                            <form action="{{ route('settings.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script loaded'); // Debugging statement

        const profilePicturePreview = document.getElementById('profile_picture_preview');
        const profilePictureInput = document.getElementById('profile_picture');

        // Show file picker when profile picture is clicked
        profilePicturePreview.addEventListener('click', function() {
            console.log('Profile picture clicked'); // Debugging statement
            profilePictureInput.click();
        });

        // Preview the selected image
        profilePictureInput.addEventListener('change', function(event) {
            console.log('Profile picture file selected'); // Debugging statement
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicturePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
@endsection