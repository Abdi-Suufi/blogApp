<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Follow a user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow(User $user)
    {
        Auth::user()->follow($user);
        return redirect()->back()->with('success', 'You are now following ' . $user->name);
    }

    /**
     * Unfollow a user.
     *1
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
