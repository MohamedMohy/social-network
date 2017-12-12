@extends('layouts.app')
@section('content')

    @foreach ($users as $user)
    <div class="container">
    <h3>{{$user->fname}} {{$user->lname}}</h3>
    <a href="{{ route('profile',$user->id) }}" aria-pressed="true">show profile</a>
            </div>
            @endforeach
          
@endsection('content')