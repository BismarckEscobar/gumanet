<?php

namespace App\Http\Controllers;

use App\dashboard_model;
use App\Models;

class dashboard_controller extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }
   
   public function index() {
       $ApplicationVersion = new \git_version();
       $data = [
           'appVersion' => $ApplicationVersion::get(),
           'name' =>  'GUMA@NET'
       ];
       return view('pages.dashboard',$data);
   }

	public function getDetalleVentas($tipo) {
		$obj = dashboard_model::getDetalleVentas($tipo);
		return response()->json($obj);
	}
}
