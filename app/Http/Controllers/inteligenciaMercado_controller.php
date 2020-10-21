<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models;
use App\Company;
use App\inteligenciaMercado_model;
use DB;

class inteligenciaMercado_controller extends Controller
{
	public function __construct() {
		$this->middleware(['auth','roles']);//pagina se carga unicamente cuando se este logeado
  	}

	public function index(Request $request) {
		$this->agregarDatosASession();
		$comentarios = inteligenciaMercado_model::orderBy('Fecha', 'desc')->paginate(5);
		
		$data = [
			'page' 				=> 'Inteligencia de Mercado',
			'name' 				=> 'GUMA@NET',
			'hideTransaccion' 	=> '',
			'comentarios'		=> $comentarios
		];	
		return view('pages.inteligenciaMercado', $data);		
	}

    public function agregarDatosASession() {
        $request = Request();
        $ApplicationVersion = new \git_version();
        $company = Company::where('id',$request->session()->get('company_id'))->first();// obtener nombre de empresa mediante el id de empresa
        $request->session()->put('ApplicationVersion', $ApplicationVersion::get());
        $request->session()->put('companyName', $company->nombre);// agregar nombre de compañia a session[], para obtenert el nombre al cargar otras pagina 
    }

    public function searchComentarios(Request $request) {
		if($request->isMethod('post')) {

			$search 	= $request->input('search');
			$search 	=  '%' . $search . '%';
			
			$date 		= $request->input('date');
			$order 		= ( $date=='desc' )?'desc':'asc';
			
			$dates 		= $request->input('fechas');

			$from = ( $dates==null )?date('Y-m-d h:i:s', strtotime('2020-01-01 00:00:00')):date('Y-m-d h:i:s', strtotime($dates['fecha1']));
			$to = ( $dates==null )?date('Y-m-d 23:59:59'):date('Y-m-d 23:59:59', strtotime($dates['fecha2']));
			
			$comentarios = inteligenciaMercado_model::where(function($q) use ($search) {
				$q->where('Nombre', 'LIKE', $search)->orWhere('Titulo', 'LIKE', $search)->orWhere('Autor', 'LIKE', $search);
			})->whereBetween('Fecha', [$from, $to])->orderBy('Fecha', $order)->paginate(5);

			return view('pages.comentarios', compact('comentarios'))->render();
		}
    }
}


