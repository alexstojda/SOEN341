@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="questions/create" role="button" class="btn btn-info btn-block">
            Add a Question
        </a>
    </div>

    <div class="container">
        @foreach ($questions as $question)
            <div class="text-center">
                <h3><a href="questions/{{ $question->id }}">{{ $question->title }}</a></h3>

            </div>
        @endforeach
    </div>

@endsection