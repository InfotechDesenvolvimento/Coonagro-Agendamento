<?php


namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Transportadora extends Authenticatable {

    protected $fillable = ['USUARIO', 'SENHA'];
    protected $hidden = ['SENHA', 'remember_token'];

    protected $primaryKey = 'CODIGO';
    protected $table = 'transportadoras';
}
