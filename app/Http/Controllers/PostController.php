<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function __contstruct(){
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index(){
        // $posts = Post::get(); // returns all posts in natural database order as Laravel Collection
        $posts = Post::orderBy('created_at', 'desc')->with(['user','likes'])->paginate(15);  // returns LengthAwarePaginator

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post){
        return view('posts.show', [
            'post' => $post
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

    public function destroy(Post $post){

        // To be done with PostPolicy
        // if(!$post->ownedBy(auth()->user())){
        //     dd('no');
        // }
        
        $this->authorize('delete', $post);
        $post->delete();

        return back();
    }
}
