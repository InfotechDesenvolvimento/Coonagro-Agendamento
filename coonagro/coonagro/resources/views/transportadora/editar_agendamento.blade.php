@extends('layouts.form-principal',  ['tag' => '1'])

@section('css')../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido">

        <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTO DE CARREGAMENTO</b> </h4>

        

        <form action="{{ route('transportadora.agendamento_editar')}}" enctype="multipart/form-data" method="post" id="formAgendamento">
            <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">
            <div class="modal-body">
            <hr>
                <input type="hidden" id="saldo_disponivel" name="saldo_disponivel">
                <input type="hidden" id="cod_produto" name="cod_produto" value="{{$agendamento->COD_PRODUTO}}">
                <input type="hidden" name="cod_transportadora" id="cod_transportadora" value="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}">
                <input type="hidden" name="cod_cliente" id="cod_cliente" value="{{$agendamento->COD_CLIENTE}}">
                <input type="hidden" name="cod_agendamento" id="cod_agendamento" value="{{$agendamento->CODIGO}}">

                <div class="row">
                    <div class="form-group col-sm-5">
                        <label class="title">CNPJ Transportadora</label>

                        <input id="cnpj_transportadora"
                               inputmode="numeric"
                               type="text"
                               name="cnpj_transportadora"
                               value="{{Auth::user()->CPF_CNPJ}}"
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
                               value="{{Auth::user()->NOME}}"
                               class="form-control"
                               required
                               readonly
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Veículo</legend>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="title">Placa do Cavalo</label>

                                    <input id="placa_cavalo"
                                           type="text"
                                           name="placa_cavalo"
                                           value="{{$agendamento->PLACA_VEICULO}}"
                                           class="form-control"
                                           style="text-transform: uppercase"
                                           maxlength="7"
                                           minlength="7"
                                           onkeypress="return semEspeciais(event)"
                                           required
                                    >
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Placa da Carreta 1</label>

                                    <input id="placa_carreta"
                                           type="text"
                                           name="placa_carreta"
                                           value="{{$agendamento->PLACA_CARRETA1}}"
                                           class="form-control"
                                           style="text-transform: uppercase"
                                           maxlength="7"
                                           minlength="7"
                                           onkeypress="return semEspeciais(event)"
                                           required
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="title">Placa da Carreta 2</label>

                                    <input id="placa_carreta2"
                                           type="text"
                                           name="placa_carreta2"
                                           value="{{$agendamento->PLACA_CARRETA2}}"
                                           class="form-control"
                                           style="text-transform: uppercase"
                                           maxlength="7"
                                           minlength="7"
                                           onkeypress="return semEspeciais(event)"
                                    >
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Placa da Carreta 3</label>

                                    <input id="placa_carreta3"
                                           type="text"
                                           name="placa_carreta3"
                                           value="{{$agendamento->PLACA_CARRETA3}}"
                                           class="form-control"
                                           style="text-transform: uppercase"
                                           maxlength="7"
                                           minlength="7"
                                           onkeypress="return semEspeciais(event)"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label class="title">Tipo do Veículo</label>

                                    <select id="tipo_veiculo"
                                            class="form-control"
                                            name="tipo_veiculo"
                                            required
                                    >
                                        </option>
                                        @foreach($tipos as $tipo)
                                            @if($tipo->CODIGO == $agendamento->COD_TIPO_VEICULO)
                                                <option selected value='{"id": "{{$tipo->CODIGO}}", "carga": "{{$tipo->CARGA_MAXIMA}}"}'
                                            @else
                                                <option value='{"id": "{{$tipo->CODIGO}}", "carga": "{{$tipo->CARGA_MAXIMA}}"}'
                                            @endif
                                            >{{$tipo->TIPO_VEICULO}}</option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" name="tipo_veiculo_nome" id="tipo_veiculo_id" value="">

                                    <div class="invalid-feedback" id="invalid-carga">
                                        Capacidade máxima do veículo não suporta a quantidade informada
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="title">Tara (Toneladas)</label>

                                    <input id="tara"
                                           type="text"
                                           name="tara"
                                           value="{{$agendamento->TARA_VEICULO}}"
                                           class="form-control peso"
                                           required
                                    >
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="title">Tipo de Embalagem</label>

                        <select id="tipo_embalagem"
                                name="tipo_embalagem"
                                class="form-control"
                                required
                        >
                            @foreach($embalagens as $embalagem)
                                @if($embalagem->CODIGO == $agendamento->COD_EMBALAGEM)
                                    <option select value="{{$embalagem->CODIGO}}"
                                @else
                                    <option value="{{$embalagem->CODIGO}}"
                                @endif
                                >{{$embalagem->TIPO_EMBALAGEM}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="title">Cota estabelecida pelo cliente</label>
                        <div class="form-group col-sm-6">
                            <input name="limite_cliente"
                                    id="limite_cliente"
                                    type="text"
                                    class="form-control"
                                    readonly>
                        </div>
                        <div class="invalid-feedback" id="invalid-limite">
                            Quantidade ultrapassa limite do cliente!
                        </div>  
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-12">
                        <h5 class="title">Nº Pedido</h5>
                        <input type="text" 
                                name="num_pedido" 
                                id="num_pedido"
                                class="form-control"
                                value="{{$agendamento->NUM_PEDIDO}}"
                                required
                                readonly>
    
                        <div class="invalid-feedback" id="invalid-pedido">
                            Pedido inválido!
                        </div>
                    </div>
    
                    <div class="col-sm-8 col-12">
                        <h5 class="title">Produto</h5>
                        <input type="text" 
                                name="produto"
                                id="produto"
                                class="form-control"
                                value="{{$agendamento->produto->DESCRICAO}}"
                                required
                                readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="title">Data</label>

                        <input
                            name="data_agendamento"
                            id="data_agendamento"
                            min='<?php echo date("Y-m-d"); ?>'
                            type="date"
                            value='{{$agendamento->DATA_AGENDAMENTO}}'
                            class="form-control"
                            required
                            readonly
                        >

                        <div class="invalid-feedback" id="invalid-data">
                            Horário limite até às 17:00 hrs
                        </div>

                        <div class="invalid-feedback" id="invalid-cota">
                            Cota diária do cliente excedida
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="title">Quantidade (Toneladas)</label>

                        <input id="quantidade"
                               type="text"
                               name="quantidade"
                               class="form-control peso"
                               onkeypress="return somenteNumeros(event)"
                               value="{{$agendamento->QUANTIDADE}}"
                               required
                               readonly
                        >

                        <div class="invalid-feedback" id="invalid-quantidade">
                            Quantidade não disponível
                        </div>
                    </div>
                </div>

                
                

                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Motorista</legend>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="title">CPF </label>

                                    <input id="cpf_motorista"
                                           type="text"
                                           name="cpf_motorista"
                                           value="{{$agendamento->CPF_CONDUTOR}}"
                                           class="form-control"
                                           required>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Nome</label>

                                    <input id="nome_motorista"
                                           type="text"
                                           name="nome_motorista"
                                           value="{{$agendamento->CONDUTOR}}"
                                           class="form-control"
                                           required>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="title">Observação</label>
                        <textarea 
                                    name="observacao"
                                    id="observacao" 
                                    rows="10"
                                    class="form-control"
                                    >{{$agendamento->OBS}}</textarea>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-success btn-lg btn-block" id="avancar" style="margin-bottom: 0">
                            <i class="fas fa-arrow-right"></i> Avançar
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                @if($agendamento->COD_STATUS_AGENDAMENTO != 2)
                    <a href="{{route('transportadora.excluir', $agendamento->CODIGO)}}">
                        <button class="btn btn-danger btn-lg btn-block ">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </a>
                @else
                    <button disabled class="btn btn-danger btn-lg btn-block ">
                        <i class="fas fa-trash"></i> Excluir
                    </button>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <a href="{{route('transportadora.home')}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </a>
            </div>
        </div>

    </div>
@stop

@section('js')../js/agendamento_transportadora.js @endsection

