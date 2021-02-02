@extends('layouts.form-principal',  ['tag' => '1'])

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

        <h4 style="padding: 30px; color: #63950A"> <b>VINCULAR PEDIDOS À TRANSPORTADORAS</b> </h4>

        <form action="{{route('administrador.filtrar_pedidos_vincular')}}">
            <div class="row">
                <div class="col-6">
                    <label>Nº Pedido:</label>
                    <input type="text" name="num_pedido" class="form-control">
                </div>
                <div class="col-4">
                    <br>
                    <button class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table id="table" class="table table-striped" style="width: 100%">
                <thead>
                    <th>Nº Pedido</th>
                    <th>Produto</th>
                    <th>Saldo (T)</th>
                    <th>Cliente </th>
                    <th>Vincular</th>
                    <th>Vincular com Data/Limite</th>
                </thead>
                <tbody>
                    @if(count($pedidos) == 0)
                        <tr>
                            <td colspan="5">Nenhum pedido em aberto</td>
                        </tr>
                    @else
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{$pedido->NUM_PEDIDO}}</td>
                                <td>{{$pedido->produto->DESCRICAO}}</td>
                                <td>{{number_format($pedido->TOTAL - $pedido->TOTAL_AGENDADO, 3, ',', '.')}}</td>
                                <td>{{$pedido->cliente->NOME}}</td>
                                <td>
                                    <a href="{{route('administrador.vincular_pedido_transportadora_comum', $pedido->NUM_PEDIDO)}}" title="Vincular pedido">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('administrador.vincular_pedido_transportadora', $pedido->NUM_PEDIDO)}}" title="Vincular pedido">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <a href="{{route('administrador.home')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </a>
    </div>
@stop

@section('js')../js/agendamento.js @endsection

