<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;
use App\GastoEncabezado;
use App\GastoViajeEmpleado;
use App\Viaje;
use App\ViajeVehiculo;
use App\GastoViaje;
use App\Vehiculo;
use App\Persona;
use App\Constants;
use Illuminate\Support\Collection as Collection;

use Carbon\Carbon;  // para poder usar la fecha y hora

class ACajaChica extends Controller
{
	public function index(){
        return view ('asistente.cajachica.index');
    }

    public function retornaindex(){
        return view ('empleado.viaje.retornaindex');
    }

    public function create(){
        $proyectos = DB::table('proyecto as pca')
            ->select('pca.idproyecto','pca.nombreproyecto as proyecto')
            ->get();

        $vehiculos = DB::table('vehiculo as veh')
            ->join('vstatus as vst','veh.idvstatus','=','vst.idvstatus')
            ->select('veh.color','veh.marca','veh.modelo','veh.idvehiculo')
            ->where('veh.idvstatus','=',1)
            ->get();

        $eles = DB::table('codigointerno as cin')
        	->join('codigoraiz as cra','cin.idele','=','cra.idele')
            ->select('cin.codigo','cin.nombre','cra.codigo as L','cra.nombre as craiz')
            ->get();

        return view ('asistente.cajachica.create',["eles"=>$eles,"proyectos"=>$proyectos,"vehiculos"=>$vehiculos]);
    }

    public function empleado(){
        $empleado = DB::table('empleado as emp')
            ->join('persona as per','emp.identificacion','=','per.identificacion')
            ->join('users as U','per.identificacion','=','U.identificacion')
            ->select('emp.idempleado','per.idafiliado')
            ->where('U.id','=',Auth::user()->id)
            ->first();

        return $empleado;
    }

    public function store(Request $request){
        $this->validateRequest($request);
        try
        {
            DB::beginTransaction();
            $afiliado = $request->afiliado;
            $cajachica = DB::table('cajachica as caj')
                ->select('caj.idcajachica')
                ->where('caj.idafiliado','=',$afiliado->idafiliado)
                ->first();


            $fechainicio = $request->fecha_inicio; 
            $fechafinal = $request->fecha_final;

            $fechainicio = Carbon::createFromFormat('d/m/Y',$fechainicio);
            $fechafinal = Carbon::createFromFormat('d/m/Y',$fechafinal);

            $fini = $fechainicio;
            $ffin = $fechafinal;

            $fechainicio = $fechainicio->toDateString();
            $fechafinal = $fechafinal->toDateString();

            if($fechafinal >= $fechainicio){

                //Gasto encabezado
                $encabezado = new GastoEncabezado;
                $viaje = new Viaje;
                $gastoviaje = new  GastoViaje;

                $days = 1;

                while ($ffin >= $fini) {
                    if($fini != $ffin){
                        $days++;
                        $fini->addDay();
                    }
                    else{
                        break;
                    }
                }

                $mytime = Carbon::now('America/Guatemala');
                $today = Carbon::now();
                $year = $today->format('Y');
                $month = $today->format('m');

                $encabezado-> fechasolicitud = $mytime->toDateString(); 
                $encabezado-> montosolicitado = $request->monto_solicitado;
                $encabezado-> chequetransfe = $request->cheque_o_transferencia;
                $encabezado-> montogastado = 0;
                $encabezado-> fechaliquidacion = $mytime->toDateString();
                $encabezado-> moneda = $request->moneda;
                $encabezado-> periodo = $year.'/'.$month;
                $encabezado-> idtipogasto = 1;
                $encabezado-> idproyecto = $request->proyecto;
                $encabezado-> idempleado = $this->empleado()->idempleado;
                $encabezado-> statusgasto = 'solicitado';
                $encabezado-> statuspago = 0;
                $encabezado-> observacion = $request->motivo;
                $encabezado-> idcajachica = $cajachica->idcajachica;

                $encabezado->save();

                $viaje-> fechainicio = $fechainicio;
                $viaje-> fechafin = $fechafinal;
                $viaje-> numerodias = $days;
                $viaje-> motivo = $request->motivo;

                $viaje->save();

                $gastoviaje-> idgastocabeza = $encabezado->idgastocabeza;
                $gastoviaje-> idviaje = $viaje->idviaje;
                $gastoviaje->save();
            }
            else{
                return response()->json(array('error'=>'la fecha inicio no puede ser mayor que la fecha final'),404);
            }

            DB::commit();
        }catch (\Exception $e) 
        {
            DB::rollback();
            return response()->json(array('error' => 'No se ha podido enviar la solicitud'),404);         
        }
        return response()->json($encabezado);
    }

