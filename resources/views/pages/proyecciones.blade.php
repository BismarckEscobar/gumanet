@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
	@include('jsViews.js_proyecciones');
@endsection
@section('content')  
<div class="row" style="margin: 0 auto">
    <div class="card mt-3" style="width: 100%">
      <div class="card-body">                
        <h5 class="card-title">{{ $page }}</h5>
        <div class="row">
            <div class="col-sm-8">
                 <div class="input-group mb-3">
                    <select class="custom-select" id="InputDtShowColumnsArtic" name="InputDtShowColumnsArtic">
                        <option value="" selected>Seleccione</option>
                        <option value="c_a">Cruz Azul</option>
                        <option value="m_p">Mercado Privado</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
            	<a href="#!" class="btn btn-primary" id="btnVerPro">Ver</a>
            </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="table-responsive mt-3 mb-5">
			<table id="dtProyecciones" class="table table-bordered" width="100%">
				<thead class="text-center">
					<tr>
						<th>ARTICULO</th>
						<th>DESCRIPCION</th>
						<th>CATEGORIA</th>
						<th>ORDEN MINIMA</th>
						<th>EMPAQUE(UD.)</th>
						<th>...</th>
					</tr>
				</thead>
				<tbody>

                </tbody>
			</table>
        </div>
    </div>
</div>
<!-- PAGINA TEMPORAL DE DETALLES -->
<div id="page-details" class="p-4 border-left" style="background-color: #f1f5f8">
    <div class="row">
        <div class="col-lg-12">
            <a href="#!" class="active-page-details btn btn-outline-primary btn-sm">Regresar</a>
        </div>
    </div>
    <div class="row mt-3"> 
        <div class="col-sm-12">
            <div class="card">
                          <div class="card-header">
                            <strong>REPORTE: 137051062</strong>
                          </div>
                <div class="card-body">
                    <form>
                      <div class="form-row">
                        <div class="form-group col-md-2">
                          <label for="cate">Categoria</label>
                          <input type="text" class="form-control" id="cate">
                        </div>
                        <div class="form-group col-md-10">
                          <label for="desc">Descripcion</label>
                          <input type="text" class="form-control" id="desc">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="labt">Laboratorio</label>
                            <input type="text" class="form-control" id="lab">
                        </div>
                        <div class="form-group col-md-3">
                          <label for="emp-ud">Empaque(Unidades)</label>
                          <input type="text" class="form-control" id="emp-ud">
                        </div>
                        <div class="form-group col-md-3">
                          <label for="ord-min">Orden minima</label>
                          <input type="text" class="form-control" id="ord-min">
                        </div>
                      </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card mt-3">
                          <div class="card-header">
                            Disponiblidad
                          </div>
                        <div class="card-body">
                            <form>
                              <div class="form-group">
                                <label for="disp">Disponible</label>
                                <input type="text" class="form-control" id="disp">
                              </div>
                            <div class="form-group">
                                <label for="pedi">Pedido</label>
                                <input type="text" class="form-control" id="pedi">
                              </div>
                            <div class="form-group">
                                <label for="trans">En transito</label>
                                <input type="text" class="form-control" id="trans">
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="card mt-3">
                          <div class="card-header">
                            Calculos
                          </div>
                        <div class="card-body">
                    <form>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="punt-reorden">Punto de reorden</label>
                          <input type="text" class="form-control" id="punt-reorden">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="pres-anio-ant">Presupuesto 2019</label>
                          <input type="text" class="form-control" id="pres-anio-ant">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="entr-pendi">Entrega(s) pendiente(s)</label>
                          <input type="text" class="form-control" id="entr-pendi">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="prom-mes-disp">Promedio meses disponibles</label>
                          <input type="text" class="form-control" id="prom-mes-disp">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="prom-vent-mens">Promedio venta mensual</label>
                          <input type="text" class="form-control" id="prom-vent-mens">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="disp-equiv">Dispibilidad equivalente</label>
                          <input type="text" class="form-control" id="disp-equiv">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="min-mes-disp">Minimos meses disponibles</label>
                          <input type="text" class="form-control" id="min-mes-disp">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="max-vent-mens">Maxima venta mensual</label>
                          <input type="text" class="form-control" id="max-vent-mens">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="cant-pedir">Cantidad a pedir</label>
                          <input type="text" class="form-control" id="cant-pedir">
                        </div>
                      </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection