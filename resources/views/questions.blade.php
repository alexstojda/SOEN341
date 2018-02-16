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
            <div class="container">
                <div class="row">
                    <div class="col-xs-2">
                        <span class="pull-right">
                            @if(Auth::check())
                                <form method="POST" action="/questions/{{ $question->id }}/upvote/">
                                @csrf
                                    <button class="glyphicon glyphicon-chevron-up" type="submit"></button>
                             </form>
                            @endif
                            <span> {{ $question->countTotalVotes() }}</span><br/>
                            @if(Auth::check())
                                <form method="POST" action="/questions/{{ $question->id }}/downvote/">
                                @csrf
                                    <button class="glyphicon glyphicon-chevron-down" type="submit"></button>
                            </form>
                            @endif
                        </span>
                    </div>
                    <div class="col-xs-10">
                        <span class="pull-left">
                        <div class="text-center">
                            <h3><a href="questions/{{ $question->id }}">{{ $question->title }}</a></h3>
                        </div>
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

