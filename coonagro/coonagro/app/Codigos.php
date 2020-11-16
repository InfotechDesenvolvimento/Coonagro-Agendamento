<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigos extends Model
{
    protected $primaryKey = 'CODIGO';
    protected $table = "codigos";
    public $timestamps = false;
}
