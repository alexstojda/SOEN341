@extends('layouts.app')

@section('content')

    @if(Auth::check())
        <div class="container">
            <a href="questions/create" role="button" class="btn btn-info btn-block">
                Add a Question
            </a>
        </div>
    @endif
    <div class="container">
        @foreach ($questions as $question)


                        <div class="text-center">
                            <h3>
                                <div class="pull-left">Votes: {{ $question->countTotalVotes() }}</div>
                                <a href="questions/{{ $question->id }}" id="qs">{{ $question->title }}</a>
                                <small>-Posted: {{ $question->created_at->diffForHumans()}}</small>
                            </h3>
                        </div>
        @endforeach
    </div>

@endsection

