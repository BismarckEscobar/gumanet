<?php setlocale(LC_TIME, "spanish") ?>
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
{!! $comentarios->render() !!}