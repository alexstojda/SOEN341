@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ isset($status) }}
        </status-toast>
    @endif

    <div class="text-center">
        <h1>Create Question</h1>
    </div>

    <hr>
    <div class="container">
        <div class="form-alert alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        <form method="POST" action="{{url('/questions?api_token='.Auth::user()->api_token)}}">
            @csrf
            <div class="form-group">
                <label for="q_header">Enter Main Question:</label>
                <input dusk="title-q" type="text" class="form-control" id="q_header" name="title">
            </div>
            <div class="form-group">
                <label for="q_body">Full Question Specifications + Context:</label>
                <textarea id="q_body" name="body"></textarea>
            </div>

            <button dusk="submit-q" type="submit" class="submit-question btn btn-danger">Submit</button>
        </form>
    </div>

@endsection

@section('scripts')
    <style type="text/css">
        .editor-toolbar.fullscreen {
            z-index: 1100 !important;
        }
    </style>
    <script>
        var validateSubmitForm = function () {
            if ($.trim($("#q_header").val()).length === 0) {
                return false;
            } else if ($.trim($("#q_body").val()).length === 0) {
                return false;
            } else {
                return true;
            }
        };
        $(function () {
            $(".form-alert").hide();
            $("form").submit(function (e) {
                console.log(validateSubmitForm());
                if (!validateSubmitForm()) {
                    e.preventDefault();
                    $(".form-alert").fadeTo(8000, 500).slideUp(500, function () {
                        $(".form-alert").slideUp(500);
                    });

                }
            });
        });
        var simplemde = new SimpleMDE({
            element: $('#q_body')[0],
            autosave: true,
            forceSync: true,
            renderingConfig: {
                singleLineBreaks: false
            }
        })
    </script>
@endsection