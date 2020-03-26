@extends('layouts.main')
@section('title', $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_saldos')
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6">
      <h1 class="h4 pb-0 text-info">Saldos <span data-feather="dollar-sign" class="mb-1"></span></h1>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6 border-right">
                <div class="form-group">
                    <label for="opcMes" class="text-muted m-0">Filtrar por Rutas</label>
                    <select class="selectpicker form-control form-control-sm" id="cmbRutas" data-show-subtext="true" data-live-search="true">
                      <option value="">RUTAS - TODOS</option>
                      @foreach($rutas as $key)
                        <option value="{{ $key['VENDEDOR'] }}" >{{ $key['NOMBRE'] }}</option>
                      @endforeach
                    </select>
                </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6 border-right">
              <p class="font-weight-bold">No vencido: <span id="noVencido">C$ {{ number_format($saldosAll[0]['N_VENCIDOS'], 2) }}</span></p>
              <table id="tbSaldos" class="table table-bordered mt-3" width="50%">
                <thead>
                  <tr>
                    <th>Saldos</th>
                    <th><span class="float-right">Montos</span></th>
                  </tr>
                </thead>
                <tbody id="tBody">                  
                  <tr>
                    <td>30 Días</td>
                    <td>C$<span class="float-right">{{ number_format($saldosAll[0]['Dias30'], 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>60 Días</td>
                    <td>C$<span class="float-right">{{ number_format($saldosAll[0]['Dias60'], 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>90 Días</td>
                    <td>C$<span class="float-right">{{ number_format($saldosAll[0]['Dias90'], 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>120 Días</td>
                    <td>C$<span class="float-right">{{ number_format($saldosAll[0]['Dias120'], 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>Más de 120 Días</td>
                    <td>C$<span class="float-right">{{ number_format($saldosAll[0]['Mas120'], 2) }}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection