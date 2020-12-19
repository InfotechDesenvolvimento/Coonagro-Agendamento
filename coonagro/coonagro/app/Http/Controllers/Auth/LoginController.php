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
        } else if($tipo_acesso == "admin") {
            $user = Administrador::where('NOME', $usuario)
                ->where('SENHA', $senha)
                ->first();
        }

        if($user != null){
            
            switch($tipo_acesso):
                case('cliente'):
                    Auth::guard($tipo_acesso)->login($user);
                    return redirect()->route('cliente.home');
                case('transportadora'):
                    Auth::guard($tipo_acesso)->login($user);
                    return redirect()->route('transportadora.home');
                case('admin'):
                    if($user->GESTOR_WEB == 'S') {
                        Auth::guard($tipo_acesso)->login($user);
                        return redirect()->route('administrador.home');
                    } else {
                        return redirect()->back()->withInput()->with('error', 'Usuário não permitido!');
                    }
            
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
