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

        <br/>
        <div class="pull-right text-center">
            <a href="{{url('questions')}}" class="btn btn-info">
                <span class="glyphicon"></span> Back to Questions
            </a>
        </div>
    </div>
@endsection