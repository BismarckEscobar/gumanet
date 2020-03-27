<?php

namespace App\Http\Controllers;

use App;
use App\Models;
use App\User;
use App\Gn_couta_x_producto;
use App\Umk_recuperacion;
use App\Tmp_meta_exl;
use App\meta_recuperacion_exl;
use DataTables;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;

use App\reportes_model;

class recuperacion_controller extends Controller
{
     public function __construct()
     {
        $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
     }
     
    function index(){
        $this->agregarDatosASession();
        $users = User::all();
        $data = [
            'page' => 'Metas',
            'name' => 'Recuperación'
        ];
        
        return view('pages.recuperacion',compact('data','users'));
    }

    public function agregarDatosASession(){
        $request = Request();
        $ApplicationVersion = new \git_version();
        $company = Company::where('id',$request->session()->get('company_id'))->first();// obtener nombre de empresa mediante el id de empresa
        $request->session()->put('ApplicationVersion', $ApplicationVersion::get());
        $request->session()->put('companyName', $company->nombre);// agregar nombre de compañia a session[], para obtenert el nombre al cargar otras pagina 
    }

    public function getMetaXRuta($fecha, $ruta){
        $request = Request();

       
      
    }

    public function getMoneyRecuRowsByRoutes($mes, $anio, $pageName){

       
        $request = Request();
        $fecha =  date('Y-m-d', strtotime($anio.'-'.$mes.'-01'));
        $recuperacion = array();
        $json = array();
        $i = 0;
        $meta=0;
        $recuperacion = Umk_recuperacion::where(['fecha_recup'=>$fecha, 'idCompanny'=>$request->session()->get('company_id')])->get();

        foreach ($recuperacion as $key) {
            $meta = meta_recuperacion_exl::where(['fechaMeta'=>$fecha, 'idCompanny'=> $request->session()->get('company_id'), 'ruta' => $key['ruta']])->pluck('meta');



            $meta =  str_replace(['[',']'],'',$meta);


                if ($meta == '') {
                    $meta = '0.00';
                }else{
                    $meta = $meta;

                } 

            $json[$i]['RECU_RUTA'] =  $key['ruta'];
            $json[$i]['RECU_VENDE'] =  $key['vendedor'];
            $json[$i]['RECU_META'] =  '<span id ="recu_meta_'.$key['ruta'].'">C$'. number_format($meta,2).'</span>';

            if ($key['recuperado_credito']>0) {

                if($pageName == 'Recuperacion'){
                    $json[$i]['RECU_CREDITO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="'.$key['recuperado_credito'].'" id ="recu_credito_'.$key['ruta'].'">';
                }else{
                    $json[$i]['RECU_CREDITO'] = 'C$'. number_format($key['recuperado_credito'],2);
                }
             
            }else{
                if($pageName == 'Recuperacion'){
                    $json[$i]['RECU_CREDITO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="0.00" id ="recu_credito_'.$key['ruta'].'">';
                 }else{
                    $json[$i]['RECU_CREDITO'] =  "C$0.00" ;
                 }
                 
            }
            if ($key['recuperado_contado']>0) {
                if($pageName == 'Recuperacion'){
                    $json[$i]['RECU_CONTADO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="'.$key['recuperado_contado'].'" id ="recu_contado_'.$key['ruta'].'">';
                  }else{
                    $json[$i]['RECU_CONTADO'] =  'C$'. number_format($key['recuperado_contado'],2);
                  }
                
            }else{
                 if($pageName == 'Recuperacion'){
                    $json[$i]['RECU_CONTADO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="0.00" id ="recu_contado_'.$key['ruta'].'">';
                 }else{
                    $json[$i]['RECU_CONTADO'] =  "C$0.00";

                 }
                
            }

            $json[$i]['RECU_TOTAL'] =  ($key['recuperado_credito'] == 0 && $key['recuperado_contado'] == 0) ? '<span id="recu_total_'.$key['ruta'].'">C$0.00</span>' : '<span id="recu_total_'.$key['ruta'].'">C$'.number_format($key['recuperado_credito'] + $key['recuperado_contado']).'</span>';
            $json[$i]['RECU_CUMPLIMIENTO'] =  ($meta=='0.00') ? '<span id="recu_cumplimiento_'.$key['ruta'].'">0.00%</span>' : '<span id="recu_cumplimiento_'.$key['ruta'].'">'.number_format(((floatval($key['recuperado_credito']) /*+ floatval($key['recuperado_contado'])*/)/floatval($meta)*100),2).'%</span>';
            //$json[$i]['RECU_OPCIONES'] =  '<a href="#" class="btn btn-primary btn-sm active" role="button" aria-pressed="true"><span class="fa fa-pencil">Eliminar</span></a>';

            $i++;
        }

        return  $json;
    }

    public function actualizarMetaRecup(Request $request){

         $data = array();
        $data = $request->all();
        

        if (isset($data['data'])) {
        
            $company_id = Company::where('id',$request->session()->get('company_id'))->first()->id;
            foreach($data['data'] as $key) {
                Umk_recuperacion::where(['idCompanny' => $company_id, 'ruta'=> $key['ruta'], 'fecha_recup' => $key['fecha']])->update(array('recuperado_credito' => $key['Recu_credito'],'recuperado_contado' => $key['Recu_contado']));
            }
            return 1;
            
        }else{

            return 0;
        }

    }


    public function agregarMetaRecup(Request $request){




        $data = array();
        $data = $request->all();
        $respuesta = 0;
        $company_id = Company::where('id',$request->session()->get('company_id'))->first()->id;

       /* if (isset($data['no_filtered']) && isset($data['filtered'])) {
            $cantFiltered = count($data['filtered']);
            $cantNoFiltered = count($data['no_filtered']);
            $cont = $cantFiltered + $cantNoFiltered;
            $j= 0;
            

            for ($i=0; $i < $cont; $i++) { 

                while($i < $cantFiltered){
                    
                    $input = ['ruta'=> $data['filtered'][$i]['ruta'], 'vendedor'=> $data['filtered'][$i]['vendedor'], 'fecha_recup' => $data['filtered'][$i]['fecha'], 'idCompanny' => $company_id, 'recuperado_contado' => $data['filtered'][$i]['Recu_contado'],'recuperado_credito'=> $data['filtered'][$i]['Recu_credito']];
                    Umk_recuperacion::insert($input);
                }

                while($i >=  $cantFiltered && $i < $cont){
                    
                   $input = ['ruta'=> $data['no_filtered'][$j]['ruta'], 'vendedor'=> $data['no_filtered'][$j]['vendedor'], 'fecha_recup' => $data['no_filtered'][$j]['fecha'], 'idCompanny' => $company_id];
                Umk_recuperacion::insert($input);
                $j++;
                }


            }


            $respuesta =  1;
            
            
        }else  if (isset($data['no_filtered']) && !isset($data['filtered'])) {

             foreach($data['filtered'] as $key) {
                $input = ['ruta'=> $key['ruta'], 'vendedor'=> $key['vendedor'], 'fecha_recup' => $key['fecha'], 'idCompanny' => $company_id, 'recuperado_contado' => $key['Recu_contado'],'recuperado_credito'=> $key['Recu_credito']];
                Umk_recuperacion::insert($input);
        
            }
            $respuesta =  1;      

        }else{
            $respuesta =  0;  
        }*/


        if (isset($data['filtered'])) {

            $company_id = Company::where('id',$request->session()->get('company_id'))->first()->id;

            foreach($data['filtered'] as $key) {
                $input = ['ruta'=> $key['ruta'], 'vendedor'=> $key['vendedor'], 'fecha_recup' => $key['fecha'], 'idCompanny' => $company_id, 'recuperado_contado' => $key['Recu_contado'],'recuperado_credito'=> $key['Recu_credito']];
                Umk_recuperacion::insert($input);
        
            }
            return 1;
            
        }else{

            return 0;
        }
        return $respuesta;

    }




    public function obtenerRutasRecu($mes, $anio, request $request){

        $otroTipoVende = "'F01','F12','F16','F18','F19'";
        $fecha =  date('Y-m-d', strtotime($anio.'-'.$mes.'-01'));
        $sql_server = new \sql_server();
        
        $company_id = Company::where('id',$request->session()->get('company_id'))->first()->id;

        $sql_view = '';
        //leer las rutas y nombre de vendedores de la compañia seleccionada
        switch($company_id){
            case '1':
                $sql_view = 'SELECT VENDEDOR, NOMBRE FROM UMK_VENDEDORES_ACTIVO WHERE VENDEDOR NOT IN ('.$otroTipoVende.')';
            break;
            case '2':
                $sql_view = 'SELECT * FROM GP_VENDEDORES_ACTIVOS WHERE VENDEDOR NOT IN ('.$otroTipoVende.')';
            break;
        }

        $query = $sql_server->fetchArray($sql_view,SQLSRV_FETCH_ASSOC);

        $i = 0;
        $json = array();
        $meta = array();

        
        foreach ($query as $fila) {
            $meta = meta_recuperacion_exl::where(['fechaMeta'=>$fecha, 'idCompanny'=> $request->session()->get('company_id'), 'ruta' => $fila["VENDEDOR"]])->pluck('meta');
           
             $meta =  str_replace(['[',']'],'',$meta);


                if ($meta == "") {
                    $meta = '0.00';
                }else{ 
                    $meta = $meta;

                } 
              
            $json[$i]["RECU_RUTA"]          = $fila["VENDEDOR"];
            $json[$i]["RECU_VENDE"]         = $fila["NOMBRE"];
            $json[$i]["RECU_META"]          =  '<span id ="recu_meta_'.$fila['VENDEDOR'].'">C$'.number_format($meta,2).'</span>';
            $json[$i]["RECU_CONTADO"]       = '<input type="text" onkeyup="getAttr(this)" class="form-control" value="0.00" id ="recu_contado_'.$fila['VENDEDOR'].'">';
            $json[$i]["RECU_CREDITO"]       = '<input type="text" onkeyup="getAttr(this)" class="form-control" value="0.00" id ="recu_credito_'.$fila['VENDEDOR'].'">';
            $json[$i]["RECU_TOTAL"]         = '<span id="recu_total_'.$fila['VENDEDOR'].'">C$0.00</span>';
            $json[$i]["RECU_CUMPLIMIENTO"]  = '<span id="recu_cumplimiento_'.$fila['VENDEDOR'].'">0.00%</span>';
            $i++;
        }

        $sql_server->close();
        return $json;
        

    }

   
}