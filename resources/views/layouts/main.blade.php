<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<title>@yield('title')</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">


<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
<!-- Custom styles for this template -->
<link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ url('css/fuente.css') }}">
<link rel="stylesheet"  type="text/css" href="{{ url('css/daterangepicker.css') }}">
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">@yield('title')</a>

    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">@yield('name_user')</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
       @include('layouts.menu')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @yield('content')
        </main>
    </div>
</div>


<script src="{{ url('js/ext/feather.min.js') }}"></script>
<script src="{{ url('js/ext/Chart.min.js') }}"></script>
<script src="{{ url('js/ext/dashboard.js') }}"></script>
<script src="{{ url('js/jquery-2.1.1.min.js') }}"></script>
<script src="{{ url('js/ext/daterangepicker.js') }}"></script>
<script src="{{ url('js/js_general.js') }}"></script>
<script>
    inicializaControlFecha();
</script>

</body>
</html>
