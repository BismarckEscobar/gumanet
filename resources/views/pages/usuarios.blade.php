@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_usuario');
@endsection
@section('content')  
<div class="row" style="margin: 0 auto">
    <div class="card mt-3" style="width: 100%">
      <div class="card-body">                
        <h5 class="card-title">{{ $page }}</h5>
        <div class="row">
            <div class="col-sm-9">
               <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
                    </div>
                    <input type="text" id="InputDtShowSearchFilterUser" class="form-control" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-sm-1">
                 <div class="input-group mb-3">
                    <select class="custom-select" id="InputDtShowColumnsUser" name="InputDtShowColumnsUser">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="Todo">Todo</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
               <div class="input-group">
                     <a href="{{ route('register') }}" style="width: 100%" class="btn btn-primary">{{ 'Nuevo' }}</a> 

                </div>
            </div>
        </div>
      </div>
    </div>
</div>  
<div class="row">
    <div class="col-12">
        <div class="table-responsive mt-3 mb-5">
            <table class="table table-bordered table-sm" width="100%" id="dtUsuarios">
            	<thead>
            	</thead>
            </table>
        </div>
    </div>
</div>
@endsection