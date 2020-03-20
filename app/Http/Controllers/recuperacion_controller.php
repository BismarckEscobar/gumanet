<?php

namespace App\Http\Controllers;

use App;
use App\Models;
use App\User;
use App\Gn_couta_x_producto;
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

    public function getMoneyRecuRowsByRoutes($mes, $anio){
        $request = Request();
        $fecha =  date('Y-m-d', strtotime($anio.'-'.$mes.'-01'));
        $recuperacion = array();
        $json = array();
        $i = 0;
        $recuperacion = meta_recuperacion_exl::where(['fechaMeta'=>$fecha, 'idCompanny'=>$request->session()->get('company_id')])->get();

        foreach ($recuperacion as $key) {
          
            $json[$i]['RECU_RUTA'] =  $key['ruta'];
            $json[$i]['RECU_VENDE'] =  $key['vendedor'];
            $json[$i]['RECU_META'] =  '<span id ="recu_meta_'.$key['ruta'].'">C$'.number_format($key['meta']).'</span>';

            if ($key['recuperado_credito']>0) {
              $json[$i]['RECU_CREDITO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="'.$key['recuperado_credito'].'" id ="recu_credito_'.$key['ruta'].'">';
            }else{
                  $json[$i]['RECU_CREDITO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="0.00" id ="recu_credito_'.$key['ruta'].'">';
            }
            if ($key['recuperado_contado']>0) {
                $json[$i]['RECU_CONTADO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="'.$key['recuperado_contado'].'" id ="recu_contado_'.$key['ruta'].'">';
            }else{
                $json[$i]['RECU_CONTADO'] =  '<input type="text" onkeyup="getAttr(this)" class="form-control" value="0.00" id ="recu_contado_'.$key['ruta'].'">';
            }

            $json[$i]['RECU_TOTAL'] =  ($key['recuperado_credito'] == 0 && $key['recuperado_contado'] == 0) ? '<span id="recu_total_'.$key['ruta'].'">C$0.00</span>' : '<span id="recu_total_'.$key['ruta'].'">C$'.number_format($key['recuperado_credito'] + $key['recuperado_contado']).'</span>';
            $json[$i]['RECU_CUMPLIMIENTO'] =  ($key['meta']==0) ? '<span id="recu_cumplimiento_'.$key['ruta'].'">100.00%</span>' : '<span id="recu_cumplimiento_'.$key['ruta'].'">'.number_format(((floatval($key['recuperado_credito']) + floatval($key['recuperado_contado']))/floatval($key['meta'])*100),2).'%</span>';
            //$json[$i]['RECU_OPCIONES'] =  '<a href="#" class="btn btn-primary btn-sm active" role="button" aria-pressed="true"><span class="fa fa-pencil">Eliminar</span></a>';

            $i++;
        }

        return  $json;
    }

    public function agregatMetaRecup(Request $request){
         $data = array();
        $data = $request->all();
        

        if (isset($data['data'])) {
        
            $company_id = Company::where('id',$request->session()->get('company_id'))->first()->id;
            foreach($data['data'] as $key) {
                meta_recuperacion_exl::where(['idCompanny' => $company_id,'ruta' => $key['ruta']])->update(array('recuperado_credito' => $key['Recu_credito'],'recuperado_contado' => $key['Recu_contado']));
            }
            return 1;
            
        }else{

            return 0;
        }

    }

   
}