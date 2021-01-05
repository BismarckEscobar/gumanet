@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_minutasCorp');
@endsection
@section('content')
<?php setlocale(LC_TIME, "spanish") ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-12">
			<h4 class="h4 mb-4">Minutas Corporativas</h4>

		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
				</div>
				<input type="text" id="search" class="form-control" placeholder="Buscar por Titulo, Contenido o Autor" aria-label="Username" aria-describedby="basic-addon1">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="orderByDate" class="text-muted m-0">Ordenar por</label>
				<select class="form-control form-control-sm" id="orderByDate">
					<option value="desc">Recientes</option>
					<option value="asc">Mas antiguos</option>
				</select>
			</div>
		</div>
		<div class="col-sm-2 mt-3">
			<button id="dom-id" class="btn btn-light btn-block text-primary fa-1x"><i class="fas fa-calendar-day"></i> Filtro por Fechas</button>
		</div>
	</div>
	<form id="fmrDescargarComent" method="post" action="dowloadComents"> @csrf </form>
	<div class="comentarios">
		
		<div class="card border-light mb-3 shadow-sm bg-white rounded">
			<div class="card-body">
				<div class="row">
					<div class="col-md-10">
						<h5 class="card-title font-weight-bold text-primary"></h5>
						<p class="card-text"></p>					
					</div>
					<div class="col-md-2 ">
					
					</div>
				</div>
			</div>
			<div class="card-footer bg-white border-0">
				<p class="float-left font-weight-bold mr-4"><img src="./images/user.svg" class="img01" /></p>
				<p class="float-left font-weight-bold mr-4">
				<img src="./images/clock.svg" class="img01" /></p>
				<p class="float-left font-weight-bold mr-4"><img src="./images/globe.svg" class="img01" /></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12  text-center">
				
			</div>
		</div>
	</div>
</div>

@endsection