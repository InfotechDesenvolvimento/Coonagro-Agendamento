<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//if(version_compare(PHP_VERSION, '7.2.0', '>=')) { error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); }

Auth::routes();

Route::get('/', function (){
    return view('auth.login');
});

Route::get('cliente', 'cliente\HomeController@index')->name('cliente.home');
Route::get('cliente/operacao', 'cliente\HomeController@operacao')->name('cliente.operacao');
Route::get('cliente/carregamento', 'cliente\CarregamentoController@index')->name('cliente.carregamento');
Route::get('cliente/agendamento/{pedido}', 'cliente\AgendamentoController@index')->name('cliente.agendamento');


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