    // metodos de una nueva liquidación ..
    public function liquidar($id){
        $proyecto = DB::table('cajachica as caj')
            ->join('gastoencabezado as gen','caj.idcajachica','=','gen.idcajachica')
            ->join('proyecto as pca','gen.idproyecto','=','pca.idproyecto')
            ->join('gastoviaje as gvi','gen.idgastocabeza','=','gvi.idgastocabeza')
            ->join('viaje as via','gvi.idviaje','=','via.idviaje')
            ->where('gen.statusgasto','=','Autorizado')
            ->where('gen.idcajachica','=', $id)
            ->select('gen.idgastocabeza','gen.fechasolicitud','caj.monto','gen.chequetransfe','gen.moneda','gen.periodo','gen.idproyecto','pca.nombreproyecto','via.fechainicio','via.fechafin','gen.idempleado','gen.idgastocabeza','gvi.idgastoviaje','via.idviaje')
            ->first();

        if (empty($proyecto->idgastocabeza)) {
            $liquidar = 0;
            return view ('empleado.viaje.indexliquidar',["liquidar"=>$liquidar]);
        }
        else{
            $liquidar = 1;

            $liquidacion= DB::table('gastoviajeempleado as gve')
                ->join('gastoviaje as gvi','gve.idgastoviaje','=','gvi.idgastoviaje')
                ->join('gastoencabezado as gen','gvi.idgastocabeza','=','gen.idgastocabeza')
                ->join('cajachica as caj','gen.idcajachica','=','caj.idcajachica')
                ->select(DB::raw('SUM(gve.montofactura) as liquidacion'))
                ->where('caj.idcajachica','=',$id)
                ->first();

            $gastoviajeemp = DB::table('gastoviajeempleado as gve')
                ->join('proyecto as pro','gve.idproyecto','=','pro.idproyecto')
                ->join('gastoviaje as gvi','gve.idgastoviaje','=','gvi.idgastoviaje')
                ->join('empleado as emp','gve.idempleado','=','emp.idempleado')
                ->join('persona as per','emp.identificacion','=','per.identificacion')
                ->join('plancuentas as pcu','gve.codigocuenta','pcu.codigocuenta')
                ->join('gastoencabezado as gen','gvi.idgastocabeza','=','gen.idgastocabeza')
                ->join('cajachica as caj','gen.idcajachica','=','caj.idcajachica')
                ->select('per.nombre1','per.nombre2','per.nombre3','per.apellido1','per.apellido2','per.apellido3','gve.factura','gve.fechafactura as fecha','gve.montofactura as monto','gve.descripcion','pcu.nombrecuenta as cuenta','pro.nombreproyecto as proyecto','gve.idgastoempleado')
                ->where('caj.idcajachica','=',$id)
                ->get();

            $vehiculo = DB::table('viajevehiculo as vve')
                ->join('vehiculo as veh','vve.idvehiculo','=','veh.idvehiculo')
                ->select('veh.placa','veh.color','veh.marca','veh.modelo','veh.kilacumulado','vve.idviajevehiculo','vve.kilometrajeini','vve.kilometrajefin')
                ->where('vve.idviaje','=',$proyecto->idviaje)
                ->get();

            return view ('empleado.viaje.indexliquidar',["proyecto"=>$proyecto,"gastoviajeemp"=>$gastoviajeemp,"vehiculo"=>$vehiculo,"liquidar"=>$liquidar,"liquidacion"=>$liquidacion]);
        }
    }

    public function indexliquidar(){
        $viaje = DB::table('cajachica as caj')
            
            ->join('empleado as emp','caj.idempleado','=','emp.idempleado')
            ->select('caj.fechainicio','caj.monto','caj.status','caj.idcajachica')
            ->where('emp.idempleado','=',$this->empleado()->idempleado)
            ->get();
        return view ('asistente.cajachica.indexviaje',["viaje"=>$viaje]);
    }

    public function validateRequest($request){
        $rules=[
        'fecha_inicio' => 'required',
        'fecha_final' => 'required',
        'motivo' => 'required',
        ];
        $messages=[
          'required' => 'Debe ingresar :attribute.',
          'max'  => 'La capacidad del campo :attribute es :max',
        ];
        $this->validate($request, $rules,$messages);        
    }
}
