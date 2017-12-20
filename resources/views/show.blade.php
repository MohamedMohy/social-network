@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="span3 well">
            <center>
                @if(\DB::table('media')->where('model_id',$user->id)->where('model_type',"App\User")->count() !=0)

                    <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img src="{{$user->getFirstMediaUrl()}}" name="aboutmea" width="140" height="140" class="img-circle"></a>
                @else
                    <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Default_profile_picture_%28male%29_on_Facebook.jpg/600px-Default_profile_picture_%28male%29_on_Facebook.jpg" name="aboutmeb" width="140" height="140" class="img-circle"></a>
                @endif

                @if ($user->id == Auth::user()->id)
                    <a href="#aboutModal" data-toggle="modal" data-target="#editprofile"><button name="editprofile" class="btn btn-danger" style="float: right; margin-top: 3px" type="button">Edit profile</button></a>
                @elseif(\DB::table('friendships')->where('recipient_id',$user->id)->where('sender_id',Auth::user()->id)->where('status',0)->count() !=0)
                        <button name="editprofile" class="btn btn-default" style="float: right; margin-top: 3px" type="button">Pending</button>
                    @elseif(\DB::table('friendships')->where('recipient_id',$user->id)->where('sender_id',Auth::user()->id)->where('status',1)->count() !=0||\DB::table('friendships')->where('sender_id',$user->id)->where('recipient_id',Auth::user()->id)->where('status',1)->count() !=0)
                            <button name="editprofile" class="btn btn-primary" style="float: right; margin-top: 3px" type="button">Friends</button>
                    @else
                        <a href="{{ route ('friendship',$user->id) }}"><button name="editprofile" class="btn btn-success" style="float: right; margin-top: 3px" type="button">Add Friend</button></a>
                    @endif
                <h3>{{$user->fname}} {{$user->lname}}</h3>
                <!-- user should be passed from the controller action to this view to be dynamic for all users not just the logged in one-->
                <em>click my face for more</em>

            </center>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id="myModalLabel">More About {{$user->fname}} {{$user->lname}}</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            @if((\DB::table('media')->where('model_id',$user->id)->where('model_type',"App\User")->count() !=0))
                                <img src="{{$user->getFirstMediaUrl()}}"  name="aboutme" width="140" height="140" border="0" class="img-circle">
                            @else
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Default_profile_picture_%28male%29_on_Facebook.jpg/600px-Default_profile_picture_%28male%29_on_Facebook.jpg"  name="aboutme" width="140" height="140" border="0" class="img-circle">
                            @endif




                            <h3 class="media-heading">{{$user ->fname}} </h3>
                            <span><strong>info: </strong></span>
                            <span class="label label-warning">{{$user->bdate}}</span>
                            <span class="label label-info">
                            @if($user->pnumber == Null)
                                @else
                                    {{$user->pnumber}}
                                @endif
                        </span>
                            <span class="label label-info">
                            @if($user->hometown == Null)
                                @else
                                    {{$user->hometown}}
                                @endif
                        </span>
                            <span class="label label-success">
                            @if($user->status == 2)
                                @else
                                    @if($user->status==0)
                                        Single
                                    @else
                                        Married
                                    @endif
                                @endif
                        </span>
                        </center>
                        <hr>
                        <center>
                            <p class="text-left"><strong>Bio: </strong><br>
                                {{$user->aboutme}}</p>
                            <br>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-default" data-dismiss="modal">I've heard enough!</button>
                        </center>
                        <a href="{{ route('friends',$user->id) }}" class="btn btn-primary" role="button" aria-pressed="true">Friends</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id="myModalLabel">More About {{$user->Fname}} {{$user->Lname}}</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route ('profile',Auth::user()->id) }}" enctype="multipart/form-data">
                            {{ csrf_field()}}
                            <label for="aboutme">About me</label>
                            <textarea class="form-control" style="resize: none" id="aboutme" rows="3" name="aboutme"></textarea>
                            <label for="phonenumber">Phone number</label>
                            <input type="number" id="phonenumber" class="form-control" name="pnumber">
                            <label for="hometown">Hometown</label>
                            <input type="text" id="hometown" class="form-control" name="hometown">
                            <label for="nickname">Nickname</label>
                            <input type="text" id="nickname" class="form-control" name="nname">
                            <label for="image">Profile picture</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <label for="status">Martial Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="2">None</option>
                                <option value="0">Single</option>
                                <option value="1">Married</option>

                            </select>
                            <button type="submit" class="btn btn-default" style="margin-top: 5px">Save!</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        @foreach($posts as $post)

    <div class="container">
  <div class="row">
    <div class="col-md-8">
        <section class="comment-list">
          <!-- First Comment -->
          <article class="row">
            <div class="col-md-2 col-sm-2 hidden-xs">
              <figure class="thumbnail">
              @if((\DB::table('media')->where('model_id',$post->user_id)->where('model_type',"App\User")->count() !=0))
                                <img src="{{$user->getFirstMediaUrl()}}"  name="aboutme" width="140" height="140" border="0">
                            @else
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Default_profile_picture_%28male%29_on_Facebook.jpg/600px-Default_profile_picture_%28male%29_on_Facebook.jpg"  name="aboutme" width="140" height="140" border="0" class="img-circle">
                            @endif
                <figcaption class="text-center">{{\DB::table('users')->where('id',$post->user_id)->value('fname')}}</figcaption>
              </figure>
            </div>
            <div class="col-md-10 col-sm-10">
              <div class="panel panel-default arrow left">
                <div class="panel-body">
                  <header class="text-left">
                    <div class="comment-user"><i class="fa fa-user"></i> <strong>{{\DB::table('users')->where('id',$post->user_id)->value('fname')}}</strong></div>
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i>{{$post->created_at->format('H:i')}}</time>
                  </header>
                  <div class="comment-post">
                    <p>
                      {{$post->body}}
                    </p>
                    @if(\DB::table('media')->where('model_id',$post->id)->where('model_type',"App\Post")->count() != 0)
                    <img src="{{$post->getFirstMediaUrl()}}" style="margin-bottom: 10px" width="140px" height="140px">
                    @endif
                  </div>
                    <p>Comments: </p>
                    @foreach(\DB::table('comments')->where('post_id',$post->id)->get() as $comment)
                        <p>{{\DB::table('users')->where('id',$comment->user_id)->value('fname')}}: <i>{{$comment->body}}</i></p>
                        <br>
                    @endforeach
                  <div class="btn-group">
                      
                  <a
                  @if(Auth::user()->id==\DB::table('likes')->where('post_id',$post->id)->where('user_id',Auth::user()->id)->value('user_id'))
                  class="btn btn-danger btn-sm" href="/unlike/{{$user->id}}/{{$post->id}}">liked!
              @else
                  class="btn btn-success btn-sm" href="/like/{{$user->id}}/{{$post->id}}">Like
              @endif
</a>
        <a href="#comment" data-toggle="modal" data-target="#comment"><button name="comment"  class="btn btn-default btn-sm">Add Comment</button></a>
        <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/comment/{{Auth::user()->id}}/{{$post->id}}/{{$user->id}}">
                            {{ csrf_field()}}
                            <label for="aboutme">Comment</label>
                            <textarea class="form-control" style="resize: none" id="aboutme" rows="3" name="comment" required></textarea>
                            <button type="submit" class="btn btn-primary" style="margin-top: 5px">Save!</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
            </div>
            @if ($user->id == Auth::user()->id)
                <a href={{ route("deletepost",$post->id) }}  ><button name="comment" class="btn btn-danger btn-sm">Delete Post</button></a>
            @endif
        </div>
              </div>
            </div>
          </article>
        </section>
    </div>
  </div>
</div>
        @endforeach
    </div>
@endsection('content')