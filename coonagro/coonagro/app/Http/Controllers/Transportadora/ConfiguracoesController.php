<?php


namespace App\Http\Controllers\transportadora;


use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Transportadora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:transportadora');
    }

    public function opcoes(){
        return view('transportadora.configuracoes');
    }

    public function alterarDados(Request $request) {
        $alteracoes = $request->all();
        $transportadora = Auth::user();

        if(isset($alteracoes['email'])) {
            $transportadora->EMAIL = $alteracoes['email'];
            $transportadora->save(); 
        }

        if(isset($alteracoes['senha'])) {
            $transportadora->SENHA = $alteracoes['senha'];
            $transportadora->save();
        }

        return redirect(route('transportadora.home'));
    }
}