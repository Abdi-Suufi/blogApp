<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $request->user()->posts()->create($request->only('title', 'body'));

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->is_admin) {
            $post->delete();
        }
        return redirect()->route('posts.index');
    }
}
