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

    <example-component></example-component>
@endsection