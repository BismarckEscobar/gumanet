<?php
Route::get('/','login_controller@index');

Route::get('/Dashboard','dashboard_controller@index');

Route::get('/Inventario','inventario_controller@index');

Route::get('/Metas','metas_controller@index');

Route::get('/Usuario','usuario_controller@index');

Route::get('/Reportes','reportes_controller@index'); 

//RUTAS INVENTARIO
Route::get('/articulos','inventario_controller@getArticulos');
Route::get('/objBodega/{articulo}','inventario_controller@getBodegaInventario');
Route::get('/objPrecios/{articulo}','inventario_controller@getPreciosArticulos');
Route::get('/objBonificado/{articulo}','inventario_controller@getArtBonificados');
Route::post('/transacciones','inventario_controller@transaccionesDetalle');
Route::post('/lotes','inventario_controller@getLotesArticulo');

//RUTAS DETALLE DE VENTAS
Route::get('/detalles/{tipo}','dashboard_controller@getDetalleVentas');




