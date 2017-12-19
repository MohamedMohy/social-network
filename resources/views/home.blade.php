@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{"welcome "}}{{Auth::user()->fname}} {{"!"}}</div>
                <form method="post" action="{{ route('home') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <textarea required class="panel-heading form-control" style="resize: none" rows="5" id="post" name="post" placeholder="What's in your mind,{{Auth::user()->fname}}?">
                </textarea>
                    <div class="form-group">
                        <label for="privacy" class="col-md-4 control-label" style="margin-top: 10px">privacy</label>
                        <div class="col-md-6">
                            <select id="privacy" class="form-control" name="privacy" style="margin-top: 10px">
                                <option value="0">public</option>
                                <option value="1">private</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="photo" class="col-md-4 control-label">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" class="form-control">
                    </div>

                        <button type="submit" class="btn btn-primary" style="float: right; margin-top: 3px;margin-right: 3px">
                            Post
                        </button>
                </form>




                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>
            </form>
        </div>
    </div>
</div>
</div>
@foreach($posts as $post)
    <a class="container" >
        <div class="col-xs-6">
            <div class="well">
                <h2> {{\DB::table('users')->where('id', $post->user_id)->value('fname')}}</h2>
                <h7>{{$post->created_at}} </h7>
                <h4>{{$post->body}}</h4>
                @if(\DB::table('media')->where('model_id',$post->id)->where('model_type',"App\Post")->count() != 0)
                    <img src="{{$post->getFirstMediaUrl()}}" style="margin-bottom: 10px" width="140px" height="140px">
                    <br>
                @else

                @endif

                <a href="#showcomment" data-toggle="modal" data-target="#showcomment"><button name="showcomments"  class="btn btn-default">show comments</button></a>
                <div class="modal fade" id="showcomment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                @foreach($post->comments() as $comment)
                                    <h1>{{$post->id}}</h1>
                                    <h4>{{\DB::table('users')->where('id',$comment->user_id)->value('fname')}}     </h4>
                                    <i>{{$comment->body}}</i>

                                @endforeach


                                <br>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <a

                @if(Auth::user()->id==\DB::table('likes')->where('post_id',$post->id)->where('user_id',Auth::user()->id)->value('user_id'))
                class="btn btn-danger" href="{{route("unlikehome",$post->id) }}">liked!
            @else
                class="btn btn-success" href="{{route("likehome",$post->id) }}">Like
            @endif
        </a><br><br>
        <a href="#comment" data-toggle="modal" data-target="#comment"><button name="comment"  class="btn btn-default">Add Comment</button></a>
        <br>

        <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/commenthome/{{Auth::user()->id}}/{{$post->id}}/{{$post->user_id}}">
                            {{ csrf_field()}}
                            <label for="aboutme">Comment</label>
                            <textarea class="form-control" style="resize: none" id="aboutme" rows="3" name="comment" required></textarea>
                            <button type="submit" class="btn btn-primary" style="margin-top: 5px">Save!</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <br>
    </a>
    @endforeach
    </div>

@endsection
