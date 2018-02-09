@extends('layouts.app')

@section('content')
    @if (session('status'))
    <status-toast>
    {{ session('status') }}
    </status-toast>
    @endif

    <div class="container">
        <a href="create" role="button" class="btn btn-info btn-block">
            Add a Question
        </a>
    </div>

    <div class="container">
        @foreach ($questions as $question)
            <div class="text-center">
                <h3><a href="{{ $question->id }}">{{ $question->title }}</a></h3>

            </div>
        @endforeach
    </div>

@endsection