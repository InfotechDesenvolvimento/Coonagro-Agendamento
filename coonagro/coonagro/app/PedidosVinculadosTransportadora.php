<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidosVinculadosTransportadora extends Model{

    protected $table = 'pedidos_vinculados_transportadora';
    protected $primaryKey = "CODIGO";
    public $timestamps = false;
    
}
