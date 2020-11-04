@extends('layouts.form-principal')

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">
        <div class="container panel-form panel-reduzido">
            <h4 style="padding: 30px; color: #63950A"> <b>AGENDAMENTOS</b> </h4>

            <a href="{{route('cliente.operacao')}}"><button class="btn btn-success btn-lg btn-block btn1">
                <b><i class="far fa-calendar-plus"></i> Novo </b>
                </button>
            </a>
            <button class="btn btn-success btn-lg btn-block btn2"> <b> <i class="fas fa-search"></i> Consultar </b> </button>
        </div>
    </div>
@stop

