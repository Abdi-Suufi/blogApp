<!-- resources/views/settings.blade.php -->

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
                        <button type="submit" class="btn btn-primary">Update Settings</button>

                        <!-- Conditionally Display Delete Button -->
                        @if (!Auth::user()->is_admin)
                        <button type="button" class="btn btn-danger mt-3" id="delete-account-button">Delete Account</button>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Hidden Delete Account Form -->
            @if (!Auth::user()->is_admin)
            <form method="POST" action="{{ route('settings.destroy') }}" id="delete-account-form" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script loaded'); // Debugging statement

        const profilePicturePreview = document.getElementById('profile_picture_preview');
        const profilePictureInput = document.getElementById('profile_picture');
        const deleteAccountButton = document.getElementById('delete-account-button');
        const deleteAccountForm = document.getElementById('delete-account-form');

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

        // Confirm before deleting account
        deleteAccountButton.addEventListener('click', function(event) {
            console.log('Delete button clicked'); // Debugging statement
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                deleteAccountForm.submit();
            }
        });
    });
</script>
@endsection
@endsection