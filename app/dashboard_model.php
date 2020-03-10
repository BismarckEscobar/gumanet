<?php

namespace App;
use App\User;
use App\Company;

Use App\Gn_couta_x_producto;
Use App\Metacuota_gumanet;

use DB;
use DateTime;

use Illuminate\Database\Eloquent\Model;

class dashboard_model extends Model {
        //Resumen / Grafica venta / Tabla de total ventas por Ruta
     public static function getTotalRutaXVentas($mes, $anio){
        $sql_server = new \sql_server();
        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Ventas_Rutas ".$mes.", ".$anio;
                break;
            case '2':
                $sql_exec = "EXEC Ventas_Rutas_GF ".$mes.", ".$anio;
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

        
        foreach ($query as $fila) {
            $json[$i]["RUTA"]       = $fila["Ruta"];
            $json[$i]["MONTO"]    = number_format($fila["Monto"],2);
            $i++;
        }

        return $json;
        $sql_server->close();

     }

    

    public static function getTotalUnidadesXRutaXVentas($mes, $anio){
        $sql_server = new \sql_server();
         $fecha = new DateTime($anio.'-'.$mes.'-01');
        $sql_exec = '';
        $request = Request();
        $idPeriodo = '';
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        $idPeriodo = Metacuota_gumanet::where(['Fecha' => $fecha,'IdCompany'=> $company_user])->pluck('IdPeriodo');

        switch ($company_user) {
            case '1':
               
                $sql_exec = "EXEC Ventas_Rutas ".$mes.", ".$anio;
                
                break;
            case '2':
                 
                $sql_exec = "EXEC Ventas_Rutas_GF ".$mes.", ".$anio;
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

        foreach ($query as $fila) {
            
            $json[$i]["VENDE"] = dashboard_model::buscarVendedorXRuta($fila["Ruta"], $company_user);
            $meta =  Gn_couta_x_producto::where(['IdPeriodo'=> $idPeriodo, 'CodVendedor' => $fila["Ruta"]])->sum('Meta');

            $json[$i]["METAU"] = number_format($meta,2)." U";
            $json[$i]["REALU"] = number_format($fila["Cantidad"],2)." U";
            
            $json[$i]["DIFU"] = ($meta==0) ? "100.00%" : number_format(((floatval($fila["Cantidad"])/floatval($meta))*100),2)."%";
            $monto =  Gn_couta_x_producto::where(['IdPeriodo'=> $idPeriodo, 'CodVendedor' => $fila["Ruta"]])->sum('val');
            $json[$i]["METAE"] = "C$".number_format($monto,2);
            $json[$i]["REALE"] = "C$".number_format($fila["Monto"],2);
            $json[$i]["DIFE"] = ($meta==0) ? "100.00%" : number_format(((floatval($fila["Monto"])/floatval($monto))*100),2)."%";
            $json[$i]["RUTA"] = '<a href="#!" id="rutaDetVenta" onclick="getDetalleVenta('.$mes.','.$anio.','."'".$json[$i]["METAU"]."'".','."'".$json[$i]["REALU"]."'".','."'".$json[$i]["METAE"]."'".','."'".$json[$i]["REALE"]."'".','."'".$fila["Ruta"]."'".')" >'.$fila["Ruta"].'</a>';
            $i++;
        }
        return $json;

            $sql_server->close();
            $sql_exec = 'SELECT ';
    }

    public static function buscarVendedorXRuta($ruta, $compañia){
        $sql_server = new \sql_server();
        $vendedor = array(); 


        switch ($compañia) {
            case '1':
                $sql_exec =  "VENDEDOR_UMK ".$ruta;
                $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);
                foreach ($query as $fila){
                $vendedor = $fila['NOMBRE'];
                }
                break;

            case '2':
                $sql_exec =  "VENDEDOR_GP ".$ruta;
                $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);
                foreach ($query as $fila){
                $vendedor = $fila['NOMBRE'];
                }
                break;
            case '3':
                # code...
                break;
            
            default:
                # code...
                break;
        }

           
           return $vendedor;
    }
