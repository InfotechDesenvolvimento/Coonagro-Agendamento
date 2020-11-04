<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model{

  protected $table = 'produtos';
  protected $primaryKey = 'CODIGO';

  public function pedidos(){
      return $this->belongsToMany(PedidoTransporte::class);
  }

}
