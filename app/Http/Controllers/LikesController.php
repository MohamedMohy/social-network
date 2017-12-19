<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    //
    public function create($user_id,$post_id){
        $like = new Like();
        $like->user_id=Auth::user()->id;
        $like->post_id=$post_id;
        $like->save();
        $post =Post::find($post_id);
        $post->counter=$post->counter+1;
        $post->save();
        return redirect()->route('profile',['id'=> $user_id]);
    }


    public function destroy($user_id,$post_id){
        $like = \DB::table('likes')->where('post_id',$post_id)->where('user_id',$user_id)->get()->first();

        Like::destroy($like->id);
        return redirect()->route('profile',['id'=> $user_id]);
    }

    public function likehome($post_id){
        $like = new Like();
        $like->user_id=Auth::user()->id;
        $like->post_id=$post_id;
        $like->save();
        $post =Post::find($post_id);
        $post->counter=$post->counter+1;
        $post->save();
        return redirect()->route('home');
    }


    public function unlikehome($post_id){
        $like = \DB::table('likes')->where('post_id',$post_id)->where('user_id',Auth::user()->id)->get()->first();
        Like::destroy($like->id);
        return redirect()->route('home');
    }
}
