@extends('form-principal')

@section('conteudo')

@if(isset($error))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-circle"></i> Quantidade inválida!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="col-12">
  <div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 550px; margin-top: 20px; background: #E8E8E8">
    <h4 style="padding: 30px; color: #63950A; font-family: 'Roboto"> <b>FORMULÁRIO AGENDAMENTO<b> </h4>
      <form action="{{ action('FormController@finalizarAgendamento') }}" enctype="multipart/form-data" method="post">

        <input type ="hidden" name="_token" value="{{{ csrf_token()  }}}">
        <input type ="hidden" name="pedido" value="{{{ $pedido }}}" />

        <div class="form-group">

          <div style="text-align: left">
            <label>Quantidade:</label>
          </div>
          <input id="qtdeInformada"
          inputmode="numeric"
          type="text"
          name="qtde"
          class="form-control"
          placeholder="Informe a quantidade"
          onkeyup="validateLimite(this.value, {{$pedido->SALDO_RESTANTE}})"
          onkeypress='return SomenteNumero(event)'
          onpaste="noPasteCaracterQtd(this.value)"
          required>
          <div style="text-align: left">
            <span id="qtde" value="5" style="color: red; font-size: 14px"> Quantidade disponível: {{$pedido->SALDO_RESTANTE}} </span>
          </div> <br>

          <div style="text-align: left">
            <label>Embalagem:</label>
          </div>
          <div class="col-sm-12" style="text-align: left">

            <div style="display:block">

              <div class="custom-control custom-radio">
                <input checked type="radio" id="customRadio3" value="3" name="packing" class="custom-control-input">
                <labeL class="custom-control-label" for="customRadio3">GRANEL</label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio1" value="1" name="packing" class="custom-control-input">
                  <label class="custom-control-label" for="customRadio1">BIG-BAG</label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio2" value="2" name="packing" class="custom-control-input">
                  <labeL class="custom-control-label" for="customRadio2">SACARIA</label>
                  </div>
                </div>

              </div> <br>

              <div style="text-align: left">
                <label>CPF / CNPJ Transportador:</label>
              </div>
              <input
              type="text"
              id="cpf_transportador"
              name="cpf_transportador"
              inputmode="numeric"
              maxlength="14"
              class="form-control"
              placeholder="CPF ou CPNJ do transportador"
              onkeypress='return SomenteNumero(event)'
              onpaste="noPasteCaracterCpfTransport()"
              required> <br>

              <div style="text-align: left">
                <label>Transportadora:</label>
              </div>
              <input onkeyup="lim(this.value)" id="texto" type="text" name="name_transportadora" class="form-control" placeholder="Nome transportadora" required>
              <!-- <span id="cont" style="font-size:10px">50/</span> Restantes <br> -->

              <br>

              <div style="text-align: left">
                <label>Placa do Veículo:</label>
              </div>
              <input type="text" name="placa_veiculo" maxlength="10" class="form-control" placeholder="Placa do veículo" required> <br>

              <div style="text-align: left">
                <label>RENAVAM:</label>
              </div>
              <input type="text" id="rena" name="renavam" maxlength="10" class="form-control" placeholder="Renavam do veículo" required> <br>


              <div style="text-align: left">
                <label>Placa da Carreta 1:</label>
              </div>
              <input type="text" name="placa_carreta1" maxlength="10" class="form-control" placeholder="Placa do carreta 1" required> <br>

              <div style="text-align: left">
                <label>Placa da Carreta 2:</label>
              </div>
              <input type="text" name="placa_carreta2" maxlength="10" class="form-control" placeholder="Placa do carreta 2" required>

              <br>

              <div class="form-group">
                <div style="text-align: left">
                  <label>Tipo de Veículo:</label>
                </div>
                <div class="mb-3">
                  <select name="tipo_veiculo" class="custom-select" required>
                    <option selected value=""> Selecione o tipo do veículo </option>
                    <option value="1">Toco</option>
                    <option value="2">Truck</option>
                    <option value="3">Bi-Truck</option>
                    <option value="4">Carreta Simples</option>
                    <option value="5">Carreta Trucada</option>
                    <option value="6">Carreta LS</option>
                    <option value="7">Carreta LS 4 Eixos</option>
                    <option value="8">Vanderleia</option>
                    <option value="9">Bi-Trem</option>
                    <option value="10">Bi-Trem 4 Eixos</option>
                    <option value="11">Bi-Caçamba</option>
                    <option value="12">Rodotrem</option>
                    <option value="13">Especial</option>
                  </select>
                </div>
              </div>

              <div style="text-align: left">
                <label>Tara do veículo em toneladas:</label>
              </div>
              <input
              type="text"
              id="tara"
              inputmode="numeric"
              name="tara_veiculo"
              maxlength="7" class="form-control"
              placeholder="Tara do veículo"
              onkeypress='return SomenteNumero(event)'
              onpaste="noPasteCaracterTara()"
              required> <br>

              <div style="text-align: left">
                <label>Condutor:</label>
              </div>
              <input
              type="text"
              name="name_condutor"
              class="form-control"
              placeholder="Nome do condutor"
              required> <br>

              <div style="text-align: left">
                <label>CNH do Condutor:</label>
              </div>
              <input
              type="text"
              id="cnh_transport"
              inputmode="numeric"
              name="cpf_condutor"
              class="form-control"
              placeholder="CNH do condutor"
              maxlength="11"
              onkeypress='return SomenteNumero(event)'
              onpaste="noPasteCaracterCnhTransport()"
              required>
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block"> <b> <i class="fas fa-arrow-circle-right"></i> AVANÇAR </b> </button></form>
          </div>
        </div>
        <br>
        <!-- <script type="text/javascript">
        function lim(valor) {
        quant = 50;
        total = valor.length;
        console.log("dpowkopda");
        if(total <= quant) {
        resto = quant - total;
        document.getElementById('cont').innerHTML = resto;
      } else {
      document.getElementById('texto').value = valor.substr(0,quant);
    }}
  </script> -->
  @stop
