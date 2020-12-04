@extends('layouts.form-principal',  ['tag' => '2'])

@section('css')../css/configuracoes.css @endsection

@section('conteudo')
    <?php date_default_timezone_set('America/Sao_Paulo');  ?>

    <div class="col-12">
        <div class="container panel-form panel-reduzido">
            <h4 style="padding: 30px; color: #63950A"> <b>CONFIGURAÇÕES</b> </h4>

            <form method="POST" action="{{ route('cliente.alterar_dados') }}">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <label>Alterar E-mail</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
                <br>
                <label>Alterar Senha</label>
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
                <br>
                <button class="btn btn-success" >Alterar</button>
            </form>

            <div class="row  justify-content-end">
                <div class="col-sm-6">
                    <a href="{{route('logout')}}">
                        <button class="btn btn-danger">Sair</button>
                    </a>
                    <a href="{{route('cliente.home')}}">
                        <button class="btn btn-info">Agendamentos</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')../js/configuracoes.js @endsection

