@extends('layouts.form-principal')

@section('css')../../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido">

        <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTO DE CARREGAMENTO</b> </h4>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4 col-12">
                    <h5 class="title">Nº Pedido</h5>
                    <h4 class="dado">{{$pedido->NUM_PEDIDO}}</h4>
                </div>

                <div class="col-sm-8 col-12">
                    <h5 class="title">Produto</h5>
                    <h4 class="dado">{{$pedido->produto->DESCRICAO}}</h4>
                </div>
            </div>

            <hr>

            <form>
                <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="title">Data</label>

                        <input
                            name="data_agendamento"
                            min='<?php echo date("Y-m-d"); ?>'
                            type="date"
                            value='<?php echo date("Y-m-d", strtotime("+1 day"))?>'
                            class="form-control"
                        >
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="title">Quantidade (Toneladas)</label>

                        <input id="quantidade"
                               type="number"
                               name="quantidade"
                               class="form-control"
{{--                               onkeyup="validateLimite(this.value, {{$pedido->SALDO_RESTANTE}})"--}}
{{--                               onkeypress='return SomenteNumero(event)'--}}
{{--                               onpaste="noPasteCaracterQtd(this.value)"--}}
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="title">Transportadora</label>

                        <select id="transportadora"
                                class="form-control"
                                name="transportadora"
                        >
                            <option value="0">--</option>
                            @foreach($transportadoras as $transportadora)
                                <option value="{{$transportadora->CODIGO}}">
                                    {{$transportadora->NOME}} - {{$transportadora->CPF_CNPJ}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>
        </div>

        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <a href="{{route('cliente.carregamento')}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <b> <i class="fas fa-arrow-left"></i> Voltar </b>
                    </button>
                </a>
            </div>
        </div>

    </div>
@stop

