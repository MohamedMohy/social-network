<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use Auth ;
use phpDocumentor\Reflection\Types\Null_;
use Spatie\MediaLibrary\Media;

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
        if($request->image != Null)
        {

            if($media=\DB::table('media')->where('model_id',$user->id))
            {
                $media->delete();
                $user->addMedia($request->image)->toMediaCollection();
            }

            else
            $user->addMedia($request->image)->toMediaCollection();
        }

        $user->update();

        return redirect()->route('profile',['id'=> $user->id]);

    }
    public function listingUsers(Request $request){
        $name = $request->searchtext;
       $users= \DB::table('users')->where('fname', $name)->get();
       return view('listingUsers',compact('users'));
    }
    public function sendfriendrequest($recipient_id){
        $recipient=User::find($recipient_id);
        Auth::user()->befriend($recipient);

        return redirect()->route('profile',['id'=>$recipient->id]);
    }
}
