@extends('layouts.form-principal',  ['tag' => '1'])

@section('css') ../css/carregamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>
    
    <div class="container panel-form">
        @if(isset($_GET['msg']))
            <br>
            <div class="alert alert-warning" role="alert">
                {{$_GET['msg']}}
            </div>
        @endif

        <h4 style="padding: 30px; color: #63950A"> <b>PEDIDOS VINCULADOS À TRANSPORTADORAS</b> </h4>
        
        <form action="{{route('administrador.filtrar_alteracoes')}}">
            <div class="row">
                <div class="col-4">
                    <label>Transportadora:</label>
                    <select id="transportadora"
                            name="transportadora"
                            class="form-control"
                        >
                        <option value="0">TODOS</option>
                        @foreach($transportadoras as $t)
                            <option value="{{$t->COD_TRANSPORTADORA}}">{{$t->TRANSPORTADORA}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label>Nº Pedido:</label>
                    <input type="text" name="num_pedido" class="form-control">
                </div>
                <div class="col-4">
                    <label>Cliente</label>
                    <select id="cliente"
                            name="cliente"
                            class="form-control"
                        >
                        <option value="0">TODOS</option>
                        @foreach($clientes as $c)
                            <option value="{{$c->CODIGO}}">{{$c->NOME}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <label>Data:</label>
                    <input type="date" name="data" class="form-control">
                </div>
                
                <div class="col-4">
                    <label>Produto:</label>
                    <select id="produto"
                            name="produto"
                            class="form-control"
                        >
                        <option value="0">TODOS</option>
                        @foreach($produtos as $p)
                            <option value="{{$p->CODIGO}}">{{$p->DESCRICAO}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-4">
                    <br>
                    <button class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <br>
        <div class="table-responsive">
            <table id="table" class="table table-striped" style="width: 100%">
                <thead>
                    <th>Data</th>   
                    <th>Quantidade (T)</th>
                    <th>Produto</th>
                    <th>Nº Pedido</th>
                    <th>Placa Veículo</th>
                    <th>Transportadora</th>
                    <th>Cliente</th>
                    <th>Data de Alteracao</th>
                    <th>Hora de Alteracao</th>
                    <th>Ver Alteração</th>
                </thead>
                <tbody>
                    @if(count($alteracoes) == 0)
                        <tr>
                            <td colspan="10">Nenhuma alteração solicitada!</td>
                        </tr>
                    @else
                        @foreach($alteracoes as $alteracao)
                            <tr>
                                <td>{{date_format(date_create($alteracao->DATA_AGENDAMENTO), 'd/m/Y')}}</td>
                                <td>{{$alteracao->QUANTIDADE}}</td>
                                <td>{{$alteracao->produto->DESCRICAO}}</td>
                                <td>{{$alteracao->NUM_PEDIDO}}</td>
                                <td>{{$alteracao->PLACA_VEICULO}}</td>
                                <td>{{$alteracao->TRANSPORTADORA}}</td>
                                <td>{{$alteracao->cliente->NOME}}</td>
                                <td>{{date_format(date_create($alteracao->DATA_ALTERACAO), 'd/m/Y')}}</td>
                                <td>{{$alteracao->HORA_ALTERACAO}}</td>
                                <td>
                                    <a href="visualizar_alteracao/{{$alteracao->CODIGO}}" target="_blank">
                                        <i class="fas fa-arrow-alt-circle-right" title="Visualizar alteração" style="cursor: pointer; color: #545b62"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <a id="voltar" href="{{route('administrador.home')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </a>
    </div>
    @section('js')../js/visualizar_vinculados_adm.js @endsection
@stop

