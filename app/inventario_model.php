<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventario_model extends Model{
    public static function getArticulos(){
        $sql_server = new \sql_server();
        $query = $sql_server->fetchArray("SELECT TOP 30 * FROM iweb_articulos ",SQLSRV_FETCH_ASSOC);
        $sql_server->close();
        return $query;
    }
}
