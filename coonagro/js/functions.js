
  function validateLimite(valorDigitado, valorMaximo){
    var $valor_maximo = valorMaximo;
    var $valor_informado = valorDigitado;

    if($valor_informado > $valor_maximo){
      document.getElementById('qtdeInformada').value = $valor_maximo;
    }
  }

  function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	     else  return false;
    }
  }

  function noPasteCaracterQtd(){

    setTimeout(function () {
      var val_informado = document.getElementById("qtdeInformada").value;

      if(val_informado.match(/^[0-9]*$/) === null){
        document.getElementById("qtdeInformada").value = "";
      }
    },100);
  }

  function noPasteCaracterCpfTransport(){

    setTimeout(function () {
      var val_informado = document.getElementById("cpf_transportador").value;

      if(val_informado.match(/^[0-9]*$/) === null){
        document.getElementById("cpf_transportador").value = "";
      }
    },100);
  }

  function noPasteCaracterTara(){

    setTimeout(function () {
      var val_informado = document.getElementById("tara").value;

      if(val_informado.match(/^[0-9]*$/) === null){
        document.getElementById("tara").value = "";
      }
    },100);
  }

  function noPasteCaracterCnhTransport(){

    setTimeout(function () {
      var val_informado = document.getElementById("cnh_transport").value;

      if(val_informado.match(/^[0-9]*$/) === null){
        document.getElementById("cnh_transport").value = "";
      }
    },100);
  }

  function lettersOnly(evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
        ((evt.which) ? evt.which : 0));
    if (charCode > 31 && (charCode < 65 || charCode > 90) &&
        (charCode < 97 || charCode > 122)) {
        return false;
    }
    return true;
  }
