<?php

namespace App\Http\Controllers;

use DB;
use Request;
// use Illuminate\Http\Request;
use App\PedidoTransporteModel;
use App\AgendamentoModel;
use App\ProdAgendamentoModel;
use App\EmbalagemModel;

class FormController extends Controller{

  public function validationNumPedido(){
    $var_aux = false;
    session()->put('var_aux', $var_aux);

    $num_pedido = Request::input('num_pedido');
    $data_agendamento = Request::input('data_agendamento');

    session()->put('num_pedido', $num_pedido);
    session()->put('data_agendamento', $data_agendamento);

    $pedido = PedidoTransporteModel::where('NUM_PEDIDO', '=', $num_pedido)
      ->where('COD_STATUS', '=', 1)
      ->get();

    $result = sizeOf($pedido);

    //verifica se o array está vazio
    if($result!=0){
      $produtos = DB::table('pedido_transporte')
        ->join('produtos', 'pedido_transporte.COD_PRODUTO', '=', 'produtos.CODIGO')
        ->select('produtos.DESCRICAO', 'produtos.CODIGO')
        ->where('NUM_PEDIDO', '=', $num_pedido)->where('COD_STATUS', '=', 1)
        ->get();

      return view('formulario2')
        ->with('pedido', $pedido)
        ->with('produtos', $produtos);
    }

    $error = 'Número de pedido inválido';
    return view('formulario1')->with('error', $error);
  }

  public function validationSaldoProduct(){
    $cod_product = Request::input('cod_product');
    $pedido = PedidoTransporteModel::where('NUM_PEDIDO', '=', session('num_pedido'))
      ->where('COD_STATUS', '=', 1)
      ->where('COD_PRODUTO', '=', $cod_product)
      ->first();

    session()->put('cod_product', $cod_product);

    // $tipos_embalagem = EmbalagemModel::all();
    return view('formulario3')
      ->with('cod_product', $cod_product)
      ->with('tipos_embalagem', $tipos_embalagem)
      ->with('pedido', $pedido);
  }

  public function finalizarAgendamento(){

    $pedido = Request::input('pedido');
    $qtde = Request::input('qtde');
    $packing = Request::input('packing');
    $name_transportador = Request::input('name_transportadora');
    $cpf_transportador = Request::input('cpf_transportador');
    $placa_veiculo = Request::input('placa_veiculo');
    $placa_carreta1 = Request::input('placa_carreta1');
    $placa_carreta2 = Request::input('placa_carreta2');
    $tipo_veiculo = Request::input('tipo_veiculo');
    $tara_veiculo = Request::input('tara_veiculo');
    $name_condutor = Request::input('name_condutor');
    $cpf_condutor = Request::input('cpf_condutor');
    $renavam = Request::input('renavam');

    session()->put('saldo_restante', $pedido->SALDO_RESTANTE);
    session()->put('qtde', $qtde);
    session()->put('packing', $packing);
    session()->put('name_transportador', $name_transportador);
    session()->put('cpf_transportador', $cpf_transportador);
    session()->put('placa_veiculo', $placa_veiculo);
    session()->put('placa_carreta1', $placa_carreta1);
    session()->put('placa_carreta2', $placa_carreta2);
    session()->put('tipo_veiculo', $tipo_veiculo);
    session()->put('tara_veiculo', $tara_veiculo);
    session()->put('name_condutor', $name_condutor);
    session()->put('cpf_condutor', $cpf_condutor);
    session()->put('renavam', $renavam);

    return view('confirmation');
  }

  public function confirmation(){
    $aux = session('var_aux');
    if($aux){
      return view('error');
    }else{
      $agendamento = new AgendamentoModel();

      $agendamento->DATA_CADASTRO = date("Y/m/d");
      $agendamento->DATA_ALTERACAO = date("Y/m/d");

      $agendamento->COD_STATUS_AGENDAMENTO = 1;
      $agendamento->NUM_PEDIDO = session('num_pedido');
      $agendamento->DATA_AGENDAMENTO = session('data_agendamento');
      $agendamento->TRANSPORTADORA = session('name_transportador');
      $agendamento->CNPJ_TRANSPORTADORA = session('cpf_transportador');
      $agendamento->PLACA_VEICULO = session('placa_veiculo');
      $agendamento->PLACA_CARRETA1 = session('placa_carreta1');
      $agendamento->PLACA_CARRETA2 = session('placa_carreta2');
      $agendamento->COD_TIPO_VEICULO = session('tipo_veiculo');
      $agendamento->TARA_VEICULO = session('tara_veiculo');
      $agendamento->CONDUTOR = session('name_condutor');
      $agendamento->CPF_CONDUTOR = session('cpf_condutor');
      $agendamento->RENAVAM_VEICULO = session('renavam');

      $agendamento->save();

      $id_agendamento = $agendamento->id;

      $prod_agendamentos = new ProdAgendamentoModel();

      $prod_agendamentos->COD_AGENDAMENTO = $id_agendamento;
      $prod_agendamentos->COD_PRODUTO = session('cod_product');
      $prod_agendamentos->QUANTIDADE = session('qtde');
      $prod_agendamentos->COD_EMBALAGEM = session('packing');
      $prod_agendamentos->SALDO_MOMENTO = session('saldo_restante');
      $prod_agendamentos->NUM_PEDIDO = session('num_pedido');
      $prod_agendamentos->COD_STATUS = 1;

      $prod_agendamentos->save();
      return redirect()->action('FormController@success')->withInput();
    }
  }

  public function success(){
    $var_aux = true;
    session()->put('var_aux', $var_aux);

    return view('message-success');
  }

  public function imprimirAgendamento(){
    return \PDF::loadView('impressao-agendamento')
               ->stream('agendamento-coonagro.pdf');
  }

  public function backForm3(){
    return back();
  }
}
