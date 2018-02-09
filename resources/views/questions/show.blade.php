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

        </div>



    </div>




@endsection