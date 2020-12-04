<?php


namespace App\Http\Controllers\cliente;


use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function opcoes(){
        return view('cliente.configuracoes');
    }

    public function alterarDados(Request $request) {
        $alteracoes = $request->all();
        $cliente = Auth::user();

        if(isset($alteracoes['email'])) {
            $cliente->EMAIL = $alteracoes['email'];
            $cliente->save(); 
        }

        if(isset($alteracoes['senha'])) {
            $cliente->SENHA = $alteracoes['senha'];
            $cliente->save();
        }

        return redirect(route('cliente.home'));
    }
}