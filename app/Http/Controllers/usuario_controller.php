<?php

namespace App\Http\Controllers;

use App\usuario_model;
use App\Models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


//Modelos
use App\User;
use App\Role;
use App\Company;


class usuario_controller extends Controller
{

	public function __construct()
	 {
	    $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
	 }


    function index(){
        $users = User::all();
        $roles = Role::all();
        $companies = Company::all();
        $data = [
            'page' => 'Usuarios',
            'name' =>  'GUMA@NET'
        ];
        
        return view('pages.usuarios',compact('data','users','roles','companies'));
    }



    public function getCompaniesByUserId($User_id){
        $user = User::find($User_id);
           return $user->companies;
    }


    public function getUsersByCompanyId($Company_id){
         $company = Company::find($Company_id);
           return $company->users;
    }
   

    public function editUser(Request $request){


        $company = array_map('intval',explode(',', $data['company_values']));
        $user = User::find($request->id);
        $user->create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'role' => $data['role'],
            'description' => $data['description'],
        ]);

         $user->companies()->attach($company,['created_at' => new \DateTime(),'updated_at' => new \DateTime()]);
        return $user;

    }
    

}
