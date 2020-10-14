@extends('form-principal')

@section('conteudo')
<?php date_default_timezone_set('America/Sao_Paulo');  ?>

<div class="col-12">
  <div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 750px;">
    <div class="card border-secondary mb-3" style="max-width: 50rem;">
      <div style="font-size: 25px; color: #585858" class="card-header"><b>DADOS DO AGENDAMENTO</b></div>
      <form class="" action="{{ action('FormController@validationSaldoProduct') }}" method="post">
        <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">
        <input type ="hidden" name="cod_product" value="{{{ session()->get('cod_product') }}}">

        <div id="fontConfirmation" style="text-align:left; letter-spacing: 0.3px" class="card-body text-secondary">
          <div class="col-12">

            <div class="row">
              <div class="col-md-6">
                <p id="formconfirmation" class="card-text"><b>NÚMERO DO PEDIDO: {{session()->get('num_pedido')}}</b></p>
              </div>
              <div class="col-sm-6">
                <p id="formconfirmation" class="card-text"><b>QUANTIDADE: {{session()->get('qtde')}}</b></p>
              </div>
            </div> <hr>

            <div class="row">
              <div class="col-md-6">
                <p id="formconfirmation" class="card-text"><b>NOME TRANSPORTADORA: {{session()->get('name_transportador')}}</b></p>
              </div>
              <div class="col-sm-6">
                <p id="formconfirmation" class="card-text"><b>CPF TRANSPORTADOR: {{session()->get('cpf_transportador')}}</b></p>
              </div>
            </div> <hr>

            <!-- <p class="card-text"><b>TIPO EMBALAGEM: {{session()->get('packing')}}</b></p> -->
            <p id="formconfirmation" class="card-text"><b>PLACA VEÍCULO: {{session()->get('placa_veiculo')}}</b></p> <hr>
            <p id="formconfirmation" class="card-text"><b>PLACA CARRETA 1: {{session()->get('placa_carreta1')}}</b></p><hr>
            <p id="formconfirmation" class="card-text"><b>PLACA CARRETA 2: {{session()->get('placa_carreta2')}}</b></p><hr>
            <p id="formconfirmation" class="card-text"><b>TARA DO VEÍCULO: {{session()->get('tara_veiculo')}}</b></p><hr>
            <p id="formconfirmation" class="card-text"><b>NOME CONDUTOR: {{session()->get('name_condutor')}}</b></p><hr>
            <p id="formconfirmation" class="card-text"><b>CNH CONDUTOR: {{session()->get('cpf_condutor')}}</b></p><hr>
            <a  style="text-decoration:none" href="{{ action('FormController@confirmation') }}"> <button id="formconfirmation" type="button" class="btn btn-success btn-lg btn-block"><i class="fas fa-check-circle"></i><b> CONCLUIR AGENDAMENTO </b></button> </a>
            <button id="formconfirmation" style="margin-top: 10px;" type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-check-circle"></i><b> VOLTAR </b></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@stop
