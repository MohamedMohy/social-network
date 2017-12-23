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
    public function index($user_id)
    {
        $user = User::find($user_id);
        if($user->isFriendWith(Auth::user()) || Auth::user()->id == $user->id)
        {
            $posts = User::find($user_id)->posts()->orderBy('created_at', 'desc')->get();
        }
        else{
            $posts=$user->posts()->where('privacy',0)->get();
        }


        $comments = Comment::all();
        // dd($comments);
        return view('show', compact('posts', 'user', 'comments'));
    }

    public function update(Request $request)
    {

        $user = Auth::user();
        if ($request->aboutme != Null)
            $user->aboutme = $request->aboutme;
        if ($request->pnumber != Null)
            $user->pnumber = $request->pnumber;
        if ($request->hometown != Null)
            $user->hometown = $request->hometown;
        if ($request->nname != Null)
            $user->nname = $request->nname;
        if ($request->status != 2)
            $user->status = $request->status;
        if ($request->image != Null) {

            if ($media = \DB::table('media')->where('model_id', $user->id)->where('model_type', "App\User")) {
                $media->delete();
                $user->addMedia($request->image)->toMediaCollection();
            } else
                $user->addMedia($request->image)->toMediaCollection();

            $post = new Post();
            $post->body = "updated his profile picture";
            $post->user_id = Auth::user()->id;
            $post->privacy = 1;
            //$post->addMedia($request->image)->toMediaCollection();
            $post->save();
        }

        $user->update();

        return redirect()->route('profile', ['id' => $user->id]);

    }

    public function listingUsers(Request $request)
    {

        $name = $request->searchtext;
        $users []=new User();
        $userss []=new User();
        $posts=Post::where('body','LIKE',"%{$name}%")->get();
        $users = \DB::table('users')->where('fname', $name)->orWhere('lname', $name)->
        orWhere('email', $name)->orWhere('hometown', $name)->get();

        foreach ($posts as $post) {
            $wahed=User::find($post->user_id);
            if($post->privacy=0||Auth::user()->isFriendWith($wahed)) {
                $wahed = \DB::table('users')->where('id', $post->user_id)->get();
                $users = $users->merge($wahed);
                }
        }
    
        $users=$users->unique();
       // $users= $users->merge($userss);
        return view('listingUsers', compact('users'));
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }

    public function sendfriendrequest($recipient_id)
    {
        $recipient = User::find($recipient_id);
        Auth::user()->befriend($recipient);
        $recipient->notify(new UserAddFriend(Auth::user()));
        return redirect()->route('profile', ['id' => $recipient->id]);
    }

    public function acceptfriendrequest($sender_id,$notification_id)
    {
        $sender = User::find($sender_id);
        \DB::table('notifications')->where('id',$notification_id)->delete();
        Auth::user()->acceptFriendRequest($sender);
       $sender->notify(new UserAcceptRequest(Auth::user()));
        return redirect()->route('profile', ['id' => $sender_id]);
    }

    public function listingrequests()
    {
        return view('friendrequests');
    }

    public function denyfriendrequest($sender_id,$notification_id)
    {
        $sender = User::find($sender_id);
        Auth::user()->denyFriendRequest($sender);
        \DB::table('notifications')->where('id',$notification_id)->delete();
        //$sender->notify(new UserAddFriend(Auth::user()));
        return redirect()->route('profile', ['id' => $sender->id]);
    }
    public function friends($id){
        $user=User::find($id);
        $friends=$user->getFriends();
        return view('friendlist',compact('friends'));
    }
    public function removepicture($id){
        $user=User::find($id);
        if(\DB::table('media')->where('model_id',$id)->where('model_type',"App\User")->count() !=0){
            $media=\DB::table('media')->where('model_id',$id)->where('model_type',"App\User");
            $media->delete();
            $post=new Post();
            $post->body="removed his profile picture";
            $post->privacy=1;
            $post->user_id=$id;
            $post->save();
        }
        return redirect()->route('profile', ['id' => $id]);
    }
    public function deletenotification($notification_id){
        \DB::table('notifications')->where('id',$notification_id)->delete();

        return redirect()->route('home');
    }


}
