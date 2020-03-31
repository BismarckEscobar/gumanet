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
		$temp = array();
		$i=0;

		$sql_exec = '';
		$request = Request();
		$company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

		switch ($company_user) {
			case '1':
			    $sql_exec = 
			    "SELECT
					m.VENDEDOR AS RUTA,
					ISNULL(( SELECT T.NOMBRE FROM UMK_VENDEDORES_ACTIVO T WHERE T.VENDEDOR=m.VENDEDOR ), '-') AS NOMBRE,
					SUM (m.NoVencidos) AS N_VENCIDOS,
					(SUM(m.Dias30) + SUM(m.Dias60) + SUM(m.Dias90) + SUM(m.Dias120) + SUM(m.Mas120)) AS VENCIDO
				FROM
					GMV_ClientesPerMora m
				GROUP BY
					VENDEDOR";
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

		if( count($query)>0 ) {
			foreach ($query as $key) {
	    		$temp[$i]['OPC'] 		= '<a id="exp_more" class="exp_more" href="#!"><i class="material-icons expan_more">expand_more</i></a>';
				$temp[$i]['RUTA'] 		= $key['RUTA'];
				$temp[$i]['RUTA01'] 	= '<p class="font-weight-bold text-info">'.$key['RUTA'].'</p>';
				$temp[$i]['NOMBRE'] 	= '<p class="font-weight-bold">'.$key['NOMBRE'].'</p>';
				$temp[$i]['N_VENCIDO'] 	= 'C$ '.number_format($key['N_VENCIDOS'], 2);
				$temp[$i]['VENCIDO'] 	= 'C$ '.number_format($key['VENCIDO'], 2);
				$i++;
			}
		}

		$sql_server->close();
		return $temp;
    }

    public static function saldosXRuta($ruta) {
		$sql_server = new \sql_server();
		$temp = array();
		$i=0;


		$sql_exec = '';
		$request = Request();
		$company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

		switch ($company_user) {
			case '1':
			    $sql_exec = 
			    "SELECT
				SUM (m.NoVencidos) AS N_VENCIDOS,
				 SUM (m.Dias30) AS Dias30,
				 SUM (m.Dias60) AS Dias60,
				 SUM (m.Dias90) AS Dias90,
				 SUM (m.Dias120) AS Dias120,
				 SUM (m.Mas120) AS Mas120,
				 m.VENDEDOR
				FROM
					GMV_ClientesPerMora m
				WHERE
					VENDEDOR = '".$ruta."'
				GROUP BY
					VENDEDOR";
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

		if( count($query)>0 ) {
			return $query;
		}

		$sql_server->close();
		return 'hol amundo';
		
    }
}
