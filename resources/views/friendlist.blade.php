@extends('layouts.app')
@section('content')
<div  class="container">
    @foreach($friends as $friend)
        @if((\DB::table('media')->where('model_id',$friend->id)->where('model_type',"App\User")->count() !=0))
            <img src="{{$friend->getFirstMediaUrl()}}"  name="aboutme" width="140" height="140" border="0" class="img-circle">
            <a href="{{route('profile',$friend->id)}}"><h4>{{$friend->fnam}} {{$friend->lname}}</h4></a>
            <br>
        @else
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Default_profile_picture_%28male%29_on_Facebook.jpg/600px-Default_profile_picture_%28male%29_on_Facebook.jpg"  name="aboutme" width="140" height="140" border="0" class="img-circle">
            <a href="{{route('profile',$friend->id)}}"><h4>{{$friend->fname}} {{$friend->lname}}</h4></a>
            <br>
        @endif
    @endforeach
</div>



@endsection('content')