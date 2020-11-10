let invalida_quantidade = false;
let invalida_carga = false;
let invalida_data = false;

$(document).ready(function () {
    $(".peso").maskMoney({symbol:'R$ ',
        showSymbol:true, thousands:'.', decimal:',', symbolStay: true
    });

    $('#cnpj_transportadora').length > 11 ?
        $('#cnpj_transportadora').mask('00.000.000/0000-00', options) :
        $('#cnpj_transportadora').mask('000.000.000-00#', options);

    $('#cpf_motorista').mask('000.000.000-00');
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
        $.getJSON('/api/transportadora/' + identificacao, function (data) {
            if(data){
                $('#transportadora').val(data.NOME);
            }
        });
    }
});

$('#placa_cavalo').focusout(function () {
    let placa = retirarEspeciais($('#placa_cavalo').val());

    if(placa.length >= 7){
        $.getJSON('/api/veiculo/' + placa, function (data) {
            $('#renavam').val(data.RENAVAM);
            $('#placa_carreta').val(data.PLACA_CARRETA);

            let tara = data.TARA;
            tara = parseFloat(tara);

                if(tara > 0)
                    $('#tara').val(tara.toLocaleString('pt-br', {minimumFractionDigits: 2}));

            let tipo_veiculo = data.COD_TIPO_VEICULO;

            if(tipo_veiculo > 0) {
                document.getElementById('tipo_veiculo').value = `{"id": ${tipo_veiculo}, "carga": ${data.tipo_veiculo.CARGA_MAXIMA}}`;
            }
        });
    }
});

$('#cpf_motorista').focusout(function () {
   let cpf_motorista = $('#cpf_motorista').val();

   if(cpf_motorista.length >= 11){
        $.getJSON('/api/motorista/' + cpf_motorista, function (data) {
            $('#nome_motorista').val(data.NOME);
            $('#cnh').val(data.CNH);
            $('#validade_cnh').val(data.DATA_VALIDADE_CNH)
        });
   }
});

$('#quantidade').keyup(function () {
    let quantidade = $(this).val();
    let saldo_disponivel = $('#saldo_disponivel').val();

        if(quantidade.length > 0){
            quantidade = formatarValor(quantidade);

            quantidade = parseFloat(quantidade);
            saldo_disponivel = parseFloat(saldo_disponivel);

            if(quantidade > saldo_disponivel){
                $('#invalid-quantidade').css('display', 'block');
                $(this).addClass('invalido');

                invalida_quantidade = true;
            } else {
                $('#invalid-quantidade').css('display', 'none');
                $(this).removeClass('invalido');

                invalida_quantidade = false;
            }

            let tipo_veiculo = $('#tipo_veiculo').val();

            tipo_veiculo = JSON.parse(`${tipo_veiculo}`);

            if (tipo_veiculo.id > 0){
                verificarTipoVeiculo(tipo_veiculo.carga);
            }
        } else {
            $('#invalid-quantidade').css('display', 'none');
            $(this).removeClass('invalido');

            invalida_quantidade = false;
        }
});

$('#tipo_veiculo').change(function () {
    let tipo_veiculo = $(this).val();

    tipo_veiculo = JSON.parse(`${tipo_veiculo}`);

    if (tipo_veiculo.id > 0){
        verificarTipoVeiculo(tipo_veiculo.carga);

        $('#tipo_veiculo_id').val(tipo_veiculo.id);
    }
});

$('#data_agendamento').change(function () {
    let data = $(this).val();

    let parts = data.split('-');
    data = new Date(parts[0], parts[1] - 1, parts[2]);

    let data_atual = new Date();

    if((data.getDate() === data_atual.getDate()) && (data.getMonth() === data_atual.getMonth()) &&
        (data.getFullYear() === data_atual.getFullYear())){

        if(data_atual.getHours() >= 17){
            $('#invalid-data').css('display', 'block');
            $('#data_agendamento').addClass('invalido');
        } else {
            $('#invalid-data').css('display', 'none');
            $('#data_agendamento').removeClass('invalido');
        }
    } else {
        $('#invalid-data').css('display', 'none');
        $('#data_agendamento').removeClass('invalido');
    }
});

function verificarTipoVeiculo(valor) {
    let carga = parseFloat(valor);
    let quantidade = $('#quantidade').val();

    if (quantidade.length > 0) {
        quantidade = parseFloat(quantidade);

        if(quantidade > carga){
            $('#invalid-carga').css('display', 'block');
            $('#tipo_veiculo').addClass('invalido');

            invalida_carga = true;
        } else {
            $('#invalid-carga').css('display', 'none');
            $('#tipo_veiculo').removeClass('invalido');

            invalida_carga = false;
        }
    } else {
        $('#invalid-carga').css('display', 'none');
        $('#tipo_veiculo').removeClass('invalido');

        invalida_carga = false;
    }
}

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

