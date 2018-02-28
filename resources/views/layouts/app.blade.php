<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ url('js/jquery-3.3.1.min.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="assets/css/styles.css">--}}
</head>

<body>
<nav class="navbar navbar-light navbar-expand-md">
    <div class="container-fluid"><a class="navbar-brand" href="#">Q&amp;A Concordia</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse"
             id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
               @guest
                <li class="nav-item" role="presentation"><a class="nav-link active" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
               @else
                <li class="dropdown">
                    <a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" role="presentation" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@yield('content')
<script src="{{ url('js/popper.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
</body>

</html>

