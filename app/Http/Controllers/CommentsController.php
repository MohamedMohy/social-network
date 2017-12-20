<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Notifications\NotifyPostOwner;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    //
    public function create($user_id,$post_id,Request $request,$profile_owner){
        $comment=new Comment();
        $comment->user_id=$user_id;
        $comment->post_id=$post_id;
        $comment->body=$request->comment;
        $comment->save();

        return redirect()->route('profile',['id'=> $profile_owner]);
    }

    public function commenthome($post_id,Request $request){
        $comment=new Comment();
        $comment->user_id=Auth::user()->id;
        $comment->post_id=$post_id;
        $comment->body=$request->comment;
        $comment->save();
        return redirect()->route('home');
    }
}
