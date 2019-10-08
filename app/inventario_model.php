<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventario_model extends Model {
    
    public static function getArticulos() {
        $sql_server = new \sql_server();

        $query = array();
        $i=0;
        $query1 = $sql_server->fetchArray("SELECT TOP 50 * FROM iweb_articulos ",SQLSRV_FETCH_ASSOC);

        foreach ($query1 as $key) {
	    	$query[$i]['ARTICULO'] 			= '<a href="#!" onclick="getDetalleArticulo('."'".$key['ARTICULO']."'".', '."'".$key['DESCRIPCION']."'".')" >'.$key['ARTICULO'].'</a>';
	    	$query[$i]['CLASE_TERAPEUTICA'] = $key['CLASE_TERAPEUTICA'];
	    	$query[$i]['DESCRIPCION'] 		= $key['DESCRIPCION'];
	    	$query[$i]['total'] 			= number_format($key['total'], 0);
	    	$query[$i]['LABORATORIO'] 		= $key['LABORATORIO'];
	    	$query[$i]['UNIDAD_ALMACEN'] 	= $key['UNIDAD_ALMACEN'];
	    	$query[$i]['006'] 				= $key['006'];
	    	$query[$i]['005'] 				= $key['005'];
	    	$query[$i]['PUNTOS'] 			= $key['PUNTOS'];
	    	$query[$i]['PRECIO_FARMACIA'] 	= $key['PRECIO_FARMACIA'];
	    	$i++;
        }
        $sql_server->close();        
        return $query;
    }

    public static function getBodegaInventario($articulo) {
        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray('SELECT * FROM iweb_bodegas WHERE ARTICULO = '."'".$articulo."'".' ', SQLSRV_FETCH_ASSOC);

        $i = 0;
        $json = array();
        foreach ($query as $fila) {

            $id = "dv-".$fila["BODEGA"];
            $ld = "i-".$fila["BODEGA"];

            $json[$i]["id"] = $i;
            $json[$i]["DETALLE"] = '<a id="exp_more" class="exp_more" href="#!"><i class="material-icons expan_more">expand_more</i></a>';
            $json[$i]["BODEGA"] = $fila["BODEGA"];
            $json[$i]["NOMBRE"] = $fila["NOMBRE"];
            $json[$i]["CANT_DISPONIBLE"] = number_format($fila["CANT_DISPONIBLE"],2);
            $i++;
        }
        $sql_server->close();
        return $json;
    }

    public static function getPreciosArticulos($articulo) {
        $sql_server = new \sql_server();
        $i = 0;
        $json = array();

        $query = $sql_server->fetchArray('EXEC sp_iweb_precios '."'".$articulo."'".' ', SQLSRV_FETCH_ASSOC);

        foreach ($query as $fila) {
            $json[$i]["NIVEL_PRECIO"] = $fila["NIVEL_PRECIO"];
            $json[$i]["PRECIO"] = ($fila["PRECIO"]=="") ? "N/D" : number_format($fila["PRECIO"],2);
            $i++;
        }

        $sql_server->close();
        return $json;
    }

    public static function getArtBonificados($articulo) {
        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray('SELECT REGLAS FROM GMV_mstr_articulos WHERE ARTICULO = '."'".$articulo."'".' ', SQLSRV_FETCH_ASSOC);
        $i = 0;
        $json = array();       
        foreach ($query as $fila) {
            $porciones = explode(",", $fila["REGLAS"]);
            for($n=0;$n<count($porciones);$n++){
                $Position_elementos = substr($porciones[$n], 0, strpos ($porciones[$n] , "+" ));
                $json[$i]["ORDEN"] = $Position_elementos;
                $json[$i]["REGLAS"] = $porciones[$n];
                $i++;
            }           
        }
        $sql_server->close();
        return $json;
    }

    public static function transaccionesDetalle($f1, $f2, $art, $tp) {
        $sql_server = new \sql_server();
        
        $f1_ = date('Y-m-d', strtotime($f1));
        $f2_ = date('Y-m-d', strtotime($f2)); 

        $query = $sql_server->fetchArray('SELECT * FROM iweb_transacciones WHERE ARTICULO = '."'".$art."'".' AND DESCRTIPO = '."'".$tp."'".' AND FECHA  BETWEEN '."'".$f1."'".' AND '."'".$f2."'".'  ORDER BY ARTICULO ASC', SQLSRV_FETCH_ASSOC);
        $i=0;
        $json = array();
        foreach($query as $fila){
            $json[$i]["FECHA"] = date_format($fila["FECHA"],"d/m/Y");
            $json[$i]["LOTE"] = $fila["LOTE"];
            $json[$i]["DESCRTIPO"] = $fila["DESCRTIPO"];
            $json[$i]["CANTIDAD"] = number_format($fila["CANTIDAD"],2);
            $json[$i]["REFERENCIA"] = $fila["REFERENCIA"];
            $i++;
        }

        $sql_server->close();
        return $json;
    }

    public static function getLotesArticulo($bodega, $articulo) {
        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray('SELECT * FROM iweb_lotes WHERE BODEGA = '."'".$bodega."'".' AND ARTICULO = '."'".$articulo."'".' ', SQLSRV_FETCH_ASSOC);
        $i = 0;
        $json = array();
        foreach ($query as $fila) {
            $json[$i]["ARTICULO"] = $fila["ARTICULO"];
            $json[$i]["BODEGA"] = $fila["BODEGA"];
            $json[$i]["CANT_DISPONIBLE"] = number_format($fila["CANT_DISPONIBLE"], 2);
            $json[$i]["LOTE"] = $fila["LOTE"];
            $json[$i]["FECHA_INGRESO"] = date('d/m/Y',strtotime($fila["FECHA_ENTR"]));
            $json[$i]["CANTIDAD_INGRESADA"] = number_format($fila["CANTIDAD_INGRESADA"], 2);
            $json[$i]["FECHA_ENTRADA"] = date('d/m/Y',strtotime($fila["FECHA_ENTRADA"]));
            $json[$i]["FECHA_VENCIMIENTO"] = date('d/m/Y',strtotime($fila["FECHA_VENCIMIENTO"]));
            $i++;
        }
        $sql_server->close();
        return $json;
    }
}