@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_inteligenciaMercado');
@endsection
@section('content')
<?php setlocale(LC_TIME, "spanish") ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-12">
			<h4 class="h4">Inteligencia de Mercado</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
				</div>
				<input type="text" id="search" class="form-control" placeholder="Buscar por titulo del comentario" aria-label="Username" aria-describedby="basic-addon1">
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
		<div class="col-md-2">
			<button id="dom-id" class="btn btn-light text-primary mt-3"><span data-feather="search"></span> Por Fecha</button>
		</div>
	</div>

	<div class="comentarios">
		@foreach( $comentarios as $key )
		<div class="row">
			<div class="col-md-12">
				<div class="card border-light mb-3 shadow-sm bg-white rounded">
				  
				  <div class="card-body">
				    <h5 class="card-title font-weight-bold text-primary">{{ $key->Titulo }}</h5>
					<p class="card-text">{{ $key->Contenido }}</p>

					<p class="float-left font-weight-bold mr-4"><img src="./images/user.svg" class="img01" /> {{ $key->Nombre }}</p>
					<p class="float-left font-weight-bold mr-4">
						<img src="./images/clock.svg" class="img01" />
						{{ strftime('%a %d de %b %G', strtotime($key->Fecha)) }}. {{ date('h:i a', strtotime($key->Fecha)) }}
					</p>
					<p class="float-left font-weight-bold mr-4"><img src="./images/globe.svg" class="img01" /> {{ $key->Autor }}</p>
				  </div>
				</div>
			</div>
		</div>
		@endforeach
		<div class="row">
			<div class="col-md-12  text-center">
				{!! $comentarios->render() !!}
			</div>
		</div>
	</div>

<!--<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="1">1</a></li>
    <li class="page-item"><a class="page-link" href="2">2</a></li>
    <li class="page-item"><a class="page-link" href="3">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>-->
</div>

@endsection