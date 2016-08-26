@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>

                    <div class="panel-body">
                        <p> Welcome to the Flickr search Engine.</p>
                        <p><a href="{{ url('/home') }}">Click Here</a> to enter and use the search engine.</p>
                        <p> Please log in or register using the links above</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
