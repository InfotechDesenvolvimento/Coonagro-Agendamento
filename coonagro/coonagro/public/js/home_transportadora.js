$(document).ready(function () {
    preencherData();
    setTable();
    filtrar_transportadora();

    $('#filtrar').click(function () {
        filtrar();
    });

    $('#limpar').click(function () {
        limparCampos();
    });

    $('#filtrar_transportadora').click(function () {
        filtrar_transportadora();
    });
});

function preencherData() {
    const data = new Date();

    let date = data.getFullYear() + '-';

    if(data.getMonth() + 1 < 10)
        date += '0' + (data.getMonth() + 1) + '-';
    else
        date += (data.getMonth() + 1) + '-';

    if(data.getDate() < 10)
        date += '0' + data.getDate();
    else
        date += data.getDate();

    $('#data_inicial').val(date);
    $('#data_final').val(date);
}

function setTable() {
    $('#table').DataTable({
        "bPaginate": false,
        "ordering": false,
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        },
        responsive: true,
        bFilter: false
    });
}

function limparCampos() {
    $('#num_agendamento').val(null);
    $('#status').val(0);
    preencherData();
}

function filtrar_transportadora() {
    $('#filtrar_transportadora').html(`
        <i class="fas fa-spinner fa-pulse mr-3"></i>
        Filtrar
    `);

    const num_agendamento = $('#num_agendamento').val();
    const status = $('#status').val();
    const data_inicial = $('#data_inicial').val();
    const data_final = $('#data_final').val();
    const transportadora = $('#transportadora').val();
    const num_pedido = $('#num_pedido').val();
    const placa_veiculo = $('#placa_veiculo').val();
    const placa_carreta = $('#placa_carreta').val();
    const data_especifica = $('#data_especifica').val();

    let filtro = {
        num_agendamento: num_agendamento,
        status: status,
        data_inicial: data_inicial,
        data_final: data_final,
        transportadora: transportadora,
        num_pedido: num_pedido,
        placa_veiculo: placa_veiculo,
        placa_carreta: placa_carreta,
        data_especifica: data_especifica
    };

    $.getJSON('transportadora/filter', filtro, function (data) {
        let resultado = '';

        Array.prototype.forEach.call(data, function (item) {
            resultado += `<tr>`;
                resultado += `<td>${item.CODIGO}</td>`;
                resultado += `<td>
                                   <a href="transportadora/carregamento/imprimir/${item.CODIGO}" target="_blank">
                                        <i class="fas fa-print" title="Ver Detalhe" style="cursor: pointer; color: #545b62"></i>
                                   </a>
                              </td>`;
                resultado += `<td>${item.PLACA_VEICULO}</td>`;
                resultado += `<td>${item.status.STATUS}</td>`;
                resultado += `<td>${formatarData(item.DATA_AGENDAMENTO)}</td>`;
                resultado += `<td>${item.QUANTIDADE}</td>`;
                resultado += `<td>${item.NUM_PEDIDO}</td>`;
                resultado += `<td>${item.PLACA_VEICULO}</td>`;
                resultado += `<td>${item.PLACA_CARRETA1}</td>`;
                resultado += `<td>${item.TRANSPORTADORA}</td>`;
            resultado += `</tr>`;
        });

        let table = $('#table').DataTable();
        table.destroy();

        $('#table tbody').html(resultado);
        setTable();

        $('#filtrar_transportadora').html(`
            <i class="fas fa-search mr-3"></i>
            Filtrar
        `);
    })
    .fail(function() {
        alert("Não foi possível filtrar os dados! Tente novamente!");

        $('#filtrar_transportadora').html(`
            <i class="fas fa-search mr-3"></i>
            Filtrar
        `);
    })
}

function formatarData(data) {
    return data.substring(8,10) + '/' + data.substring(5,7) + '/' + data.substring(0, 4);
}
