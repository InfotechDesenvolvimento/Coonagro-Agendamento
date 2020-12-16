<!DOCTYPE html>
<html>
<head>
    <title> Coonagro - Agendamentos</title>
</head>
<body>
    <div>
        <h2 style="color: darkgreen;"> Coonagro </h2>
        <h3 style="color: darkgreen;">Cooperativa Nacional Agroindustrial </h3>
        <br>
        <img src="data:image/svg;base64, {{ base64_encode(QrCode::format('svg')->size(100)->generate($agendamento->{'CODIGO'})) }} ">
        <b style="color: darkgray">Codigo</b>
        <p>{{ $agendamento->{'CODIGO'} }}</p>
    </div>
    <br>
    <div>
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
                        <p>{{ $agendamento->{'NUM_PEDIDO'} }}</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b style="color: darkgray">Data do Agendamento</b>
                        <p>{{date_format(date_create($agendamento->{'DATA_AGENDAMENTO'}), 'd/m/Y')}}</p>
                    </td>

                    <td style="padding-left: 50px">
                        <b style="color: darkgray">Quantidade (Toneladas)</b>
                        <p>{{str_replace('.', ',' ,number_format($agendamento->{'QUANTIDADE'}, 2))}}</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b style="color: darkgray">CNPJ Transportadora</b>
                        <p>{{ $agendamento->{'CNPJ_TRANSPORTADORA'} }}</p>
                    </td>
                    <td style="padding-left: 50px">
                        <b style="color: darkgray">Transportadora</b>
                        <p>{{ $agendamento->{'TRANSPORTADORA'} }}</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b style="color: darkgray">Placa Cavalo</b>
                        <p>{{ $agendamento->{'PLACA_VEICULO'} }}</p>
                    </td>
                    <td style="padding-left: 50px">
                        <b style="color: darkgray">Placa Carreta 1</b>
                        <p>{{ $agendamento->{'PLACA_CARRETA1'} }}</p>
                    </td>
                </tr>

                <tr>
                    @if(isset($agendamento->{'PLACA_CARRETA2'}))
                        <td>
                            <b style="color: darkgray">Placa Carreta 2</b>
                            <p>{{ $agendamento->{'PLACA_CARRETA2'} }}</p>
                        </td>
                    @endif
                    @if(isset($agendamento->{'PLACA_CARRETA3'}))
                        <td style="padding-left: 50px">
                            <b style="color: darkgray">Placa Carreta 3</b>
                            <p>{{ $agendamento->{'PLACA_CARRETA3'} }}</p>
                        </td>
                    @endif
                </tr>

                <tr>
                    <td>
                        <b style="color: darkgray">Tara (Toneladas)</b>
                        <p>{{ $agendamento->{'TARA_VEICULO'} }}</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b style="color: darkgray">CPF Motorista</b>
                        <p>{{ $agendamento->{'CPF_CONDUTOR'} }}</p>
                    </td>
                    <td style="padding-left: 50px">
                        <b style="color: darkgray">Motorista</b>
                        <p>{{ $agendamento->{'CONDUTOR'} }}</p>
                    </td>
                </tr>
            </tbody>

            <b style="color: darkgray">Observação</b>

            <p>{{$agendamento->OBS}}</p>
        </table>
    </div>
</body>
</html>