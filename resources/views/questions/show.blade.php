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

             <br><hr>

            {{--Container to display question comments--}}
            @if (is_null($comments))
            @else
                <div class="text-center">
                    <br><br>
                    @foreach ($comments as $comment)
                        <div> {{--<class="text-center">--}}
                            + {{$comment->body}} <h5>{{$comment->user->name}}</h5>
                        </div>
                    @endforeach

                </div>
            @endif

            {{--Button that holds a form to post Comments to Question--}}
            @if (Auth::check())
                <a href="#com" class="btn btn-default pull-right" data-toggle="collapse">Comment</a>
                <div id="com" class="collapse">

                    <div class="container-fluid">
                        <form method="POST" action="/comments/{{ $question->id }}">
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
                                            @csrf
                                            <button class="glyphicon glyphicon-chevron-up" type="submit"></button>
                                         </form>
                                        @endif
                                        <span> {{ $answer->countTotalVotes() }}</span><br/>
                                        @if(Auth::check())
                                        <form method="POST" action="/answers/{{ $answer->id }}/downvote/">
                                            @csrf
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

                    {{--List of comments for each answer--}}
                    @if (is_null($answerComments))
                    @else
                        <div class="fluid-container">
                            @foreach ($answerComments as $ac)
                                @foreach ($ac as $answerComment)
                                    @if($answer->id==$answerComment->answer_id)
                                        <ul>
                                            <div>
                                                <li>{{$answerComment->body}}  <h6>{{$answerComment->user->name}}</h6></li>
                                            </div>
                                        </ul>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @endif

                    @if (Auth::check())
                        {{--Button to form for posting comments on each answer--}}
                        <a href="#ca{{$answer->id}}" class="btn btn-default" data-toggle="collapse">Comment</a>
                        <div id="ca{{$answer->id}}" class="collapse">

                            <div class="container-fluid">
                                <form method="POST" action="/comments/{{ $question->id }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="answerCommentBody">Your comment:</label>
                                        <input type="text-area" class="form-control" id="c_body" name="body" required>
                                        <input type="hidden" name="question_id" value=null>
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

            <div class="container-fluid">
                <form method="POST" action="/answers/{{ $question->id }}">
                    @csrf

                    <div class="form-group">
                        <label for="answer_label">Your answer:</label>
                        <input type="textarea" class="form-control" id="answer_body" name="body" required>
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
            <br/>
            <a href="/questions" class="btn btn-info">
                <span class="glyphicon"></span> Back to Questions
            </a>
        </div>
    </div>
@endsection