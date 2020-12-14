<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidosVinculadosTransportadora extends Model{

    protected $table = 'pedidos_vinculados_transportadora';
    protected $primaryKey = "CODIGO";
    public $timestamps = false;
    
    public function pedido_transporte(){
        return $this->hasOne(PedidoTransporte::class, 'NUM_PEDIDO', 'NUM_PEDIDO');
    }

    public function produto() {
        return $this->hasOne(Produto::class, 'CODIGO', 'COD_PRODUTO');
    }

    public function transportadora() {
        return $this->hasOne(Transportadora::class, 'CODIGO', 'COD_TRANSPORTADORA');
    }

    public function cliente() {
        return $this->hasOne(Cliente::class, 'CODIGO', 'COD_CLIENTE');
    }
}
