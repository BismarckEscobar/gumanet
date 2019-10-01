@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('content')
    <h2>Articulos</h2>

    <div class="row">
        <div class="col-10 text-align-left">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
              </div>
              <input type="text" id="InputDtShowSearchFilterArt" class="form-control" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="col-2 text-align-right">
            <div class="input-group mb-3">
                <select class="custom-select" id="InputDtShowColumnsArtic" name="InputDtShowColumnsArtic">
                    <option value="20" selected>20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="Todo">Todo</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="dtInventarioArticulos">
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
        </div>
    </div>
@endsection