let invalida_quantidade = false;
let invalida_cota = false;
let numCota = 0;
let dias = 0;
const saldo_disponivel_bk = $('#pedido_saldo_disponivel').val();


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

function adicionarCota() {
    var saldo_livre = 0;
    var total_agendado = 0;
    var cota_disponivel = 0;
    var cliente = $('#cod_cliente').val();
    var data2 = new Date();
    var data1 = new Date(data2);
    data1.setDate(data2.getDate() + dias);
    var day = ("0" + data1.getDate()).slice(-2);
    var month = ("0" + (data1.getMonth() + 1)).slice(-2);
    var today = data1.getFullYear()+"-"+(month)+"-"+(day);
    dias += 1;
    $.getJSON('../../api/cota/' + cliente + '/' + today, function (data) {
        saldo_livre = data.SALDO_LIVRE;
        total_agendado = data.TOTAL_AGENDADO;
        cota_disponivel = saldo_livre - total_agendado;
        if(cota_disponivel > 0) {
            var element = `<tr id='linha_${numCota}'>
                                <td> <input id="quantidade_${numCota}"
                                            type="text"
                                            name="quantidade_${numCota}"
                                            class="form-control peso"
                                            onkeypress="return somenteNumeros(event)"
                                            required
                                    >
                                </td>

                                <td>
                                    <input id="data_${numCota}"
                                            type="date"
                                            name="data_${numCota}"
                                            value="${today}"
                                            min="${today}"
                                            class="form-control"
                                            readonly
                                    >
                                </td>
                            
                                <td>
                                    <input id="cota_disponivel_${numCota}"
                                            type="text"
                                            name="cota_disponivel_${numCota}"
                                            class="form-control"
                                            readonly
                                            value="${cota_disponivel}"
                                    >
                                </td>

                                <td>
                                </td>
                            </tr>
                            <tr id='sublinha_${numCota}'>
                                <td>
                                    <div class="invalid-feedback" id="invalid-quantidade_${numCota}">
                                        Quantidade não disponível
                                    </div>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <div class="invalid-feedback" id="invalid-cota_${numCota}">
                                        Cota diária do cliente excedida
                                    </div>
                                </td>
                            </tr>

                            <script>
                                $('#quantidade_${numCota}').keyup(function () {
                                    let quantidade = $('#quantidade_${numCota}').val();
                                    let p_saldo_disponivel = $('#pedido_saldo_disponivel').val();
                                    let cota_cliente = $('#cota_disponivel_${numCota}').val();
                                    
                                        if(quantidade.length > 0){
                                            quantidade = formatarValor(quantidade);
                                            quantidade = parseFloat(quantidade);
                                            p_saldo_disponivel = parseFloat(p_saldo_disponivel);
                                            if(quantidade > p_saldo_disponivel){
                                                $('#invalid-quantidade_${numCota}').css('display', 'block');
                                                $(this).addClass('invalido');
                                                invalida_quantidade = true;
                                            } else if(quantidade > cota_cliente) {
                                                $('#invalid-cota_${numCota}').css('display', 'block');
                                                $(this).addClass('invalido');
                                                invalida_cota = true;
                                            } else if(quantidade > cota_cliente && quantidade > p_saldo_disponivel) {
                                                $('#invalid-cota_${numCota}').css('display', 'block');
                                                $(this).addClass('invalido');
                                                invalida_cota = true;
                                                $('#invalid-quantidade_${numCota}').css('display', 'block');
                                                $(this).addClass('invalido');
                                            } else {
                                                $('#invalid-quantidade_${numCota}').css('display', 'none');
                                                invalida_quantidade = false;
                                                $('#invalid-cota_${numCota}').css('display', 'none');
                                                invalida_cota = false;
                                                $(this).removeClass('invalido');
                                            }
                                        } else {
                                            $('#invalid-quantidade_${numCota}').css('display', 'none');
                                            invalida_quantidade = false;
                                            $('#invalid-cota_${numCota}').css('display', 'none');
                                            invalida_cota = false;
                                            $(this).removeClass('invalido');
                                        }
                                
                                    
                                });
                                $('#quantidade_${numCota}').focusout(function () {
                                    let saldo = $('#pedido_saldo_disponivel').val();
                                    let quantidade = $(this).val();
                                    let qtd = parseInt($(this).val());
                                    let p_saldo_disponivel = $('#pedido_saldo_disponivel').val();
                                    let cota_cliente = $('#cota_disponivel_${numCota}').val();

                                    if(qtd > 0){
                                        quantidade = formatarValor(quantidade);
                                        quantidade = parseFloat(quantidade);
                                        p_saldo_disponivel = parseFloat(p_saldo_disponivel);
                                        if(quantidade > p_saldo_disponivel){
                                            $('#linha_${numCota}').remove();
                                            $('#sublinha_${numCota}').remove();
                                            numCota = numCota - 1;
                                        } else if(quantidade > cota_cliente) {
                                            $('#linha_${numCota}').remove();
                                            $('#sublinha_${numCota}').remove();
                                            numCota = numCota - 1;
                                        } else if(quantidade > cota_cliente && quantidade > p_saldo_disponivel) {
                                            $('#linha_${numCota}').remove();
                                            $('#sublinha_${numCota}').remove();
                                            numCota = numCota - 1;
                                        } else {
                                            $('#invalid-quantidade_${numCota}').css('display', 'none');
                                            invalida_quantidade = false;
                                            $('#invalid-cota_${numCota}').css('display', 'none');
                                            invalida_cota = false;
                                            $(this).removeClass('invalido');
                                            $('#pedido_saldo_disponivel').val(saldo-quantidade);
                                            $(this).attr('readonly', true);
                                        }
                                    } else {
                                        $('#linha_${numCota}').remove();
                                        $('#sublinha_${numCota}').remove();
                                        numCota = numCota - 1;
                                    }
                                });
                                $('#quantidade_${numCota}').focusout(function () {
                                    
                                });
                            </script>
                        `;
            numCota += 1;
        } else {
            var element = `<tr>
                                <td> <input class="form-control" type="text" readonly >
                                </td>

                                <td>
                                    <input  type="date"
                                            value="${today}"
                                            class="form-control"
                                            readonly
                                    >
                                </td>
                            
                                <td>
                                    <input  type="text"
                                            class="form-control"
                                            readonly
                                            value="${cota_disponivel}"
                                    >
                                </td>

                                <td>
                                </td>
                            </tr>`;
        }
        $('#adicionar').before(element);
        $('#numCota').val(numCota);
        $(".peso").maskMoney({symbol:'R$ ',
            showSymbol:true, thousands:'.', decimal:',', symbolStay: true
        });
    });
}
