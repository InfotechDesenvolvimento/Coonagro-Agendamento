<?php

if(version_compare(PHP_VERSION, '7.2.0', '>=')) { error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); }

Auth::routes();


Route::group(['middleware' => 'auth'], function() {

  Route::get('/', function () {
      return view('formulario1');
  });

  Route::get('/formulario', function () {
      return view('formulario2');
  });

  Route::get('/finish', function () {
      return view('message-success');
  });

  Route::get('/error', function () {
      return view('error');
  });

  //validações
  Route::post('/validation-pedido', 'FormController@validationNumPedido');
  Route::post('/validation-saldo', 'FormController@validationSaldoProduct');
  Route::post('/concluir-agendamento', 'FormController@finalizarAgendamento');
  Route::get('/finalizar-agendamento', 'FormController@confirmation');
  Route::get('/imprimir', 'FormController@imprimirAgendamento');
  Route::get('/success', 'FormController@success');

});

Route::post('/login', 'LoginController@postLogin');

Route::get('/home', 'HomeController@index')->name('home');
