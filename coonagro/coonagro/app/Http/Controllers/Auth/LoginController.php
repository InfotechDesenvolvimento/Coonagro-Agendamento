<?php

namespace App\Http\Controllers\Auth;

use App\Cliente;
use App\Administrador;
use App\Transportadora;
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

        if($tipo_acesso == "cliente"){
            $user = Cliente::where('USUARIO', $usuario)
                ->where('SENHA', $senha)
                ->first();
        } else if($tipo_acesso == "transportadora"){
            $user = Transportadora::where('USUARIO', $usuario)
                ->where('SENHA', $senha)
                ->first();
        } else if($tipo_acesso == "administrador") {
            $user = Administrador::where('USUARIO', $usuario)
                ->where('SENHA', $senha)
                ->first();
        }

        if($user != null){
            Auth::guard($tipo_acesso)->login($user);
            
            switch($tipo_acesso):
                case('cliente'):
                    return redirect()->route('cliente.home');
                case('transporadora'):
                    return redirect()->route('transportadora.home');
                case('administrador'):
                    return redirect()->route('administrador.home');
            
            endswitch;
        } else {
            return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
