<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use App\TipoVeiculo;

class Veiculo extends Model
{
    protected $primaryKey = 'CODIGO';
    protected $table = 'veiculos';

    public function tipoVeiculo(){
        return $this->hasOne(TipoVeiculo::class, 'CODIGO', 'COD_TIPO_VEICULO');
    }
}
