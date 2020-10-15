<?php

namespace App\Http\Controllers;

use App\AgendamentoOutrosModel;
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

        //session()->put('saldo_restante', $pedido->SALDO_RESTANTE);
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

    public function successOutros(){
        return view('mensagem-sucesso');
    }

    public function imprimirAgendamento(){
        return \PDF::loadView('impressao-agendamento')
            ->stream('agendamento-coonagro.pdf');
    }

    public function imprimirAgendamentoOutros(){
        return \PDF::loadView('impressao-outros')
            ->stream('agendamento-coonagro.pdf');
    }

    public function backForm3(){
        return back();
    }

    public function finalizarAgendamentoOutros(){

        $data_agendamento = Request::get('data_agendamento');
        $hora_agendamento = Request::get('hora_agendamento');
        $tipo_operacao = Request::get('tipo_operacao');
        $placa_veiculo = Request::get('placa');
        $nome_motorista = Request::get('nome_motorista');
        $cpf_motorista = Request::get('cpf_motorista');
        $transportadora = Request::get('transportadora');
        $num_nota = Request::get('num_nota');
        $peso_bruto = Request::get('peso_bruto');
        $peso_liquido = Request::get('peso_liquido');
        $observacao = Request::get('observacao');
        $motivo = Request::get('motivo');

        session()->put('data', $data_agendamento);
        session()->put('hora', $hora_agendamento);
        session()->put('tipo_operacao', $tipo_operacao);
        session()->put('cpf_motorista', $cpf_motorista);
        session()->put('nome_motorista', $nome_motorista);
        session()->put('placa_veiculo', $placa_veiculo);
        session()->put('transp', $transportadora);
        session()->put('num_nota', $num_nota);
        session()->put('peso_bruto', $peso_bruto);
        session()->put('peso_liquido', $peso_liquido);
        session()->put('observacao', $observacao);
        session()->put('motivo', $motivo);

        return view('confirmacao');
    }

    public function confirmationOutros(){
        $agendamento = new AgendamentoOutrosModel();

        $agendamento->DATA_CADASTRO = date("Y/m/d");
        $agendamento->DATA_ALTERACAO = date("Y/m/d");
        $agendamento->IDE_DATA_EMISSAO = date("Y/m/d");

        $agendamento->DATA_ENTRADA = session('data');
        $agendamento->HORA_ENTRADA = session('hora');
        $agendamento->TRANSP_PLACA_VEICULO = strtoupper(session('placa_veiculo'));
        $agendamento->TRANSP_XNOME = strtoupper(session('transp'));
        $agendamento->COD_STATUS_XML = 4;
        $agendamento->COD_OPERACAO = session('tipo_operacao');
        $agendamento->NUM_NOTA_FISCAL_ELETRONICA = session('num_nota');
        $agendamento->MOTIVO_AGENDAMENTO = strtoupper(session('motivo'));

        if(session('peso_bruto') != ""){
            $peso_bruto = session('peso_bruto');
            $peso_bruto = str_replace('.', '', $peso_bruto);
            $peso_bruto = str_replace(',', '.', $peso_bruto);
            $agendamento->TRANSP_PESO_BRUTO = $peso_bruto;
        }

        if(session('peso_liquido') != ""){
            $peso_liquido = session('peso_liquido');
            $peso_liquido = str_replace('.', '', $peso_liquido);
            $peso_liquido = str_replace(',', '.', $peso_liquido);
            $agendamento->TRANSP_PESO_LIQUIDO = $peso_liquido;
        }

        $agendamento->CPF_CONDUTOR = session('cpf_motorista');
        $agendamento->NOME_CONDUTOR = strtoupper(session('nome_motorista'));
        $agendamento->PLACA_CARRETA1 = strtoupper(session('placa_veiculo'));
        $agendamento->OBS = strtoupper(session('observacao'));

        $agendamento->save();

        return redirect()->action('FormController@successOutros')->withInput();
    }


}
