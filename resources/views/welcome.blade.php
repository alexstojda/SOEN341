
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <script src="{{ url('js/jquery-3.3.1.min.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="{{ url('fonts/font-awesome.min.css')}}">
    <link rel="stylesheet" href="css/styles.css">

</head>

<body>
<nav class="navbar navbar-light navbar-expand-md">
    <div class="container-fluid"><a class="navbar-brand" href="#"><i class="fa fa-toggle-on" style="margin-right:6px;"></i>Q&amp;A CONCORDIA</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        @if (Route::has('login'))
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
                @auth
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="{{ url('/home') }}">HOME</a></li>
                @else
                     <li class="nav-item" role="presentation"><a class="nav-link active" href="{{ route('login') }}">LOGIN</a></li>
                     <li class="nav-item" role="presentation"><a class="nav-link" href="{{ route('register') }}">REGISTER</a></li>
                @endauth
            </ul>
        </div>
        @endif
    </div>
</nav>
<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="text-center"><br><strong>Spotted: Concordia</strong><br></h1>
        <p class="text-center" style="font-size:62px;"><strong>Q&amp;A</strong><br></p>
        <div class="wrapper"><a class="btn btn-light btn-sm" role="button" href="https://github.com/alexstojda/SOEN341">Learn more</a></div>
    </div>
    <header class="justify-content-center align-content-center" style="margin-top:0;">
        <h1 class="text-center"></h1>
        <h1 class="text-center"></h1>
    </header>
</div>
<script src="{{ url('js/popper.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
</body>

</html>


