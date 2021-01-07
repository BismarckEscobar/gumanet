@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_dashboard')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="h4 mt-4">Dashboard</h4>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="opcMes" class="text-muted m-0">Filtrar por mes</label>
                        <select class="form-control form-control-sm" id="opcMes">
                          <?php                        
                            $mes = date("m");
                            $meses = array('none','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');

                            for ($i= 1; $i <= 12 ; $i++) {
                              if ($i==$mes) {
                                echo'<option selected value="'.$i.'">'.$meses[$i].'</option>';
                              }else {
                                echo'<option value="'.$i.'">'.$meses[$i].'</option>';
                              }
                            }
                          ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="opcAnio" class="text-muted m-0">por año</label>
                        <select class="form-control form-control-sm" id="opcAnio">
                            <?php
                                $year = date("Y");
                                for ($i= 2018; $i <= $year ; $i++) {
                                  if ($i==$year) {
                                    echo'<option selected value="'.$i.'">'.$i.'</option>';
                                  }else {
                                    echo'<option value="'.$i.'">'.$i.'</option>';
                                  }
                                 
                                }
                            ?>
                        </select>  
                    </div>                
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <a href="#!" style="width: 100%" id="filterM_A" class="btn btn-primary float-right mt-3">Aplicar</a>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div class="content-graf mb-5">
        <div class="row" id="ct04">
            <div class="graf col-sm-12 mt-3">
                <div class="container-vms" id="grafVtsMes" style="width: 100%; margin: 0 auto"></div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-sm-12 mb-1">
                                <h4 class="text-muted text-center font-weight-bold divSpinner">Acumulado Año</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-5 text-center">                    
                                <p class="text-muted m-0 lblanio2">...</p>
                                <p class="font-weight-bolder" id="lblmontoanio2" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-5 text-center">
                                <p class="text-muted m-0 lblanio1">...</p>
                                <p class="font-weight-bolder" id="lblmontoanio1" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-2 text-center">
                                <p class="text-muted m-0">% CREC.</p>
                                <p class="font-weight-bolder" style="font-size: 1.2rem!important" id="lblCrecimiento">...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-sm-12 mb-1">
                                <h4 class="text-muted text-center font-weight-bold divSpinner">Promedio Mensual</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-5 text-center">                    
                                <p class="text-muted m-0 lblanio2">...</p>
                                <p class="font-weight-bolder" id="lblporcenanio2" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-5 text-center">
                                <p class="text-muted m-0 lblanio1">...</p>
                                <p class="font-weight-bolder" id="lblporcenanio1" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-2 text-center">
                                <p class="text-muted m-0">% CREC.</p>
                                <p class="font-weight-bolder" style="font-size: 1.2rem!important" id="lblporcentaje">...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-sm-12 mb-1">
                                <h4 class="text-muted text-center font-weight-bold divSpinner">Acumulado Año Anterior</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-5 text-center">                    
                                <p class="text-muted m-0 clsAnioPas">...</p>
                                <p class="font-weight-bolder" id="lblmontoanio2_" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-5 text-center">
                                <p class="text-muted m-0 clsAnioAntePas">...</p>
                                <p class="font-weight-bolder" id="lblMontoAnio3" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-2 text-center">
                                <p class="text-muted m-0">% CREC.</p>
                                <p class="font-weight-bolder" style="font-size: 1.2rem!important" id="lblCrecimiento_">...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-sm-12 mb-1">
                                <h4 class="text-muted text-center font-weight-bold divSpinner">Promedio Mensual Año Anterior</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-5 text-center">                    
                                <p class="text-muted m-0 clsAnioPas">...</p>
                                <p class="font-weight-bolder" id="lblporcenanio1_" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-5 text-center">
                                <p class="text-muted m-0 clsAnioAntePas">...</p>
                                <p class="font-weight-bolder" id="lblporcenanio3" style="font-size: 1.2rem!important">...</p>
                            </div>
                            <div class="col-sm-2 text-center">
                                <p class="text-muted m-0">% CREC.</p>
                                <p class="font-weight-bolder" style="font-size: 1.2rem!important" id="lblporcentaje_">...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="ct05">            
            <div class="graf col-sm-12 mt-3 text-right">
                <figure class="highcharts-figure">
                <select class="selectpicker col-sm-4 form-control form-control-sm mb-2 mt-3" id="select-cate" data-show-subtext="false" data-live-search="true" ></select>
                    <div class="container-cat" id="grafVtsXCateg"></div>
                </figure>
            </div>
        </div>
        <div class="row" id="ct01">
            <div class="graf col-sm-4 mt-3"><div class="container-vm" id="grafVentas"></div></div>
            <div class="graf col-sm-4 mt-3"><div class="container-rm" id="grafRecupera"></div></div>
            <div class="graf col-sm-4 mt-3"><div class="container-vb" id="grafBodega"></div></div>
        </div>
        <div class="row" id="ct03">
            <div class="graf col-sm-6 mt-3"><div class="container-cv" id="grafCompMontos"></div></div>
            <div class="graf col-sm-6 mt-3"><div class="container-cc" id="grafCompCantid"></div></div>
        </div>
        <div class="row" id="ct02">
            <div class="graf col-sm-6 mt-3"><div class="container-tc" id="grafClientes"></div></div>
            <div class="graf col-sm-6 mt-3"><div class="container-tp" id="grafProductos"></div></div>
        </div>
    </div>
    <!-- PAGINA TEMPORAL DE DETALLES -->
    <div id="page-details" class="p-4 border-left" style="background-color: #f1f5f8">
        <div class="row">
            <div class="col-lg-12">
                <a href="#!" class="active-page-details btn btn-outline-primary btn-sm">Regresar</a>
            </div>
        </div>
        <div class="row center">
            <div class="col-sm-12">
                <div class="card mt-3 border-0 shadow-sm">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <h5 class="card-title" id="title-page-tem"></h5>
                            <p class="text-muted" id="fechaFiltrada"></p>
                        </div>
                        <div class="col-sm-8">
                            <div class="row ml-3">
                                <div class="col-sm-4" id="montoMetaContent">
                                    <p class="text-muted m-0" id="txtMontoMeta"></p>
                                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="MontoMeta"></p>
                                </div>
                                <div class="col-sm-4" id="montoRealContent">
                                    <p class="text-muted m-0" id="txtMontoReal"></p>
                                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="MontoReal"></p>
                                </div>
                                <div class="col-sm-4" id="cumplMetaContent">
                                    <p class="text-muted m-0">% Cumpl.</p>
                                    <p class="font-weight-bolder text-info" style="font-size: 1.3rem!important" id="cumplMeta"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-11 mt-3">
                           <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
                                </div>
                                <input type="text" id="filterDtTemp" class="form-control" placeholder="Buscar">
                            </div>
                        </div>
                        <div class="col-sm-1 mt-3">
                             <div class="input-group">
                                <select class="custom-select" id="cantRowsDtTemp">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="-1">Todo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="table-responsive">
                    <div id="cjRutVentas"><table class="table table-bordered table-sm" width="100%" id="dtTotalXRutaVent" ></table></div>        
                </div>
            </div>
            
            <div class="col-sm-12 mt-2">
                <div class="table-responsive">
                    <div id="cjRecuperacion">
                        <table class="table table-bordered table-sm" width="100%" id="dtRecuperacion"></table>
                    </div>
                </div>                    
            </div>

            <div class="col-sm-12 mt-2">
                <div class="table-responsive">
                   <div id="cjRecu_GumaPharma">
                        <table class="table table-bordered table-sm" width="100%" id="dtRecu_GumaPharma"></table>
                    </div>
                </div>                    
            </div>

            <div class="col-sm-12 mt-2">
                <div class="table-responsive">
                    <div id="cjCliente">
                        <p class="font-weight-bold">ARTICULOS FACTURADOS</p>
                        <table class="table table-bordered table-sm" width="100%" id="dtCliente"></table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-2">
                <div class="table-responsive">
                    <div id="cjArticulo">
                        <p class="font-weight-bold">CLIENTES</p>
                        <table class="table table-bordered table-sm" width="100%" id="dtArticulo"></table>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<!-- Modal:Detalle Venta Comparación Meta, Real Cumplimineto -->
