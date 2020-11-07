<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/transportadora/{identificacao}', 'TransportadoraController@getTransportadora');
Route::get('/veiculo/{placa}', 'VeiculoController@getVeiculo');
Route::get('/motorista/{identificacao}', 'MotoristaController@show');
