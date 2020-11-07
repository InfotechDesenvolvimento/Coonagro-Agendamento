<?php


namespace App\Http\Controllers;


use App\Motorista;

class MotoristaController extends Controller
{
    public function show($identificacao){
        return response()->json(Motorista::where('CPF_CNPJ', $identificacao)->first());
    }
}
