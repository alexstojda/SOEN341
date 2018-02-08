@extends('layouts.app')

@section('content')
    {{--@if (session('status'))--}}
        {{--<status-toast>--}}
            {{--{{ session('status') }}--}}
        {{--</status-toast>--}}
    {{--@endif--}}

    <div class="text-center">
        <h1>Create Question</h1>
        Here
    </div>

    <hr>
    <form method="POST" action="/questions">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="questionHeader">Enter Main Question:</label>
            <input type="text" class="form-control" id="q_header" name="q_head" required>
        </div>
        <div class="form-group">
            <label for="questionBody">Full Question Specifics:</label>
            <input type="text-area" class="form-control" id="q_body" name="q_body" required>
        </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    </form>


@endsection