<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();

        return view('administrador.home', compact('status'));
    }

    public function operacao(){
        return view('administrador.operacao');
    }
}
