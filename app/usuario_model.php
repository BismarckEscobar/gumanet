<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class usuario_model extends Model
{
    public static function getUsuario() {
    	$data;
    	$i = 0;
        $usuario =  DB::table('users')->get();
        foreach ($usuario as $key) {
        	if ($key->estado == 0){
        		$data[$i]["estado"] = "Activo";
			}else{
				$data[$i]["estado"] = "Inactivo";
	        }
    		$data[$i]["name"] = $key->name." ".$key->surname;
    		$data[$i]["email"] = $key->email;
    		$data[$i]["role"] = $key->role;
    		$data[$i]["company"] = $key->company;
    		$data[$i]["description"] = $key->description;
    		$data[$i]["created_at"] = $key->created_at;
    		$i++;
    	}
        
        return $data;
    }
    
}
