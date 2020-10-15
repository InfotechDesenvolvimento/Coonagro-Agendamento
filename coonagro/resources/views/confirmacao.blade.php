@extends('form-principal')

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">
        <div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 750px;">
            <div class="card border-secondary mb-3" style="max-width: 50rem;">
                <div style="font-size: 25px; color: #585858" class="card-header"><b>DADOS DO AGENDAMENTO</b></div>

                <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">

                <div id="fontConfirmation" style="text-align:left; letter-spacing: 0.3px" class="card-body text-secondary">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-md-6">
                                <p id="formconfirmation" class="card-text"><b>DATA AGENDAMENTO: {{session()->get('data')}}</b></p>
                            </div>
                            <div class="col-sm-6">
                                <p id="formconfirmation" class="card-text"><b>HORA PREVISTA: {{session()->get('hora')}}</b></p>
                            </div>
                        </div> <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <p id="formconfirmation" class="card-text"><b>TIPO DE OPERAÇÃO: @if(session()->get('tipo_operacao') == 3) Almoxarifado @else Outros @endif</b></p>
                            </div>
                            <div class="col-sm-6">
                                <p id="formconfirmation" class="card-text"><b>PLACA DO VEÍCULO: {{session()->get('placa_veiculo')}}</b></p>
                            </div>
                        </div> <hr>

                        <p id="formconfirmation" class="card-text"><b>MOTIVO DO AGENDAMENTO: {{session()->get('motivo')}}</b></p> <hr>
                        <p id="formconfirmation" class="card-text"><b>CPF MOTORISTA: {{session()->get('cpf_motorista')}}</b></p> <hr>
                        <p id="formconfirmation" class="card-text"><b>NOME MOTORISTA: {{session()->get('nome_motorista')}}</b></p><hr>
                        <p id="formconfirmation" class="card-text"><b>TRANSPORTADORA: {{session()->get('transp')}}</b></p><hr>
                        <p id="formconfirmation" class="card-text"><b>Nº NOTA FISCAL: {{session()->get('num_nota')}}</b></p><hr>
                        <p id="formconfirmation" class="card-text"><b>PESO BRUTO: {{session()->get('peso_bruto')}}</b></p><hr>
                        <p id="formconfirmation" class="card-text"><b>PESO LÍQUIDO: {{session()->get('peso_liquido')}}</b></p><hr>
                        <p id="formconfirmation" class="card-text"><b>OBSERVAÇÃO: {{session()->get('observacao')}}</b></p><hr>

                        <a  style="text-decoration:none" href="{{ action('FormController@confirmationOutros') }}"> <button id="formconfirmation" type="button" class="btn btn-success btn-lg btn-block"><i class="fas fa-check-circle"></i><b> CONCLUIR AGENDAMENTO </b></button> </a>
                        <button id="formconfirmation" style="margin-top: 10px;" class="btn btn-primary btn-lg btn-block" onclick='history.go(-1)'><i class="fas fa-check-circle"></i><b> VOLTAR </b></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
