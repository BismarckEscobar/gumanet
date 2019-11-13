<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class metas_controller extends Controller
{

	public function __construct()
	 {
	    $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
	 }
	 
    function index(){
        $users = User::all();
        $data = [
            'page' => 'Metas',
            'name' =>  'GUMA@NET'
        ];
        
        return view('pages.metas',compact('data','users'));
    }
}
