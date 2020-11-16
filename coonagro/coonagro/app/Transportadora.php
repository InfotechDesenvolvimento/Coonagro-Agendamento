<?php


namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Transportadora extends Authenticatable {

    protected $fillable = ['USUARIO', 'SENHA', 'NOME', 'NOME_FANTASIA', 'CPF_CNPJ', 'CODIGO'];
    protected $hidden = ['SENHA', 'remember_token'];

    protected $table = 'transportadoras';
    public $timestamps = false;



}
