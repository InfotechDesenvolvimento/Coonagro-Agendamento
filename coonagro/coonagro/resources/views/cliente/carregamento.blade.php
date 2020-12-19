@extends('layouts.form-principal',  ['tag' => '1'])

@section('css') ../css/carregamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="container panel-form">
        <h4 style="padding: 30px; color: #63950A"> <b>PEDIDOS EM ABERTO</b> </h4>

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
                                <td>{{ number_format($pedido->TOTAL - $pedido->TOTAL_AGENDADO, 3, ',', '.') }}</td>
                                <td class="agendamento">
                                    <a href="{{route('cliente.agendamento', $pedido->NUM_PEDIDO)}}" title="Realizar Agendamento">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <a href="{{route('cliente.operacao')}}">
                    <button class="btn btn-success btn-lg btn-block back">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </a>
            </div>
        </div>

    </div>
@stop

