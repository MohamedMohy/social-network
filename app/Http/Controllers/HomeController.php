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
        $publicposts=Post::where('privacy',0)->orderBy('created_at', 'ascen')->get();
        $friends=Auth::user()->getFriends();
        $privateposts=Post::where('privacy',1)->orderBy('created_at', 'ascen')->get();
        $privatepostsoffriends =array();
        $publicpostsarray =array();
        foreach ($publicposts as $publicpost)
            array_push($publicpostsarray,$publicpost);

        foreach ($friends as $friend){
            foreach ($privateposts as $privatepost)
            {
                if($friend->id == $privatepost->user_id)
                    $privatepostsoffriends[] = $privatepost;
            }
        }
        $posts = array_merge($privatepostsoffriends,$publicpostsarray);
        return view('home',compact('posts'));
    }




}
