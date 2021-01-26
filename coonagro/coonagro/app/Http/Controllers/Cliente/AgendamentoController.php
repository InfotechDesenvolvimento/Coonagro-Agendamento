<?php


namespace App\Http\Controllers\Cliente;

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
                    if($dados->placa_carreta2 != null) {
                        $veiculo->PLACA_CARRETA2 = strtoupper($dados->placa_carreta2);
                    }
                    if($dados->placa_carreta3 != null) {
                        $veiculo->PLACA_CARRETA3 = strtoupper($dados->placa_carreta3);
                    }
                    $veiculo->COD_TIPO_VEICULO = $tipo_veiculo->id;
                    $veiculo->TARA = $this->formataValor($dados->tara);
                    if($dados->renavam != null) {
                        $veiculo->RENAVAM = $dados->renavam;
                    }

                    $objVeiculo->insert($veiculo);
                }

            $objMotorista = new MotoristaController();
            $motorista = $objMotorista->show($dados->cpf_motorista);
            $motorista = $motorista->getData();

                if(count(get_object_vars($motorista)) == 0){
                    $motorista = new Motorista();

                    $motorista->CPF_CNPJ = $dados->cpf_motorista;
                    $motorista->NOME = strtoupper($dados->nome_motorista);
                    if($dados->cnh != null) {
                        $motorista->CNH = $dados->cnh;
                    }
                    if($dados->validade_cnh != null) {
                        $motorista->DATA_VALIDADE_CNH = $dados->validade_cnh;
                    }
                    
                    $objMotorista->insert($motorista);
                }

            $agendamento = new Agendamento();

            $agendamento->NUM_PEDIDO = $dados->num_pedido;
            $agendamento->DATA_AGENDAMENTO = $dados->data_agendamento;
            $agendamento->TRANSPORTADORA = strtoupper($dados->transportadora);
            $agendamento->CNPJ_TRANSPORTADORA = $dados->cnpj_transportadora;
            $agendamento->PLACA_VEICULO = strtoupper($dados->placa_cavalo);
            $agendamento->PLACA_CARRETA1 = strtoupper($dados->placa_carreta);
            if($dados->placa_carreta2 != null) {
                $agendamento->PLACA_CARRETA2 = strtoupper($dados->placa_carreta2);
            }
            if($dados->placa_carreta3 != null) {
                $agendamento->PLACA_CARRETA3 = strtoupper($dados->placa_carreta3);
            }
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
            $agendamento->COD_TRANSPORTADORA = $transportadora->CODIGO;

            return $this->insert($agendamento);
        } else {
            return redirect()->route('cliente.carregamento');
        }
    }

    public function insert(Agendamento $agendamento){

        $transportadora = Transportadora::find($agendamento->COD_TRANSPORTADORA);
        
        $agendamento->DATA_CADASTRO = date("Y-m-d");
        $agendamento->DATA_ALTERACAO = date("Y-m-d");
        $agendamento->HORA_CADASTRO = now();
        $agendamento->HORA_ALTERACAO = now();                                                                       
        $agendamento->COD_STATUS_AGENDAMENTO = 1;
        $agendamento->COD_CLIENTE = Auth::user()->getAuthIdentifier();

        $email = 0;

        if(Auth::user()->EMAIL != null && $transportadora->EMAIL != null) {
            if(!filter_var(Auth::user()->EMAIL, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Agendamento não pôde ser concluído, e-mail do CLIENTE inválido! Favor alterar para um endereço válido!';
                return redirect()->route('carregamento.falha', $erro);
            }
            elseif(!filter_var($transportadora->EMAIL, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Agendamento não pôde ser concluído, e-mail da TRANSPORTADORA inválido! Favor alterar para um endereço válido!';
                return redirect()->route('carregamento.falha', $erro);
            }
            else {
                $email = 1;
            }
        }

        if($agendamento->save())
        {
            $objPedidoTransporte = new PedidoTransporteController();
            $objPedidoTransporte->update($agendamento->NUM_PEDIDO, $agendamento->QUANTIDADE);
            
            $cod_cliente = Auth::user()->getAuthIdentifier();
            $objCotaCliente = new CotaClienteController();
            $objCotaCliente->update($cod_cliente, $agendamento->DATA_AGENDAMENTO, $agendamento->QUANTIDADE);
        }

        $cod_agendamento = $agendamento->CODIGO;

        if($email == 1) {
            $data = $agendamento->ToJson();
            $data = json_decode($data);
            Mail::to($transportadora->EMAIL)->send(new EnviaEmail($data));
            Mail::to(Auth::user()->EMAIL)->send(new EnviaEmail($data));
        }

        session()->forget('agendamento');
        return redirect()->route('carregamento.sucesso', $cod_agendamento);
    }

    public function falha($erro) {
        return view('cliente.operacao_falha', compact('erro'));
    }

    public function sucesso($cod_agendamento) {
        return view('cliente.mensagem-sucesso', compact('cod_agendamento'));
    }

    public function show($codigo){
        return Agendamento::where('CODIGO', $codigo)->with(['produto', 'embalagem', 'tipoVeiculo', 'cliente'])->first();
    }

    public function imprimir($cod_agendamento){
        $agendamento = $this->show($cod_agendamento);

        $qrcode = QrCode::size(150)->generate($agendamento->CODIGO);

        set_time_limit(300);

        return \PDF::loadView('cliente.imprimir', ['agendamento' => $agendamento, 'qrcode' => $qrcode])
            ->stream('agendamento-coonagro.pdf');

        //return view('cliente.imprimir', compact('agendamento'));
    }

    public function filter(Request $request){

        $cod_cliente = Auth::user()->getAuthIdentifier();

        if($request->get('data_especifica') == '') {
            $agendamentos = Agendamento::when($request->get('num_agendamento') != "", function ($query) use ($request) {
                                            $query->where('CODIGO', $request->get('num_agendamento'));
                                    })->when($request->get('status') != "0", function ($query) use ($request){
                                            $query->where('COD_STATUS_AGENDAMENTO', $request->get('status'));
                                    })->when($request->get('produto') != "0", function ($query) use ($request){
                                            $query->where('COD_PRODUTO', $request->get('produto'));
                                    })->when($request->get('data_inicial') != "", function ($query) use ($request){
                                            $query->where('DATA_AGENDAMENTO', '>=', $request->get('data_inicial'));
                                    })->when($request->get('data_final') != "", function ($query) use ($request){
                                            $query->where('DATA_AGENDAMENTO', '<=', $request->get('data_final'));
                                    })->when($request->get('num_pedido') != "", function ($query) use ($request){
                                            $query->where('NUM_PEDIDO', $request->get('num_pedido'));
                                    })->when($request->get('transportadora') != "", function ($query) use ($request){
                                            $query->where('TRANSPORTADORA', 'LIKE', '%' . $request->get('transportadora') .'%');
                                    })->when($request->get('placa_veiculo') != "", function ($query) use ($request){
                                            $query->where('PLACA_VEICULO', 'LIKE', '%' . $request->get('placa_veiculo') . '%');
                                    })->when($request->get('placa_carreta') != "", function ($query) use ($request){
                                            $query->where('PLACA_CARRETA1', 'LIKE', '%' . $request->get('placa_carreta') . '%');
                                    })->where('COD_CLIENTE', $cod_cliente)->with('status')->with('produto')->orderBy('CODIGO')->get();
        } else {
            $agendamentos = Agendamento::when($request->get('num_agendamento') != "", function ($query) use ($request) {
                                            $query->where('CODIGO', $request->get('num_agendamento'));
                                    })->when($request->get('status') != "0", function ($query) use ($request){
                                            $query->where('COD_STATUS_AGENDAMENTO', $request->get('status'));
                                    })->when($request->get('produto') != "0", function ($query) use ($request){
                                            $query->where('COD_PRODUTO', $request->get('produto'));
                                    })->when($request->get('data_especifica') != "", function ($query) use ($request){
                                            $query->where('DATA_AGENDAMENTO', $request->get('data_especifica'));
                                    })->when($request->get('num_pedido') != "", function ($query) use ($request){
                                            $query->where('NUM_PEDIDO', $request->get('num_pedido'));
                                    })->when($request->get('transportadora') != "", function ($query) use ($request){
                                            $query->where('TRANSPORTADORA', 'LIKE', '%' . $request->get('transportadora') .'%');
                                    })->when($request->get('placa_veiculo') != "", function ($query) use ($request){
                                            $query->where('PLACA_VEICULO', 'LIKE', '%' . $request->get('placa_veiculo') . '%');
                                    })->when($request->get('placa_carreta') != "", function ($query) use ($request){
                                            $query->where('PLACA_CARRETA1', 'LIKE', '%' . $request->get('placa_carreta') . '%');
                                    })->where('COD_CLIENTE', $cod_cliente)->with('status')->with('produto')->orderBy('CODIGO')->get();
        }

        return response()->json($agendamentos);
    }

    public function verDetalhe($cod_agendamento) {
        $agendamento = Agendamento::where('CODIGO', $cod_agendamento)->with('tipoVeiculo')->with('embalagem')->first();

        if($agendamento != null) {
                return view('cliente.agendamento_detalhes', compact('agendamento'));
        }
    }

    public function totalAgendado() {
        $cod_cliente = Auth::user()->getAuthIdentifier();

        $agendamentos = DB::select("SELECT SUM(QUANTIDADE) AS TOTAL, TRANSPORTADORA from agendamentos where COD_CLIENTE = $cod_cliente and COD_STATUS_AGENDAMENTO<= 3 group by TRANSPORTADORA");
        $total_agendado = Agendamento::where('COD_CLIENTE', $cod_cliente)->where('COD_STATUS_AGENDAMENTO', '<=', '3')->sum('QUANTIDADE');
        
        return view('cliente.total_agendado', compact('agendamentos', 'total_agendado'));
    }

    public function filtrarTotalAgendado(Request $request) {
        $cod_cliente = Auth::user()->getAuthIdentifier();

        if($request->get('data_agendamento') != '') {
            $data = $request->get('data_agendamento');
            $agendamentos = DB::select("SELECT SUM(QUANTIDADE) AS TOTAL, TRANSPORTADORA from agendamentos where COD_CLIENTE = $cod_cliente and COD_STATUS_AGENDAMENTO<= 3 and DATA_AGENDAMENTO = '$data' group by TRANSPORTADORA");
            $total_agendado = Agendamento::where('COD_CLIENTE', $cod_cliente)->where('COD_STATUS_AGENDAMENTO', '<=', '3')->where('DATA_AGENDAMENTO', '=', $data)->sum('QUANTIDADE');
            return view('cliente.total_agendado', compact('agendamentos', 'total_agendado'));
        }
        else {
            return redirect()->route('cliente.total_agendado');
        }
    }

    public function formataValor($valor){
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }
}
