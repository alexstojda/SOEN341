@extends('layouts.app')

@section('content')
    @if (session('status'))
        <status-toast>
            {{ session('status') }}
        </status-toast>
    @endif
    <div class="container">

        <div class="text-center">

            <h2>{{ $question->title }}</h2>

            <p>{{ $question->body }}</p>

            <div class="container-fluid">
                <form method="POST" action="/answers/{{ $question->id }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="answer_label">Your answer:</label>
                        <input type="textarea" class="form-control" id="answer_body" name="body" required>
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>

        </div>



    </div>




@endsection