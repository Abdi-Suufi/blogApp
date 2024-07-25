<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// Welcome page route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (only accessible if authenticated and verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (only accessible if authenticated and verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/delete', [ProfileController::class, 'showDeleteForm'])->name('profile.delete');
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.profile');
});

// Post routes
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Settings routes (only accessible if authenticated and verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
});

// Admin routes (only accessible if authenticated and admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');
    Route::delete('/admin/user/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/admin/user/{user}/posts', [AdminController::class, 'viewUserPosts'])->name('admin.viewUserPosts');
});

// Email verification routes
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Like and comment routes
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');


use App\Http\Controllers\FollowController;

Route::middleware('auth')->group(function () {
    // Route to follow a user
    Route::post('/users/{user}/follow', [FollowController::class, 'follow'])->name('users.follow');

    // Route to unfollow a user
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'unfollow'])->name('users.unfollow');
});

// Include the auth routes
require __DIR__ . '/auth.php';
