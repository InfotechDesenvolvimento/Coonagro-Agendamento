<?php


namespace App\Http\Controllers\Administrador;


use App\Mail\EnviaEmail;
use Mail;
use App\Agendamento;
use App\AgendamentoAlteracao;
use App\Codigos;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CotaClienteController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\PedidoTransporteController;
use App\Http\Controllers\TransportadoraController;
use App\Http\Controllers\VeiculoController;
use App\PedidosVinculadosTransportadora;
use App\Motorista;
use App\Produto;
use App\PedidoTransporte;
use App\TipoEmbalagem;
use App\TipoVeiculo;
use App\Transportadora;
use App\Veiculo;
use App\Cliente;
use App\CotaCliente;
use App\NotaFiscal;
use App\SituacaoPedidoTransporte;
use App\TipoOperacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PedidoController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $clientes = Cliente::get();
        $produtos = Produto::get();
        $situacao_pedido = SituacaoPedidoTransporte::get();
        $tipo_operacao = TipoOperacao::get();

        return view('administrador.novo_pedido', compact(['clientes', 'produtos', 'situacao_pedido', 'tipo_operacao']));
    }

    public function registrarPedido(Request $request) {
        $p = PedidoTransporte::where('NUM_PEDIDO', $request->get('num_pedido'))->get();
        if($p != null) {
            $pedido = new PedidoTransporte();
            $pedido->NUM_PEDIDO = $request->get('num_pedido');
            $pedido->COD_STATUS = $request->get('status');
            $pedido->COD_CLIENTE = $request->get('cliente');
            $pedido->COD_PRODUTO = $request->get('produto');
            $pedido->COD_TIPO_OPERACAO = $request->get('tipo_operacao');
            $pedido->TOTAL = $request->get('total_pedido');
            $pedido->SALDO_MOVIMENTADO = $request->get('saldo_movimentado');
            $pedido->SALDO_RESTANTE = $request->get('saldo_restante');
            $pedido->TOTAL_AGENDADO = $request->get('total_agendado');
            $pedido->DATA_CADASTRO = date('Y-m-d');
            if($request->get('obs') != '') {
                $pedido->OBS = $request->get('obs');
            }
            if($pedido->save()) {
                $msg = 'Pedido cadastrado com sucesso!';
                return redirect()->route('administrador.pedidos')->with('msg', $msg);
            } else {
                $msg = 'Erro ao cadastrar pedido!';
                return redirect()->route('administrador.pedidos')->with('msg', $msg);
            }
        } else {
            $msg = 'Erro ao cadastrar pedido!';
            return redirect()->route('administrador.pedidos')->with('msg', $msg);
        }

    }

}
