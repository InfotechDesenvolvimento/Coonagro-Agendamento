<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();
        $cod_cliente = Auth::user()->getAuthIdentifier();
        $produtos = DB::select('SELECT produtos.DESCRICAO, produtos.CODIGO FROM agendamentos, produtos WHERE agendamentos.COD_PRODUTO = produtos.CODIGO AND agendamentos.COD_CLIENTE = '.$cod_cliente.' GROUP BY produtos.DESCRICAO');

        return view('cliente.home', compact('status', 'produtos'));
    }

    public function operacao(){
        return view('cliente.operacao');
    }
}
