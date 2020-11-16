<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();

        return view('cliente.home', compact('status'));
    }

    public function operacao(){
        return view('cliente.operacao');
    }
}
