@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ $status }}
        </status-toast>
    @endif

    <dashboard-notification>
        You are logged in!
    </dashboard-notification>

    <div class="container">
        <a href="questions/" role="button" class="btn btn-info btn-block">
                Go To Questions!
        </a>
    </div>



@endsection