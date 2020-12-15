<?php

namespace App\Http\Controllers\Transportadora;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:transportadora');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();
        $produtos = Produto::get();
       
        return view('transportadora.home', compact('status','produtos'));
    }

    public function operacao(){
        return view('transportadora.operacao');
    }
}
