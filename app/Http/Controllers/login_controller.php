<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class login_controller extends Controller
{
    function index(){
        $data = [
            'name' =>  'GUMA@NET'
        ];
        return view('pages.login',$data);
    }
}
