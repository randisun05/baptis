<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ReactDetail;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })
        ->where('status', 'active')
        ->latest()
        ->paginate(6);

        $posts->appends(['q' => request()->q]);

        return inertia('Public/Website/Posts/Index', [
            'title' => "Daftar Warta Paroki",
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return inertia('Public/Website/Posts/Show', [
           'title' => $post->title,
           'post' => $post
       ]);
    }

}