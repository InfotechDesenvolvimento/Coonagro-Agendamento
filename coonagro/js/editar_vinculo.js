let invalida_quantidade = false;
let invalida_cota = false;

cliente = $('#cod_cliente').val();
data = $('#data').val();

$.getJSON('../../api/cota/' + cliente + '/' + data, function (data) {
    saldo_livre = data.SALDO_LIVRE;
    total_agendado = data.TOTAL_AGENDADO;
    cota_disponivel = saldo_livre - total_agendado;
    $('#cota_disponivel').val(cota_disponivel);
});

$(document).ready(function () {
    $(".peso").maskMoney({symbol:'R$ ',
        showSymbol:true, thousands:'.', decimal:',', symbolStay: true
    });

    $('#vincular').click(function(){ 
        
    });
});

let options = {
    onKeyPress: function (cpf, ev, el, op) {
        let masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('#cnpj_transportadora').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
};

$('#quantidade').keyup(function () {
    let quantidade = $('#quantidade').val();
    let p_saldo_disponivel = $('#pedido_saldo_disponivel').val();
    let cota_cliente = $('#cota_disponivel').val();
    if(quantidade.length > 0){
        quantidade = formatarValor(quantidade);
        quantidade = parseFloat(quantidade);
        p_saldo_disponivel = parseFloat(p_saldo_disponivel);
        if(quantidade > cota_cliente && quantidade > p_saldo_disponivel) {
            $('#invalid-cota').css('display', 'block');
            invalida_cota = true;
            $('#invalid-quantidade').css('display', 'block');
            $(this).addClass('invalido');
            $('#vincular').attr('disabled', true);
            invalid_quantidade = true;
        } else if(quantidade > cota_cliente) {
            $('#invalid-cota').css('display', 'block');
            $(this).addClass('invalido');
            invalida_cota = true;
            $('#vincular').attr('disabled', true);
        } else if(quantidade > p_saldo_disponivel) {
            $('#invalid-quantidade').css('display', 'block');
            $(this).addClass('invalido');
            invalida_quantidade = true;
            $('#vincular').attr('disabled', true);
        }  else {
            $('#invalid-quantidade').css('display', 'none');
            invalida_quantidade = false;
            $('#invalid-cota').css('display', 'none');
            invalida_cota = false;
            $(this).removeClass('invalido');
            $('#vincular').attr('disabled', false);
        }
    } else {
        $('#invalid-quantidade').css('display', 'none');
        invalida_quantidade = false;
        $('#invalid-cota').css('display', 'none');
        invalida_cota = false;
        $(this).removeClass('invalido');
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
    novo = novo.replace(',', '');
    novo = novo / 100;

    return novo;
}

