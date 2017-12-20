@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{"welcome "}}{{Auth::user()->fname}} {{"!"}}</div>
                <form method="post" action="{{ route('home') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <textarea required class="panel-heading form-control" style="resize: none" rows="5" id="post" name="post" placeholder="What's in your mind,{{Auth::user()->fname}}?"></textarea>
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
<div class="container">
    <h5>Public Posts: </h5>
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
                                <img src="{{App\User::find($post->user_id)->getFirstMediaUrl()}}"  name="aboutme" width="140" height="140" border="0" >
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
                    <div class="comment-user"><i class="fa fa-user"></i> {{\DB::table('users')->where('id',$post->user_id)->value('fname')}}</div>
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i>{{$post->created_at}}</time>
                  </header>
                  <div class="comment-post">
                    <p>
                      {{$post->body}}
                      <p>Comments: </p>
                      @foreach(\DB::table('comments')->where('post_id',$post->id)->get() as $comment)
                          <p>{{\DB::table('users')->where('id',$comment->user_id)->value('fname')}}: <i>{{$comment->body}}</i></p>
                          <br>
                      @endforeach
                          </p>
                    </p>
                    @if(\DB::table('media')->where('model_id',$post->id)->where('model_type',"App\Post")->count() != 0)
                    <img src="{{$post->getFirstMediaUrl()}}" style="margin-bottom: 10px" width="140px" height="140px">
                    @endif
                  </div>
                  <div class="btn-group">
                  <a
                  @if(Auth::user()->id==\DB::table('likes')->where('post_id',$post->id)->where('user_id',Auth::user()->id)->value('user_id'))
                class="btn btn-danger btn-sm" href="{{route("unlikehome",$post->id) }}">liked!
            @else
                class="btn btn-success btn-sm" href="{{route("likehome",$post->id) }}">Like
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
                        <form method="post" action="/commenthome/{{$post->id}}">
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

@endsection
