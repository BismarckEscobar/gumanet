<?php
namespace App\Http\Controllers;

use App\inventario_model;
use Illuminate\Http\Request;
use App\Models;

use App\Company;

class inventario_controller extends Controller
{
	public function __construct() {
		$this->middleware(['auth','roles']);//pagina se carga unicamente cuando se este logeado
  	}

	public function index() {
		$this->agregarDatosASession();

		$data = array(
			'page' 				=> 'Inventario',
			'name' 				=> 'GUMA@NET',
			'hideTransaccion' 	=> ''
		);
		return view('pages.inventario', $data);
	}

    public function agregarDatosASession(){
        $request = Request();
        $ApplicationVersion = new \git_version();
        $company = Company::where('id',$request->session()->get('company_id'))->first();// obtener nombre de empresa mediante el id de empresa
        $request->session()->put('ApplicationVersion', $ApplicationVersion::get());
        $request->session()->put('companyName', $company->nombre);// agregar nombre de compañia a session[], para obtenert el nombre al cargar otras pagina 
    }

	public function getArticulos() {
		$obj = inventario_model::getArticulos();
		return response()->json($obj);
	}

	public function liquidacion6Meses() {
		$obj = inventario_model::dataLiquidacion6Meses();
		return response()->json($obj);
	}

	public function liquidacion12Meses() {
		$obj = inventario_model::dataLiquidacion12Meses();
		return response()->json($obj);
	}

	public function descargarInventario($tipo) {
		$obj = inventario_model::descargarInventario($tipo);
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
