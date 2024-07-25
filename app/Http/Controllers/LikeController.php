<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $like = $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Post liked!');
    }

    public function destroy(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Like removed!');
    }
}