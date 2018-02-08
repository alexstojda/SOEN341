{{--@extends('layouts.app')--}}

{{--@section('content')--}}
    {{--@if (session('status'))--}}
    {{--<status-toast>--}}
    {{--{{ session('status') }}--}}
    {{--</status-toast>--}}
    {{--@endif--}}
    {{--@foreach ($questions as $question)--}}
    {{--<div class="text-center">--}}
        {{--<h2><a href="question/{{ question->q_head }}">{{ question->q_head }}</h2>a></h2>--}}

        {{--<p>{{ question->q_body }}</p>--}}

    {{--</div>--}}
    {{--@endforeach--}}


{{--@endsection--}}