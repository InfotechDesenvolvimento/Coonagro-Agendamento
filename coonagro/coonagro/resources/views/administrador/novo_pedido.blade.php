@extends('layouts.form-principal',  ['tag' => '2'])

@section('css')../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form">

        <h4 style="padding: 30px; color: #63950A"> <b>NOVO PEDIDO</b> </h4>

        <form action="{{ route('administrador.novo_pedido_cadastrar') }}" method="post" id="formAgendamento">
            <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">
            <div class="modal-body">
            <hr>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="title">Nº Pedido</label>
                        <input id="num_pedido"
                               type="number"
                               name="num_pedido"
                               class="form-control"
                               required
                        >
                        <div class="invalid-feedback" id="invalid-pedido">
                            Número de pedido inválido!
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="title">Status</label>

                        <select name="status" id="status" class="form-control">
                            @foreach($situacao_pedido as $status)
                                <option value="{{ $status->CODIGO }}"> {{ $status->SITUACAO }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="title">Cliente</label>

                                <select name="cliente" id="cliente" class="form-control">
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->CODIGO }}"> {{ $cliente->NOME_FANTASIA }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label class="title">Produto</label>

                                <select name="produto" id="produto" class="form-control">
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->CODIGO }}"> {{ $produto->DESCRICAO }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="title">Tipos de operação</label>

                                <select name="tipo_operacao" id="tipo_operacao" class="form-control">
                                    @foreach($tipo_operacao as $tipo)
                                        <option value="{{ $tipo->CODIGO }}"> {{ $tipo->TIPO_OPERACAO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label class="title">Total do pedido</label>

                                <input id="total_pedido"
                                        type="number"
                                        name="total_pedido"
                                        class="form-control"
                                        required
                                >
                            </div>

                            <div class="form-group col-sm-3">
                                <label class="title">Saldo movimentado</label>

                                <input 
                                        id="saldo_movimentado"
                                        type="text"
                                        name="saldo_movimentado"
                                        class="form-control"
                                        value="0"
                                        readonly
                                >
                            </div>

                            <div class="form-group col-sm-3">
                                <label class="title">Saldo restante</label>

                                <input 
                                        id="saldo_restante"
                                        type="text"
                                        name="saldo_restante"
                                        class="form-control"
                                        readonly
                                >
                            </div>

                            <div class="form-group col-sm-3">
                                <label class="title">Total agendado</label>

                                <input 
                                        id="total_agendado"
                                        type="text"
                                        name="total_agendado"
                                        class="form-control"
                                        value="0"
                                        readonly
                                >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Observações</label>
                                <textarea name="obs" id="obs" class="form-control" rows="5"></textarea>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-success btn-lg btn-block" id="avancar" style="margin-bottom: 0" disabled>
                            <i class="fas fa-arrow-right"></i> Registrar novo pedido
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <a href="{{route('administrador.pedidos')}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </a>
            </div>
        </div>

    </div>
@stop

@section('js')../../js/novo_pedido.js @endsection

