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

    public function filter(Request $request) {
        
        $agendamentos = Agendamento::when($request->get('num_agendamento') != "", function ($query) use ($request) {
                                            $query->where('CODIGO', $request->get('num_agendamento'));
                                    })->when($request->get('status') != "0", function ($query) use ($request){
                                            $query->where('COD_STATUS_AGENDAMENTO', $request->get('status'));
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

        /*$agendamentos = DB::table('agendamentos')
                        ->select('agendamentos.*', 'produtos.DESCRICAO')
                        ->leftJoin('produtos', 'produtos.CODIGO', '=', 'agendamentos.COD_PRODUTO')
                        ->when($request->get('num_agendamento') != "", function ($query) use ($request) {
                            $query->where('CODIGO', $request->get('num_agendamento'));
                        })->when($request->get('status') != "0", function ($query) use ($request){
                            $query->where('COD_STATUS_AGENDAMENTO', $request->get('status'));
                        })->when($request->get('data_inicial') != "", function ($query) use ($request){
                            $query->where('DATA_AGENDAMENTO', '>=', $request->get('data_inicial'));
                        })->when($request->get('data_final') != "", function ($query) use ($request){
                                $query->where('DATA_AGENDAMENTO', '<=', $request->get('data_final'));
                        })->with('status')->groupBy('agendamentos.CODIGO')->get();

        $agendamentos = Agendamento::when($request->get('num_agendamento') != "", function ($query) use ($request) {
                                //$query->where('CODIGO', $request->get('num_agendamento'));
                        })->when($request->get('status') != "0", function ($query) use ($request){
                                //$query->where('COD_STATUS_AGENDAMENTO', $request->get('status'));
                        })->when($request->get('data_inicial') != "", function ($query) use ($request){
                                //$query->where('DATA_AGENDAMENTO', '>=', $request->get('data_inicial'));
                        })->when($request->get('data_final') != "", function ($query) use ($request){
                                //$query->where('DATA_AGENDAMENTO', '<=', $request->get('data_final'));
                        })->with('status')->orderBy('COD_CLIENTE')->get();
        */

        return response()->json($agendamentos);
    }
}
