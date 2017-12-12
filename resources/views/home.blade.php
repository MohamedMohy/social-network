@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{"welcome "}}{{Auth::user()->fname}} {{"!"}}</div>
                <form method="post" action="{{ route('home') }}">
                    {{ csrf_field() }}
                <textarea required class="panel-heading form-control" style="resize: none" rows="5" id="post" name="post" placeholder="What's in your mind,{{Auth::user()->fname}}?">
                </textarea>

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
            </div>
        </div>
    </div>
</div>
@endsection
