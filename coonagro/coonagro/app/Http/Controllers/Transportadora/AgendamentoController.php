<?php


namespace App\Http\Controllers\Transportadora;


use App\Mail\EnviaEmail;
use Mail;
use App\Agendamento;
use App\Codigos;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CotaClienteController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\PedidoTransporteController;
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
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AgendamentoController extends Controller
{
    public function __construct(){
        $this->middleware('auth:transportadora');
    }

    public function index(){
        $tipos = TipoVeiculo::orderBy('TIPO_VEICULO')->get();
        $embalagens = TipoEmbalagem::orderBy('TIPO_EMBALAGEM')->get();

        return view('transportadora.agendamento', compact(['tipos', 'embalagens']));
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

        return view('transportadora.confirmacao-carregamento', compact(['confirmacao']));
    }

    public function finalizar(){

        if(session()->has('agendamento')){
            $dados = json_decode(session()->get('agendamento'));

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
            $agendamento->TRANSPORTADORA = Auth::user()->NOME;
            $agendamento->CNPJ_TRANSPORTADORA = Auth::user()->CPF_CNPJ;
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
            $agendamento->OBS = $dados->observacao;

            return $this->insert($agendamento);
        } else {
            return redirect()->route('transportadora.operacao');
        }
    }

    public function insert(Agendamento $agendamento){

        $agendamento->DATA_CADASTRO = date("Y/m/d");
        $agendamento->DATA_ALTERACAO = date("Y/m/d");
        $agendamento->COD_STATUS_AGENDAMENTO = 1;
        $agendamento->COD_TRANSPORTADORA = Auth::user()->getAuthIdentifier();

        if($agendamento->save())
        {
            $objPedidoTransporte = new PedidoTransporteController();
            $objPedidoTransporte->update($agendamento->NUM_PEDIDO, $agendamento->QUANTIDADE);

            $pedido = $objPedidoTransporte->getObjPedido($agendamento->NUM_PEDIDO);
            
            $objCotaCliente = new CotaClienteController();
            $objCotaCliente->update($pedido->COD_CLIENTE, $agendamento->DATA_AGENDAMENTO, $agendamento->QUANTIDADE);
        }

        $cod_agendamento = $agendamento->CODIGO;

        session()->forget('agendamento');

        $data = $agendamento->ToJson();
        $data = json_decode($data);

        if(Auth::user()->EMAIL != null) {
            Mail::to(Auth::user()->EMAIL)->send(new EnviaEmail($data));
        }

        return redirect()->route('transportadora.carregamento.sucesso', $cod_agendamento);
    }

    public function sucesso($cod_agendamento){
        return view('transportadora.mensagem-sucesso', compact('cod_agendamento'));
    }

    public function show($codigo){
        return Agendamento::where('CODIGO', $codigo)->with(['produto', 'embalagem', 'tipoVeiculo'])->first();
    }

    public function imprimir($cod_agendamento){
        $agendamento = $this->show($cod_agendamento);

        $qrcode = QrCode::size(150)->generate($agendamento->CODIGO);
        
        set_time_limit(300);

        return \PDF::loadView('transportadora.imprimir', ['agendamento' => $agendamento, 'qrcode' => $qrcode])
            ->stream('agendamento-coonagro.pdf');

    }

    public function filter(Request $request){

        $cod_transportadora = Auth::user()->getAuthIdentifier();

        $agendamentos = Agendamento::when($request->get('num_agendamento') != "", function ($query) use ($request) {
                                $query->where('CODIGO', $request->get('num_agendamento'));
                        })->when($request->get('status') != "0", function ($query) use ($request){
                                $query->where('COD_STATUS_AGENDAMENTO', $request->get('status'));
                        })->when($request->get('data_inicial') != "", function ($query) use ($request){
                                $query->where('DATA_AGENDAMENTO', '>=', $request->get('data_inicial'));
                        })->when($request->get('data_final') != "", function ($query) use ($request){
                                $query->where('DATA_AGENDAMENTO', '<=', $request->get('data_final'));
                        })->where('COD_TRANSPORTADORA', $cod_transportadora)
                        ->with('status')->orderBy('CODIGO')->get();

        return response()->json($agendamentos);
    }

    public function formataValor($valor){
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }
}