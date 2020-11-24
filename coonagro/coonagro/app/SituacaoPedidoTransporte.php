<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SituacaoPedidoTransporte extends Model{

  protected $table = 'situacao_pedido_transporte';
  protected $primaryKey = 'CODIGO';

  public function getStatus(){
      return SituacaoPedidoTransporte::all();
  }

}
