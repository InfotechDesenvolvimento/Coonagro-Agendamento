<?php


namespace App\Http\Controllers\administrador;


use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function opcoes(){
        return view('administrador.configuracoes');
    }

    public function alterarDados(Request $request) {
        $alteracoes = $request->all();
        $admin = Auth::user();

        if(isset($alteracoes['senha'])) {
            $admin->SENHA = $alteracoes['senha'];
            $admin->save();
        }

        return redirect(route('administrador.home'));
    }
}