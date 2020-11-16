@extends('layouts.form-principal',  ['tag' => '3'])

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">
        <div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 750px; margin-top: 20px; background: #E8E8E8">
            <h2 style="text-align:center;margin-top: 50px; color:green">
                <b>AGENDAMENTO REALIZADO COM SUCESSO</b>
                <i class="fas fa-check-circle"></i>
            </h2>

            <br>
            <a style="text-decoration:none;" href="{{route('carregamento.imprimir', $cod_agendamento)}}" target="_blank">
                <button style="margin-top: 7px; font-size: 17px" type="button" class="btn btn-primary btn-lg btn-block">
                    <i class="fas fa-print"></i> <b>IMPRIMIR AGENDAMENTO</b>
                </button>
            </a>
            <a style="text-decoration:none;" href="{{ route('cliente.operacao')  }}">
                <button style="margin-top: 7px; font-size: 17px" type="button" class="btn btn-warning btn-lg btn-block">
                    <i class="fas fa-plus-circle"></i> <b>NOVO AGENDAMENTO </b>
                </button>
            </a>
        </div>
    </div>

@endsection
