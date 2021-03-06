@extends('layouts.form-principal', ['tag' => '2'])

@section('css')../../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido">

        <h4 style="padding: 30px; color: #63950A"> <b>VINCULAR PEDIDO A TRANSPORTADORA</b> </h4>

        <form action="{{route('cliente.vincular')}}" method="post">
            <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">
            <div class="row">
                <div class="col-sm-4 col-12">
                    <h5 class="title">Nº Pedido</h5>
                    <h4 class="dado">{{$pedido->NUM_PEDIDO}}</h4>
                    <input type="text" name="num_pedido" id="num_pedido" value="{{$pedido->NUM_PEDIDO}}" hidden>
                </div>

                <div class="col-sm-4 col-12">
                    <h5 class="title">Produto</h5>
                    <h4 class="dado">{{$pedido->produto->DESCRICAO}}</h4>
                    <input type="text" name="cod_produto" id="cod_produto" value="{{$pedido->produto->CODIGO}}" hidden>
                </div>
                
                <div class="col-sm-4 col-12">
                    <h5 class="title">Saldo disponível</h5>
                    <h4 class="dado">{{$pedido->TOTAL - $pedido->TOTAL_AGENDADO}}</h4>
                    <h5 class="title">Saldo restante</h5>
                    <input readonly class="form-control" type="text" id="pedido_saldo_disponivel" value="{{ $pedido->TOTAL - $pedido->TOTAL_AGENDADO }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-5">
                    <label class="title">CNPJ Transportadora</label>

                    <input id="cnpj_transportadora"
                           inputmode="numeric"
                           type="text"
                           name="cnpj_transportadora"
                           value=""
                           class="form-control"
                           maxlength="18"
                           minlength="14"
                           onkeypress="return somenteNumeros(event)"
                           required
                    >
                </div>

                <div class="form-group col-sm-7">
                    <label class="title">Transportadora</label>

                    <input id="transportadora"
                           type="text"
                           name="transportadora"
                           value=""
                           class="form-control"
                           readonly
                    >
                </div>
                <input type="hidden" id="cod_transportadora" name="cod_transportadora">
                <input type="hidden" id="num_cota">
                <input type="hidden" id="cod_cliente" value="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}">
            </div>
            <div class="invalid-feedback" id="invalid-transportadora">
                Transportadora inválida!
            </div>
            <br>
            <div class="tabela">
                <table id="table" class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th>Quantidade Máxima</th>
                            <th>Data</th>
                            <th>Cota Cliente Disponível</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <a id="adicionar" onclick="adicionarCota()">
                <b><i class="fas fa-plus-square"></i></b>
            </a>
            <button class="btn btn-primary btn-lg btn-block" id="vincular" disabled style="margin-top: 50px">
                <b><i class="fas fa-boxes"></i> Vincular Pedido </b>
            </button>
            <input type="hidden" id="numCota" name="numCota" value="0">
        </form>
        <a href="{{route('cliente.vincular_pedidos')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <b><i class="fas fa-arrow-left"></i> Voltar</b>
            </button>
        </a>
    </div>
@stop

@section('js')../../js/vincular.js @endsection

