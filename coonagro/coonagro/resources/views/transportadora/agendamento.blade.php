@extends('layouts.form-principal',  ['tag' => '2'])

@section('css')../../css/agendamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form panel-reduzido">

        <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTO DE CARREGAMENTO</b> </h4>

        <?php
            $old = null;

            if(session()->has('agendamento'))
                $old = json_decode(session()->get('agendamento'));
        ?>

        

        <form action="{{ route('transportadora.carregamento.validar')}}" enctype="multipart/form-data" method="post" id="formAgendamento">
            <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4 col-12">
                    <h5 class="title">Nº Pedido</h5>
                    <input type="text" 
                            name="num_pedido" 
                            id="num_pedido"
                            class="form-control"
                            required>
                </div>

                <div class="col-sm-8 col-12">
                    <h5 class="title">Produto</h5>
                    <input type="text" 
                            name="produto"
                            id="produto"
                            class="form-control"
                            required>
                </div>
            </div>

            <hr>
                <input type="hidden" id="saldo_disponivel" name="saldo_disponivel">
                <input type="hidden" id="cod_produto" name="cod_produto">
                <input type="hidden" name="cod_transportadora" id="cod_transportadora" value="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}">
                <input type="hidden" name="cod_cliente" id="cod_cliente">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="title">Data</label>

                        <input
                            name="data_agendamento"
                            id="data_agendamento"
                            min='<?php echo date("Y-m-d"); ?>'
                            type="date"
                            value='<?php if($old != null){echo $old->data_agendamento;} else {echo date("Y-m-d", strtotime("+1 day"));}?>'
                            class="form-control"
                            required
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
                               value="@if($old != null) {{$old->quantidade}} @endif"
                               required
                        >

                        <div class="invalid-feedback" id="invalid-quantidade">
                            Quantidade não disponível
                        </div>
                    </div>
                </div>

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
                                           value="@if($old != null) {{$old->placa_cavalo}} @endif"
                                           class="form-control"
                                           style="text-transform: uppercase"
                                           maxlength="7"
                                           minlength="7"
                                           onkeypress="return semEspeciais(event)"
                                           required
                                    >
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Placa da Carreta</label>

                                    <input id="placa_carreta"
                                           type="text"
                                           name="placa_carreta"
                                           value="@if($old != null) {{$old->placa_carreta}} @endif"
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
                                <div class="form-group col-sm-12">
                                    <label class="title">Tipo do Veículo</label>

                                    <select id="tipo_veiculo"
                                            class="form-control"
                                            name="tipo_veiculo[]"
                                            required
                                    >
                                        <?php
                                            $tipo_veiculo = null;

                                           if($old != null)
                                               $tipo_veiculo = json_decode($old->tipo_veiculo[0]);
                                        ?>

                                        @foreach($tipos as $tipo)
                                            <option value='{"id": {{$tipo->CODIGO}}, "carga": {{$tipo->CARGA_MAXIMA}}}'
                                                    @if($tipo_veiculo != null)
                                                        @if($tipo_veiculo->id == $tipo->CODIGO)
                                                            selected
                                                        @endif
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
                                           value="@if($old != null) {{$old->tara}} @endif"
                                           class="form-control peso"
                                           required
                                    >
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Renavam</label>

                                    <input id="renavam"
                                           type="text"
                                           name="renavam"
                                           value="@if($old != null) {{$old->renavam}} @endif"
                                           class="form-control"
                                           maxlength="11"
                                           minlength="11"
                                           onkeypress="somenteNumeros(event)"
                                    >
                                </div>
                            </div>
                        </fieldset>
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
                                           value="@if($old != null) {{$old->cpf_motorista}} @endif"
                                           class="form-control"
                                           required
                                    >
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Nome</label>

                                    <input id="nome_motorista"
                                           type="text"
                                           name="nome_motorista"
                                           value="@if($old != null) {{$old->nome_motorista}} @endif"
                                           class="form-control"
                                           required
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="title">CNH</label>

                                    <input id="cnh"
                                           type="text"
                                           name="cnh"
                                           value="@if($old != null) {{$old->cnh}} @endif"
                                           class="form-control"
                                           minlength="11"
                                           maxlength="11"
                                           onkeypress="return somenteNumeros(event)"
                                           required
                                    >
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="title">Validade da CNH</label>

                                    <input
                                        id="validade_cnh"
                                        name="validade_cnh"
                                        value="<?php if($old != null) echo $old->validade_cnh ?>"
                                        type="date"
                                        class="form-control"
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
                                <option value="{{$embalagem->CODIGO}}"
                                    @if($old != null)
                                        @if($old->tipo_embalagem == $embalagem->CODIGO)
                                            selected
                                        @endif
                                    @endif
                                >{{$embalagem->TIPO_EMBALAGEM}}</option>
                            @endforeach
                        </select>
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
                                    >@if($old != null) {{$old->observacao}} @endif</textarea>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-success btn-lg btn-block" style="margin-bottom: 0">
                            <i class="fas fa-arrow-right"></i> Avançar
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <a href="{{route('transportadora.operacao')}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </a>
            </div>
        </div>

    </div>
@stop

@section('js')../../js/agendamento_transportadora.js @endsection

