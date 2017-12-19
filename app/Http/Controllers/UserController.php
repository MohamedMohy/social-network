<?php

namespace App\Http\Controllers;
use App\Notifications\UserAcceptRequest;
use App\Notifications\UserAddFriend;
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
        if($request->status !=2)
            $user->status=$request->status;
        if($request->image != Null)
        {

            if($media=\DB::table('media')->where('model_id',$user->id)->where('model_type',"App\User"))
            {
                $media->delete();
                $user->addMedia($request->image)->toMediaCollection();
            }

            else
            $user->addMedia($request->image)->toMediaCollection();

            $post=new Post();
            $post->body="updated his profile picture";
            $post->user_id=Auth::user()->id;
            $post->privacy=1;
            //$post->addMedia($request->image)->toMediaCollection();
            $post->save();
        }

        $user->update();

        return redirect()->route('profile',['id'=> $user->id]);

    }
    public function listingUsers(Request $request){
     
        $name = $request->searchtext;

       $users= \DB::table('users')->where('fname', $name)->get();
       if($users->count() == 0)
           $users=\DB::table('users')->where('lname', $name)->get();
       if($users->count()==0)
           $users=\DB::table('users')->where('email', $name)->get();
        if($users->count()==0)
            $users=\DB::table('users')->where('hometown', $name)->get();


       return view('listingUsers',compact('users'));
    }
    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }
    public function sendfriendrequest($recipient_id){
        $recipient=User::find($recipient_id);
        Auth::user()->befriend($recipient);
        $recipient->notify(new UserAddFriend(Auth::user()));
        return redirect()->route('profile',['id'=>$recipient->id]);
    }
    public function acceptfriendrequest($sender_id){
        $sender=User::find($sender_id);
        Auth::user()->acceptFriendRequest($sender);
        $sender->notify(new UserAcceptRequest(Auth::user()));
        return redirect()->route('profile',['id'=>$sender->id]);
    }
    public function listingrequets($user){

        return view('friendrequests');
    }
    public function denyfriendrequest($sender_id){
        $sender=User::find($sender_id);
        Auth::user()->denyFriendRequest($sender);
        $sender->notify(new UserAddFriend(Auth::user()));
        return redirect()->route('profile',['id'=>$sender->id]);
    }



}
