<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Produto;
use App\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();
        $produtos = DB::select('SELECT produtos.DESCRICAO, produtos.CODIGO FROM agendamentos, produtos WHERE agendamentos.COD_PRODUTO = produtos.CODIGO GROUP BY produtos.DESCRICAO');
        $clientes = DB::select('SELECT clientes.NOME, clientes.CODIGO FROM agendamentos, clientes WHERE agendamentos.COD_CLIENTE = clientes.CODIGO GROUP BY clientes.NOME');

        return view('administrador.home', compact('status', 'produtos', 'clientes'));
    }

    public function operacao(){
        return view('administrador.operacao');
    }
}
