<?php


namespace App\Http\Controllers;


use App\Codigos;
use App\Motorista;

class MotoristaController extends Controller
{
    public function show($identificacao){
        return response()->json(Motorista::where('CPF_CNPJ', $identificacao)->first());
    }

    public function insert(Motorista $motorista){
        $codigos = Codigos::find(273);

        $motorista->CODIGO = $codigos->CODIGO_PRIMARIO;

        $codigos->CODIGO_PRIMARIO = $codigos->CODIGO_PRIMARIO + 1;
        $codigos->save();

        $motorista->DATA_CADASTRO = date("Y/m/d");
        $motorista->DATA_ALTERACAO = date("Y/m/d");;

        $motorista->save();

        return $motorista;
    }
}
