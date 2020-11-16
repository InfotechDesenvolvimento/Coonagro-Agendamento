@extends('layouts.form-principal')

@section('conteudo')
<div class="col-12" >
  <div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 550px; background: #E8E8E8">
    <h4 style="text-align:center;margin-top: 50px; color:red"> <b>ERRO - AGENDAMENTO JÁ REALIZADO<b> <i class="fas fa-times"></i>  <h4  ><br>
    <a style="text-decoration:none;" href="{{ url('/') }}"> <button style="margin-top: 7px; font-size: 17px" type="button" class="btn btn-primary btn-lg btn-block"> <i class="fas fa-plus-circle"></i> NOVO AGENDAMENTO </b></button> </a>
  </div>
</div>

@stop
