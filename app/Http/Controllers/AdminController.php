<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.panel', compact('users'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.panel')->with('success', 'User deleted successfully.');
    }

    public function viewUserPosts(User $user)
    {
        $posts = $user->posts;
        return view('admin.user-posts', compact('user', 'posts'));
    }

    public function adminPanel()
    {
        $users = User::where('is_admin', 0)->get();
        return view('admin.panel', compact('users'));
    }
}
