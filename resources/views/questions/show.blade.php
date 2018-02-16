@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ $status }}
        </status-toast>
    @endif
    <div class="container">

        <div class="text-center">

            <h2>{{ $question->title }}</h2>

            <p>{{ $question->body }}</p>

            <div class="pull-right">
                By {{$question->user->name}} <br>
                {{ $question->created_at->diffForHumans()}}
            </div>

            <div class="container">
                <h3>Answers:</h3>
                @foreach ($answers as $answer)
                    <div class="text-center">
                        {{--add the up/down vote buttons--}}

                        <div class="container">
                            <div class="row">

                                <div class="col-xs-6">
                                    <span class="pull-right">
                                        @if(Auth::check())
                                            <form method="POST" action="/answers/{{ $answer->id }}/upvote/">
                                                {{ csrf_field() }}
                                                <button class="glyphicon glyphicon-chevron-up" type="submit"></button>
                                         </form>
                                        @endif
                                        <span> {{ $answer->countTotalVotes() }}</span><br/>
                                        @if(Auth::check())
                                            <form method="POST" action="/answers/{{ $answer->id }}/downvote/">
                                             {{ csrf_field() }}
                                                <button class="glyphicon glyphicon-chevron-down" type="submit"></button>
                                        </form>
                                        @endif
                                    </span>
                                </div>
                                <div class="col-xs-6">
                                    <span class="pull-left">
                                    {{-- show the questions --}}
                                        <br/><p>+ {{ $answer->body }} <h6>by {{$answer->user->name}}</h6></p>
                                        {{--<p>{{ $answer->userName }}}</p> // to be added--}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="container-fluid">
                <form method="POST" action="/answers/{{ $question->id }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="answer_label">Your answer:</label>
                        <input type="textarea" class="form-control" id="answer_body" name="body" required>
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Post</button>

            </div>
            </form>
            <br/>
            <a href="/questions" class="btn btn-info">
                <span class="glyphicon"></span> Back to Questions
            </a>

        </div>


    </div>



    </div>




@endsection