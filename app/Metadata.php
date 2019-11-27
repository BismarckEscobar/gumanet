<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
	protected $table = 'meta_datas';
    protected $connection = 'sqlsrv';
    protected $dateFormat = 'Y-m-d H:i:s';
}
