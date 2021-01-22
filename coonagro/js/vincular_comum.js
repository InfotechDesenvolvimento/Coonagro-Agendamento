$(document).ready(function () {
    $('#cnpj_transportadora').length > 11 ?
        $('#cnpj_transportadora').mask('00.000.000/0000-00', options) :
        $('#cnpj_transportadora').mask('000.000.000-00#', options);
});

let options = {
    onKeyPress: function (cpf, ev, el, op) {
        let masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('#cnpj_transportadora').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
};

$('#cnpj_transportadora').focusout(function () {
    let identificacao = retirarEspeciais($('#cnpj_transportadora').val());

    if(identificacao.length >= 11){
        $.getJSON('../../api/transportadora/' + identificacao, function (data) {
            if(data.NOME != null){
                $('#transportadora').val(data.NOME);
                $('#vincular').attr('disabled', false);
                $('#invalid-transportadora').css('display', 'none');
                $('#cod_transportadora').val(data.CODIGO);
            } else {
                $('#transportadora').val('');
                $('#vincular').attr('disabled', true);
                $('#invalid-transportadora').css('display', 'block');
                $('#cod_transportadora').val('');
            }
        });
    }
});

function retirarEspeciais(value) {
    value = value.replaceAll('.', '');
    value = value.replaceAll('-', '');
    value = value.replaceAll('/', '');

    return value;
}

function somenteNumeros(event) {
    let charCode = event.charCode ? event.charCode : event.keyCode;

    if (charCode !== 8 && charCode !== 9) { // charCode 8 = backspace charCode 9 = tab
        if (charCode < 48 || charCode > 57) { //charCode 48 equivale a 0 charCode 57 equivale a 9
            return false;
        }
    }
}

function semEspeciais(event) {
    let charCode = event.charCode ? event.charCode : event.keyCode;

    if(charCode === 8 || charCode === 9 || (charCode >= 33 && charCode <= 47) || (charCode >= 58 && charCode <= 63) ||
        (charCode >= 91 && charCode <= 96)){
        return false;
    }
}

function formatarValor(valor) {
    let novo = valor.replace('.', '');
    novo = novo.replace(',', '.');

    return novo;
}
