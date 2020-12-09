@extends('layouts.form-principal')

@section('css')css/home.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">
        <div class="container panel-form">
            <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTOS</b> </h4>
            
            <a href="{{route('cliente.operacao')}}"><button class="btn btn-primary btn-lg btn-block">
                    <b><i class="far fa-calendar-plus"></i> Novo </b>
                </button> 
            </a>

            <a href="{{route('cliente.vincular_pedidos')}}">
                <button class="btn btn-primary btn-lg btn-block">
                    <b><i class="fas fa-boxes"></i> Vincular Pedidos em Transportadoras </b>
                </button>
            </a>

            <div id="formConsulta">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Nº Agendamento</label>
                        <input type="text"
                               class="form-control"
                               id="num_agendamento"
                        >
                    </div>
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Status</label>
                        <select id="status"
                                class="form-control"
                        >
                            <option value="0">TODOS</option>
                            @foreach($status as $s)
                                <option value="{{$s->CODIGO}}">{{$s->STATUS}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>(De)</label>
                        <input
                            type="date"
                            class="form-control"
                            id="data_inicial"
                        >
                    </div>

                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>(Até)</label>
                        <input
                            type="date"
                            class="form-control"
                            id="data_final"
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <button class="btn btn-warning" id="filtrar">
                            <i class="fas fa-search mr-3"></i>
                            Filtrar
                        </button>
                    </div>

                    <div class="col-sm-6 form-group">
                        <button class="btn btn-info" id="limpar">
                            <i class="fas fa-eraser mr-3"></i>
                            Limpar Campos
                        </button>
                    </div>
                </div>
            </div>

            <div class="tabela">
                <table id="table" class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th style="width: 10px !important;">Nº</th>
                            <th style="width: 40px !important;">Ações</th>
                            <th>Status</th>
                            <th style="width: 80px !important;">Data</th>
                            <th style="width: 110px !important;">Quantidade (T)</th>
                            <th>Nº Pedido</th>
                            <th>Placa Veículo</th>
                            <th>Placa Carreta 1</th>
                            <th>Placa Carreta 2</th>
                            <th>Transportadora</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="row  justify-content-end">
                <div class="col-sm-6">
                    <a href="{{route('cliente.configuracoes')}}">
                        <button class="btn btn-info">Configurações</button>
                    </a>
                    <a href="{{route('logout')}}">
                        <button class="btn btn-danger">Sair</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')js/home.js @endsection

@section('bloco-js')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
@endsection

