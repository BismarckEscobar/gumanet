<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
 <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
<!-- Mi CSS -->
<link rel="stylesheet" href="{{ url('css/style.css') }}">
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
<link rel="stylesheet" type="text/css" href="{{ url('css/jquery.dataTables.min.css') }}">
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">            
            @include('layouts.menu')
        </div>
        <div class="col-sm-10 p-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li  class="breadcrumb-item" id="item-nav-01"><a href="Dashboard">Dashboard</a></li>                    
                    <li class="ml-auto"><a href="#!" class="active-menu"><i class="material-icons" style="font-size: 20px">menu</i></a></li>
                </ol>
            </nav>
            <div class="p-3">
                @yield('content')
                <div id="sidebar" class="border-left shadow-sm p-3">
                    <p class="font-weight-bold ml-2">Configuración<button type="button" class="active-menu close" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>
                    <ul class="list-group list-group-flush mt-3">
                      <li><a href="#!"><i class="align-middle mb-1 material-icons">https</i> Cambiar contraseña</a></li>
                      <li><a href="#!"><i class="align-middle mb-1 material-icons">exit_to_app</i> Cerrar sesion</a></li>
                    </ul><hr>

                    <!--OPCIONES PARA DASHBOARDS-->
                    <div id="content-dash"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('js/ext/feather.min.js') }}"></script>
<script src="{{ url('js/ext/Chart.min.js') }}"></script>
<script src="{{ url('js/jquery-2.1.1.min.js') }}"></script>
<script src="{{ url('js/highcharts.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/ext/moment.js') }}"></script>
<script src="{{ url('js/ext/daterangepicker.js') }}"></script>
<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('js/js_general.js') }}"></script>
<script src="{{ url('js/sweetalert2.all.js') }}"></script>
<script src="{{ url('js/jquery.cookie.js') }}"></script>
@yield('metodosjs');
</body>
</html>