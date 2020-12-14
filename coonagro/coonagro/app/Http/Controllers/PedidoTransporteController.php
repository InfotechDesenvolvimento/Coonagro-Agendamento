<?php

namespace App\Http\Controllers;

use App\PedidoTransporte;
use App\PedidosVinculadosTransportadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PedidoTransporteController extends Controller
{
    public function update($num_pedido, $quantidade){

        $pedido = PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->first();

        if($pedido != null){
            $pedido->TOTAL_AGENDADO = $pedido->TOTAL_AGENDADO + $quantidade;

            $pedido->save();
        }
    }

    public function getPedido($num_pedido, $cod_transportadora){
        $pedido = PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->first();

        if($pedido != null) {
            $cod_cliente = $pedido->COD_CLIENTE;

            $pedido_vinculado = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
            ->where('COD_TRANSPORTADORA', $cod_transportadora)
            ->where('NUM_PEDIDO', $num_pedido)->get();

            if($pedido_vinculado->isNotEmpty()) {
                return response()->json(PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->first());
            }
            else {
                return response()->json(null);
            }
        } else {
            return response()->json(null);
        }
    }

    public function getLimite($num_pedido, $cod_transportadora, $data) {
        $pedido = PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->first();

        if($pedido != null) {
            $cod_cliente = $pedido->COD_CLIENTE;

            $pedido_vinculado = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
            ->where('COD_TRANSPORTADORA', $cod_transportadora)
            ->where('NUM_PEDIDO', $num_pedido)
            ->where('DATA', $data)->first();

            if($pedido_vinculado != null) {
                return response()->json($pedido_vinculado);
            }
            else {
                return response()->json(null);
            }
        } else {
            return response()->json(null);
        }
    }

    public function getObjPedido($num_pedido) {
        return PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->first();
    }
}
