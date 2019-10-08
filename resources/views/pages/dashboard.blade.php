@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_dashboard');
@endsection
@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Resumen</h1>
    <div class="content-graf">
        <div class="row">
            <div class="graf col-sm-4"><div class="container-vm" id="chart01"></div></div>
            <div class="graf col-sm-4"><div class="container-rm" id="chart02"></div></div>
            <div class="graf col-sm-4"><div class="container-vb" id="chart03"></div></div>
        </div>
        <div class="row mt-5">
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
    </div>
</div>
@endsection