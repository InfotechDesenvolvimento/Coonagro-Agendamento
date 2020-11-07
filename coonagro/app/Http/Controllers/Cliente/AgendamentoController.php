<?php


namespace App\Http\Controllers\Cliente;


use App\Http\Controllers\Controller;
use App\PedidoTransporte;
use App\TipoEmbalagem;
use App\TipoVeiculo;
use App\Transportadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{

    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index($num_pedido){
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $tipos = TipoVeiculo::orderBy('TIPO_VEICULO')->get();
        $embalagens = TipoEmbalagem::orderBy('TIPO_EMBALAGEM')->get();

        $pedido = PedidoTransporte::where([
                        'COD_CLIENTE' => $cod_cliente,
                        'NUM_PEDIDO' => $num_pedido
                      ])->with('produto')->first();

        return view('cliente.agendamento', compact(['pedido', 'tipos', 'embalagens']));
    }

    public function validarDados(Request $request){
        echo "hello";
    }
}
