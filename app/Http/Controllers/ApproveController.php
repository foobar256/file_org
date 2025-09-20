<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ApproveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->can_approve) {
            abort(403);
        }

        $posts = Post::where('is_approved', false)
            ->latest()
            ->get();

        return view('approve.index', compact('posts'));
    }

    public function approve(Post $post): RedirectResponse
    {
        $user = Auth::user();
        if (!$user || !$user->can_approve) {
            abort(403);
        }

        $post->is_approved = true;
        $post->save();

        return redirect()->route('approve.index')->with('status', 'Post approved.');
    }
}

