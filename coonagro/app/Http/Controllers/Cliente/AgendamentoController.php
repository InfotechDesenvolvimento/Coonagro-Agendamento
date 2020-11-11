<?php


namespace App\Http\Controllers\Cliente;


use App\Agendamento;
use App\Codigos;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\TransportadoraController;
use App\Http\Controllers\VeiculoController;
use App\Motorista;
use App\PedidoTransporte;
use App\TipoEmbalagem;
use App\TipoVeiculo;
use App\Transportadora;
use App\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    private $request;

    public function __construct(){
        $this->middleware('auth:cliente');
    }

    public function index($num_pedido){
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $tipos = TipoVeiculo::orderBy('TIPO_VEICULO')->get();
        $embalagens = TipoEmbalagem::orderBy('TIPO_EMBALAGEM')->get();

        $pedido = PedidoTransporte::where([
                        'COD_CLIENTE' => $cod_cliente,
                        'NUM_PEDIDO' => $num_pedido
                      ])->with('produto')->first();

        return view('cliente.agendamento', compact(['pedido', 'tipos', 'embalagens']));
    }

    public function validarDados(Request $request){
        $confirmacao = $request->all();

        $date = date_create($confirmacao['data_agendamento']);
        $confirmacao["data_agendamento_formatado"] = date_format($date,"d/m/Y");
        $confirmacao['placa_carreta'] = strtoupper($confirmacao['placa_carreta']);
        $confirmacao['placa_cavalo'] = strtoupper($confirmacao['placa_cavalo']);

        $tipo_veiculo = json_decode($confirmacao['tipo_veiculo'][0]);

        $tipo_veiculo = TipoVeiculo::find($tipo_veiculo->id);
        $confirmacao['tipo_veiculo_nome'] = $tipo_veiculo->TIPO_VEICULO;

        $tipo_embalagem = TipoEmbalagem::find($confirmacao['tipo_embalagem']);
        $confirmacao['tipo_embalagem_nome'] = $tipo_embalagem->TIPO_EMBALAGEM;

        $date = date_create($confirmacao['validade_cnh']);
        $confirmacao['validade_cnh_formatado'] = date_format($date, "d/m/Y");

        session()->put('agendamento', json_encode($request->input()));

        return view('cliente.confirmacao-carregamento', compact(['confirmacao']));
    }

    public function finalizar(){

        if(session()->has('agendamento')){
            $dados = json_decode(session()->get('agendamento'));

            $objTransportadora = new TransportadoraController();
            $transportadora = $objTransportadora->getTransportadoraFormatada($dados->cnpj_transportadora);
            $transportadora = $transportadora->getData();

                if(count(get_object_vars($transportadora)) == 0){
                    $transportadora = new Transportadora();

                    $transportadora->CPF_CNPJ = $dados->cnpj_transportadora;
                    $transportadora->NOME = strtoupper($dados->transportadora);

                    $objTransportadora->insert($transportadora);
                }

            $objVeiculo = new VeiculoController();
            $veiculo = $objVeiculo->getVeiculo($dados->placa_cavalo);
            $veiculo = $veiculo->getData();

                if(count(get_object_vars($veiculo)) == 0){
                    $tipo_veiculo = json_decode($dados->tipo_veiculo[0]);

                    $veiculo = new Veiculo();

                    $veiculo->PLACA = strtoupper($dados->placa_cavalo);
                    $veiculo->PLACA_CARRETA = strtoupper($dados->placa_carreta);
                    $veiculo->COD_TIPO_VEICULO = $tipo_veiculo->id;
                    $veiculo->TARA = $this->formataValor($dados->tara);
                    $veiculo->RENAVAM = $dados->renavam;

                    $objVeiculo->insert($veiculo);
                }

            $objMotorista = new MotoristaController();
            $motorista = $objMotorista->show($dados->cpf_motorista);
            $motorista = $motorista->getData();

                if(count(get_object_vars($motorista)) == 0){
                    $motorista = new Motorista();

                    $motorista->CPF_CNPJ = $dados->cpf_motorista;
                    $motorista->NOME = strtoupper($dados->nome_motorista);
                    $motorista->CNH = $dados->cnh;
                    $motorista->DATA_VALIDADE_CNH = $dados->validade_cnh;

                    $objMotorista->insert($motorista);
                }

            $agendamento = new Agendamento();

            $agendamento->NUM_PEDIDO = $dados->num_pedido;
            $agendamento->DATA_AGENDAMENTO = $dados->data_agendamento;
            $agendamento->TRANSPORTADORA = strtoupper($dados->transportadora);
            $agendamento->CNPJ_TRANSPORTADORA = $dados->cnpj_transportadora;
            $agendamento->PLACA_VEICULO = strtoupper($dados->placa_cavalo);
            $agendamento->PLACA_CARRETA1 = strtoupper($dados->placa_carreta);
            $agendamento->RENAVAM_VEICULO = $dados->renavam;

            $tipo_veiculo = json_decode($dados->tipo_veiculo[0]);

            $agendamento->COD_TIPO_VEICULO = $tipo_veiculo->id;
            $agendamento->TARA_VEICULO = $this->formataValor($dados->tara);
            $agendamento->CONDUTOR = strtoupper($dados->nome_motorista);
            $agendamento->CPF_CONDUTOR = $dados->cpf_motorista;
            $agendamento->COD_PRODUTO = $dados->cod_produto;
            $agendamento->QUANTIDADE = $this->formataValor($dados->quantidade);
            $agendamento->COD_EMBALAGEM = $dados->tipo_embalagem;

            return $this->insert($agendamento);
        } else {
            return redirect()->route('cliente.carregamento');
        }
    }

    public function insert(Agendamento $agendamento){

        $agendamento->DATA_CADASTRO = date("Y/m/d");
        $agendamento->DATA_ALTERACAO = date("Y/m/d");
        $agendamento->COD_STATUS_AGENDAMENTO = 1;

        $agendamento->save();

        //session()->forget('agendamento');

        return view('cliente.mensagem-sucesso', compact('agendamento'));
    }

    public function imprimir($cod_agendamento){
        
    }



    public function formataValor($valor){
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }
}
