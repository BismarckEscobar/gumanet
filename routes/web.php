<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $sql_server = new \sql_server();

    $data = [
        'name' =>  'GUMA@NET',
        'rArticulos' => $sql_server->fetchArray("SELECT TOP 10 * FROM iweb_articulos ",SQLSRV_FETCH_ASSOC)
    ];
    return view('welcome',$data);

});

