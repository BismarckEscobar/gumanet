<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class metas_controller extends Controller
{

	public function __construct()
	 {
	    $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
	 }
	 
    function index(){
        $data = [
            'name' =>  'GUMA@NET'
        ];
        return view('pages.metas',$data);
    }
}
