<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title> Agendamento Coonagro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>
    <div style="text-align: center;">
        <h2 style="color: darkgreen;"> Coonagro </h2>
        <h3 style="color: darkgreen;">Cooperativa Nacional Agroindustrial </h3>
        <br>
        <img src="data:image/svg;base64, {{ base64_encode(QrCode::format('svg')->size(100)->generate($agendamento->CODIGO)) }} ">
    </div>

    <br>

    <table>
        <thead>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            <tr><td></td><td style="padding-left: 50px"></td></tr>
            <tr>
                <td>
                    <b style="color: darkgray">Nº Pedido</b>
                    <p>{{$agendamento->NUM_PEDIDO}}</p>
                </td>
                <td style="padding-left: 50px">
                    <b style="color: darkgray">Produto</b>
                    <p>{{$agendamento->produto->DESCRICAO}}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <b style="color: darkgray">Data do Agendamento</b>
                    <p>{{date_format(date_create($agendamento->DATA_AGENDAMENTO), 'd/m/Y')}}</p>
                </td>

                <td style="padding-left: 50px">
                    <b style="color: darkgray">Quantidade (Toneladas)</b>
                    <p>{{str_replace('.', ',' ,number_format($agendamento->QUANTIDADE, 2))}}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <b style="color: darkgray">CNPJ Transportadora</b>
                    <p>{{$agendamento->CNPJ_TRANSPORTADORA}}</p>
                </td>
                <td style="padding-left: 50px">
                    <b style="color: darkgray">Transportadora</b>
                    <p>{{$agendamento->TRANSPORTADORA}}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <b style="color: darkgray">Placa Cavalo</b>
                    <p>{{$agendamento->PLACA_VEICULO}}</p>
                </td>
                <td style="padding-left: 50px">
                    <b style="color: darkgray">Placa Carreta</b>
                    <p>{{$agendamento->PLACA_CARRETA1}}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <b style="color: darkgray">Tipo do Veículo</b>
                    <p>{{$agendamento->tipoVeiculo->TIPO_VEICULO}}</p>
                </td>
                <td style="padding-left: 50px">
                    <b style="color: darkgray">Cliente</b>
                    <p>{{$agendamento->cliente->NOME}}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <b style="color: darkgray">Tara (Toneladas)</b>
                    <p>{{$agendamento->TARA_VEICULO}}</p>
                </td>
                <td style="padding-left: 50px">
                    <b style="color: darkgray">Renavam</b>
                    <p>{{$agendamento->RENAVAM_VEICULO}}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <b style="color: darkgray">CPF Motorista</b>
                    <p>{{$agendamento->CPF_CONDUTOR}}</p>
                </td>
                <td style="padding-left: 50px">
                    <b style="color: darkgray">Motorista</b>
                    <p>{{$agendamento->CONDUTOR}}</p>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <b style="color: darkgray">Tipo de Embalagem</b>
                    <p>{{$agendamento->embalagem->TIPO_EMBALAGEM}}</p>
                </td>
            </tr>
        </tbody>

        <p>{{$agendamento->OBS}}</p>
        <b style="color: darkgray">Observação</b>
    </table>
</body>
</html>
