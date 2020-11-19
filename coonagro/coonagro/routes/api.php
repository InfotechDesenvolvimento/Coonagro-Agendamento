<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/transportadora/{identificacao}', 'TransportadoraController@getTransportadora');
Route::get('/veiculo/{placa}', 'VeiculoController@getVeiculo');
Route::get('/motorista/{identificacao}', 'MotoristaController@show');
Route::get('/cota/{cliente}/{data}', 'CotaClienteController@show');
Route::get('/pedido/{num_pedido}', 'PedidoTransporteController@getPedido');
Route::get('/produto/{codigo}', 'ProdutoController@getProduto');