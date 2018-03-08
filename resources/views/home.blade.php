@extends('layouts.app')

@section('content')
    @if (isset($status))
        <status-toast>
            {{ $status }}
        </status-toast>
    @endif

    <dashboard-notification>
        @{{ appName }}
    </dashboard-notification>

    <div class="container">
        <a href="questions/" role="button" class="btn btn-info btn-block">
            Go To Questions!
        </a>
    </div>



@endsection

@section('scripts')
    <script type="text/javascript">
      let v = new Vue({
        el: '#app',
        data: {
          appName: 'SOEN341'
        }
      })
    </script>
@endsection