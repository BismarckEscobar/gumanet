@extends('layouts.main')
@section('title' , $data['name'])
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_meta')
@endsection
@section('content')
<div class="row" style="margin: 0 auto">
    <div class="card mt-3" style="width: 100%">
      <div class="card-body">                
        <h5 class="card-title">{{ $data['page'] }}</h5>
        <div class="row">
        	<div class="col-12">
        		<div class="alert alert-primary" role="alert"  id="alertMetas">
				  
				</div>
        	</div>
        </div>
        <div class="row justify-content-center mb-2">

            <div class="col-md-3">
		        <div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="radioMeta" id="radioMeta1" value="option1" checked>
					  <label class="form-check-label" for="radioMeta1">
					    Agergar Meta
					  </label>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="radioMeta" id="radioMeta2" value="option2">
					  <label class="form-check-label" for="radioMeta2">
					    Ver Meta
					  </label>
				</div>
			</div>

		</div>

        <div class="row justify-content-center">
            <div class="col-md-3 mb-2">
                 <div class="input-group">
                    <select class="custom-select" id="selectMesMeta" name="selectMesMeta">
                    	<option value="00">Mes</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                 <div class="input-group">
                    <select class="custom-select" id="selectAnnoMeta" name="selectAnnoMeta">
                    	<option value="00">Año</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 mb-2">
            	<form method="POST" id="export_excel">
		            <div class="input-group">
					  <div class="custom-file" id="contInputExlFileMetas">
					    <input type="file" class="custom-file-input" id="addExlFileMetas">
					    <label class="custom-file-label" for="addExlFileMetas">Seleccione un archivo Ecxel
					    </label>
					  </div>
					</div>
				</form>
			</div>
		</div>
		
		 <div class="row justify-content-center">
            <div class="col-md-6">
            	<div class="input-group">
                     <a href="#" style="width: 100%" class="btn btn-primary"  id="btnShowModalExl"></a> 

                </div>

            </div>
        </div>

      </div>
    </div>
</div>  

<div class="row" id="verMetasAgregadasXMes" style="margin: 0 auto">
    <div class="card mt-3" style="width: 100%">
	    <div class="card-body">         
	    	<h5 class="card-title">{{ "Recuperación" }}</h5>
	        <hr>     
	        <h5 class="card-title">{{ "Cuota" }}</h5>
	        <hr>
	        <div class="row">
	        	<div class="col-12">

	        		<table id="tblVerMetasAgregadas">
			        	<thead class="text-center">
			                <tr>
			                    <th>NOMBRE</th>
			                    <th>USUARIO</th>
			                    <th>ROL</th>
			                    <th>DESCRIPCIÓN</th>
			                    <th>FECHA INGRESO</th>
			                    <th>ESTADO</th>
			                    <th >OPCIONES</th>
			                </tr>
			        	</thead>
			        	<tbody>
			                @csrf
			                @foreach($users as $user)
			                    <tr class="post{{ $user->id }}">
			                        <td>{{ $user->name." ".$user->surname }}</td>
			                        <td>{{ $user->email }}</td>
			                        <td>
			                            {{ App\Role::find($user->role)->nombre }}
			                        </td>
			                        <td>{{ $user->description }}</td>
			                        <td>{{ $user->created_at }}</td>
			                        <td>
			                            @if($user->estado == 0)
			                                Activo
			                            @else
			                                Inactivo
			                            @endif
			                        </td>
			                        <td style="width: 120px">
			                            <center>
			                            {{-- <a href='#' class ='show-modal btn  btn-sm' data-id='{{ $user->id }}'><span data-feather='eye'></span></a> --}}
			                            <a href='#' class ='btn btn-sm tooltip-test' title="Editar" data-toggle="modal" id="editUserModal" data-target="#modalEditUsuario" data-id='{{ $user->id }}' data-name='{{ $user->name }}' data-surname='{{ $user->surname }}' data-email='{{ $user->email }}' data-role='{{ $user->role }}' data-description='{{ $user->description }}'><span data-feather='edit'></span></a>
			                            <a href='#' class ='delete-modal btn btn-sm tooltip-test' title="Eliminar" data-toggle="modal" id="deleteUserModal" data-target="#modalEliminarUsuario" data-id='{{ $user->id }}'><span data-feather='trash-2'></span></a>
			                            @if($user->estado == 0)
			                                <a href='#' class ='btn btn-sm tooltip-test estadoBtn' title="Desactivar"  data-id='{{ $user->id }}'  data-status='0'><span data-feather='x'></span></a>
			                            @else
			                                <a href='#' class ='btn btn-sm tooltip-test estadoBtn' title="Activar"  data-id='{{ $user->id }}' data-status='1'><span data-feather='check'></span></a>
			                            @endif
			                        </center>
			                        </td>
			                    </tr>
			                @endforeach
			            </tbody>
			        </table>
			        
			      </div>
	        	</div>
	        </div>
	    </div>
	</div>
</div>



{{--///////////////////////////////////////// MODAL SHOW EXCEL /////////////////////////////--}}

<div class="modal fade" id="modalShowModalExl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar uausrio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tblExcelImportMeta">
        	<thead class="text-center">
                <tr>
                    <th>NOMBRE</th>
                    <th>USUARIO</th>
                    <th>ROL</th>
                    <th>DESCRIPCIÓN</th>
                    <th>FECHA INGRESO</th>
                    <th>ESTADO</th>
                    <th >OPCIONES</th>
                </tr>
        	</thead>
        	<tbody>
                @csrf
                @foreach($users as $user)
                    <tr class="post{{ $user->id }}">
                        <td>{{ $user->name." ".$user->surname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ App\Role::find($user->role)->nombre }}
                        </td>
                        <td>{{ $user->description }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            @if($user->estado == 0)
                                Activo
                            @else
                                Inactivo
                            @endif
                        </td>
                        <td style="width: 120px">
                            <center>
                            {{-- <a href='#' class ='show-modal btn  btn-sm' data-id='{{ $user->id }}'><span data-feather='eye'></span></a> --}}
                            <a href='#' class ='btn btn-sm tooltip-test' title="Editar" data-toggle="modal" id="editUserModal" data-target="#modalEditUsuario" data-id='{{ $user->id }}' data-name='{{ $user->name }}' data-surname='{{ $user->surname }}' data-email='{{ $user->email }}' data-role='{{ $user->role }}' data-description='{{ $user->description }}'><span data-feather='edit'></span></a>
                            <a href='#' class ='delete-modal btn btn-sm tooltip-test' title="Eliminar" data-toggle="modal" id="deleteUserModal" data-target="#modalEliminarUsuario" data-id='{{ $user->id }}'><span data-feather='trash-2'></span></a>
                            @if($user->estado == 0)
                                <a href='#' class ='btn btn-sm tooltip-test estadoBtn' title="Desactivar"  data-id='{{ $user->id }}'  data-status='0'><span data-feather='x'></span></a>
                            @else
                                <a href='#' class ='btn btn-sm tooltip-test estadoBtn' title="Activar"  data-id='{{ $user->id }}' data-status='1'><span data-feather='check'></span></a>
                            @endif
                        </center>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger procesarActionBtn" data-dismiss="modal">Procesar</button>
      </div>
    </div>
  </div>
</div>


@endsection