<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoTransporte extends Model{

    protected $table = 'pedido_transporte';
    protected $primaryKey = "CODIGO";
    public $timestamps = false;

    public function produto(){
        return $this->hasOne(Produto::class, 'CODIGO', 'COD_PRODUTO');
    }

    public function vinculado() {
        return $this->hasOne(PedidosVinculadosTransportadora::class, 'NUM_PEDIDO', 'NUM_PEDIDO');
    }
}
