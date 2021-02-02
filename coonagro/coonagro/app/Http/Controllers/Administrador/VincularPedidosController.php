<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\PedidosVinculadosTransportadora;
use App\PedidoTransporte;
use App\StatusAgendamento;
use App\Pedidos;
use App\Produto;
use App\Transportadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class VincularPedidosController extends Controller{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $pedidos = PedidoTransporte::where('COD_STATUS', 1)->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('cliente')->with('produto')->get();
        return view('administrador.vincular_pedidos', compact('pedidos'));
    }

    public function filtrarPedidosVincular(Request $request) {
        $pedidos = PedidoTransporte::where('COD_STATUS', 1)->when($request->get('num_pedido') != "", function ($query) use ($request) {
            $query->where('NUM_PEDIDO', $request->get('num_pedido'));
        })->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('cliente')->with('produto')->get();
        return view('administrador.vincular_pedidos', compact('pedidos'));
    }

    public function vincularPedido($num_pedido) {
        $pedido = PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->with('produto')->with('cliente')->first();

        return view('administrador.vincular_pedido_transportadora', compact('pedido'));
    }

    public function vincularPedidoComum($num_pedido) {
        $pedido = PedidoTransporte::where('NUM_PEDIDO', $num_pedido)->with('produto')->with('cliente')->first();

        return view('administrador.vincular_pedido_transportadora_comum', compact('pedido'));
    }

    public function vincular() {
        $pedido = PedidoTransporte::where('NUM_PEDIDO', $_POST['num_pedido'])->first();
        $cod_cliente = $pedido->COD_CLIENTE;

        $num_cotas = $_POST['numCota'];

        $pedido_vinculado = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
                                ->where('COD_TRANSPORTADORA', $_POST['cod_transportadora'])
                                ->where('NUM_PEDIDO', $_POST['num_pedido'])->get();

        
        $pedidos = PedidoTransporte::where('COD_STATUS', 1)
                            ->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('produto')->get();

        if($pedido_vinculado->isEmpty()) {
            if($num_cotas > 0) {
                for($i = 0; $i<$num_cotas; $i++) {
                    if(isset($_POST['data_'.$i]) && isset($_POST['quantidade_'.$i])) {
                        $pedido_vinculado = new PedidosVinculadosTransportadora();
                        $pedido_vinculado->DATA = $_POST['data_'.$i];
                        $pedido_vinculado->COTA = $_POST['quantidade_'.$i];
                        $pedido_vinculado->COD_CLIENTE = $cod_cliente;
                        $pedido_vinculado->COD_TRANSPORTADORA = $_POST['cod_transportadora'];
                        $pedido_vinculado->NUM_PEDIDO = $_POST['num_pedido'];
                        $pedido_vinculado->COD_PRODUTO = $_POST['cod_produto'];
                        $pedido_vinculado->save();
                    }
                }
            }

            $msg = "A transportadora foi vinculada ao pedido com sucesso.";
            return view('administrador.vincular_pedidos', compact(['msg', 'pedidos']));
        } else {
            $msg = "A transportadora já está vinculada à este pedido.";
            return view('administrador.vincular_pedidos', compact(['msg', 'pedidos']));
        }
    }

    public function vincularComum() {
        $pedido = PedidoTransporte::where('NUM_PEDIDO', $_POST['num_pedido'])->first();
        $cod_cliente = $pedido->COD_CLIENTE;

        $pedido_vinculado = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
                                ->where('COD_TRANSPORTADORA', $_POST['cod_transportadora'])
                                ->where('NUM_PEDIDO', $_POST['num_pedido'])
                                ->where('COTA', null)->where('DATA', null)->get();

        $pedidos = PedidoTransporte::where('COD_STATUS', 1)
                            ->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('produto')->get();

        if($pedido_vinculado->isEmpty()) {
            $pedido_vinculado = new PedidosVinculadosTransportadora();
            $pedido_vinculado->COD_CLIENTE = $cod_cliente;
            $pedido_vinculado->COD_TRANSPORTADORA = $_POST['cod_transportadora'];
            $pedido_vinculado->NUM_PEDIDO = $_POST['num_pedido'];
            $pedido_vinculado->COD_PRODUTO = $_POST['cod_produto'];
            $pedido_vinculado->save();
            
            $msg = "A transportadora foi vinculada ao pedido com sucesso.";
            return view('administrador.vincular_pedidos', compact(['msg', 'pedidos']));
        } else {
            $msg = "A transportadora já está vinculada à este pedido.";
            return view('administrador.vincular_pedidos', compact(['msg', 'pedidos']));
        }
    }

    public function visualizarPedidosVinculados() {
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $pedidos = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
                                ->with('transportadora')->with('pedido_transporte')->with('produto')->with('cliente')->get();

        $produtos = DB::select('SELECT produtos.DESCRICAO, produtos.CODIGO FROM agendamentos, produtos WHERE agendamentos.COD_PRODUTO = produtos.CODIGO AND agendamentos.COD_CLIENTE = '.$cod_cliente.' GROUP BY produtos.DESCRICAO');
        $transportadoras = DB::select('SELECT transportadoras.NOME, transportadoras.CODIGO FROM agendamentos, transportadoras WHERE agendamentos.COD_TRANSPORTADORA = transportadoras.CODIGO AND agendamentos.COD_CLIENTE = '.$cod_cliente.' GROUP BY transportadoras.NOME');

        return view('cliente.visualizar_vinculados', compact('pedidos', 'produtos', 'transportadoras'));
    }

    public function visualizarPedidosVinculadosFiltrar(Request $request) {
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $pedidos = PedidosVinculadosTransportadora::when($request->get('num_pedido') != "", function ($query) use ($request) {
                                                        $query->where('NUM_PEDIDO', $request->get('num_pedido'));
                                                })->when($request->get('produto') != "0", function ($query) use ($request){
                                                        $query->where('COD_PRODUTO', $request->get('produto'));
                                                })->when($request->get('data') != "", function ($query) use ($request){
                                                        $query->where('DATA', $request->get('data'));
                                                })->when($request->get('transportadora') != "0", function ($query) use ($request){
                                                        $query->where('COD_TRANSPORTADORA', $request->get('transportadora'));
                                                })->where('COD_CLIENTE', $cod_cliente)->with('transportadora')->with('produto')->orderBy('CODIGO')->get();

        $produtos = DB::select('SELECT produtos.DESCRICAO, produtos.CODIGO FROM agendamentos, produtos WHERE agendamentos.COD_PRODUTO = produtos.CODIGO AND agendamentos.COD_CLIENTE = '.$cod_cliente.' GROUP BY produtos.DESCRICAO');
        $transportadoras = DB::select('SELECT transportadoras.NOME, transportadoras.CODIGO FROM agendamentos, transportadoras WHERE agendamentos.COD_TRANSPORTADORA = transportadoras.CODIGO AND agendamentos.COD_CLIENTE = '.$cod_cliente.' GROUP BY transportadoras.NOME');

        return view('cliente.visualizar_vinculados', compact('pedidos', 'produtos', 'transportadoras'));
    }

    public function desvincular($cod_pedido) {
        $vinculo = PedidosVinculadosTransportadora::find($cod_pedido);

        if($vinculo != null) {
            $vinculo->delete();
            $msg = "Vínculo removido!";
        } else {
            $msg = "Vínculo não encontrado!";
        }

        $cod_cliente = Auth::user()->getAuthIdentifier();

        $pedidos = PedidosVinculadosTransportadora::where('COD_CLIENTE', $cod_cliente)
                                ->with('transportadora')->with('pedido_transporte')->with('produto')->with('cliente')->get();

        return redirect()->route('cliente.pedidos_vinculados', compact('pedidos', 'msg'));
    }

    public function editar($cod_pedido) {
        $cod_cliente = Auth::user()->getAuthIdentifier();
        $vinculo = PedidosVinculadosTransportadora::find($cod_pedido);
        $transportadora = Transportadora::find($vinculo->COD_TRANSPORTADORA);

        $pedido = PedidoTransporte::where([
            'COD_CLIENTE' => $cod_cliente,
            'NUM_PEDIDO' => $vinculo->NUM_PEDIDO
          ])->with('produto')->first();

        return view('cliente.editar_vinculo', compact('pedido', 'vinculo', 'transportadora'));
    }

    public function salvarVinculo($cod_pedido) {
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $pedido_vinculado = PedidosVinculadosTransportadora::find($cod_pedido);
        $pedido_vinculado->COTA = $_POST['quantidade'];
        $pedido_vinculado->save();

        $cod_cliente = Auth::user()->getAuthIdentifier();
        $vinculo = PedidosVinculadosTransportadora::find($cod_pedido);
        $transportadora = Transportadora::find($vinculo->COD_TRANSPORTADORA);

        $pedido = PedidoTransporte::where([
            'COD_CLIENTE' => $cod_cliente,
            'NUM_PEDIDO' => $vinculo->NUM_PEDIDO
          ])->with('produto')->first();
        
        $msg = 'Vinculo atualizado!';
        return view('cliente.editar_vinculo', compact('pedido', 'vinculo', 'transportadora', 'msg'));
    }
}
