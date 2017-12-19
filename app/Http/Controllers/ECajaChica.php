<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;
use App\GastoViajeEmpleado;
use App\GastoEncabezado;
use App\ViajeVehiculo;
use App\GastoViaje;
use App\Constants;
use App\Vehiculo;
use App\Persona;
use App\Viaje;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;  // para poder usar la fecha y hora

class ECajaChica extends Controller
{
    public function empleado(){
        $empleado = DB::table('empleado as emp')
            ->join('persona as per','emp.identificacion','=','per.identificacion')
            ->join('users as U','per.identificacion','=','U.identificacion')
            ->select('emp.idempleado','per.idafiliado')
            ->where('U.id','=',Auth::user()->id)
            ->first();
        return $empleado;
    }

    public function add(){
        $proyectos = DB::table('proyecto as pca') // todos los proyectos
            ->select('pca.idproyecto','pca.nombreproyecto as proyecto')
            ->get();

        $proyecto = DB::table('proyecto as pca')
            ->select('pca.idproyecto','pca.nombreproyecto as proyecto')
            ->where('pca.indice','=',1)
            ->first();

        $vehiculos = DB::table('vehiculo as veh')
            ->join('vstatus as vst','veh.idvstatus','=','vst.idvstatus')
            ->select('veh.color','veh.marca','veh.modelo','veh.idvehiculo')
            ->where('veh.idvstatus','=',1)
            ->get();

        $eles = DB::table('codigointerno as cin')
            ->join('codigoraiz as cra','cin.idele','=','cra.idele')
            ->select('cin.codigo','cin.nombre','cra.codigo as L','cra.nombre as craiz')
            ->get();

        $afiliado = DB::table('nomytras as ntr')
            ->select('ntr.idafiliado')
            ->where('ntr.idempleado','=',$this->empleado()->idempleado)
            ->orderby('ntr.idnomytas','desc')
            ->first();

        return view ('empleado.cajachica.create',["eles"=>$eles,"proyectos"=>$proyectos,"vehiculos"=>$vehiculos,"afiliado"=>$afiliado,"proyecto"=>$proyecto]);
    }

    public function store(Request $request){
        $this->validateRequest($request);
        try
        {
            DB::beginTransaction();
            $afiliado = $request->afiliado;
            $cajachica = DB::table('cajachica as caj')
                ->select('caj.idcajachica')
                ->where('caj.idafiliado','=',$afiliado)
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