// Tabla de detalles
    public static function getDetalleVentasXRuta($mes, $anio, $ruta){

        $sql_server = new \sql_server();
        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        $fecha = new DateTime($anio.'-'.$mes.'-01');
        $idPeriodo = Metacuota_gumanet::where(['Fecha' => $fecha,'IdCompany'=> $company_user])->pluck('IdPeriodo');

        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC umk_VentaArticulo_Vendedor ".$mes.", ".$anio.", '".$ruta."'";
                
                break;
            case '2':
                $sql_exec = "EXEC Gp_VentaArticulo_Vendedor ".$mes.", ".$anio.", '".$ruta."'";
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
        $j=0;
        $codProdVendido = array();
        $json = array();
        ////Agrega los productos que se han vendido de meta y los que no se encuentran en meta en el arreglo Json para mostrar en tabla de metas  
         foreach ($query as $fila) {
            $json[$i]["ARTICULO"]       = $fila["ARTICULO"];
            $json[$i]["DESCRIPCION"]    = $fila["DESCRIPCION"];
            $meta =  Gn_couta_x_producto::where(['CodVendedor' => $ruta, 'IdPeriodo'=> $idPeriodo, 'CodProducto' => $fila["ARTICULO"]])->sum('Meta');
            
             $MetaCodArticVendido[$j] = Gn_couta_x_producto::where(['CodVendedor' => $ruta, 'IdPeriodo'=> $idPeriodo, 'CodProducto' => $fila["ARTICULO"]])->pluck('CodProducto');
             if (count($MetaCodArticVendido[$j]) > 0) {// si la cantidad de caracteres mayor a cero, registra valor
                $MetaCodArticVendido[$j] =  $MetaCodArticVendido[$j];
                $j++;
            }
            
           
            $json[$i]["METAU"] = number_format($meta,2);
            $json[$i]["REALU"] = number_format($fila["CANTIDAD"], 2);
            $json[$i]["DIFU"] = ($meta==0 || $meta=="") ? "0.00%" : number_format(((floatval($fila["CANTIDAD"])/floatval($meta))*100),2)."%";

            $monto =  Gn_couta_x_producto::where(['CodVendedor' => $ruta, 'IdPeriodo'=> $idPeriodo, 'CodProducto' => $fila["ARTICULO"]])->sum('val');
            $json[$i]["METAE"] = number_format($monto,2);
            $json[$i]["REALE"] = number_format($fila["MONTO"], 2);
            $json[$i]["DIFE"] = ($meta==0 || $meta=="") ? "0.00%" : number_format(((floatval($fila["MONTO"])/floatval($monto))*100),2)."%";
            $i++;
        } 
        
          ////Agrega los productos que no se han vendido en el arreglo Json para mostrar en tabla de metas  
        $query_prod_no_vendidos = Gn_couta_x_producto::where(['CodVendedor' => $ruta, 'IdPeriodo'=> $idPeriodo])->whereNotIn('CodProducto',$MetaCodArticVendido)->get();
        
        foreach ($query_prod_no_vendidos as $fila) {
            $json[$i]["ARTICULO"]       = $fila["CodProducto"];
            $json[$i]["DESCRIPCION"]    = $fila["NombreProducto"].'<span style = "color: red"> &nbsp(No vendido)</span>';
            
            $json[$i]["METAU"] = number_format($fila["Meta"],2);
            $json[$i]["REALU"] = 0.00;
            $json[$i]["DIFU"] = ($fila["Meta"]==0 || $fila["Meta"]=="") ? "0.00%" : number_format(((0.00/floatval($fila["Meta"]))*100),2)."%";

            $json[$i]["METAE"] = number_format($fila["val"],2);
            $json[$i]["REALE"] = 0.00;
            $json[$i]["DIFE"] = ($fila["val"]==0 || $fila["val"]=="") ? "0.00%" : number_format(((0.00/floatval($fila["val"]))*100),2)."%";
            $i++;
        } 
        

        $sql_server->close();
        return $json;

    }
    
    
    public static function getDetalleVentas($tipo, $mes, $anio, $cliente, $articulo, $ruta) {
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        $cliente = ($cliente=='ND')?'':$cliente;
        $articulo = ($articulo=='ND')?'':$articulo;
        $ruta = ($ruta=='ND')?'':$ruta;

         switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Umk_VentaLinea_Articulo ".$mes.", ".$anio.", '', '".$cliente."', '".$articulo."', ''";

                break;
            case '2':
                $sql_exec = "EXEC Gp_VentaLinea_Articulo ".$mes.", ".$anio.", '', '".$cliente."', '".$articulo."', ''";
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
                    $mes = (strlen($mes)==1)?'0'.$mes:$mes;
                    $f1 = intval($anio.$mes.'01');

                    $fecha = new DateTime( $anio.'-'.$mes.'-01' );
                    $fecha->modify('last day of this month');
                    $ult_dia = $fecha->format('d');
                    $f2 = intval($anio.$mes.$ult_dia);

                    switch ($company_user) {
                        case '1':
                            $sql_exec = "EXEC Recuperacion_Cartera '".$f1."', '".$f2."', '' ";

                            break;
                        case '2':
                            $sql_exec = "SELECT
                                            T0.COBRADOR AS Vendedor,
                                            SUM(T0.MONTO) AS real_,
                                            T0.NombreVendedor AS Nombre
                                        FROM
                                            gn_recuperacion T0
                                        WHERE
                                            T0.Mes = ".$mes."
                                            AND T0.Anno = ".$anio."
                                        GROUP BY T0.COBRADOR, T0.NombreVendedor";
                            break;
                        case '3':
                            $sql_exec = "";
                            break;            
                        default:                
                            dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                            break;
                    }

                    $query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);

    		        foreach ($query as $fila_) {                        
                        $real = ($company_user==1)?(floatval($fila_['Recuperacion_Contado'])):$fila_['real_'];
                        $meta = dashboard_model::returnMetaRecuperacion($mes, $anio, $company_user, $fila_['Vendedor']);

                        $cump = ($meta==0)?100:( $real / $meta ) * 100;

    		        	$json[$i]["RUTA"] 		= $fila_['Vendedor'];
    		        	$json[$i]["NOMBRE"] 	= $fila_['Nombre'];
    		            $json[$i]["MONTO"] 		= number_format($real, 2);
    		            $json[$i]["META"] 		= number_format($meta, 2);
    		            $json[$i]["EFEC"] 		= number_format($cump, 0).'%';
    		            $i++;
    		        }
        		break;
            case 'clien':
                foreach ($query as $fila) {
                    $json[$i]["ARTICULO"]       = $fila["articulo"];
                    $json[$i]["DESCRIPCION"]    = $fila["descripcion"];
                    $json[$i]["CANTIDAD"]       = number_format($fila["Cantidad"], 2);
                    $json[$i]["TOTAL"]          = number_format($fila["total"], 2);
                    $i++;
                }
                break;
            case 'artic':
                foreach ($query as $fila) {
                    $json[$i]["CLIENTE"]       = $fila["cliente"];
                    $json[$i]["NOMBRE"]        = $fila["nombre"];
                    $json[$i]["CANTIDAD"]      = number_format($fila["Cantidad"], 2);
                    $json[$i]["TOTAL"]         = number_format($fila["total"], 2);
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

    public static function returnMetaRecuperacion($mes, $anio, $company_user, $rta) {
        $meta = 0;
        $query = DB::select("CALL sp_recuperacionMeta(".$mes.",".$anio.",".$company_user.", '".$rta."' )");
            
        foreach($query as $t) {
            $meta = $t->meta;
        }

        return $meta;

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
        $items = 0;
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Umk_VentaLinea_Articulo ".$mes.", ".$anio.", '', '', '', ''";
                $sql_meta = "EXEC UMK_meta_articulos ".$mes.", ".$anio.", '', '', ''";
                break;
            case '2':
                $sql_exec = "EXEC Gp_VentaLinea_Articulo ".$mes.", ".$anio.", '', '', '', ''";
                $sql_meta = "EXEC Gp_meta_articulos ".$mes.", ".$anio.", '', '', ''";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query  = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);        
        $query2 = $sql_server->fetchArray($sql_meta, SQLSRV_FETCH_ASSOC);
        $json = array();

        foreach ($query as $key) {
            $total = $total + floatval($key['Monto']);
        }

        $json[0]['name'] = 'Real';
        $json[0]['data'] =  $total;

        $json[1]['name'] = 'Meta';
        $json[1]['data'] = floatval($query2[0]['meta']);

        $json[2]['name'] = 'items';
        $json[2]['data'] =  dashboard_model::cantItems($mes, $anio, $company_user);

        return $json;
        $sql_server->close();
    }

    public static function cantItems($mes, $anio, $company_user) {
        $sql_server = new \sql_server();
        $sql_exec = '';        
        switch ($company_user) {
            case '1':
                $sql_exec =
                "SELECT dbo.UMK_RETURN_ITEMS_MES(".$mes.", ".$anio.") cantItems";
                break;
            case '2':                
                $sql_exec =
                "SELECT dbo.GP_RETURN_ITEMS_MES(".$mes.", ".$anio.") cantItems";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        
        if (count($query)>0) {
           return $query[0]['cantItems']; 
        }

        return false;
    }

    public static function getComparacionMesVentas($mes, $anio) {
        $total_1 = $total_2 = $total_3 = 0;
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        $meses = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

        
        switch ($company_user) {
            case '1':
                $sql_exec =
                "EXEC UMK_GN_VENTAS_COMPARACION ".$mes.", ".$anio." ";
                break;
            case '2':                
                $sql_exec =
                "EXEC GP_GN_VENTAS_COMPARACION ".$mes.", ".$anio." ";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $json = array();

        if (count($query)>0) {
            $x = $query[0];

            $json[0]['name'] = ($meses[($x['mesActual'])-1]).' '.$x['anioActual'];
            $json[0]['data'] =  floatval($query[0]['montoActual']);

            $json[1]['name'] = ($meses[($x['mesPasado'])-1]).' '.$x['anioPasado'];
            $json[1]['data'] =  floatval($x['montoAnioPasado']);

            $json[2]['name'] = ($meses[($x['mesAnterior'])-1]).' '.$x['AnioAnterior'];
            $json[2]['data'] = floatval($x['montoMesPasado']);
        }


        return $json;
        $sql_server->close();
    }

    public static function getComparacionMesItems($mes, $anio) {
        $total_1 = $total_2 = $total_3 = 0;
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        $meses = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

        
        switch ($company_user) {
            case '1':
                $sql_exec =
                "EXEC UMK_GN_ITEMS_COMPARACION ".$mes.", ".$anio." ";
                break;
            case '2':
                $sql_exec =
                "EXEC GP_GN_ITEMS_COMPARACION ".$mes.", ".$anio." ";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $json = array();

        if (count($query)>0) {
            $x = $query[0];

            $json[0]['name'] = ($meses[($x['mesActual'])-1]).' '.$x['anioActual'];
            $json[0]['data'] =  floatval($query[0]['cantActual']);

            $json[1]['name'] = ($meses[($x['mesPasado'])-1]).' '.$x['anioPasado'];
            $json[1]['data'] =  floatval($x['cantAnioPasado']);

            $json[2]['name'] = ($meses[($x['mesAnterior'])-1]).' '.$x['AnioAnterior'];
            $json[2]['data'] = floatval($x['cantMesPasado']);            
        }


        return $json;
        $sql_server->close();
    }

    public static function getVentasXCategorias($mes, $anio) {
        $sql_server = new \sql_server();
        $Dta = array();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = "SELECT
                            SUM(VENTA) AS Monto,
                            Clasificacion3 As ClaseTerapeutica
                            FROM Softland.DBO.VtasTotal_UMK (nolock)
                            WHERE month(DIA)=".$mes." AND year(DIA)=".$anio."
                            AND  Ruta NOT IN('F01', 'F12')
                            GROUP BY Clasificacion3,Clasificacion5";
                break;
            case '2':
                $sql_exec = "SELECT
                            SUM(VENTA) AS Monto,
                            Clasificacion3 As ClaseTerapeutica
                            FROM Softland.DBO.GP_VtasTotal_UMK (nolock)
                            WHERE month(DIA)=".$mes." AND year(DIA)=".$anio."
                            AND  Ruta NOT IN('F01', 'F12')
                            GROUP BY Clasificacion3,Clasificacion5";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        $json = array();
        $i=0;
        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ) {
            foreach ($query as $key) {

                $json[$i]['name']       = $key['ClaseTerapeutica'];
                $json[$i]['data']       = floatval($key['Monto']);

                $i++;
            }
        }

        return $json;
        //$sql_server->close();
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

    public static function ventaXCategorias($mes, $anio, $cate) {
        $sql_server = new \sql_server();
        $Dta = array();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;        

        if ($cate=='TODAS LAS CATEGORIAS') {
        	return dashboard_model::getVentasXCategorias($mes, $anio);
        }else{
        	switch ($company_user) {
            	case '1':
                	$sql_exec = "EXEC Umk_VentaLinea_Articulo ".$mes.", ".$anio.", '".$cate."', '', '','' ";
                	$sql_meta = "EXEC UMK_meta_articulos ".$mes.", ".$anio.", '".$cate."', '', '' ";
                break;
            	case '2':
                	$sql_exec = "EXEC Gp_VentaLinea_Articulo ".$mes.", ".$anio.", '".$cate."', '', '','' ";
                 	$sql_meta = "EXEC Gp_meta_articulos ".$mes.", ".$anio.", '".$cate."', '', '' ";
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

        	$json = array();
        	$real_ = $meta_ = 0;

        	if( count($query)>0 ){
				$real_ = array_sum(array_column($query, 'Monto'));
        	}

        	if( count($query2)>0 ){
				$meta_ = floatval($query2[0]['meta']);
        	}

		    $json[0]['name'] = 'Real';
		    $json[0]['data'] = floatval($real_);

		    $json[1]['name'] = 'Meta';
		    $json[1]['data'] = $meta_;

        	$sql_server->close();        	
        	return $json;
    	}
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
        $dtaRecupera[] = array(
            'tipo' => 'dtaRecupera',
            'data' => dashboard_model::getRecuperaMes($mes, $anio)
        );

        $dtaCompMesesVentas[] = array(
            'tipo' => 'dtaCompMesesVentas',
            'data' => dashboard_model::getComparacionMesVentas($mes, $anio)
        );

        $dtaCompMesesItems[] = array(
            'tipo' => 'dtaCompMesesItems',
            'data' => dashboard_model::getComparacionMesItems($mes, $anio) 
        );

        $dtaVentasXCateg[] = array(
        	'tipo' => 'dtaVentasXCateg',
        	'data' => dashboard_model::getVentasXCategorias($mes, $anio)
        );

        $array_merge = array_merge($dtaBodega, $dtaTop10Cl, $dtaTop10Pr, $dtaVtasMes, $dtaRecupera, $dtaCompMesesVentas, $dtaCompMesesItems, $dtaVentasXCateg);
        return $array_merge;
        $sql_server->close();
    }

    public static function getRecuperaMes($mes, $anio) {
        $total = 0;
        $sql_server = new \sql_server();

        $mes = (strlen($mes)==1)?'0'.$mes:$mes;
        $f1 = intval($anio.$mes.'01');
        
        $fecha = new DateTime( $anio.'-'.$mes.'-01' );
        $fecha->modify('last day of this month');
        $ult_dia = $fecha->format('d');
        $f2 = intval($anio.$mes.$ult_dia);

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Recuperacion_Cartera '".$f1."', '".$f2."', ''; ";
                $sql_meta = "CALL sp_recuperacionMeta(".$mes.",".$anio.",".$company_user.", '' )";
                break;
            case '2':
                $sql_exec = "SELECT SUM(MONTO) AS M_REC FROM gn_recuperacion T0 WHERE Mes = ".$mes." AND Anno=".$anio." ";
                $sql_meta = "CALL sp_recuperacionMeta(".$mes.",".$anio.",".$company_user.", '' )";
                break;
            case '3':
                $sql_exec = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        
        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);        
        $query2 = DB::select($sql_meta);
        $meta = 0;
        $json = array();
            
        if (count($query)>0) {
            if ($company_user==1) {
                foreach ($query as $key) {
                    $total = $total +  ( floatval($key['Recuperacion_Contado']) );
                    
                }
            }else {
                $total = floatval($query[0]['M_REC']);
            }


            $json[0]['name'] = 'Real';
            $json[0]['data'] =  $total;
        }
        
        foreach($query2 as $t){
            $meta = $t->meta;
        }

        if (count($query)>0 || $meta!=null) {
            $json[1]['name'] = 'Meta';
            $json[1]['data'] = floatval($meta);
        }        


        return $json;
        $sql_server->close();
    }

    public static function getVentasMensuales() {
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        
        switch ($company_user) {
            case '1':
                $sql = 'EXECUTE UMK_GN_VENTAS_MENSUALES';
                break;
            case '2':
                $sql = "EXECUTE GP_GN_VENTAS_MENSUALES";
                break;
            case '3':
                $sql = "";
                break;            
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $json = array();
        $val1__ = array();
        $val2__ = array();
        $query = $sql_server->fetchArray($sql, SQLSRV_FETCH_ASSOC);

        $anioActual = intval(date('Y'));
        $anioPasado = $anioActual - 1;

        foreach ($meses as $key => $mes) {
            $x1 = array_column(array_filter($query, function($item) use($anioActual, $mes) { return $item['anio'] == $anioActual and $item['mes']==$mes; } ), 'montoVenta');


            $y1 = array_column(array_filter($query, function($item) use($anioPasado, $mes) { return $item['anio'] == $anioPasado and $item['mes']==$mes; } ), 'montoVenta');

            (count($x1)>0)?(array_push($val1__,$x1[0])):(false);
            (count($y1)>0)?(array_push($val2__,$y1[0])):(array_push($val2__,0));
        }


        $json[0]['name'] = $anioPasado;
        $json[0]['venta'] = $val2__;
        
        $json[1]['name'] = $anioActual;
        $json[1]['venta'] = $val1__;
        return $json;
        $sql_server->close();
    }
}
