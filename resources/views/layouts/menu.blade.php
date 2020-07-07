<!-- Vertical navbar -->
<div class="vertical-nav bg-white border-right" id="sidebar-menu-left">
  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-sm-12 text-center">        
        <img class="rounded mb-1" src="{{ url('images/p20.png') }}" width="85%">        
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-12">
        <p class="font-weight-normal mt-0 mb-0 text-left ml-3"><strong class="text-muted">Usuario: </strong>{{ Auth::User()->email }}</p>
        <p id="companny_id" class="font-weight-normal mt-0 mb-0 text-left ml-3" hidden="true">{{ Session::get('company_id') }}</p>
        <p class="font-weight-normal text-left ml-3"><strong class="text-muted">Unidad: </strong>{{ Session::get('companyName')}}</p>
      </div>
    </div>
    <hr style="padding:0; margin:0;"></hr>
    <div class="row mt-4">
      <div class="col-sm-12">
        <ul class="nav flex-column">
          @if(Auth::User()->activeRole()==1)
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Dashboard">
              <span data-feather="menu"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Reportes">
              <span data-feather="bar-chart-2"></span>
              Ventas por categorías
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Inventario">
              <span data-feather="shopping-cart"></span>
              Inventario
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Metas">
              <span data-feather="file"></span>
              Metas
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-secondary" href="Usuario">
                  <span data-feather="users"></span>
                  Usuarios
              </a>
           </li>
          <li>
            <a class="nav-link text-secondary" href="Saldos">
              <span data-feather="dollar-sign"></span>
              Saldos
            </a>
          </li>
            @if(Session::get('companyName')=='UNIMARK' || Session::get('companyName')=='INNOVA')
             <li>
              <a class="nav-link text-secondary" href="Recuperacion">
                <span data-feather="corner-down-left"></span>
                Recuperación
              </a>
            </li>
            @endif     
          @elseif(Auth::User()->activeRole()==2)
          <li class="nav-item">                
              <a class="nav-link text-secondary" href="Dashboard">
                  <span data-feather="menu"></span>
                  Dashboard <span class="sr-only">(current)</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-secondary" href="Reportes">
                  <span data-feather="bar-chart-2"></span>
                  Ventas por categorías
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-secondary" href="Inventario">
                  <span data-feather="shopping-cart"></span>
                  Inventario
              </a>
          </li>
          <li>
            <a class="nav-link text-secondary" href="Saldos">
              <span data-feather="dollar-sign"></span>
              Saldos
            </a>
          </li>
            @if(Session::get('companyName')=='UNIMARK')

            @endif
          @elseif(Auth::User()->activeRole()==3)
          <li class="nav-item">
              <a class="nav-link text-secondary" href="Metas">
                  <span data-feather="file"></span>
                  Metas
              </a>
          </li>
          @elseif(Auth::User()->activeRole()==4 )
            @if(Session::get('companyName')=='UNIMARK')
               <li>
                <a class="nav-link text-secondary" href="Recuperacion">
                  <span data-feather="corner-down-left"></span>
                  Recuperación
                </a>
              </li>
            @endif
          @elseif(Auth::User()->activeRole()==5)
          <li class="nav-item">
              <a class="nav-link text-secondary" href="Inventario">
                  <span data-feather="shopping-cart"></span>
                  Inventario
              </a>
          </li>
          @endif
          <li class="nav-item">
              <a class="nav-link text-secondary" href="Proyecciones">
                  <span data-feather="trending-up"></span>
                  Proyecciones de ventas
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-danger font-weight-bold" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span data-feather="log-out"></span> Cerrar sesion
              </a>
            </li>
        </ul>
      </div>
    </div>
  </div>
  <div id="_version">
  @include('layouts.app_version', array( 'appVersion'=>Auth::User()->gitVersion() ))
  </div>
</div>
<!-- End vertical navbar -->