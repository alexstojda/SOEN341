@extends('layouts.app')

@section('content')

    @if(Auth::check())
        <div class="container">
            <a href="questions/create" role="button" class="btn btn-info btn-block">
                Add a Question
            </a>
        </div>
    @endif
    <div class="container-fluid text-center">

        <h1>Questions</h1>
        @foreach ($questions as $question)

                        <div class="card container text-center">
                                <div class="pull-left"><h3>Votes: {{ $question->countTotalVotes() }} </h3></div>
                                <h3>   <a dusk="question" href="questions/{{ $question->id }}" id="qs">{{ $question->title }}</a>
                                <small>-Posted: {{ $question->created_at->diffForHumans()}}</small></h3>
                        </div>
        @endforeach
    </div>

@endsection

