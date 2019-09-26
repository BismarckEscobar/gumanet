@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('content')
    <h2>Articulos</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ARTICULO</th>
                <th>DESCRIPCION</th>
                <th>EXISTENCIA</th>
                <th>LABORATORIO</th>
                <th>PRECIO</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($rArticulos as $key => $value)
                <tr>
                    <td>{{ $value['ARTICULO'] }}</td>
                    <td>{{ $value['DESCRIPCION'] }}</td>
                    <td>{{ number_format($value['total'],2) }}</td>
                    <td>{{ $value['LABORATORIO'] }}</td>
                    <td>{{ number_format($value['PRECIO_FARMACIA'],2) }}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>
@endsection