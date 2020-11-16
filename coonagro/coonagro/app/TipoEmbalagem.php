<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class TipoEmbalagem extends Model
{
    protected $primaryKey = 'CODIGO';
    protected $table = 'tipo_embalagem';
}
