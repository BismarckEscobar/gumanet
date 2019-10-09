<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class login_controller extends Controller
{

	public function __construct(){
    	return $this->middleware('auth');
    }

    function index(){
        $data = [
            'name' =>  'GUMA@NET'
        ];
        return view('pages.login',$data);
    }



}
