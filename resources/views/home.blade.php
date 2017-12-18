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
@endsection
