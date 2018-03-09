@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            <p></p>
            <p></p>
            <p></p>

            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row vertical-align">
                            <div class="col col-xs-6">
                                <h3 class="panel-title">Questions</h3>
                            </div>
                            @if(Auth::check())
                                <div class="col col-xs-6 text-right">
                                    {{--<a href="#" class="btn btn-default">Example</a>--}}
                                    <button type="button" class="btn btn-sm btn-primary btn-create"
                                            onclick="window.location.href='questions/create'">Add a Question
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                            <tr>
                                <th><em class="fa fa-cog"> Votes</em></th>
                                <th class="hidden-xs">Posted:</th>
                                <th>Question header</th>

                            </tr>
                            </thead>
                            @foreach ($questions as $question)
                                <tbody>
                                <tr>
                                    <td align="center">
                                        <vote model="questions" :id="{{$question->id}}" :auth="false"
                                              csrf="{{csrf_token()}}"></vote>
                                    </td>
                                    <td class="hidden-xs">{{ $question->created_at->diffForHumans()}}</td>
                                    <td><a dusk="question" href="questions/{{ $question->id }}"
                                           id="qs">{{ $question->title }}</a></td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>

                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-4">Page 1 of 5
                            </div>
                            <div class="col col-xs-8">
                                <ul class="pagination hidden-xs pull-right">
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                </ul>
                                <ul class="pagination visible-xs pull-right">
                                    <li><a href="#">«</a></li>
                                    <li><a href="#">»</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection