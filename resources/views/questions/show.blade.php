@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ $status }}
        </status-toast>
    @endif

    {{--    <div class="container">
        <div class="container-fluid">
            <h2>{{ $question->title }}</h2>
            <hr>
            <div class="row">
                <div class="col-sm-1">
                        <span class="pull-left text-center">
                            <vote :id="{{$question->id}}" model="questions"
                                  :show_buttons="{{var_export(Auth::check())}}"></vote>
                        </span>
                </div>
                <div class="col-sm-11">
                    {!! $parser->parse($question->body) !!}
                </div>
            </div>
            <div class="row">
                <div class="pull-right text-center">
                    By {{$question->user->name}} <br>
                    {{ $question->created_at->diffForHumans()}}
                </div>
                <br>
                <hr>

                <comments model="questions" :id="{{$question->id}}"></comments>
            </div>
        </div>
    </div>--}}
    <div class="container">
        <question :id="{{$question->id}}" :show_forms="{{var_export(Auth::check())}}"></question>

        <answers :qid="{{$question->id}}" {!! Auth::check() ? ':uid="'.Auth::id().'"' : '' !!} :show_forms="{{var_export(Auth::check())}}"></answers>

        {{--     <div class="container">
                <h3>{{count($answers)}} Answers</h3>


                @foreach ($answers as $answer)
                    <div class="row">
                        <div class="pull-left col-md-1 text-center">
                            --}}{{--add the up/down vote buttons--}}{{--
                            <vote :id="{{$answer->id}}" model="answers" :show_buttons="{{var_export(Auth::check())}}"></vote>
                            @if($canAcceptAnswer && !$hasAcceptedAnswer)
                                <button class="accept-answer btn glyphicon glyphicon-unchecked"
                                        data-questionid="{{$question->id}}" data-answerid="{{$answer->id}}"></button>
                            @elseif($canAcceptAnswer && $hasAcceptedAnswer && ($answer->id == $question->answer_id))
                                <button class="accept-answer btn glyphicon glyphicon-check btn-success"
                                        data-questionid="{{$question->id}}" data-answerid="{{$answer->id}}"></button>
                            @elseif($hasAcceptedAnswer)
                                <button disabled class="accept-answer btn glyphicon glyphicon-check btn-success"></button>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-11 col-md-offset-1">
                                @if (is_null($answerComments))
                                @else
                                @foreach ($answerComments as $ac)
                                @foreach ($ac as $answerComment)
                                @if($answer->id==$answerComment->answer_id)
                                <br> + {{$answerComment->body}}
                                <small> - {{$answerComment->user->name}}</small>
                                @endif
                                @endforeach
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
        </div>

        @if (Auth::check())
            <div class="container">
                <form method="POST" action="/answers">
                    @csrf

                    <div class="form-group">
                        <label for="answer_body">Your answer:</label>
                        <textarea class="form-control" id="answer_body" name="body" required></textarea>
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        @endif--}}

        <br/>
        <div class="pull-right text-center">
            <a href="{{url('questions')}}" class="btn btn-info">
                <span class="glyphicon"></span> Back to Questions
            </a>
        </div>
    </div>
@endsection