@extends('form-principal')

@section('conteudo')
<?php date_default_timezone_set('America/Sao_Paulo');  ?>

<div class="col-12">

<div class="container" style="text-align:center; border-radius: 15px; max-width: 580px; background: #E8E8E8">
  <h4 style="padding: 30px; color: #63950A"> <b> AGENDAMENTO DE CARREGAMENTO</b> </h4>
  <form action="{{ action('FormController@validationNumPedido') }}" method="post">
    <input type ="hidden" name="_token" value="{{{ csrf_token() }}}">

    <div class="form-group">
      <div style="text-align: left">
          <label><b>Data do Agendamento:</b></label>
      </div>
      <input
        name="data_agendamento"
        min='<?php echo date("Y-m-d"); ?>'
        type="date"
        value='<?php echo date("Y-m-d", strtotime("+1 day")); ?>'
        class="form-control">
      <br>

      <div style="text-align: left">
          <label><b>Número do pedido:</b></label>
      </div>
      <input
        id="num_pedido"
        inputmode="numeric"
        type="text"
        name="num_pedido"
        class="form-control"
        maxlength="8"
        placeholder="Informe o número do pedido"
        onkeypress='return SomenteNumero(event)'
        onpaste="noPasteCaracterNumPedido(this.value)"
        >

      @if(isset($error))
        <div style="text-align: left">
          <span style="color: red; font-size: 14px"> Número do pedido inválido! </span>
        </div>
      @endif
    </div>

    <button type="submit" class="btn btn-success btn-lg btn-block"> <b> <i class="fas fa-arrow-circle-right"></i> AVANÇAR </b> </button></form>
  </form> <br>

  <hr>
  <a href="{{route('outros')}}" class="btn btn-success btn-lg btn-block" id="outras"> <b> <i class="fas fa-hand-point-right"></i> OUTRAS OPERAÇÕES </b> </a>
</div>
</div>

<script>
function SomenteNumero(e){
  var tecla=(window.event)?event.keyCode:e.which;
  if((tecla>47 && tecla<58)) return true;
  else{
    if (tecla==8 || tecla==0) return true;
     else  return false;
  }
}

function noPasteCaracterNumPedido(){

  setTimeout(function () {
    var val_informado = document.getElementById("num_pedido").value;
    console.log(val_informado);

    if(val_informado.match(/^[0-9]*$/) === null){
      document.getElementById("num_pedido").value = "";
    }
  },100);
}
</script>

@stop
