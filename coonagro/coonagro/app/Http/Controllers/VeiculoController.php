<?php


namespace App\Http\Controllers;

use App\Codigos;
use App\Veiculo;

class VeiculoController extends Controller
{
    public function getVeiculo($placa){
        return response()->json(Veiculo::where('PLACA', $placa)->
                with('tipoVeiculo')->first());
    }

    public function insert(Veiculo $veiculo){
        $codigos = Codigos::find(77);

        $veiculo->CODIGO = $codigos->CODIGO_PRIMARIO;

        $codigos->CODIGO_PRIMARIO = $codigos->CODIGO_PRIMARIO + 1;
        $codigos->save();

        $veiculo->DATA_CRIACAO = date("Y/m/d");
        $veiculo->DATA_ALTERACAO = date("Y/m/d");

        $veiculo->save();

        return $veiculo;
    }
}
