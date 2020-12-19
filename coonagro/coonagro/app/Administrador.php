<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrador extends Authenticatable
{
    public $timestamps = false;
    
    protected $fillable = ['NOME', 'SENHA'];
    protected $hidden = ['SENHA', 'remember_token'];

    protected $primaryKey = 'CODIGO';
    protected $table = 'usuarios';
}
