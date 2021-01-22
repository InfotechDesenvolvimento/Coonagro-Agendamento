@extends('layouts.form-principal', ['tag' => '3'])

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">

        <div class="container panel-form panel-reduzido">
            @if(isset($erro))
                <div class="alert alert-danger" role="alert">
                    {{ $erro }}
                </div>
            @endif

            <h4 style="padding: 30px; color: #63950A"> <b>TIPO DE OPERAÇÃO</b> </h4>

            <a href="{{route('transportadora.agendamento')}}">
                <button class="btn btn-info btn-lg btn-block">
                    <b><i class="fas fa-truck-loading"></i> Carregamento </b>
                </button>
            </a>
            <button class="btn btn-warning btn-lg btn-block">
                <b> <i class="fas fa-hand-point-right"></i> Outros </b>
            </button>

            <hr>
            <a href="{{route('transportadora.home')}}">
                <button class="btn btn-success btn-lg btn-block back">
                    <b> <i class="fas fa-arrow-left"></i> Voltar </b>
                </button>
            </a>
        </div>
    </div>
@stop

