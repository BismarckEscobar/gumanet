<?php

namespace App\Http\Controllers;

use App\proyecciones_model;
use App\Models;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class proyecciones_controller extends Controller
{
    public function __construct()
     {
        $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
     }

     
    function index() {
        $data = [
            'name' =>  'GUMA@NET',
            'page' => 'Proyecciones de Ventas'
        ];
        return view('pages.proyecciones', $data);
    }

    function dataProyeccionXTipo() {

    $obj = proyecciones_model::getDataProyecciones();
    return (response()->json($obj));

		/*$i=0;
		$json[$i]['ARTICULO'] 		='10118472';
		$json[$i]['DESCRIPCION'] 	='Temozolamida 100 mg Capsulas 5/Caja (Naprod)';
		$json[$i]['CLASE_ABC'] 	='AAA';
		$json[$i]['ORDEN_MINIMA'] 	='4.9518';
		$json[$i]['FACTOR_EMPAQUE'] 	='5.0000';

		$json[$i]['OPC'] = '<center><a href="#!" id="donwloadExcelPlantilla"><i class="material-icons">content_paste</i></a></center>';

		return response()->json($json);*/
				
    }

    public function vista() {
        $i=0;
        $rtnArticulo=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM DESARROLLO.dbo.ESTADISTICA_CA",SQLSRV_FETCH_ASSOC);
        foreach($query as $key){
            $rtnArticulo['data'][$i]['LABORATORIO']                  = $key['LABORATORIO'];
            $rtnArticulo['data'][$i]['COSTO_PROM_LOC']               = number_format($key['COSTO_PROM_LOC'],4,'.','');
            $rtnArticulo['data'][$i]['ARTICULO']                     = $key['ARTICULO'];
            $rtnArticulo['data'][$i]['DESCRIPCION']                  = $key['DESCRIPCION'];
            $rtnArticulo['data'][$i]['CLASE_ABC']                    = $key['CLASE_ABC'];
            $rtnArticulo['data'][$i]['FACTOR_EMPAQUE']               = number_format($key['FACTOR_EMPAQUE'],4,'.','');
            $rtnArticulo['data'][$i]['ORDEN_MINIMA']                 = $key['ORDEN_MINIMA'];
            $rtnArticulo['data'][$i]['BODEGA']                       = $key['BODEGA'];
            $rtnArticulo['data'][$i]['CANT_DISPONIBLE']              = number_format($key['CANT_DISPONIBLE'],4,'.','');
            $rtnArticulo['data'][$i]['CANT_PEDIDA']                  = number_format($key['CANT_PEDIDA'],4,'.','');
            $rtnArticulo['data'][$i]['CANT_TRANSITO']                = number_format($key['CANT_TRANSITO'],4,'.','');
            $rtnArticulo['data'][$i]['CANT_RESERVADA']               = number_format($key['CANT_RESERVADA'],4,'.','');
            $rtnArticulo['data'][$i]['PRECIO']                       = $key['PRECIO'];
            $rtnArticulo['data'][$i]['NIVEL_PRECIO']                 = $key['NIVEL_PRECIO'];
            $rtnArticulo['data'][$i]['CODIGO_Privado']               = $key['CODIGO(Privado)'];
            $rtnArticulo['data'][$i]['DESCRIPCION_Privado']          = $key['DESCRIPCION(Privado)'];
            $rtnArticulo['data'][$i]['CLASE_ABC_Privado']            = $key['CLASE_ABC(Privado)'];
            $rtnArticulo['data'][$i]['ORDEN_MINIMA_Privado']         = $key['ORDEN_MINIMA(Privado)'];
            $rtnArticulo['data'][$i]['FACTOR_EMPAQUE_Privado']       = number_format($key['FACTOR_EMPAQUE(Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['BODEGA_privado']               = $key['BODEGA (privado)'];
            $rtnArticulo['data'][$i]['CANT_DISPONIBLE_Privado']      = number_format($key['CANT_DISPONIBLE (Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['CANT_PEDIDA_Privado']          = number_format($key['CANT_PEDIDA (Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['CANT_TRANSITO_Privado']        = number_format($key['CANT_TRANSITO (Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['CANT_RESERVADA_Privado']       = number_format($key['CANT_RESERVADA(Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['COSTO_PROM_LOC_Privado']       = number_format($key['COSTO_PROM_LOC(Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['Precio_Privado']               = number_format($key['Precio(Privado)'],4,'.','');
            $rtnArticulo['data'][$i]['NIVEL_PRECIO_Privado']         = $key['NIVEL_PRECIO(Privado)'];

            $i++;
        }


        echo json_encode($rtnArticulo);
        $this->sqlsrv->close();
    }
}
