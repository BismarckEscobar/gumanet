<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reportes_model extends Model
{
    public static function claseTerapeutica() {
        
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = " SELECT * FROM UMK_CLASIFICACION_ARTICULO ";
                break;
            case '2':
                $sql_exec = " SELECT * FROM GP_CLASIFICACION_ARTICULO ";
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = " SELECT * FROM INN_CLASIFICACION_ARTICULO ";
                break;   
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ){
            return $query;
        }

        $sql_server->close();
        return false;
    }


    public static function rutas(){
         $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = " SELECT * FROM UMK_VENDEDORES_ACTIVO ";
                break;
            case '2':
                $sql_exec = " SELECT * FROM GP_VENDEDORES_ACTIVOS ";
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = " SELECT * FROM INV_VENDEDORES_ACTIVOS ";
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

         $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ){
            return $query;
        }

        $sql_server->close();
        return false;
    }

    public static function articulos() {
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = " SELECT * FROM UMK_ARTICULOS_ACTIVOS ";
                break;
            case '2':
                $sql_exec = " SELECT * FROM GP_ARTICULOS_ACTIVOS ";
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = " SELECT * FROM INN_ARTICULOS_ACTIVOS ";
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ){
			return $query;
        }

        $sql_server->close();
        return false;
    }

	public static function clientes() {
        $sql_server = new \sql_server();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = " SELECT * FROM UMK_CLIENTES_ACTIVOS ";
                break;
            case '2':
                $sql_exec = " SELECT * FROM GP_CLIENTES_ACTIVOS ";
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = " SELECT * FROM INN_CLIENTES_ACTIVOS ";
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ){
			return $query;
        }

        $sql_server->close(); 
        return false;
    }

    public static function returndetalleVentas($clase, $cliente, $articulo, $mes, $anio, $ruta) {
        $sql_server = new \sql_server();
        $Dta = array();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = "EXEC Umk_VentaLinea_Articulo ".$mes.", ".$anio.", '".$clase."', '".$cliente."', '".$articulo."','".$ruta."'";
                $sql_meta = "EXEC UMK_meta_articulos ".$mes.", ".$anio.", '".$clase."', '".$cliente."', '".$articulo."'";
                break;
            case '2':
                $sql_exec = "EXEC Gp_VentaLinea_Articulo ".$mes.", ".$anio.", '".$clase."', '".$cliente."', '".$articulo."','".$ruta."'";
                 $sql_meta = "EXEC Gp_meta_articulos ".$mes.", ".$anio.", '".$clase."', '".$cliente."', '".$articulo."'";
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = "EXEC Inv_VentaLinea_Articulo ".$mes.", ".$anio.", '".$clase."', '".$cliente."', '".$articulo."','".$ruta."'";
                 $sql_meta = "EXEC Inv_meta_articulos ".$mes.", ".$anio.", '".$clase."', '".$cliente."', '".$articulo."'";
                break;
                break; 
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $query2 = $sql_server->fetchArray($sql_meta, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ){
			return $Dta = array('objDt' => $query, 'meta' => intval($query2[0]['meta']));
        }

        $sql_server->close();
        return false;
    }

    public static function returnDetFactVenta($nFactura){
        $sql_server = new \sql_server();
        $Dta = array();

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = 'SELECT FACTURA, ARTICULO, DESCRIPCION, CANTIDAD, PRECIO_UNITARIO, PRECIO_TOTAL FROM UMK_DETALLES_FACTURAS WHERE FACTURA = '."'".$nFactura."'";
                break;
            case '2':
                $sql_exec = 'SELECT FACTURA, ARTICULO, DESCRIPCION, CANTIDAD, PRECIO_UNITARIO, PRECIO_TOTAL FROM GP_DETALLES_FACTURAS WHERE FACTURA = '.$nFactura.'';
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = 'SELECT FACTURA, ARTICULO, DESCRIPCION, CANTIDAD, PRECIO_UNITARIO, PRECIO_TOTAL FROM INN_DETALLES_FACTURAS WHERE FACTURA = '.$nFactura.'';
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        if( count($query)>0 ){
            return $Dta = array('objDt' => $query);
        }

        $sql_server->close();
        return false;
    }
}
