<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models;
use App\Company;

class minutasCorp_controller extends Controller
{
	public function __construct() {
		$this->middleware(['auth','roles']);//pagina se carga unicamente cuando se este logeado
  	}

	public function index(Request $request) {
		$this->agregarDatosASession();

        $data = [
            'page' => 'Minutas Corporativas',
            'name' =>  'GUMA@NET'
        ];
		
		return view('pages.minuta',$data);
	}

	public function agregarDatosASession() {
		$request = Request();
		$ApplicationVersion = new \git_version();
		$company = Company::where('id',$request->session()->get('company_id'))->first();// obtener nombre de empresa mediante el id de empresa
		$request->session()->put('ApplicationVersion', $ApplicationVersion::get());
		$request->session()->put('companyName', $company->nombre);// agregar nombre de compañia a session[], para obtenert el nombre al cargar otras pagina 
	}
}
