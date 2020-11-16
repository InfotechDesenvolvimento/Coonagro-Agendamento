@extends('layouts.form-principal', ['tag' => '1'])

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">

        <div class="container panel-form panel-reduzido">
            <h4 style="padding: 30px; color: #63950A"> <b>TIPO DE OPERAÇÃO</b> </h4>

            <a href="{{route('cliente.carregamento')}}">
                <button class="btn btn-success btn-lg btn-block btn2">
                    <b><i class="fas fa-truck-loading"></i> Carregamento </b>
                </button>
            </a>
            <button class="btn btn-success btn-lg btn-block btn1">
                <b> <i class="fas fa-hand-point-right"></i> Outros </b>
            </button>

            <hr>
            <a href="{{route('cliente.home')}}">
                <button class="btn btn-success btn-lg btn-block back">
                    <b> <i class="fas fa-arrow-left"></i> Voltar </b>
                </button>
            </a>
        </div>
    </div>
@stop

