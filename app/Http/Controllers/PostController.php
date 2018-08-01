<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class PostController extends Controller
{
    //
    public function store(Request $request, Post $post){
        $newPost = $request->user()->posts()->create([
            'body' => $request->input('body')
        ]);

        return response()->json($post->with('user')->find($newPost->id));
    }

    public function index(Request $request, Post $post)
    {
        $posts = $post->whereIn('user_id', $request->user()->following()
                        ->pluck('users.id')
                        ->push($request->user()->id))
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->take($request->get('limit', 10))
                        ->get();
    
        return response()->json($posts);
    }
}
