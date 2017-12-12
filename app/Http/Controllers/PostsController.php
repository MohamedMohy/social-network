<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth ;

class PostsController extends Controller
{
    //
    public function create (Request $request)
    {
        $post=new Post();
        $post->user_id=Auth::user()->id;
        $post->body=$request->post;
        $post->save();
        return view('home');
    }
    public function index(){


    }
}
