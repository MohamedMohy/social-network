<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $posts=auth()->user()->posts()->get();
        return view('show',compact('posts'));
    }

    public function friends(){
    // {
    //     $vard =DB::table('friendship')->where('user_one_id', User->id );
    //     return view('friendlist',compact('vard'));
    }

}
