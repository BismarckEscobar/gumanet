<?php

namespace App\Http\Controllers;

use App\metas_model;
use App\Models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use PHPExcel;
use PHPExcel_IOFactory;

class metas_controller extends Controller
{

	public function __construct()
	 {
	    $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
        ini_set('memory_limit', '1024M');
	 }
	 
    function index(){
        $users = User::all();
        $data = [
            'page' => 'Metas',
            'name' =>  'GUMA@NET'
        ];
        
        return view('pages.metas',compact('data','users'));
    }




    public function exportMetaFromExl(){
        
        $file_directory = "tmp_excel/";

        if(!empty($_FILES["addExlFileMetas"])){
            
            $mes = $_POST["mes"];
            $anno = $_POST["anno"];


      
    
            

            $file_array = explode(".", $_FILES["addExlFileMetas"]["name"]);
            $new_file_name = "tmp_excel.". $file_array[1];
            move_uploaded_file($_FILES["addExlFileMetas"]["tmp_name"], $file_directory . $new_file_name);
            if($file_array[1]=="xlsx" || $file_array[1]=="xls"){
                

                $file_type  = PHPExcel_IOFactory::identify("tmp_excel/".$new_file_name);
                $objReader  = PHPExcel_IOFactory::createReader($file_type);
                $objPHPExcel = $objReader->load($file_directory . $new_file_name);
                //$sheet_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                
                metas_model::saveExlToTmpTable($objPHPExcel,$mes,$anno);

                

            }else{
                echo "Archivo invalido";
            }
           

        }else{
            echo "no paso";
        }
    }

    public function getHistorialMeta(){
        echo metas_model::getHistorialMeta();
    }

    public function getExlFromTmpTable(){
        echo metas_model::getExlFromTmpTable();
    }

    public function add_data_meta(){

        /*$data = array();
        $i = 0;
        
        foreach ($_POST as $key => $value) {
            $data[$i]['fechaMeta'] = $key[$i]['fechaMeta'];
            $data[$i]['ruta'] = $key[$i]['ruta'];
            $data[$i]['codigo'] = $key[$i]['codigo'];
            $data[$i]['cliente'] = $key[$i]['cliente'];
            $data[$i]['articulo'] = $key[$i]['articulo'];
            $data[$i]['descripcion'] = $key[$i]['descripcion'];
            $data[$i]['valor'] = $key[$i]['valor'];
            $data[$i]['unidad'] = $key[$i]['unidad']; 
            $i++;
        }*/
        /*$data = array();
        for ($i=0; $i < count($_POST); $i++) { 

            $data[$i]['fechaMeta'] = $_POST[$i]['fechaMeta'];
            $data[$i]['ruta'] = $_POST[$i]['ruta'];
            $data[$i]['codigo'] = $_POST[$i]['codigo'];
            $data[$i]['cliente'] = $_POST[$i]['cliente'];
            $data[$i]['articulo'] = $_POST[$i]['articulo'];
            $data[$i]['descripcion'] = $_POST[$i]['descripcion'];
            $data[$i]['valor'] = $_POST[$i]['valor'];
            $data[$i]['unidad'] = $_POST[$i]['unidad']; 
        
        }*/

        echo metas_model::add_data_meta();

    }

    public function calcAddUnidadMeta(){
        metas_model::calcAddUnidadMeta();

    }

    public function truncate_tmp_exl_tbl(){
        metas_model::truncate_tmp_exl_tbl();
    }
}
