<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Post;
use Auth ;
use App\Comment;

class PostsController extends Controller
{
    //
    public function create (Request $request)
    {
        $post=new Post();
        $post->user_id=Auth::user()->id;
        $post->body=$request->post;
        $post->privacy=$request->privacy;
        if($request->hasFile('photo')){
            $post->addMedia($request->photo)->toMediaCollection();
        }
        $post->save();
        $posts=Post::where('privacy',0)->get();
        $privateposts =Post::where('privacy',1)->get();
        foreach ($privateposts as $privatepost)
        {
         if($privatepost->user_id==Auth::user()->id){
             $posts.add($privatepost);
         }
        }
        return view('home',compact('posts'));

    }
    public function delete($post_id){
       $post= Post::find($post_id);
        foreach(\DB::table('comments')->where('post_id',$post_id)->get() as $comment)
        {
           Comment::destroy($comment->id);
        }
       $post->delete();
        return redirect()->route('profile',['id'=> Auth::user()->id]);
    }
}
