<?php
namespace App\Http\Controllers;

use App\inventario_model;
use Illuminate\Http\Request;
use App\Models;

class inventario_controller extends Controller
{

	 public function __construct()
  {
    $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
  }

	public function index() {
		$data = array(
			'page' 				=> 'Inventario',
			'name' 				=> 'GUMA@NET',
			'hideTransaccion' 	=> ''
		);
		return view('pages.inventario', $data);
	}

	public function getArticulos() {
		$obj = inventario_model::getArticulos();
		return response()->json($obj);
	}

	public function getArticuloDetalle($articulo) {
		$obj = inventario_model::getArticuloDetalle($articulo);
		return response()->json($obj);
	}

	public function getBodegaInventario($articulo) {		
		$obj = inventario_model::getBodegaInventario($articulo);
		return response()->json($obj);
	}

	public function getPreciosArticulos($articulo) {
		$obj = inventario_model::getPreciosArticulos($articulo);
		return response()->json($obj);
	}

	public function getArtBonificados($articulo) {
		$obj = inventario_model::getArtBonificados($articulo);
		return response()->json($obj);
	}

	public function transaccionesDetalle(Request $request) {		
		if($request->isMethod('post')){
			$obj = inventario_model::transaccionesDetalle($request->input('f1'),$request->input('f2'),$request->input('art'),$request->input('tp'));
			return response()->json($obj);
		}
	}

	public function getLotesArticulo(Request $request) {
		if($request->isMethod('post')){
			$obj = inventario_model::getLotesArticulo($request->input('bodega'),$request->input('articulo'));
			return response()->json($obj);
		}
	}
}
