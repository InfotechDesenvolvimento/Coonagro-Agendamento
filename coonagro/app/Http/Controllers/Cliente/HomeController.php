<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index(){
        return view('cliente.home');
    }

    public function operacao(){
        return view('cliente.operacao');
    }
}
