<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(User $user): View
    {
        $isFollowing = Auth::check() && Auth::user()->isFollowing($user);
        return view('users.profile', [
            'user' => $user,
            'isFollowing' => $isFollowing,
        ]);
    }
}
