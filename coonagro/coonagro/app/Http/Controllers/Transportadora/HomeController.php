<?php

namespace App\Http\Controllers\Transportadora;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:transportadora');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();
        $cod_transportadora = Auth::user()->getAuthIdentifier();
        $produtos = DB::select('SELECT produtos.DESCRICAO, produtos.CODIGO FROM agendamentos, produtos WHERE agendamentos.COD_PRODUTO = produtos.CODIGO AND agendamentos.COD_TRANSPORTADORA = '.$cod_transportadora.' GROUP BY produtos.DESCRICAO');

       
        return view('transportadora.home', compact('status','produtos'));
    }

    public function operacao(){
        return view('transportadora.operacao');
    }
}
