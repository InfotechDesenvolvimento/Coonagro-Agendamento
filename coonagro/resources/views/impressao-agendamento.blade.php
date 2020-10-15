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
      <p><b>NÚMERO DO PEDIDO: {{session()->get('num_pedido')}}</b></p>
      <p><b>QUANTIDADE: {{session()->get('qtde')}}</b></p>
    <br>
      <p class="card-text"><b>NOME TRANSPORTADORA: {{session()->get('name_transportador')}}</b></p>
      <p class="card-text"><b>CPF TRANSPORTADOR: {{session()->get('cpf_transportador')}}</b></p>
    </div> <br>

    <p class="card-text"><b>PLACA VEÍCULO: {{session()->get('placa_veiculo')}}</b></p>
    <p class="card-text"><b>PLACA CARRETA 1: {{session()->get('placa_carreta1')}}</b></p>
    <p class="card-text"><b>PLACA CARRETA 2: {{session()->get('placa_carreta2')}}</b></p>
    <p class="card-text"><b>TARA DO VEÍCULO: {{session()->get('tara_veiculo')}}</b></p>
    <p class="card-text"><b>NOME CONDUTOR: {{session()->get('name_condutor')}}</b></p>
    <p class="card-text"><b>CNH CONDUTOR: {{session()->get('cpf_condutor')}}</b></p>
  </div>
  </body>
</html>
