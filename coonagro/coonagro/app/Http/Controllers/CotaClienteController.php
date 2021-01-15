<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\CotaCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CotaClienteController extends Controller
{
    public function show($cod_cliente, $data){

        $cota = CotaCliente::where(
            [
                'COD_CLIENTE' => $cod_cliente,
                'DATA' => $data
            ])->first();

        if($cota == null){
            $cliente = Cliente::find($cod_cliente);
            if($cliente){
                $cota = new CotaCliente();

                $cota->COD_CLIENTE = $cliente->CODIGO;
                $cota->DATA = $data;
                $cota->COTA_DIARIA = $cliente->COTA_MAXIMA_DIARIA;
                $cota->TOTAL_AGENDADO = 0;
                $cota->TOTAL_MOVIMENTADO = 0;
                $cota->SALDO_LIVRE = $cliente->COTA_MAXIMA_DIARIA;
                $cota->PERCENTUAL_LIVRE = 100;
                $cota->PERCENTUAL_MOVIMENTADO = 0;

                $cota->save();
            }
        }

        return response()->json($cota);
    }

    public function update($cod_cliente, $data, $quantidade){

        $cota = CotaCliente::where([
                'DATA' => $data,
                'COD_CLIENTE' => $cod_cliente
            ])->first();

        if($cota != null){
            $cota->TOTAL_AGENDADO = $cota->TOTAL_AGENDADO + $quantidade;

            $cota->save();
        }
    }
}
