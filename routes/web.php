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

Route::get('/Dashboard','dashboard_controller@index');

Route::get('/Inventario','inventario_controller@getArticulos');

Route::get('/Metas','metas_controller@index');

Route::get('/Usuario','usuario_controller@index');

Route::get('/Reportes','reportes_controller@index');


