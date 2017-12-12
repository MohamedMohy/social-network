<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth ;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
{
    //
    public function index(){
        $posts=auth()->user()->posts()->get();
        return view('show',compact('posts'));
    }
    public function update(Request $request){
        $user = Auth::user();
        if($request->aboutme != Null)
            $user->aboutme=$request->aboutme;
        if($request->pnumber != Null)
            $user->pnumber=$request->pnumber;
        if($request->hometown != Null)
            $user->hometown=$request->hometown;
        if($request->nname != Null)
            $user->nname=$request->nname;

        $user->save();
        return redirect('profile');



    }

}
