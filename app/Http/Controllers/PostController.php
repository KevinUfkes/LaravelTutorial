<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        // $posts = Post::get(); // returns all posts in natural database order as Laravel Collection
        $posts = Post::paginate(15);  // returns LengthAwarePaginator

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required'
        ]);

        // Post::create([
        //     'user_id' => auth()->id(),
        //     'body' => $request->body
        // ]);


        // To automatically create 1-many relationship
        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]);

        // Different syntax to accomplish the previous
        $request->user()->posts()->create($request->only('body'));

        return back();
    }
}
