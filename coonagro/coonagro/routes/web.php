<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//if(version_compare(PHP_VERSION, '7.2.0', '>=')) { error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); }

Auth::routes();

Route::get('/', function (){
    return view('auth.login');
})->name('login');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('transportadora/agendamento', 'transportadora\AgendamentoController@index')->name('transportadora.agendamento');
Route::post('transportadora/carregamento/confirmar', 'transportadora\AgendamentoController@validarDados')->name('transportadora.carregamento.validar');
Route::get('transportadora/operacao', 'transportadora\HomeController@operacao')->name('transportadora.operacao');
Route::get('transportadora', 'transportadora\HomeController@index')->name('transportadora.home');
Route::get('/transportadora/filter', 'transportadora\AgendamentoController@filter')->name('transportadora.filter');
Route::get('transportadora/carregamento/imprimir/{cod_agendamento}', 'transportadora\AgendamentoController@imprimir')->name('transportadora.carregamento.imprimir');
Route::get('transportadora/carregamento/finalizar', 'transportadora\AgendamentoController@finalizar')->name('transportadora.carregamento.finalizar');
Route::get('/transportadora/carregamento/sucesso/{cod_agendamento}', 'transportadora\AgendamentoController@sucesso')->name('transportadora.carregamento.sucesso');
Route::get('/transportadora/configuracoes/', 'transportadora\ConfiguracoesController@opcoes')->name('transportadora.configuracoes');
Route::post('/transportadora/alterar_dados/', 'transportadora\ConfiguracoesController@alterarDados')->name('transportadora.alterar_dados');
Route::get('/transportadora/pedidos_vinculados', 'transportadora\AgendamentoController@visualizarPedidosVinculados')->name('transportadora.pedidos_vinculados');
Route::get('transportadora/total_agendado', 'transportadora\AgendamentoController@totalAgendado')->name('transportadora.total_agendado');

Route::get('cliente', 'cliente\HomeController@index')->name('cliente.home');
Route::get('/cliente/filter', 'cliente\AgendamentoController@filter')->name('cliente.filter');
Route::get('cliente/operacao', 'cliente\HomeController@operacao')->name('cliente.operacao');
Route::get('cliente/carregamento', 'cliente\CarregamentoController@index')->name('cliente.carregamento');
Route::get('cliente/agendamento/{pedido}', 'cliente\AgendamentoController@index')->name('cliente.agendamento');
Route::post('cliente/carregamento/confirmar', 'cliente\AgendamentoController@validarDados')->name('carregamento.validar');
Route::get('/cliente/carregamento/finalizar', 'cliente\AgendamentoController@finalizar')->name('carregamento.finalizar');
Route::get('/cliente/carregamento/sucesso/{cod_agendamento}', 'cliente\AgendamentoController@sucesso')->name('carregamento.sucesso');
Route::get('/cliente/carregamento/imprimir/{cod_agendamento}', 'cliente\AgendamentoController@imprimir')->name('carregamento.imprimir');
Route::get('/cliente/configuracoes/', 'cliente\ConfiguracoesController@opcoes')->name('cliente.configuracoes');
Route::post('/cliente/alterar_dados/', 'cliente\ConfiguracoesController@alterarDados')->name('cliente.alterar_dados');
Route::get('cliente/vincular_pedidos/', 'cliente\VincularPedidosController@index')->name('cliente.vincular_pedidos');
Route::get('cliente/vincular_pedido/{pedido}', 'cliente\VincularPedidosController@vincularPedido')->name('cliente.vincular_pedido_transportadora');
Route::post('cliente/vincular/', 'cliente\VincularPedidosController@vincular')->name('cliente.vincular');
Route::get('cliente/pedidos_vinculados', 'cliente\VincularPedidosController@visualizarPedidosVinculados')->name('cliente.pedidos_vinculados');
Route::get('cliente/total_agendado', 'cliente\AgendamentoController@totalAgendado')->name('cliente.total_agendado');
Route::get('cliente/desvincular/{pedido}', 'cliente\VincularPedidosController@desvincular')->name('cliente.desvincular');


Route::get('/cliente/get/{cod_cliente}', 'administrador\AgendamentoController@getCliente')->name('administrador.get.cliente');
Route::get('administrador', 'administrador\HomeController@index')->name('administrador.home');
Route::get('/administrador/filter', 'administrador\AgendamentoController@filter')->name('administrador.filter');

//Route::get('transportadora/operacao', 'transportadora\HomeController@operacao')->name('transportadora.operacao');


//Route::get('cliente/carregamento-retornar', 'cliente\AgendamentoController@retornarCarregamento');
//
//Route::get('cliente/carregamento/confirmacao', function (){
//    return view('cliente.')
//})
//Route::group(['middleware' => 'auth'], function() {
//
//    Route::get('/', function () {
//        return view('formulario1');
//    });
//
//    Route::get('/formulario', function () {
//        return view('formulario2');
//    });
//
//    Route::get('/finish', function () {
//        return view('message-success');
//    });
//
//    Route::get('/error', function () {
//        return view('error');
//    });
//
//    Route::get('/outros', function (){
//        return view('outros');
//    })->name('outros');
//
//    //validações
//    Route::post('/validation-pedido', 'FormController@validationNumPedido');
//    Route::post('/validation-saldo', 'FormController@validationSaldoProduct');
//    Route::post('/concluir-agendamento', 'FormController@finalizarAgendamento');
//    Route::post('/concluir-agendamento-outros', 'FormController@finalizarAgendamentoOutros');
//    Route::get('/finalizar-agendamento', 'FormController@confirmation');
//    Route::get('/finalizar-agendamento-outros', 'FormController@confirmationOutros');
//    Route::get('/imprimir', 'FormController@imprimirAgendamento');
//    Route::get('/imprimir-outros', 'FormController@imprimirAgendamentoOutros');
//    Route::get('/success', 'FormController@success');
//    Route::get('/sucesso', 'FormController@successOutros');
//
//});

//Route::post('/login', 'LoginController@postLogin');

//Route::get('/home', 'HomeController@index')->name('home');
