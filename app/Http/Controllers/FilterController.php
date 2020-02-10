<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Facades\App\Repository\Posts;

class FilterController extends Controller
{
    public function index()
    {
        $posts = Posts::allPosts();
        
        return view('post.filter',['posts' => $posts ]);
    }
    public function getpost(Request $request)
    {
        $posts=Post::where('active',$request->sort)->get();

        return response()->json([

            'post'=>$posts

        ]);
        
    }

}

// $posts = Post::query();

// if($request->has('active')){
//     $posts->where('active',request('active'));
// }

// if($request->has('title')){
//     $posts->orderBy('title',request('title'));
// }

// $posts = $post->get();