<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\reportes_model;

class reportes_controller extends Controller
{
    public function __construct()
     {
        $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
     }

     
    function index(){
        $clases     = reportes_model::claseTerapeutica();
        $articulos  = reportes_model::articulos();
        $clientes   = reportes_model::clientes();
        $data = [
            'name' =>  'GUMA@NET',
            'page' => 'Ventas'
        ];
        return view('pages.reportes', compact('data', 'clases', 'articulos', 'clientes'));
    }

    public function detalleVentas(Request $request) {
        if($request->isMethod('post')) {
            $obj = reportes_model::returndetalleVentas($request->input('clase'),$request->input('cliente'),$request->input('articulo'),$request->input('mes'),$request->input('anio'));
            return response()->json($obj);
        }
    }
}