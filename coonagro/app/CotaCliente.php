<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotaCliente extends Model
{
    protected $primaryKey = 'CODIGO';
    protected $table = 'cota_cliente';
    public $timestamps = false;
}
