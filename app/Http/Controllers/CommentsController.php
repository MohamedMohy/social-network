<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

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
}
