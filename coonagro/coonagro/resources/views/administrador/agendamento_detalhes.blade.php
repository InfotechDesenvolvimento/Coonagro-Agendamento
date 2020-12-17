@extends('layouts.form-principal',  ['tag' => '2'])

@section('css')../../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido confirmacao">
        @if(isset($msg))
            <br>
            <div class="alert alert-warning" role="alert">
                {{$msg}}
            </div>
        @endif

        <h4 style="padding: 30px; color: #63950A"> <b>DADOS DO AGENDAMENTO</b> </h4>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">Nº Pedido</h5>
                <h4 class="dado">{{$agendamento->NUM_PEDIDO}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Produto</h5>
                <h4 class="dado">{{$agendamento->produto->DESCRICAO}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">Data do Agendamento</h5>
                <h4 class="dado">{{date_format(date_create($agendamento->DATA_AGENDAMENTO), 'd/m/Y')}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Quantidade (Toneladas)</h5>
                <h4 class="dado">{{$agendamento->QUANTIDADE}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">CNPJ Transportadora</h5>
                <h4 class="dado">{{$agendamento->CNPJ_TRANSPORTADORA}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Transportadora</h5>
                <h4 class="dado">{{$agendamento->TRANSPORTADORA}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">Placa Cavalo</h5>
                <h4 class="dado">{{$agendamento->PLACA_VEICULO}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Placa Carreta 1</h5>
                <h4 class="dado">{{$agendamento->PLACA_CARRETA1}}</h4>
            </div>

            <div class="col-sm-12">
                <h5 class="title">Tipo do Veículo</h5>
                <h4 class="dado">{{$agendamento->tipoVeiculo->TIPO_VEICULO}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Tara (Toneladas)</h5>
                <h4 class="dado">{{$agendamento->TARA_VEICULO}}</h4>
            </div>

        </div>

        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h5 class="title">CPF Motorista</h5>
                <h4 class="dado">{{$agendamento->CPF_CONDUTOR}}</h4>
            </div>

            <div class="col-sm-6">
                <h5 class="title">Nome</h5>
                <h4 class="dado">{{$agendamento->CONDUTOR}}</h4>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-12">
                <h5 class="title">Tipo de Embalagem</h5>
                <h4 class="dado">{{$agendamento->embalagem->TIPO_EMBALAGEM}}</h4>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-12">
                <h5 class="title">Observação</label>
                <h4 class="dado">{{$agendamento->OBS}}</h4>
            </div>
        </div>

        <hr>

        @if($agendamento->COD_STATUS_AGENDAMENTO == 1)
            <div class="row">
                <div class="form-group col-sm-6">
                    <a href="{{route('administrador.aprovar_agendamento', $agendamento->CODIGO)}}">
                        <button class="btn btn-success btn-lg btn-block" style="margin-bottom: 0">
                            <i class="fas fa-check"></i> Aprovar
                        </button>
                    </a>
                </div>
                <div class="form-group col-sm-6">
                    <a href="{{route('administrador.recusar_agendamento', $agendamento->CODIGO)}}">
                        <button class="btn btn-danger btn-lg btn-block" style="margin-bottom: 0">
                            <i class="fas fa-times"></i> Não aprovar
                        </button>
                    </a>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <a href="{{route('administrador.home')}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
