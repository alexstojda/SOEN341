@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ $status }}
        </status-toast>
    @endif

    <div class="container">
        <div class="container-fluid">
            <h2>{{ $question->title }}</h2>
            <hr>
            <div class="row">
                <div class="col-sm-1">
                        <span class="pull-left text-center">
                            @if(Auth::check())
                                <form method="POST" action="/questions/{{ $question->id }}/upvote/">
                                @csrf
                                    <button dusk="upvote-q{{ $question->id }}" class="glyphicon glyphicon-chevron-up"
                                            type="submit"></button>
                             </form>
                            @endif
                            <span> {{ $question->countTotalVotes() }}</span><br/>
                            @if(Auth::check())
                                <form method="POST" action="/questions/{{ $question->id }}/downvote/">
                                @csrf
                                    <button dusk="downvote-q{{ $question->id }}" class="glyphicon glyphicon-chevron-down"
                                            type="submit"></button>
                            </form>
                            @endif
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
                {{--Container to display question comments--}}
                @if (is_null($comments))
                @else
                    @foreach ($comments as $comment)
                        + {{$comment->body}}
                        <small> - {{$comment->user->name}}</small><br>
                    @endforeach
            </div>
            @endif
        </div>
        {{--Button that holds a form to post Comments to Question--}}
        @if (Auth::check())
            <div class="pull-right">
                <a href="#com" class="btn btn-default pull-right" data-toggle="collapse">Comment</a>
            </div>
            <div id="com" class="collapse">

                <div class="container-fluid">
                    <form method="POST" action="/comments">
                        @csrf

                        <div class="form-group">
                            <label for="commentBody">Your comment:</label>
                            <input type="textarea" class="form-control" id="c_body" name="body" required>
                            <input type="hidden" name="question_id" value="{{$question->id}}">
                            <input type="hidden" name="answer_id" value=null>
                            <input type="hidden" name="i_am_a" value="commentQ">
                        </div>

                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <div class="container">
        <h3>{{count($answers)}} Answers</h3>
        @foreach ($answers as $answer)
            <hr>
            <div class="fluid-container">
                {{--add the up/down vote buttons--}}
                <div class="row">
                    <div class="pull-left col-xs-1 text-center">
                        @if(Auth::check())
                            <form method="POST" action="/answers/{{ $answer->id }}/upvote/">
                                @csrf
                                <button dusk="upvote-a{{ $answer->id }}" class="glyphicon glyphicon-chevron-up"
                                        type="submit"></button>
                            </form>
                        @endif
                        <span> {{ $answer->countTotalVotes() }}</span><br/>
                        @if(Auth::check())
                            <form method="POST" action="/answers/{{ $answer->id }}/downvote/">
                                @csrf
                                <button dusk="downvote-a{{ $answer->id }}"
                                        class="glyphicon glyphicon-chevron-down" type="submit"></button>
                            </form>
                        @endif
                    </div>
                    <div>
                        <ul>
                            {{-- show the questions --}}
                            <h4>{!! $parser->parse($answer->body) !!} <br>
                                <small>by {{$answer->user->name}}</small>
                            </h4>
                        </ul>

                        {{--List of comments for each answer--}}
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
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
                </div>
            </div>

            @if (Auth::check())
                {{--Button to form for posting comments on each answer--}}
                <div class="pull-right">
                    <a href="#ca{{$answer->id}}" class="btn btn-default" data-toggle="collapse">Comment</a>
                </div>
                <div id="ca{{$answer->id}}" class="collapse">

                    <div class="container-fluid">
                        <form method="POST" action="/comments">
                            @csrf

                            <div class="form-group">
                                <label for="answerCommentBody">Your comment:</label>
                                <input type="text-area" class="form-control" id="c_body" name="body" required>
                                <input type="hidden" name="question_id" value="{{$question->id}}">
                                <input type="hidden" name="answer_id" value="{{$answer->id}}">
                                <input type="hidden" name="i_am_a" value="commentA">
                            </div>

                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>
            @endif
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
    @endif
    <br/>
    <div class="text-center">
        <a href="/questions" class="btn btn-info">
            <span class="glyphicon"></span> Back to Questions
        </a>
    </div>


@endsection
@section('scripts')
    <style type="text/css">
        .editor-toolbar.fullscreen {
            z-index: 1100 !important;
        }
    </style>
    <script>
        var simplemde = new SimpleMDE({
            element: $("#answer_body")[0],
            autosave: true,
            forceSync: true,
            renderingConfig: {
                singleLineBreaks: false
            }
        });
    </script>
@endsection