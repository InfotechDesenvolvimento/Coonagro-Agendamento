$(document).ready(function () {

});

$('#total_pedido').focusout(function () {
    $('#saldo_restante').val($('#total_pedido').val());
});

$('#num_pedido').focusout(function () {
    let num_pedido = $('#num_pedido').val();
    if(num_pedido != '') {
        $.getJSON('../../api/verificar_pedido/'+num_pedido, function (data) {
            if(JSON.stringify(data) === '{}'){
                $('#invalid-pedido').css('display', 'none');
                $('#avancar').attr('disabled', false);
            } else {
                $('#invalid-pedido').css('display', 'block');
                $('#avancar').attr('disabled', true);
            }
        });
    } else {
        $('#invalid-pedido').css('display', 'block');
        $('#avancar').attr('disabled', true);
    }
});