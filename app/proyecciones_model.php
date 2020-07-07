<?php

namespace App;
use App\User;
use App\Company;

use Illuminate\Database\Eloquent\Model;

class proyecciones_model extends Model {
    
    public static function getDataProyecciones() {
    	$sql_server = new \sql_server();
    	$sql_exec = 'SELECT * FROM DESARROLLO.dbo.ESTADISTICA_CA';

    	$query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);

        $i = 0;
        $json = array();

        foreach($query as $key) {            
            
            $json[$i]['ARTICULO']					= $key['ARTICULO'];
            $json[$i]['DESCRIPCION']				= $key['DESCRIPCION'];
            $json[$i]['CLASE_ABC']					= $key['CLASE_ABC'];
            $json[$i]['ORDEN_MINIMA']				= $key['ORDEN_MINIMA'];
            $json[$i]['FACTOR_EMPAQUE']				= number_format($key['FACTOR_EMPAQUE'],4,'.','');
            $json[$i]['OPC'] 						= '<a href="#!" onclick="detailsProyeccion()" class"active-page-details"><i class="material-icons">content_paste</i></a>';

            $i++;
        }

        return $json;
        $sql_server->close();

    }
}
