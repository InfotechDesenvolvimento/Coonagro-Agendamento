@extends('layouts.form-principal',  ['tag' => '2'])

@section('css') ../../css/carregamento.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>
    
    <div class="container panel-form">
        @if(isset($msg))
            <br>
            <div class="alert alert-warning" role="alert">
                {{$msg}}
            </div>
        @endif

        <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTOS</b> </h4>
        <form method="POST" action="{{route('administrador.total_agendado_cliente_filtrar')}}">
            <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">
            <div class="row">
                <div class="col-6">
                    <input type="date" name="data_agendamento" class="form-control">
                </div>
                <div class="col-6">
                    <button class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table id="table" class="table table-striped" style="width: 100%">
                <thead>
                    <th>Cliente</th>
                    <th>Total Agendado (T)</th>
                </thead>
                <tbody>
                    @foreach($agendamentos as $agendamento)
                        @if($agendamento->CLIENTE == null)
                            <?php $total_agendado = $total_agendado - $agendamento->TOTAL; ?>
                        @else
                            <tr>
                                <td>{{$agendamento->CLIENTE}}</td>
                                <td>{{$agendamento->TOTAL}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            
            <h4 style="padding: 30px; color: #63950A">TOTAL AGENDADO: {{$total_agendado}}t</h4>
        </div>
        <a href="{{route('administrador.home')}}">
            <button class="btn btn-success btn-lg btn-block back">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </a>
    </div>
@stop

