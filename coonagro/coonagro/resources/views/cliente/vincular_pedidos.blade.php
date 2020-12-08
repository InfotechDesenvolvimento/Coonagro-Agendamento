@extends('layouts.form-principal',  ['tag' => '2'])

@section('css') ../css/carregamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>
    
    <div class="container panel-form panel-reduzido">
        @if(isset($msg))
            <br>
            <div class="alert alert-warning" role="alert">
                {{$msg}}
            </div>
        @endif

        <h4 style="padding: 30px; color: #63950A"> <b>VINCULAR PEDIDOS À TRANSPORTADORAS</b> </h4>
        
        <a href="{{route('cliente.pedidos_vinculados')}}">
            <button class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-list"></i> Pedidos Vinculados
            </button>
        </a>

        <div class="table-responsive">
            <table id="table" class="table table-striped" style="width: 100%">
                <thead>
                    <th>Nº Pedido</th>
                    <th>Produto</th>
                    <th>Saldo (T)</th>
                    <th>Ação</th>
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
                                <td>{{ number_format($pedido->SALDO_RESTANTE - $pedido->TOTAL_AGENDADO, 3, ',', '.') }}</td>
                                <td class="agendamento">
                                    <a href="{{route('cliente.vincular_pedido_transportadora', $pedido->NUM_PEDIDO)}}" title="Vincular pedido">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <a href="{{route('cliente.home')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </a>
    </div>
@stop

@section('js')../../js/agendamento.js @endsection

