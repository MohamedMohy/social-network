@extends('layouts.app')
@section('content')

<div class="container">
    <div class="span3 well">
        <center>
        <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRbezqZpEuwGSvitKy3wrwnth5kysKdRqBW54cAszm_wiutku3R" name="aboutme" width="140" height="140" class="img-circle"></a>

            @if ($user->id == Auth::user()->id)
                <a href="#aboutModal" data-toggle="modal" data-target="#editprofile"><button name="editprofile" class="btn btn-danger" style="float: right; margin-top: 3px" type="button">Edit profile</button></a>
            @else
                <button name="editprofile" class="btn btn-success" style="float: right; margin-top: 3px" type="button">Add Friend</button>
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
                    <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRbezqZpEuwGSvitKy3wrwnth5kysKdRqBW54cAszm_wiutku3R" name="aboutme" width="140" height="140" border="0" class="img-circle"></a>
                    <h3 class="media-heading">Joe Sixpack <small>USA</small></h3>
                    <span><strong>Skills: </strong></span>
                        <span class="label label-warning">{{$user->bdate}}</span>
                        <span class="label label-info">maybe phone#1 </span>
                        <span class="label label-info">hometown </span>
                        <span class="label label-success">martial status</span>
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
                    <a href="{{ route('friends') }}" class="btn btn-primary" role="button" aria-pressed="true">Friends</a>
                    
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
                    <form method="post" action="{{ route ('profile',Auth::user()->id) }}">
                        {{ csrf_field()}}
                        <label for="aboutme">About me</label>
                        <textarea class="form-control" style="resize: none" id="aboutme" rows="3" name="aboutme"></textarea>
                        <label for="phonenumber">Phone number</label>
                        <input type="number" id="phonenumber" class="form-control" name="pnumber">
                        <label for="hometown">Hometown</label>
                        <input type="text" id="hometown" class="form-control" name="hometown">
                        <label for="nickname">Nickname</label>
                        <input type="text" id="nickname" class="form-control" name="nname">
                        <label for="profilepicture">Profile picture</label>
                        <input type="file" class="form-control" id="profilepicture" name="profilepicture">
                        <label for="status">Hometown</label>
                        <select id="status" class="form-control" name="status">
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
            <a class="container" >
                <a href="{{route('profile',$user->id)}}">
                    <h2>

                    </h2>
                </a>

                <div class="col-xs-6">
                    <div class="well">
                        <h2> {{\DB::table('users')->where('id', $post->user_id)->value('fname')}}</h2>
                        <h7>{{$post->created_at}}</h7>
                        <h4>{{$post->body}}</h4>
                        @foreach(\DB::table('comments')->where('post_id',$post->id)->get() as $comment)
                            <i>{{$comment->body}}</i>
                            <br>
                        @endforeach
                    </div>
                </div>
                <a

                        @if(Auth::user()->id==\DB::table('likes')->where('post_id',$post->id)->where('user_id',Auth::user()->id)->value('user_id'))
                        class="btn btn-danger" href="/unlike/{{$user->id}}/{{$post->id}}">liked!
                        @else
                        class="btn btn-success" href="/like/{{$user->id}}/{{$post->id}}">Like
                        @endif</a><br><br>
                <a href="#comment" data-toggle="modal" data-target="#comment"><button name="comment"  class="btn btn-default">Add Comment</button></a>
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

                    {{-->--}}
                    {{--@if($user->id==\DB::table('likes')->where('post_id',$post->id)->value('user_id'))--}}
                    {{--liked!--}}
                    {{--@else--}}
                    {{--Like--}}
                {{--@endif</a>--}}
            <br>
            </a>
        @endforeach
</div>
@endsection('content')