<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dashboard_model extends Model {
    
    public static function getDetalleVentas($tipo) {
        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray("SELECT TOP 20 * FROM iweb_articulos ",SQLSRV_FETCH_ASSOC);

        $i = 0;
        $json = array();

        switch ($tipo) { 
        	case 'vent':
		        foreach ($query as $fila) {
		        	$json[$i]["ARTICULO"] 		= $fila["ARTICULO"];
		        	$json[$i]["DESCRIPCION"] 	= $fila["DESCRIPCION"];
		            $json[$i]["U_MEDIDA"] 		= $fila["UNIDAD_ALMACEN"];
		            $json[$i]["CANTIDAD"] 		= number_format($fila["total"], 2);
		            $json[$i]["MONTO"] 			= number_format($fila["PRECIO_FARMACIA"], 2);
		            $i++;
		        }
        		break;
        	case 'recu':
		        foreach ($query as $fila) {
		        	$json[$i]["RUTA"] 		= 'N/D';
		        	$json[$i]["NOMBRE"] 	= 'N/D';
		            $json[$i]["MONTO"] 		= number_format($fila["PRECIO_FARMACIA"], 2);
		            $json[$i]["META"] 		= number_format($fila["PRECIO_FARMACIA"], 2);
		            $json[$i]["EFEC"] 		= '10%';
		            $i++;
		        }
        		break;        	
        	default:
        		return false;
        		break;
        }
        $sql_server->close();
        return $json;
    }
}
