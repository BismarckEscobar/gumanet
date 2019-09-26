<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<title>{{ $name }}</title>
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

<link rel="stylesheet" href="{{ url('css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ url('css/fuente.css') }}">
<link rel="stylesheet"  type="text/css" href="{{ url('css/daterangepicker.css') }}">
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span data-feather="home"></span>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Inventario">
                            <span data-feather="shopping-cart"></span>
                            Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Metas">
                            <span data-feather="file"></span>
                            Metas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Usuario">
                            <span data-feather="users"></span>
                            Usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Reportes">
                            <span data-feather="bar-chart-2"></span>
                            Reportes
                        </a>
                    </li>

                </ul>


            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week
                    </button>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <canvas class="my-4 w-100" id="myChart01" width="900" height="380"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <canvas class="my-4 w-100" id="myChart02" width="900" height="380"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <h2>Articulos</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tablaEjemplo">
                    <thead>
                    <tr>
                        <th>ARTICULO</th>
                        <th>DESCRIPCION</th>
                        <th>EXISTENCIA</th>
                        <th>LABORATORIO</th>
                        <th>PRECIO</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($rArticulos as $key => $value)
                        <tr>
                            <td>{{ $value['ARTICULO'] }}</td>
                            <td>{{ $value['DESCRIPCION'] }}</td>
                            <td>{{ number_format($value['total'],2) }}</td>
                            <td>{{ $value['LABORATORIO'] }}</td>
                            <td>{{ number_format($value['PRECIO_FARMACIA'],2) }}</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>


<script src="{{ url('js/ext/jquery-3.3.1.slim.min.js') }} "integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">//este esta dando proble4mas</script>
<script>window.jQuery || document.write('<script src="{{ url('js/ext/jquery-slim.min.js') }}"><\/script>')//tuvo probelma porque la ruta apuntaba a un nivel mas /vendor, el cual no existe</script><script src="{{ url ('js/ext/bootstrap.bundle.min.js') }}" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous">//este esta dando problemas</script>
<script src="{{ url('js/jquery.dataTables.js') }}"></script>
<script src="{{ url('js/ext/feather.min.js') }}"></script>
<script src="{{ url('js/ext/Chart.min.js') }}"></script>
<script src="{{ url('js/ext/dashboard.js') }}"></script>
<script src="{{ url('js/ext/moment.js') }}"></script>
<script src="{{ url('js/ext/daterangepicker.js') }}"></script>
<script src="{{ url('js/js_general.js') }}"></script>
<script>
inicializaControlFecha();
</script>
</body>
</html>
