<?php


namespace App\Http\Controllers\Cliente;


use App\Http\Controllers\Controller;
use App\PedidoTransporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarregamentoController extends Controller
{
    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index(){
        $cod_cliente =  Auth::user()->getAuthIdentifier();

        $pedidos = PedidoTransporte::where('COD_CLIENTE', $cod_cliente)
            ->whereRaw('SALDO_RESTANTE - TOTAL_AGENDADO > 0')->orderBy('NUM_PEDIDO')->with('produto')->get();

        return view('cliente.carregamento', compact('pedidos'));
    }

}
