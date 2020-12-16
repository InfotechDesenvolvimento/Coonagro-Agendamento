@extends('layouts.form-principal',  ['tag' => '2'])

@section('css') ../css/carregamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>
    
    <div class="container panel-form">
        @if(isset($msg))
            <br>
            <div class="alert alert-warning" role="alert">
                {{$msg}}
            </div>
        @endif

        <h4 style="padding: 30px; color: #63950A"> <b>PEDIDOS LIBERADOS PARA AGENDAMENTO</b> </h4>
        
        <form action="{{route('transportadora.pedidos_vinculados_filtrar')}}">
            <div class="row">
                <div class="col-4">
                    <label>Transportadora:</label>
                    <select id="transportadora"
                            name="transportadora"
                            class="form-control"
                        >
                        <option value="0">TODOS</option>
                        @foreach($transportadoras as $t)
                            <option value="{{$t->CODIGO}}">{{$t->NOME}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-4">
                    <label>Nº Pedido:</label>
                    <input type="text" name="num_pedido" class="form-control">
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
                    <button class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <br>
        <div class="table-responsive">
            <table id="table" class="table table-striped" style="width: 100%">
                <thead>
                    <th>Nº Pedido</th>
                    <th>Produto</th>
                    <th>Cliente</th>
                    <th>Limite Quantidade</th>
                    <th>Data</th>
                </thead>
                <tbody>
                    @if(count($pedidos) == 0)
                        <tr>
                            <td colspan="4">Nenhum pedido em aberto</td>
                        </tr>
                    @else
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{$pedido->NUM_PEDIDO}}</td>
                                <td>{{$pedido->produto->DESCRICAO}}</td>
                                <td>{{$pedido->cliente->NOME}}</td>
                                <td>{{$pedido->COTA}}</td>
                                @if($pedido->DATA != null)
                                    <td>{{date_format(date_create($pedido->DATA), 'd/m/Y')}}</td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <a href="{{route('transportadora.home')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </a>
    </div>
@stop

