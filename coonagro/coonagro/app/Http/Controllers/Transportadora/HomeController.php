<?php

namespace App\Http\Controllers\Transportadora;

use App\Http\Controllers\Controller;
use App\StatusAgendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transportadora;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:transportadora');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();
        
        return view('transportadora.home', compact('status'));
    }
}
