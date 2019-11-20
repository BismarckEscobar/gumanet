<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class metas_model extends Model
{

         


    public static function saveExlToTmpTable($objPHPExcel,$mes,$anno)
    {
    	try{


    	$i = 2;//contador
    	$param=0;

		while ($param==0) {
			
			

			DB::table('tmp_meta_exl')->insert(array('fechaMeta' => $anno.'/'.$mes.'/01',
				'ruta' => $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
        		'codigo' => $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(),
        		'cliente' => $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue(),
        		'articulo' => $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue(),
        		'descripcion' => $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(),
        		'valor' => $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue(),
        		'unidad' => $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(),
        		'created_at' => new\DateTime()));
				
			$i++;
			if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL){
				$param=1;
			}			
		}


    	}catch(Exception $e){
    		echo "excepción: ".$e;
    	}




    }



    public static function getExlFromTmpTable(){
    	try
    	{
    		return DB::table('tmp_meta_exl')->get();
    	}
    	catch(Exception $e)
    	{
    		echo "excepción: ".$e;
    	}

    }
    public function cnn_SQL_Server($sql_exec,$params, $tipo, $cnnType){////CREA CON#EXION A SQL SERVER
        ////VARIABLES DE CONEXION A SQL SERVER/////////////
        $serverName = "192.168.1.18";
        $dbname = "DESARROLLO";
        $user = "dbomanager";
        $password = "Umk*.*@!";
        $characterSet = "UTF-8";
        $connection;
         //////////////////////////////////////////////////

        $connectionInfo = array( "Database"=> $dbname, "UID"=> $user, "PWD"=> $password,  "CharacterSet" =>$characterSet);

        $connection = sqlsrv_connect($serverName, $connectionInfo);

        if( $connection === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($tipo == 'insert') {

            $stmt = sqlsrv_query( $connection, $sql_exec, $params);//ALMACENAR DATOS

            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

        }
        if ($tipo == 'select') {

            $stmt = sqlsrv_query( $connection, $sql_exec);//SELECCIONA DATOS

            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $a_array = array();

            while ($res = sqlsrv_fetch_array($stmt, $cnnType)) {
                $a_array[] = $res;
            }
             if ($connection) {
                sqlsrv_close($connection);
            }

            return $a_array;
        }
        


        

        if ($connection) {
            sqlsrv_close($connection);
        }
    }

    public static function add_data_meta(){

        

        $data = json_decode(json_encode(DB::table('tmp_meta_exl')->get()), True); //class stdObjet to array
        $fecha = date('Y-m-d', strtotime(substr($data[0]['fechaMeta'],0,10))); //devuelve los primeros 10 digitos de la cadena
        $sql_exec = '';
        $type = 'insert';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;


          
       ///////AGREGA ENCABEZADO DE META

        $sql_exec = 'INSERT INTO "metacuota_GumaNet" (Tipo, Estado, Fecha, IdCompany) VALUES (?,?,?,?)';
        $params = array("CUOTA",  1, $fecha, $company_user);

        (new self)->cnn_SQL_Server($sql_exec, $params, $type, NULL);

        $idPeriodo = (new self)->getUltimoPeriodoAgregado();

        (new self)->addDataFromTmpToDataMeta($data,$idPeriodo);


    }



    private function getUltimoPeriodoAgregado(){
        $type = 'select';
        $cnnType=SQLSRV_FETCH_ASSOC;
        $sql_exec = 'SELECT max(IdPeriodo) as IdPeriodo FROM "metacuota_GumaNet"';

        
        $res;
        $query = $this->cnn_SQL_Server($sql_exec, NULL, $type, $cnnType);
        foreach ($query as $key) {
            $res = $key['IdPeriodo']; 
        }

        return $res;
    }


    public static function getHistorialMeta(){
        
    }




    private function addDataFromTmpToDataMeta($data, $idPeriodo){
         //////AGREGAR DATOS PARA CALCULAR METAS///////
        $sql_exec="";
       $type = 'insert';


        
        foreach ($data as $key) {
            $fecha = date('Y-m-d', strtotime($key['created_at']));
            $sql_exec = 'INSERT INTO "meta_data" (fechaMeta, ruta, codigo, cliente, articulo, descripcion, valor, unidad, created_at, IdPeriodo) VALUES (?,?,?,?,?,?,?,?,?,?)';

            $params = array($key['fechaMeta'], $key['ruta'], $key['codigo'], $key['cliente'], $key['articulo'], $key['descripcion'], $key['valor'], $key['unidad'],$key['created_at'],$idPeriodo);

            $this->cnn_SQL_Server($sql_exec,$params, $type, NULL);
            
        }
        
    }



	
    public static function calcAddUnidadMeta(){
    	
		return DB::table('tmp_meta_exl')
                 ->select(DB::raw('mes, anno, ruta, articulo, descripcion, sum(valor) as valor, sum(unidad) as unidad'))
                 ->groupBy('ruta','articulo', 'descripcion', 'mes', 'anno')
                 ->get();
    }



    public static function truncate_tmp_exl_tbl(){
    	DB::table('tmp_meta_exl')->truncate();
	}
}
