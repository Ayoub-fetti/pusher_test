<?php

namespace App\Http\Controllers;

use App\Mail\PostLikedNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\likes;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Notifications\PostLiked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class likeController extends Controller
{
    public function toggleLike(Posts $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();
        
        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create([
                'user_id' => Auth::id()
            ]);
            $isLiked = true;
            $post->user->notify(new PostLiked($post));
        }
        
        return response()->json([
            'success' => true,
            'likesCount' => $post->likes()->count(),
            'isLiked' => $isLiked
        ]);
    }

    public function checkLike(Posts $post)
    {
        return response()->json([
            'isLiked' => $post->likes()->where('user_id', Auth::id())->exists()
        ]);
    }
}