<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <center><img class="rounded mb-3" src="{{ url('images/p20.png') }}" width="75%" ></center>
        <hr style="padding:0; margin:0; margin-bottom: 5px"></hr>
        <label class="pl-3 flow-text" style="font-size: 1.1em; font-weight: bold;"></span>{{ Auth::User()->email }}  </label><br>
        {{--<span>{{ Auth::User()->role }}</span>--}}
        <hr style="padding:0; margin:0;"></hr>
        <ul class="nav flex-column">
            <li class="nav-item">                
                <a class="nav-link" href="Dashboard">
                    <span data-feather="menu"></span>
                    Resumen <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Reportes">
                    <span data-feather="bar-chart-2"></span>
                    Ventas
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
                <a class="nav-link" href="Inventario">
                    <span data-feather="shopping-cart"></span>
                    Inventario
                </a>
            </li>
        </ul>
    </div>
</nav>