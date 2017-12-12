<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function posts(Request $request)
    {
        $post=new Post();
        $post->userid=Auth::user()->id;
        $post->body=$request->post;
        $post->save();
        $posts = auth()->user()->posts()->get();
        dd($posts);
        return view('home',compact($posts));
    }

    public function show(){
        return view('show');
    }
}
