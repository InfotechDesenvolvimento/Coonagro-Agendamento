<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use App\TipoVeiculo;

class NotaFiscal extends Model
{
    protected $table = 'nota_fiscal_eletronica';
    public $timestamps = false;

}
