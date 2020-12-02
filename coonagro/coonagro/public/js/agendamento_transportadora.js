let invalida_quantidade = false;
let invalida_carga = false;
let invalida_data = false;
let invalida_cota = false;

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

$('#data_agendamento').focusout(function () {
    verificarCota();
});

$('#quantidade').focusout(function () {
    verificarCota();
});

$('#cnpj_transportadora').focusout(function () {
    let identificacao = retirarEspeciais($('#cnpj_transportadora').val());

    if(identificacao.length >= 11){
        $.getJSON('../../api/transportadora/' + identificacao, function (data) {
            if(data){
                $('#transportadora').val(data.NOME);
            }
        });
    }
});

$('#num_pedido').focusout(function () {
    let num_pedido = $('#num_pedido').val();
    if(num_pedido != '') {
        $.getJSON('../../api/pedido/' + num_pedido, function (data) {
            if(JSON.stringify(data) === '{}'){
                $('#invalid-pedido').css('display', 'block');
                $('#produto').val(null);
                var data = new Date();
                var data1 = new Date(data);
                data1.setDate(data.getDate() + 1);
                var day = ("0" + data1.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                $('#data_agendamento').val(today);
                $('#quantidade').val(null)
                $('#saldo_disponivel').val(null);
            } else {
                if(data.COD_STATUS == 1) {
                    $('#invalid-pedido').css('display', 'none');
                    $('#cod_cliente').val(data.COD_CLIENTE);
                    $('#cod_produto').val(data.COD_PRODUTO);
                    $('#saldo_disponivel').val(data.SALDO_RESTANTE - data.TOTAL_AGENDADO);
                    $.getJSON('../../api/produto/' + $('#cod_produto').val() , function (data) {
                        $('#produto').val(data.DESCRICAO);
                    });
                } else {
                    $('#invalid-pedido').css('display', 'block');
                    $('#produto').val(null);
                    var data = new Date();
                    var data1 = new Date(data);
                    data1.setDate(data.getDate() + 1);
                    var day = ("0" + data1.getDate()).slice(-2);
                    var month = ("0" + (now.getMonth() + 1)).slice(-2);
                    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                    $('#data_agendamento').val(today);
                    $('#quantidade').val(null);
                    $('#saldo_disponivel').val(null);
                }
            }
        });
    } else {
        $('#invalid-pedido').css('display', 'block');
        $('#produto').val(null);
        var data = new Date();
        var data1 = new Date(data);
        data1.setDate(data.getDate() + 1);
        var day = ("0" + data1.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
        $('#data_agendamento').val(today);
        $('#quantidade').val(null);
        $('#saldo_disponivel').val(null);
    }
});


$('#placa_cavalo').focusout(function () {
    let placa = retirarEspeciais($('#placa_cavalo').val());

    if(placa.length >= 7){
        $.getJSON('../../api/veiculo/' + placa, function (data) {
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
        $.getJSON('../../api/motorista/' + cpf_motorista, function (data) {
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

            invalida_data = true;
        } else {
            $('#invalid-data').css('display', 'none');
            $('#data_agendamento').removeClass('invalido');

            invalida_data = false;
        }
    } else {
        $('#invalid-data').css('display', 'none');
        $('#data_agendamento').removeClass('invalido');

        invalida_data = false;
    }
});

$('#formAgendamento').submit(function (event) {
    if(invalida_data || invalida_cota){
        event.preventDefault();
        $('#data_agendamento').focus();
    } else if(invalida_carga){
        event.preventDefault();
        $('#tipo_veiculo').focus();
    } else if(invalida_quantidade){
        event.preventDefault();
        $('#quantidade').focus();
    }
});

function verificarCota() {

    if(!invalida_quantidade && !invalida_data) {
        let cliente = $('#cod_cliente').val();
        let data = $('#data_agendamento').val();
        let quantidade = formatarValor($('#quantidade').val());

        if(quantidade > 0){
            $.getJSON('../../api/cota/' + cliente + '/' + data, function (data) {

                if((data.SALDO_LIVRE - data.TOTAL_AGENDADO) >= quantidade){
                    invalida_cota = false;

                    $('#invalid-cota').css('display', 'none');
                    $('#data_agendamento').removeClass('invalido');
                } else {
                    invalida_cota = true;

                    $('#invalid-cota').css('display', 'block');
                    $('#data_agendamento').addClass('invalido');
                }
            });
        }
    } else {
        invalida_cota = false;

        $('#invalid-cota').css('display', 'none');
        $(this).removeClass('invalido');
    }
}

function verificarTipoVeiculo(valor) {
    let carga = parseFloat(valor);
    let quantidade = parseFloat($('#quantidade').val());
    let tara = parseFloat($('#tara').val());
    let qtd_max = parseFloat(carga - tara);
    let embalagem = $('#tipo_embalagem').val();


    if(embalagem == 2) {
        let peso_por_embalagem = 0.0015;
        let quantidade_embalagens = quantidade / 1;
        $('#qtd_embalagens').val(quantidade_embalagens);
        let peso_total_embalagens = parseFloat(quantidade_embalagens * peso_por_embalagem);
        $('#peso_total_embalagens').val(peso_total_embalagens);
        let peso_bruto_liquido = parseFloat(quantidade + peso_total_embalagens);
        $('#peso_total_carga').val(peso_bruto_liquido);
        quantidade = peso_bruto_liquido;
        $('#carga_max').val(carga);
        $('#peso_total').val(quantidade+tara);

    } else if(embalagem == 3) {
        peso_emabalagem = 0.000122;
        quantidade_embalagens = quantidade / 0.05;
        $('#qtd_embalagens').val(quantidade_embalagens);
        let peso_total_embalagens = parseFloat(quantidade_embalagens * peso_por_embalagem);
        $('#peso_total_embalagens').val(peso_total_embalagens);
        let peso_bruto_liquido = parseFloat(quantidade + peso_total_embalagens);
        $('#peso_total_carga').val(peso_bruto_liquido);
        quantidade = peso_bruto_liquido;
        $('#carga_max').val(carga);
        $('#peso_total').val(quantidade+tara);
    }

    //if (quantidade.length > 0) {
        if(quantidade > qtd_max) {
            $('#invalid-carga').css('display', 'block');
            $('#tipo_veiculo').addClass('invalido');
            invalida_carga = true;
        } else {
            $('#invalid-carga').css('display', 'none');
            $('#tipo_veiculo').removeClass('invalido');
            invalida_carga = false;
        }
    //} else {
    //    $('#invalid-carga').css('display', 'none');
    //    $('#tipo_veiculo').removeClass('invalido');
    //    invalida_carga = false;
    //}
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

