<?php

namespace App\Http\Controllers;

use App;
use App\metas_model;
use App\Models;
use App\User;
use App\Metadata;
use App\Tmp_meta_exl;
use App\Company;
use DataTables;
use DB;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;



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




    public function exportMetaFromExl(Request $request){
        
        $file_directory = "tmp_excel/";

        if(!empty($_FILES["addExlFileMetas"])){
            
            $mes = $request->input('mes');
            $anno = $request->input('anno');



            $file_array = explode(".", $_FILES["addExlFileMetas"]["name"]);
            $new_file_name = "tmp_excel.". $file_array[1];
            move_uploaded_file($_FILES["addExlFileMetas"]["tmp_name"], $file_directory . $new_file_name);
            if($file_array[1]=="xlsx" || $file_array[1]=="xls"){
                

                $file_type  = PHPExcel_IOFactory::identify("tmp_excel/".$new_file_name);
                $objReader  = PHPExcel_IOFactory::createReader($file_type);
                $objPHPExcel = $objReader->load($file_directory . $new_file_name);
                //$sheet_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                try{


                    $i = 2;//contador
                    $param=0;

                    while ($param==0) {
                        
                        

                        Tmp_meta_exl::insert(array('fechaMeta' => $anno.'/'.$mes.'/01',
                            'ruta' => $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                            'codigo' => $this->addZeros($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()),
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
                //metas_model::saveExlToTmpTable($objPHPExcel,$mes,$anno);

                

            }else{
                echo "Archivo invalido";
            }
           

        }else{
            echo "no paso";
        }
    }



    public function getTmpExlData(){
        $metaData = Tmp_meta_exl::all();
        
       return DataTables::of($metaData)->make(true);
      
    }


     public function getHistorialMeta(Request $request){
            
        if($request->isMethod('post')){
            $mes = $request->input('mes');
            $anno = $request->input('anno');

            $fecha =  date('Y-m-d', strtotime($anno.'-'.$mes.'-01'));

            $metaData = Metadata::where('fechaMeta', $fecha)->get();

            //$metaData2 = DB::connection('sqlsrv')->table('meta_datas')->where('fechaMeta', $fecha)->get();
            if(empty($metaData)){
                return 0;
            }else{
                return DataTables::of($metaData)->make(true);
            }
        }
       
    }


    public function existeFechaMeta(Request $request){
        if($request->isMethod('post')){
            $mes = $request->input('mes');
            $anno = $request->input('anno');
            $fecha =  date('Y-m-d', strtotime($anno.'-'.$mes.'-01'));

            $res = Metadata::where('fechaMeta', $fecha)->take(1)->get();
            if (empty($res[0])){
                return 0;
            }else{
                return 1;
            }
        }
    }


////función se mostrara en las gráficas
    public function calcAddUnidadMeta(){
       return Tmp_meta_exl::select(Tmp_meta_exl::raw('mes, anno, ruta, articulo, descripcion, sum(valor) as valor, sum(unidad) as unidad'))->groupBy('ruta','articulo', 'descripcion', 'mes', 'anno')->get();
    }

    public function truncate_tmp_exl_tbl(){
        Tmp_meta_exl::truncate();
    }


    public function add_data_meta(Request $request){

        $data = json_decode(json_encode(Tmp_meta_exl::all()), True); //class stdObjet to array
        $fecha = date('Y-m-d', strtotime(substr($data[0]['fechaMeta'],0,10))); //devuelve los primeros 10 digitos de la cadena
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
         $this->cambiarEstadoMeta();
       ///////AGREGA ENCABEZADO DE META
        $idPeriodo = DB::connection('sqlsrv')->table('metacuota_GumaNet')->insertGetId(['Tipo'=>'CUOTA', 'Estado' => 1,'Fecha' => $fecha,'IdCompany' => $company_user]);//inserta registro y retorna su ID debe ser autoincremento
        $this->addDataFromTmpToDataMeta($data,$idPeriodo);
    }


    private function addDataFromTmpToDataMeta($data, $idPeriodo){
        //////AGREGAR DATOS PARA CALCULAR METAS///////
       
        foreach ($data as $key) {
            $fecha = date('Y-m-d', strtotime($key['created_at']));
            Metadata::insert(['fechaMeta'=> $key['fechaMeta'], 'ruta'=> $key['ruta'], 'codigo'=> $key['codigo'], 'cliente'=> $key['cliente'], 'articulo'=> $key['articulo'], 'descripcion'=> $key['descripcion'], 'valor'=> $key['valor'], 'unidad'=> $key['unidad'], 'created_at'=> $key['created_at'], 'IdPeriodo' => $idPeriodo]);
        }
        
    }

    private function cambiarEstadoMeta(){
        DB::connection('sqlsrv')->table('metacuota_GumaNet')->where('Estado',1)->update(['Estado' => 0]);
    }

    private function addZeros($code){
        $res='';
        switch (strlen($code)) {
            case 4:
                $res = '0'.$code;
                break;
            case 3:
                $res = '00'.$code;
                break;
            case 2:
                $res = '000'.$code;
                break;
            case 1:
                $res = '0000'.$code;
                break;
            
            default:
                $res = $code;
                break;
        }

        return $res;
        
    }

   
}
