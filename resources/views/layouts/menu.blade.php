<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">

        <center>
            <img class="rounded mb-1" src="{{ url('images/p20.png') }}" width="75%">
            <p class="font-weight-normal mt-0 mb-0 text-left ml-3"><strong>Usuario: </strong>{{ Auth::User()->email }}</p>
            <p class="font-weight-normal text-left ml-3"><strong>Unidad: </strong>{{ Session::get('companyName')}}</p>
        </center>

        <hr style="padding:0; margin:0;"></hr>
        <ul class="nav flex-column  mt-3">
            @if(Auth::User()->activeRole()==1)
            <li class="nav-item">                
                <a class="nav-link" href="Dashboard">
                    <span data-feather="menu"></span>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Reportes">
                    <span data-feather="bar-chart-2"></span>
                    Ventas por categorías
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
            @elseif(Auth::User()->activeRole()==2)
            <li class="nav-item">                
                <a class="nav-link" href="Dashboard">
                    <span data-feather="menu"></span>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Reportes">
                    <span data-feather="bar-chart-2"></span>
                    Ventas por categorías
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Inventario">
                    <span data-feather="shopping-cart"></span>
                    Inventario
                </a>
            </li>
            @elseif(Auth::User()->activeRole()==3)
            <li class="nav-item">
                <a class="nav-link" href="Metas">
                    <span data-feather="file"></span>
                    Metas
                </a>
            </li>
            @endif
        </ul>        

    </div>
    @include('layouts.app_version', array( 'appVersion'=>Auth::User()->gitVersion() ))
</nav>