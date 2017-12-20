<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

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
        $posts=Post::where('privacy',0)->get();
        $privateposts =Post::where('privacy',1)->get();
        foreach ($privateposts as $privatepost)
        {
         if($privatepost->user_id==Auth::user()->id){
             $posts.add($privatepost);
         }
        }
        //dd($posts);
        return view('home',compact('posts'));
    }



}
