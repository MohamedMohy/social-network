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

}
