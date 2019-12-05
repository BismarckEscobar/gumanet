<?php

namespace App;
use App\User;
use App\Company;

use Illuminate\Database\Eloquent\Model;

class dashboard_model extends Model {
    
    public static function getDetalleVentas($tipo, $mes, $anio) {
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Umk_VentaLinea_Articulo ".$mes.", ".$anio.", '', '', ''";
                break;
            case '2':
                $sql_exec = "EXEC Gp_VentaLinea_Articulo ".$mes.", ".$anio.", '', '', ''";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);

        $i = 0;
        $json = array();

        switch ($tipo) {
        	case 'vent':
		        foreach ($query as $fila) {
		        	$json[$i]["ARTICULO"] 		= $fila["articulo"];
		        	$json[$i]["DESCRIPCION"] 	= $fila["descripcion"];
		            $json[$i]["U_MEDIDA"] 		= $fila["UM"];
		            $json[$i]["CANTIDAD"] 		= number_format($fila["Cantidad"], 2);
                    $json[$i]["PRECIOUND"]      = number_format($fila["precioUnitario"], 2);
		            $json[$i]["MONTO"] 			= number_format($fila["total"], 2);
		            $i++;
		        }
        		break;
        	case 'recu':
		        foreach ($query as $fila) {
		        	$json[$i]["RUTA"] 		= 'N/D';
		        	$json[$i]["NOMBRE"] 	= 'N/D';
		            $json[$i]["MONTO"] 		= number_format($fila["precioUnitario"], 2);
		            $json[$i]["META"] 		= number_format($fila["precioUnitario"], 2);
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
        
        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = " EXEC Umk_ReportVentas_Cliente ".$mes.", ".$anio." ";
                break;
            case '2':
                $sql_exec = " EXEC Gp_ReportVentas_Cliente ".$mes.", ".$anio." ";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);

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

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = " EXEC Umk_DetalleVentas_Mes ".$mes.", ".$anio." ";
                break;
            case '2':
                $sql_exec = " EXEC Gp_DetalleVentas_Mes ".$mes.", ".$anio." ";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);

        $json = array();
        $i = 0;

        if( count($query)>0 ) {
            foreach ($query as $key) {

                $json[$i]['name']       = $key['Articulo'];
                $json[$i]['articulo']   = $key['Descripcion'];
                $json[$i]['data']       = intval($key['MontoVenta']);

                $i++;
            }
        }

        return $json;
        $sql_server->close();
    }

    public static function getVentasMes($mes, $anio) {
        $total = 0;
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Umk_VentaLinea_Articulo ".$mes.", ".$anio.", '', '', ''";
                $sql_meta = "EXEC UMK_meta_articulos ".$mes.", ".$anio.", '', '', ''";
                break;
            case '2':
                $sql_exec = "EXEC Gp_VentaLinea_Articulo ".$mes.", ".$anio.", '', '', '' ";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $query2 = $sql_server->fetchArray($sql_meta, SQLSRV_FETCH_ASSOC);

        foreach ($query as $key) {
            $total = $total + floatval($key['total']);
        }

        $json[0]['name'] = 'Real';
        $json[0]['data'] =  $total;

        $json[1]['name'] = 'Meta';
        $json[1]['data'] = intval($query2[0]['meta']);

        return $json;
        $sql_server->close();
    }

    public static function getValBodegas($date) {
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = " EXEC UMK_ReportValorizacion_TotalINV '".$date."' ";
                break;
            case '2':
                $sql_exec = " EXEC GP_ReportValorizacion_TotalINV '".$date."' ";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);
        
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
        $dtaVtasMes[] = array(
            'tipo' => 'dtaVentasMes',
            'data' => dashboard_model::getVentasMes($mes, $anio)
        );

        $array_merge = array_merge($dtaBodega, $dtaTop10Cl, $dtaTop10Pr, $dtaVtasMes);
        return $array_merge;
        $sql_server->close();

    }
}
