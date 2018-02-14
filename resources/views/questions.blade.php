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
                        <a href="#">
                            <span class="glyphicon glyphicon-chevron-up"></span>
                        </a><br/>
                        <span> {{ $votes_val = 5 }}</span><br/>
                        <a href="#">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
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