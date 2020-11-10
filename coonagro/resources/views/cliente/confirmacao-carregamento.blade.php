@extends('layouts.form-principal')

@section('css')../../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido confirmacao">

        <h4 style="padding: 30px; color: #63950A"> <b>DADOS DO AGENDAMENTO</b> </h4>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">Nº Pedido</h5>
                <h4 class="dado">{{$confirmacao['num_pedido']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Produto</h5>
                <h4 class="dado">{{$confirmacao['produto']}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">Data do Agendamento</h5>
                <h4 class="dado">{{$confirmacao['data_agendamento_formatado']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Quantidade (Toneladas)</h5>
                <h4 class="dado">{{$confirmacao['quantidade']}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">CNPJ Transportadora</h5>
                <h4 class="dado">{{$confirmacao['cnpj_transportadora']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Transportadora</h5>
                <h4 class="dado">{{$confirmacao['transportadora']}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">Placa Cavalo</h5>
                <h4 class="dado">{{$confirmacao['placa_cavalo']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Placa Carreta</h5>
                <h4 class="dado">{{$confirmacao['placa_carreta']}}</h4>
            </div>

            <div class="col-sm-12">
                <h5 class="title">Tipo do Veículo</h5>
                <h4 class="dado">{{$confirmacao['tipo_veiculo_nome']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Tara (KG)</h5>
                <h4 class="dado">{{$confirmacao['tara']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Renavam</h5>
                <h4 class="dado">{{$confirmacao['renavam']}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">CPF Motorista</h5>
                <h4 class="dado">{{$confirmacao['cpf_motorista']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Nome</h5>
                <h4 class="dado">{{$confirmacao['nome_motorista']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">CNH</h5>
                <h4 class="dado">{{$confirmacao['cnh']}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Validade da CNH</h5>
                <h4 class="dado">{{$confirmacao['validade_cnh_formatado']}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-12">
                <h5 class="title">Tipo de Embalagem</h5>
                <h4 class="dado">{{$confirmacao['tipo_embalagem_nome']}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="form-group col-sm-12">
                <a href="{{route('carregamento.finalizar')}}">
                    <button class="btn btn-success btn-lg btn-block" style="margin-bottom: 0">
                        <i class="fas fa-arrow-right"></i> Concluir
                    </button>
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <a href="{{url()->previous()}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
