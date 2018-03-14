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
        <form method="POST" action="/questions">
            @csrf

            <div class="form-group">
                <label for="q_header">Enter Main Question:</label>
                <input type="text" class="form-control" id="q_header" name="title" required>
            </div>
            <div class="form-group">
                <label for="q_body">Full Question Specifications + Context:</label>
                <textarea id="q_body" name="body" required></textarea>
            </div>

            <button type="submit" class="btn btn-danger">Submit</button>
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