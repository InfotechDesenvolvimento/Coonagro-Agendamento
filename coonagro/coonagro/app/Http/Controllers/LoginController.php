<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cliente;

class LoginController extends Controller{

    public function __construct(){
      $user = Auth::user();
    }

    public function login(){
      return view('auth.login');
    }

    public function username() { return 'USUARIO'; }
    public function password() { return 'SENHA'; }

    public function logout(){
      auth()->guard('cliente')->logout();
      return redirect('/login');
    }

    public function postLogin(Request $request){
      $validator = validator($request->all(), [
        'user' => 'required|min:3|max:100',
        'password' => 'required|min:3|max:100',
      ]);
      if($validator->fails()){
        return redirect('/login');
      }

      $user = Cliente::where('USUARIO', '=', $request->get('user'))->first();

      if($user){
        $user = Cliente::where('SENHA', '=', $request->get('password'))->where('BLOQUEADO', '=', 'N')->first();

        if($user!=null){
          Auth::login($user);
          return redirect('/');
        }else{
          $error = 'Usuário ou senha inválida!';
          return view('auth.login')->with('error', $error);
        }

      }else{
        $error = 'Usuário ou senha inválida!';
        return view('auth.login')->with('error', $error);
      }
    }
}
