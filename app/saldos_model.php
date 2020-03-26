<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class saldos_model extends Model {
    
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
                $sql_exec = "";
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

    public static function saldosAll($ruta) {
		$sql_server = new \sql_server();

		$sql_exec = '';
		$request = Request();
		$company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

		switch ($company_user) {
			case '1':
			    $sql_exec = "SELECT
								SUM (m.NoVencidos) AS N_VENCIDOS,
								SUM (m.Dias30) AS Dias30,
								SUM (m.Dias60) AS Dias60,
								SUM (m.Dias90) AS Dias90,
								SUM (m.Dias120) AS Dias120,
								SUM (m.Mas120) AS Mas120
							FROM
								GMV_ClientesPerMora m
								WHERE VENDEDOR LIKE '%".$ruta."%'";
			    break;
			case '2':
			    return false;
			    break;
			case '3':
			    return false;
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
}
