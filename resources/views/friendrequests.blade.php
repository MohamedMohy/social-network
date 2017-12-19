
@extends('layouts.app')
@section('content')
    @foreach (Auth::user()->notifications as $notification)
        <h4>{{$notification->data['follower_name']}}</h4>
        <a href="/acceptfriendrequest/{{$notification->data['follower_id']}}/{{$notification->id}}"><button type="submit" class="btn-primary btn">Accept</button></a>
        <a href="/denyfriendrequest/{{$notification->data['follower_id']}}/{{$notification->id}}"><button type="button" class="btn-primary btn">Decline</button></a>

    @endforeach
@endsection('content')