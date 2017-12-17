<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use Auth ;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
{
    //
    public function index($user_id){
        $posts=User::find($user_id)->posts()->get();
        $user=User::find($user_id);
        $comments=Comment::all();
       // dd($comments);
        return view('show',compact('posts','user','comments'));
    }
    
    public function update(Request $request){
        $user = Auth::user();
        if($request->aboutme != Null)
            $user->aboutme =$request->aboutme;
        if($request->pnumber != Null)
            $user->pnumber=$request->pnumber;
        if($request->hometown != Null)
            $user->hometown=$request->hometown;
        if($request->nname != Null)
            $user->nname=$request->nname;
       if($request->profilepicture != Null)
          $user->addMedia($request->file('image')->toMediaCollection('images'));

        $user->update();

        return redirect()->route('profile',['id'=> $user->id]);

    }
    public function listingUsers(Request $request){
        $name = $request->searchtext;
       $users= \DB::table('users')->where('fname', $name)->get();
       return view('listingUsers',compact('users'));
    }
    public function friends(){
    }
}
