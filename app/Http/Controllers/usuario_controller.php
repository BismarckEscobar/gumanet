<?php

namespace App\Http\Controllers;

use App\usuario_model;
use App\Models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class usuario_controller extends Controller
{

	public function __construct()
	 {
	    $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
	 }


    function index(){
        $data = [
            'page' => 'Usuarios',
            'name' =>  'GUMA@NET'
        ];
        
        return view('pages.usuarios',$data);
    }

    public function getUsuario() {
        return usuario_model::getUsuario();
    }
    

}
