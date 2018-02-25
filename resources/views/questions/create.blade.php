@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ isset($status) }}
        </status-toast>
    @endif

    <div class="text-center">
        <h1>Create Question</h1>
    </div>

    <hr>
    <div class="container-fluid">
    <form method="POST" action="/questions">
        @csrf

        <div class="form-group">
            <label for="questionHeader">Enter Main Question:</label>
            <input type="text" class="form-control" id="q_header" name="title" required>
        </div>
        <div class="form-group">
            <label for="questionBody">Full Question Specifications + Context:</label>
            <input type="text-area" class="form-control" id="q_body" name="body" required>
        </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>

@endsection