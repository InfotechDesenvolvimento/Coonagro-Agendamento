@extends('form-principal')

@section('conteudo')
<div class="col-12">
<div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 580px;background: #E8E8E8;">
  <h4 style="padding: 30px; color: #63950A; font-family: 'Roboto"> <b>FORMULÁRIO AGENDAMENTO<b> </h4>
  <form action="{{ action('FormController@validationSaldoProduct') }}" method="post">
    <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">

<div class="form-group">
  <div style="text-align: left">
    <label>Produtos:</label>
  </div>
  <div class="mb-3">
      <select name="cod_product" class="custom-select" required>
        <option selected value=""> Selecione um produto </option>
        @foreach($produtos as $produto)
          <option value="{{ $produto->CODIGO}}"> {{ $produto->DESCRICAO }}</option>
        @endforeach
      </select>
    </div>
  <button type="submit" class="btn btn-success btn-lg btn-block"> <b> <i class="fas fa-arrow-circle-right"></i> AVANÇAR </b> </button></form>
</div></div>
@stop
