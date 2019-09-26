<?php

namespace App\Http\Controllers;


use App\inventario_model;
use Illuminate\Http\Request;
use App\Models;

class inventario_controller extends Controller
{
   public function getArticulos(){

       $data = [
           'name' =>  'GUMA@NET',
           'rArticulos' => inventario_model::getArticulos()
       ];
       return view('pages.inventario',$data);
   }
}
