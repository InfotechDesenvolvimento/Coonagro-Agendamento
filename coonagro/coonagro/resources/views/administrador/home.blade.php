@extends('layouts.form-principal')

@section('css')css/home.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">
        <div class="container panel-form">
            <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTOS</b> </h4>
            
            <a href="{{route('administrador.vinculos')}}">
                <button class="btn btn-primary btn-lg btn-block">
                    <b><i class="fas fa-boxes"></i> Vínculos Transportadora/Pedido </b>
                </button>
            </a>

            <a href="{{route('administrador.pedidos')}}">
                <button class="btn btn-primary btn-lg btn-block">
                    <b><i class="fas fa-box"></i> Pedidos </b>
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
                        <label>Nº Pedido</label>
                        <input type="text"
                            class="form-control"
                            id="num_pedido"
                        >
                    </div>
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Transportadora</label>
                        <input type="text"
                            class="form-control"
                            id="transportadora"
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Placa veículo</label>
                        <input type="text"
                            class="form-control"
                            id="placa_veiculo"
                        >
                    </div>
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Placa carreta 1</label>
                        <input type="text"
                            class="form-control"
                            id="placa_carreta"
                        >
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>(De)</label>
                        <input
                            type="date"
                            class="form-control"
                            id="data_inicial"
                            max="{{date('Y-m-d')}}"
                        >
                    </div>

                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>(Até)</label>
                        <input
                            type="date"
                            class="form-control"
                            id="data_final"
                            min="{{date('Y-m-d')}}"
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Data específica</label>
                        <input
                            type="date"
                            class="form-control"
                            id="data_especifica"
                        >
                    </div>
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Produto</label>
                        <select id="produto"
                                class="form-control"
                        >
                            <option value="0">TODOS</option>
                            @foreach($produtos as $p)
                                <option value="{{$p->CODIGO}}">{{$p->DESCRICAO}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-12 form-group">
                        <label>Cliente</label>
                        <select id="cliente"
                                class="form-control"
                        >
                            <option value="0">TODOS</option>
                            @foreach($clientes as $c)
                                <option value="{{$c->CODIGO}}">{{$c->NOME}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <button class="btn btn-warning" id="filtrar_administrador">
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
            
            <a href="{{route('administrador.total_agendado_transportadoras')}}">
                <button class="btn btn-primary btn-lg btn-block">
                    <b><i class="fas fa-cubes"></i> Total Agendado por Transportadoras </b>
                </button>
            </a>
            <br>
            <a href="{{route('administrador.total_agendado_clientes')}}">
                <button class="btn btn-primary btn-lg btn-block">
                    <b><i class="fas fa-cubes"></i> Total Agendado por Cliente </b>
                </button>
            </a>
            <div class="tabela">
                <table id="table" class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Ações</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Quantidade (T)</th>
                            <th>Produto</th>
                            <th>Nº Pedido</th>
                            <th>Placa Veículo</th>
                            <th>Placa Carreta 1</th>
                            <th>Transportadora</th>
                            <th>Cliente</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-sm-6">
                    <a href="{{route('logout')}}">
                        <button class="btn btn-danger">Sair</button>
                    </a>
                    <a href="{{route('administrador.configuracoes')}}">
                        <button class="btn btn-info">Configurações</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')js/home_administrativo.js @endsection

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

