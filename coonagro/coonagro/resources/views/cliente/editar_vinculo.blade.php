@extends('layouts.form-principal',  ['tag' => '2'])

@section('css')../../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido">

        <h4 style="padding: 30px; color: #63950A"> <b>EDITAR VINCULO PEDIDO-TRANSPORTADORA</b> </h4>
        @if(isset($msg))
            <div class="alert alert-primary" role="alert">
                {{$msg}}
            </div>
        @endif
        <form action="{{route('cliente.salvar_vinculo', ['pedido' => $vinculo->CODIGO])}}" method="post">
            <input type="hidden" name="cod_transportadora" id="cod_transportadora" value="{{$transportadora->CODIGO}}">
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
                    <input class="form-control" type="hidden" id="pedido_saldo_disponivel" value="{{ $pedido->TOTAL - $pedido->TOTAL_AGENDADO }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-5">
                    <label class="title">CNPJ Transportadora</label>

                    <input id="cnpj_transportadora"
                           inputmode="numeric"
                           type="text"
                           name="cnpj_transportadora"
                           value="{{$transportadora->CPF_CNPJ}}"
                           class="form-control"
                           maxlength="18"
                           minlength="14"
                           onkeypress="return somenteNumeros(event)"
                           required
                           readonly
                    >
                </div>

                <div class="form-group col-sm-7">
                    <label class="title">Transportadora</label>

                    <input id="transportadora"
                           type="text"
                           name="transportadora"
                           value="{{$transportadora->NOME}}"
                           class="form-control"
                           readonly
                    >
                </div>
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
                        <tr >
                            <td> <input id="quantidade"
                                        type="text"
                                        name="quantidade"
                                        class="form-control peso"
                                        onkeypress="return somenteNumeros(event)"
                                        required
                                        value="{{$vinculo->COTA}}"
                                >
                            </td>

                            <td>
                                <input id="data"
                                        type="date"
                                        name="data"
                                        class="form-control"
                                        readonly
                                        value="{{$vinculo->DATA}}"
                                >
                            </td>
                        
                            <td>
                                <input id="cota_disponivel"
                                        type="text"
                                        name="cota_disponivel"
                                        class="form-control"
                                        readonly
                                        value=""
                                >
                            </td>

                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="invalid-feedback" id="invalid-quantidade">
                                    Quantidade não disponível
                                </div>
                            </td>
                            <td>
                            </td>
                            <td>
                                <div class="invalid-feedback" id="invalid-cota">
                                    Cota diária do cliente excedida
                                </div>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>

            <button class="btn btn-primary btn-lg btn-block" id="vincular" disabled style="margin-top: 50px">
                <b><i class="fas fa-boxes"></i> Atualizar Vinculo </b>
            </button>
        </form>
        <a href="{{route('cliente.pedidos_vinculados')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <b><i class="fas fa-arrow-left"></i> Voltar</b>
            </button>
        </a>
    </div>
@stop

@section('js')../../js/editar_vinculo.js @endsection

