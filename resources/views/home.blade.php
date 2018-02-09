@extends('layouts.app')

@section('content')
    @if (session('status'))
        <status-toast>
            {{ session('status') }}
        </status-toast>
    @endif

    <dashboard-notification>
        You are logged in!
    </dashboard-notification>

    <div class="container">
        <a href="questions/index" role="button" class="btn btn-info btn-block">
                Go To Questions!
        </a>
    </div>



@endsection