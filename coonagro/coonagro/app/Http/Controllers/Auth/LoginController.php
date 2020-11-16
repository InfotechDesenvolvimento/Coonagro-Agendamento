<?php

namespace App\Http\Controllers\Auth;

use App\Cliente;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $usuario = strtoupper($request->get('usuario'));
        $senha = strtoupper($request->get('senha'));
        $tipo_acesso = $request->get('tipo_usuario');

        $user = null;

        if($tipo_acesso == "cli"){
            $user = Cliente::where('USUARIO', $usuario)
                ->where('SENHA', $senha)
                ->first();
        }

        if($user != null){
            Auth::guard('cliente')->login($user);

            return redirect()->route('cliente.home');
        } else {
            return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');
        }
    }


}
