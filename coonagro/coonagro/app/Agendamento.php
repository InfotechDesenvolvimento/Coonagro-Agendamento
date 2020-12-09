<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model {
  public $timestamps = false;

  protected $table = 'agendamentos';
  protected $primaryKey = 'CODIGO';

  public function produto(){
      return $this->hasOne(Produto::class, 'CODIGO', 'COD_PRODUTO');
  }

  public function embalagem(){
      return $this->hasOne(TipoEmbalagem::class, 'CODIGO', 'COD_EMBALAGEM');
  }

  public function tipoVeiculo(){
      return $this->hasOne(TipoVeiculo::class, 'CODIGO', 'COD_TIPO_VEICULO');
  }

  public function status(){
      return $this->hasOne(StatusAgendamento::class, 'CODIGO', 'COD_STATUS_AGENDAMENTO');
  }

  public function cliente(){
      return $this->hasOne(Cliente::class, 'CODIGO', 'COD_CLIENTE');
  }
}
