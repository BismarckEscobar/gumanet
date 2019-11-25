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

//RUTAS MENU
Route::get('/Inventario','inventario_controller@index');
Route::get('/Metas','metas_controller@index');
Route::get('/Usuario','usuario_controller@index');
Route::get('/Reportes','reportes_controller@index'); 


//RUTAS LOGIN
Route::get('/','Auth\LoginController@showLoginForm');//pagina login
Auth::routes();//dentro de la funcion routes() se encunetran todas las rutas para login del Auth "Vendor/laravel/src/illuminate/routing/router.php"
Route::get('/Dashboard','dashboard_controller@index')->name('Dashboard');
Route::get('/getCompanies','Auth\LoginController@getCompanies');
//Route::get('password/reset/{token}', 'resetPassword_Controller@index')->name('pass.reset','{token}');

//RUTA RESET PASS
Route::get('/formReset','resetPass_controller@index')->name('formReset');
Route::post('/resetPass','resetPass_controller@resetPass')->name('resetPass');


//RUTAS USUARIO
Route::get('/usuarios','usuario_controller@getUsuario');
Route::get('/usuario/{id}/companies','usuario_controller@getCompaniesByUserId');
Route::get('/company/{id}/usuarios','usuario_controller@getUsersByCompanyId');
Route::post('/editUser','usuario_controller@editUser');
Route::post('/deleteUser','usuario_controller@deleteUser');
Route::post('/changeUserStatus','usuario_controller@changeUserStatus');
Route::get('/role','usuario_controller@getRole');

//RUTAS INVENTARIO
Route::get('/articulos','inventario_controller@getArticulos');
Route::get('/objBodega/{articulo}','inventario_controller@getBodegaInventario');
Route::get('/objPrecios/{articulo}','inventario_controller@getPreciosArticulos');
Route::get('/objBonificado/{articulo}','inventario_controller@getArtBonificados');
Route::post('/transacciones','inventario_controller@transaccionesDetalle');
Route::post('/lotes','inventario_controller@getLotesArticulo');

//RUTAS METAS
Route::post('/meta_exp','metas_controller@exportMetaFromExl');
Route::get('/get_tmp_exl_data','metas_controller@getExlFromTmpTable');
Route::get('/add_data_meta','metas_controller@add_data_meta');
Route::post('/calc_and_add_unidad_meta','metas_controller@calcAddUnidadMeta');
Route::get('/truncate_tmp_exl_tbl','metas_controller@truncate_tmp_exl_tbl');
Route::post('/get_historial_meta','metas_controller@getHistorialMeta');

//RUTAS DETALLE DE VENTAS
Route::get('/detalles/{tipo}/{mes}/{anio}','dashboard_controller@getDetalleVentas');

//RUTAS GRAFICAS DASHBOARDS
Route::get('/dataGraf/{mes}/{anio}','dashboard_controller@getDataGraficas');
Route::get('/top10Cls','dashboard_controller@getTop10Clientes');
Route::get('/valBodegas','dashboard_controller@getValBodegas');

//RUTAS REPORTES VENTAS
Route::post('/ventasDetalle','reportes_controller@detalleVentas');



