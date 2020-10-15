@extends('form-principal')

@section('conteudo')

    <div class="col-12">
        <div class="container" style="padding: 30px; text-align:center; border-radius: 15px; max-width: 550px; margin-top: 20px; background: #E8E8E8">
            <h4 style="padding: 30px; color: #63950A; font-family: 'Roboto"> <b>FORMULÁRIO DE AGENDAMENTO</b> </h4>

            <form action="{{ action('FormController@finalizarAgendamentoOutros') }}" enctype="multipart/form-data" method="post">
                <input type ="hidden" name="_token" value="{{{ csrf_token()  }}}">

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Data do Agendamento:</b></label>
                    </div>

                    <input
                        name="data_agendamento"
                        type="date"
                        min='<?php echo date("Y-m-d"); ?>'
                        value='<?php echo date("Y-m-d", strtotime("+1 day")); ?>'
                        class="form-control"
                        required
                    >
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Hora Prevista:</b></label>
                    </div>

                    <input
                        name="hora_agendamento"
                        type="time"
                        class="form-control"
                        required
                    >
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Tipo de Operação:</b></label>
                    </div>

                    <select class="form-control"  name="tipo_operacao">
                        <option value="3">Almoxarifado</option>
                        <option value="5">Outros</option>
                    </select>

                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Placa do Veículo:</b></label>
                    </div>

                    <input
                        name="placa"
                        type="text"
                        class="form-control"
                        minlength="7"
                        required
                    >
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Nome do Motorista:</b></label>
                    </div>

                    <input
                        name="nome_motorista"
                        type="text"
                        class="form-control">
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>CPF do Motorista:</b></label>
                    </div>

                    <input
                        name="cpf_motorista"
                        type="text"
                        class="form-control"
                        id="cpf_motorista">
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Transportadora:</b></label>
                    </div>

                    <input
                        name="transportadora"
                        type="text"
                        class="form-control">
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Nº Nota Fiscal:</b></label>
                    </div>

                    <input
                        name="num_nota"
                        type="text"
                        class="form-control">
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Peso Bruto:</b></label>
                    </div>

                    <input
                        name="peso_bruto"
                        type="text"
                        class="form-control peso">
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Peso Líquido:</b></label>
                    </div>

                    <input
                        name="peso_liquido"
                        type="text"
                        class="form-control peso">
                    <br>
                </div>

                <div class="form-group">
                    <div style="text-align: left">
                        <label><b>Observação:</b></label>
                    </div>

                    <textarea
                        name="observacao"
                        class="form-control"
                        rows="5"
                    >
                    </textarea>
                    <br>
                </div>

                <button type="submit" class="btn btn-success btn-lg btn-block"> <b> <i class="fas fa-arrow-circle-right"></i> AVANÇAR </b> </button></form>
            </form>
        </div>
    </div>


    <script>

       $(document).ready(function(){
           $('#cpf_motorista').mask('000.000.000-00');

           $(".peso").maskMoney({symbol:'R$ ',
               showSymbol:true, thousands:'.', decimal:',', symbolStay: true
           });
       });
    </script>

@endsection
