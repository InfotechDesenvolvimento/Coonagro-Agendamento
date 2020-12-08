<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\PedidosVinculadosTransportadora;
use App\PedidoTransporte;
use App\StatusAgendamento;
use App\Pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class VincularPedidosController extends Controller{

    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index(){
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $pedidos = PedidoTransporte::where('COD_CLIENTE', $cod_cliente)->where('COD_STATUS', 1)
            ->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('produto')->get();

        return view('cliente.vincular_pedidos', compact('pedidos'));
    }

    public function vincularPedido($num_pedido) {
        $cod_cliente = $cod_cliente =  Auth::user()->getAuthIdentifier();

        $pedido = PedidoTransporte::where([
            'COD_CLIENTE' => $cod_cliente,
            'NUM_PEDIDO' => $num_pedido
          ])->with('produto')->first();

          return view('cliente.vincular_pedido_transportadora', compact('pedido'));
    }

    public function vincular() {
        $cod_cliente = Auth::user()->getAuthIdentifier();
        
        $pedidos = PedidoTransporte::where('COD_CLIENTE', $cod_cliente)->where('COD_STATUS', 1)
                    ->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('produto')->get();

        $pedido_vinculado = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
                    ->where('COD_TRANSPORTADORA', $_POST['cod_transportadora'])
                    ->where('NUM_PEDIDO', $_POST['num_pedido'])->get();

        if($pedido_vinculado->isEmpty()) {
            $pedido_vinculado = new PedidosVinculadosTransportadora();
            $pedido_vinculado->COD_CLIENTE = $cod_cliente;
            $pedido_vinculado->COD_TRANSPORTADORA = $_POST['cod_transportadora'];
            $pedido_vinculado->NUM_PEDIDO = $_POST['num_pedido'];
            $pedido_vinculado->COD_PRODUTO = $_POST['cod_produto'];
            $pedido_vinculado->save();
            $msg = "A transportadora foi vinculada ao pedido com sucesso.";
            return view('cliente.vincular_pedidos', compact(['msg', 'pedidos']));
        } else {
            $msg = "A transportadora já está vinculada à este pedido.";
            return view('cliente.vincular_pedidos', compact(['msg', 'pedidos']));
        }
    }

    public function visualizarPedidosVinculados() {
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $pedidos = DB::table('pedidos_vinculados_transportadora')
                        ->select('transportadoras.NOME as TRANSPORTADORA', 'produtos.DESCRICAO as PRODUTO', 'pedidos_vinculados_transportadora.NUM_PEDIDO')
                        ->leftJoin('produtos', 'produtos.CODIGO', '=', 'pedidos_vinculados_transportadora.COD_PRODUTO')
                        ->leftJoin('transportadoras', 'transportadoras.CODIGO', '=', 'pedidos_vinculados_transportadora.COD_TRANSPORTADORA')
                        ->where('pedidos_vinculados_transportadora.COD_CLIENTE', $cod_cliente)->groupBy('pedidos_vinculados_transportadora.CODIGO')->get();


        return view('cliente.visualizar_vinculados', compact('pedidos'));
        //return json_encode($pedidos);
    }

}
