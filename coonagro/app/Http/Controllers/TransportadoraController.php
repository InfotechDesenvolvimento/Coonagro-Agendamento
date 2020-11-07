<?php


namespace App\Http\Controllers;


use App\Transportadora;

class TransportadoraController extends Controller
{
    public function getTransportadora($identificacao){

        if(strlen($identificacao) == 11){
            $identificacao = $this->formataCpf($identificacao);
        } else if(strlen($identificacao) == 14){
            $identificacao = $this->formataCnpj($identificacao);
        }

        return response()->json(Transportadora::where('CPF_CNPJ', $identificacao)->first());
    }

    public function formataCpf($identificacao){
        $formatado = substr($identificacao, 0,3) . ".";
        $formatado .= substr($identificacao, 3, 3) . ".";
        $formatado .= substr($identificacao,6, 3) . "-";
        $formatado .= substr($identificacao, 9, 2);
        return  $formatado;
    }

    public function formataCnpj($identificacao){
        $formatado = substr($identificacao, 0, 2) . ".";
        $formatado .= substr($identificacao, 2, 3) . ".";
        $formatado .= substr($identificacao, 5, 3) . "/";
        $formatado .= substr($identificacao, 8, 4) . "-";
        $formatado .= substr($identificacao, 12, 2);
        return $formatado;
    }
}
