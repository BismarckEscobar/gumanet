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

//Route::get('/','login_controller@index');



Route::get('/Inventario','inventario_controller@getArticulos');

Route::get('/Metas','metas_controller@index');

Route::get('/Usuario','usuario_controller@index');

Route::get('/Reportes','reportes_controller@index');

Route::get('/','Auth\loginController@showLoginForm')->name('login');//mostrar pagina delogin (login/index)
Route::post('/login','Auth\loginController@login')->name('login');//request
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );



Auth::routes();

Route::get('/Dashboard','dashboard_controller@index')->name('Dashboard');
Route::get('register','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register','Auth\RegisterController@register')->name('register');

Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm');

Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');






