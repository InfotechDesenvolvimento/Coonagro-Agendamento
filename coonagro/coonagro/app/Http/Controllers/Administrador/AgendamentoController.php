<?php


namespace App\Http\Controllers\Administrador;


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
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AgendamentoController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $tipos = TipoVeiculo::orderBy('TIPO_VEICULO')->get();
        $embalagens = TipoEmbalagem::orderBy('TIPO_EMBALAGEM')->get();

        return view('administrador.agendamento', compact(['tipos', 'embalagens']));
    }

    public function show($codigo){
        return Agendamento::where('CODIGO', $codigo)->with(['produto', 'embalagem', 'tipoVeiculo'])->first();
    }

    public function imprimir($cod_agendamento){
        $agendamento = $this->show($cod_agendamento);

        $qrcode = QrCode::size(150)->generate($agendamento->CODIGO);
        
        set_time_limit(300);

        return \PDF::loadView('administrador.imprimir', ['agendamento' => $agendamento, 'qrcode' => $qrcode])
            ->stream('agendamento-coonagro.pdf');
    }
    
    public function getCliente($cod_cliente){
        $cliente = Cliente::find($cod_cliente);
        return $cliente->NOME;
    }

    public function totalAgendadoClientes() {

        //$agendamentos = Agendamento::where('COD_CLIENTE', $cod_cliente)->groupBy('TRANSPORTADORA')->get();
        $agendamentos = DB::select("SELECT SUM(QUANTIDADE) AS TOTAL, clientes.NOME AS CLIENTE FROM agendamentos
                                    LEFT OUTER JOIN clientes on (clientes.CODIGO = agendamentos.COD_CLIENTE)
                                    GROUP BY clientes.NOME");
        $total_agendado = Agendamento::sum('QUANTIDADE');
        
        //DB::table('agendamentos')->select('SELECT SUM(QUANTIDADE) AS TOTAL FROM agendamentos')->where('COD_CLIENTE', $cod_cliente);

        //return json_encode($agendamentos);
        return view('administrador.total_agendado_clientes', compact('agendamentos', 'total_agendado'));
    }

    public function totalAgendadoTransportadoras() {

        //$agendamentos = Agendamento::where('COD_CLIENTE', $cod_cliente)->groupBy('TRANSPORTADORA')->get();
        $agendamentos = DB::select("SELECT SUM(QUANTIDADE) AS TOTAL, TRANSPORTADORA from agendamentos group by TRANSPORTADORA");
        $total_agendado = Agendamento::sum('QUANTIDADE');
        
        //DB::table('agendamentos')->select('SELECT SUM(QUANTIDADE) AS TOTAL FROM agendamentos')->where('COD_CLIENTE', $cod_cliente);

        //return json_encode($agendamentos);
        return view('administrador.total_agendado_transportadoras', compact('agendamentos', 'total_agendado'));
    }

    public function filter(Request $request) {
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
                                        })->with('status')->with('produto')->orderBy('CODIGO')->get();
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
                                        })->with('status')->with('produto')->orderBy('CODIGO')->get();
        }

        return response()->json($agendamentos);
    }
}