<div class="modal fade" id="mdDetailsVentas" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bolder text-info" id="vendedorNombre"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodyModal">
                <div class="row">
                <div class="col-sm-2">
                    <p class="text-muted m-0">Meta Units.</p>
                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="total_Meta_Unidad"></p>
                </div>
                <div class="col-sm-2">                    
                    <p class="text-muted m-0" >Real Units.</p>
                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="total_Real_Unidad"></p>
                </div>
                <div class="col-sm-2 border-right">
                    <p class="text-muted m-0">Diferencia en %</p>
                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="total_Dif_Unidad"></p>
                </div>
                <div class="col-sm-2">
                    <p class="text-muted m-0" >Real Vtas.</p>
                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="total_Real_Efectivo"></p>
                </div>
                <div class="col-sm-2">
                    <p class="text-muted m-0">Meta Vtas.</p>
                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="total_Meta_Efectivo"></p>
                </div>
                <div class="col-sm-2">
                    <p class="text-muted m-0">Diferencia en %</p>
                    <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="total_Dif_Efectivo"></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-11 mt-2">
                   <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
                        </div>
                        <input type="text" id="filterDtDetalle" class="form-control" placeholder="Buscar">
                    </div>
                </div>
                <div class="col-sm-1 mt-2">
                     <div class="input-group">
                        <select class="custom-select" id="cantRowsDtDetalle">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="-1">Todo</option>
                        </select>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="table-responsive">
                            <div id="cjVentas"><table class="table table-bordered table-sm" width="100%" id="dtVentas" ></table></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal:Detalle -->
<div class="modal fade" id="mdDetails" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal-01"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="bodyModal">
        <div class="row">
            <div class="col-sm-3">                    
                <p class="text-muted m-0" id="text-mes-actual"></p>
                <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="val-mes-actual"></p>
            </div>
            <div class="col-sm-3">
                <p class="text-muted m-0" id="text-anio-pasado"></p>
                <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="val-anio-pasado"></p>
            </div>
            <div class="col-sm-2 border-right">
                <p class="text-muted m-0">Diferencia en %</p>
                <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="dif-porcen-vts"></p>
            </div>
            <div class="col-sm-2">
                <p class="text-muted m-0" id="text-mes-pasado"></p>
                <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="val-mes-pasado"></p>
            </div>
            <div class="col-sm-2">
                <p class="text-muted m-0">Diferencia en %</p>
                <p class="font-weight-bolder" style="font-size: 1.3rem!important" id="dif-porcen-its"></p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection