<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoTransporte extends Model{

    protected $table = 'pedido_transporte';
    protected $primaryKey = "CODIGO";

    //'fk de categoria', 'pk de categoria')

    public function produto(){
        return $this->hasOne(Produto::class, 'CODIGO', 'COD_PRODUTO');
    }
}
