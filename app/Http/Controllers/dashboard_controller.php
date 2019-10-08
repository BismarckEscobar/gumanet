<?php

namespace App\Http\Controllers;

use App\dashboard_model;
use App\Models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class dashboard_controller extends Controller {
   
   function index() {
       $data = [
           'name' =>  'GUMA@NET'
       ];
       return view('pages.dashboard',$data);
   }

	public function getDetalleVentas($tipo) {
		$obj = dashboard_model::getDetalleVentas($tipo);
		return response()->json($obj);
	}
}
