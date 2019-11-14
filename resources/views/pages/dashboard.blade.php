@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_dashboard');
@endsection
@section('content') 
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8">
            <h1 class="h4 mb-4 pb-0">Resumen</h1>
        </div> 
        
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-4">
                  <select class="form-control form-control-sm float-right" id="inputGroupSelect01">
                    <option selected>Mes</option>
                    <option value="1">enero</option>
                    <option value="2">febrero</option>
                    <option value="3">marzo</option>
                    <option value="4">abril</option>
                    <option value="5">mayo</option>
                    <option value="6">junio</option>
                    <option value="7">julio</option>
                    <option value="8">agosto</option>
                    <option value="9">septiembre</option>
                    <option value="10">octubre</option>
                    <option value="11">noviembre</option>
                    <option value="12">diciembre</option>
                  </select>
                </div>
                <div class="col-sm-4 float-right">
                  <select class="form-control form-control-sm" id="inputGroupSelect01">
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
                <div class="col-sm-4"><a href="#!" style="width: 100%" class="btn-sm btn btn-primary float-right">Aplicar</a></div>
                
            </div>
        </div>
    </div>
    <div class="content-graf">
        <div class="row" id="ct01">
            <div class="graf col-sm-4"><div class="container-vm" id="chart01"></div></div>
            <div class="graf col-sm-4"><div class="container-rm" id="chart02"></div></div>
            <div class="graf col-sm-4"><div class="container-vb" id="chart03"></div></div>
        </div>
        <div class="row mt-5" id="ct02">
            <div class="graf col-sm-6"><div class="container-tc" id="chart04"></div></div>
            <div class="graf col-sm-6"><div class="container-tp" id="chart05"></div></div>
        </div>
    </div>
    <!-- PAGINA TEMPORAL DE DETALLES -->
    <div id="page-details" class="p-4" style="background-color: #f1f5f8">
        <div class="row">
            <div class="col-sm-12">
                <a href="#!" class="active-page-details btn btn-outline-primary btn-sm">Regresar</a>
            </div>
        </div>
        <div class="row center">
            <div class="col-sm-12">
                <div class="card mt-3">
                  <div class="card-body">
                    <h5 class="card-title" id="title-page-tem"></h5>
                    <div class="row">
                        <div class="col-sm-11">
                           <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
                                </div>
                                <input type="text" id="filterDtTemp" class="form-control" placeholder="Buscar">
                            </div>
                        </div>
                        <div class="col-sm-1">
                             <div class="input-group mb-3">
                                <select class="custom-select" id="cantRowsDtTemp">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="Todo">Todo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive mt-3 mb-5">
                    <table class="table table-bordered table-sm" width="100%" id="dtTemporal"></table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-title" id="MontoReal"></h5>
                    <p class="card-text" id="txtMontoReal"></p>
                  </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-title" id="MontoMeta"></h5>
                    <p class="card-text" id="txtMontoMeta"></p>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection