<?php


namespace App\Http\Controllers;

use App\Veiculo;

class VeiculoController extends Controller
{
    public function getVeiculo($placa){
        return response()->json(Veiculo::where('PLACA', $placa)->
                with('tipoVeiculo')->first());
    }
}
