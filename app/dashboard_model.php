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

    public static function getTop10Clientes($mes, $anio) {

        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray(" EXEC Gp_ReportVentas_Cliente ".$mes.", ".$anio." ",SQLSRV_FETCH_ASSOC);


        $json = array();
        $i = 0;
        
        
        if( count($query)>0 ){
            foreach ($query as $key) {

                $json[$i]['name']       = $key['codigo'];
                $json[$i]['cliente']    = $key['cliente'];
                $json[$i]['data']       = intval($key['MontoVenta']);

                $i++;
            }
        }

        return $json;
        $sql_server->close();
    }

    public static function getTop10Productos($mes, $anio) {

        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray(" EXEC Gp_DetalleVentas_Mes ".$mes.", ".$anio." ",SQLSRV_FETCH_ASSOC);


        $json = array();
        $i = 0;
        
        
        if( count($query)>0 ) {
            foreach ($query as $key) {

                $json[$i]['name']       = $key['Articulo'];
                $json[$i]['articulo']   = $key['Descripcion'];
                $json[$i]['data']       = intval($key['MontoVenta']);

                $i++;
            }
        }else {
            $mes = date('m');
            $anio = date('Y');
            $query_t = $sql_server->fetchArray(" EXEC Gp_DetalleVentas_Mes ".$mes.", ".$anio." ",SQLSRV_FETCH_ASSOC);

            foreach ($query_t as $key) {

                $json[$i]['name']       = $key['Articulo'];
                $json[$i]['articulo']   = $key['Descripcion'];
                $json[$i]['data']       = intval($key['MontoVenta']);

                $i++;
            }

        }

        return $json;
        $sql_server->close();
    }

    public static function getValBodegas($date) {
        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray(" EXEC GP_ReportValorizacion_TotalINV '".$date."' ",SQLSRV_FETCH_ASSOC);
        
        $json = array();
        $i = 0;

        if( count($query)>0 ){
            foreach ($query as $key) {

                $json[$i]['name']       = 'B'.($i+1);
                $json[$i]['bodega']     = $key['Bodega'];
                $json[$i]['data']       = intval($key['TotalBodega']);

                $i++;
            }
        }

        return $json;
        $sql_server->close();
    }

    public static function getDataGraficas($mes, $anio) {
        $array_merge = array();
        $date = $anio.'-'.$mes.'-01';
        $dtaBodega[] = array(
            'tipo' => 'dtaBodega',
            'data' => dashboard_model::getValBodegas($date)
        );
        $dtaTop10Cl[] = array(
            'tipo' => 'dtaCliente',
            'data' => dashboard_model::getTop10Clientes($mes, $anio)
        );
        $dtaTop10Pr[] = array(
            'tipo' => 'dtaProductos',
            'data' => dashboard_model::getTop10Productos($mes, $anio)
        );

        $array_merge = array_merge($dtaBodega, $dtaTop10Cl, $dtaTop10Pr);
        return $array_merge;
        $sql_server->close();

    }
}
