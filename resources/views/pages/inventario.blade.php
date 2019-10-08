@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_inventario');
@endsection
@section('content')  
<div class="row" style="margin: 0 auto">
    <div class="card mt-3" style="width: 100%">
      <div class="card-body">                
        <h5 class="card-title">{{ $page }}</h5>
        <div class="row">
            <div class="col-sm-11">
               <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
                    </div>
                    <input type="text" id="InputDtShowSearchFilterArt" class="form-control" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-sm-1">
                 <div class="input-group mb-3">
                    <select class="custom-select" id="InputDtShowColumnsArtic" name="InputDtShowColumnsArtic">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="Todo">Todo</option>
                    </select>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>  
<div class="row">
    <div class="col-12">
        <div class="table-responsive mt-3 mb-5">
            <table class="table table-bordered table-sm" width="100%" id="dtInventarioArticulos"></table>
        </div>
    </div>
</div>

<!--MODAL: DETALLE DE ARTICULO-->
<div class="modal fade bd-example-modal-xl" data-backdrop="static" data-keyboard="false" id="mdDetalleArt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header d-block">
        <h5 class="modal-title text-center" id="tArticulo"></h5>
      </div>
      <div class="modal-body">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="navBodega" data-toggle="tab" href="#nav-bod" role="tab" aria-controls="nav-bod" aria-selected="true">Bodega</a>
            <a class="nav-item nav-link" id="navPrecios" data-toggle="tab" href="#nav-prec" role="tab" aria-controls="nav-prec" aria-selected="false">Precios</a>
            <a class="nav-item nav-link" id="navBonificados" data-toggle="tab" href="#nav-boni" role="tab" aria-controls="nav-boni" aria-selected="false">Bonificados</a>
            <a class="nav-item nav-link" id="navTransaccion" data-toggle="tab" href="#nav-trans" role="tab" aria-controls="nav-trans" aria-selected="false">Transacciones</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-bod" role="tabpanel" aria-labelledby="navBodega">
            <div class="row">
                <div class="col-sm-12">
                    <table id="tblBodega" class="table table-bordered mt-3">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Bodega</th>
                            <th>Nombre</th>
                            <th>Cant. Disponible</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-prec" role="tabpanel" aria-labelledby="navPrecios">
            <div class="row">
              <div class="col-sm-12">
                <table id="tblPrecios" class="table table-bordered mt-3">
                  <thead>
                  <tr>
                      <th>Nivel de Precio</th>
                      <th>Precio</th>
                  </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-boni" role="tabpanel" aria-labelledby="navBonificados">
            <table id="tblBonificados" class="table table-bordered mt-3">
              <thead>
              <tr>
                  <th>Reglas</th>
              </tr>
              </thead>
            </table>
          </div>
          <div class="tab-pane fade" id="nav-trans" role="tabpanel" aria-labelledby="navTransaccion">
            <div class="row">
              <div class="col-sm-12">
                <div class="card" style="border-top: none">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="f1">Desde</label>
                          <input type="text" class="input-fecha" id="f1">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="f2">Hasta</label>
                          <input type="text" class="input-fecha" id="f2">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="catArt">Tipo</label>
                          <select class="custom-select custom-select-sm" id="catArt">
                            <option selected value="Físico">Físico</option>
                            <option value="Costo">Costo</option>
                            <option value="Compra">Compra</option>
                            <option value="Aprobación">Aprobación</option>
                            <option value="Traspaso">Traspaso</option>
                            <option value="Venta">Venta</option>
                            <option value="Reservación">Reservación</option>
                            <option value="Consumo">Consumo</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <a href="#!" id="btnSearch" class="btn btn-primary btn-sm mt-4">Buscar</a>
                      </div>
                    </div>
                  </div>
                </div>
                <table id="tblTrans" class="table table-bordered mt-2">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Lote</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Referencia</th>
                    </tr>
                    </thead>
                    <tbody id="tbody1">
                      <tr>
                        <td colspan="5"><center>No hay datos que mostrar</center></td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection