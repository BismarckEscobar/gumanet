@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_reportes');
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
		<div class="card-header">Filtrar por</div>
    	<div class="card-body">
			<div class="row">
				<div class="col-sm-3 p-1">
					<select class="selectpicker form-control form-control-sm" data-show-subtext="true" data-live-search="true">
						<option selected>Tipo</option>
						<option>Clase terapeutica</option>
					</select>
				</div>
				<div class="col-sm-3 p-1">
					<select class="selectpicker form-control form-control-sm" data-show-subtext="true" data-live-search="true">
						<option selected>Cliente</option>
						<option value="1">Cliente 01</option>
					</select>
				</div>
				<div class="col-sm-3 p-1">
					<select class="selectpicker form-control form-control-sm" data-show-subtext="true" data-live-search="true">
						<option selected>Articulo</option>
						<option value="1">Articulo 01</option>
					</select>
				</div>
				<div class="col-sm-3 p-1 border-left">
		            <div class="row">
		                <div class="col-sm-4">
		                  <select class="form-control form-control-sm float-right" id="cmbMes">
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
		                <div class="col-sm-4">
		                  <select class="form-control form-control-sm" id="cmbAnio">
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
    	</div>
    </div>
    <div class="row mt-3">
    	<div class="col-sm-8">
    		<div class="card">
    			<div class="card-body">
    				<h5 class="card-title">Clientes</h5>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
						</div>
						<input type="text" id="InputDtShowSearchFilterArt" class="form-control" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">
					</div>
    				<div class="table-responsive mt-3 mb-5">
						<table id="tblClientes" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th>Codigo</th>
									<th>Nombre</th>
									<th>Factura</th>
									<th>Fecha</th>
									<th>Monto</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>00001</td>
									<td>Cliente 01</td>
									<td>xxxxxx</td>
									<td>01/01/2019</td>
									<td>C$ 10.00</td>
								</tr>
							</tbody>
						</table>
    				</div>
			        <div class="row">
			            <div class="col-sm-3">
			                <div class="card text-center">
			                  <div class="card-body">
			                    <h5 class="card-title" id="MontoMeta">C$ 0.00</h5>
			                    <p class="card-text" id="txtMontoMeta">Total cliente</p>
			                  </div>
			                </div>
			            </div>
			        </div>
    			</div>
    		</div>
    	</div>
		<div class="col-sm-4">
			<div class="card">
				<div class="card-body">
					<div id="container01"></div>
				</div>		
			</div>
		</div>
    </div>

</div> 
@endsection