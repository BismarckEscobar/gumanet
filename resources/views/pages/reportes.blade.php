@extends('layouts.main')
@section('title' , $data['name'])
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
					<select class="selectpicker form-control form-control-sm" id="cmbClase" data-show-subtext="true" data-live-search="true">
                    @foreach($clases as $key)
						<option>{{ $key['clase'] }}</option>
                    @endforeach
					</select>
				</div>
				<div class="col-sm-3 p-1">
					<select class="selectpicker form-control form-control-sm" id="cmbCliente" data-show-subtext="true" data-live-search="true">
						<option selected value="">CLIENTES - TODOS</option>
	                    @foreach($clientes as $key)
							<option value="{{$key['CLIENTE']}}">{{ $key['NOMBRE'] }}</option>
	                    @endforeach
					</select>
				</div>
				<div class="col-sm-3 p-1">
					<select class="selectpicker form-control form-control-sm" id="cmbArticulo" data-show-subtext="true" data-live-search="true">
						<option value="" selected>ARTICULOS - TODOS</option>
	                    @foreach($articulos as $key)
							<option value="{{$key['ARTICULO']}}">{{ $key['DESCRIPCION'] }}</option>
	                    @endforeach
					</select>
				</div>
				<div class="col-sm-3 p-1 border-left">
		            <div class="row">
		                <div class="col-sm-4">
		                  <select class="form-control form-control-sm float-right" id="cmbMes">
	                        <?php
	                        	setlocale(LC_ALL, 'es_ES');
								$mes = date("m");

								for ($i= 1; $i <= 12 ; $i++) {
									$dateObj   = DateTime::createFromFormat('!m', $i);
									$monthName = strftime('%B', $dateObj->getTimestamp());
									
									if ($i==$mes) {
										echo'<option selected value="'.$i.'">'.$monthName.'</option>';
									}else {
										echo'<option value="'.$i.'">'.$monthName.'</option>';
									}
								}
	                        ?>
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
		                <div class="col-sm-4"><a href="#!" id="filterData" class="btn-sm btn btn-primary float-right">Aplicar</a></div>
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
						<input type="text" id="btnSearchCl" class="form-control" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">
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
							<tbody></tbody>
						</table>
    				</div>
			        <div class="row">
			            <div class="col-sm-6">
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
    <div class="row mt-3">
    	<div class="col-sm-12">
    		<div class="card">
    			<div class="card-body">
    				<h5 class="card-title">Articulos</h5>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
						</div>
						<input type="text" id="btnSearchArt" class="form-control" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">
					</div>
    				<div class="table-responsive mt-3 mb-5">
						<table id="tblArticulos" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th>Articulo</th>
									<th>Nombre</th>
									<th>Cantidad</th>
									<th>Precio x ud.</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
    				</div>
			        <div class="row">
			            <div class="col-sm-6">
			                <div class="card text-center">
			                  <div class="card-body">
			                    <h5 class="card-title" id="MontoMeta2">C$ 0.00</h5>
			                    <p class="card-text" id="txtMontoMeta">Total articulo</p>
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