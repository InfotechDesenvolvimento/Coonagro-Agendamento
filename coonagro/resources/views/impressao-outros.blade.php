<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title> Agendamento Coonagro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

</head>
<body>
    <div style="text-align:center">
        <h1> Coonagro </h1> <h1>Cooperativa Nacional Agroindustrial </h1> <br><br>
    </div>

    <p><b>DATA AGENDAMENTO: {{session()->get('hora')}}</b></p>
    <p><b>HORA PREVISTA: {{session()->get('data')}}</b></p>
    <p><b>TIPO DE OPERAÇÃO: @if(session()->get('tipo_operacao') == 3) Administração @else Outros @endif</b></p>

    <br>
    <p class="card-text"><b>TRANSPORTADORA: {{session()->get('transp')}}</b></p>
    <p class="card-text"><b>CPF MOTORISTA: {{session()->get('cpf_motorista')}}</b></p>
    <p class="card-text"><b>NOME MOTORISTA: {{session()->get('nome_motorista')}}</b></p>
    <br>

    <p class="card-text"><b>PLACA VEÍCULO: {{session()->get('placa_veiculo')}}</b></p>
    <p class="card-text"><b>PESO BRUTO: {{session()->get('peso_bruto')}}</b></p>
    <p class="card-text"><b>PESO LÍQUIDO: {{session()->get('peso_liquido')}}</b></p>
    <p class="card-text"><b>OBSERVAÇÃO: {{session()->get('observacao')}}</b></p>

</body>
</html>
