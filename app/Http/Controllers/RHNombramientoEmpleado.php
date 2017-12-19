<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Storage;
use DB;
use Carbon\Carbon;  // para poder usar la fecha y hora
use Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use App\Empleado;
use App\Puesto;
use App\Afiliado;
use App\Nomytras;
use App\Vacadetalle;
use App\Asignajefe;
use App\Persona;
use App\Constants;

use App\Http\Requests\Nomrequest;



class RHNombramientoEmpleado extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

    	$casos=DB::table('caso as c')
        ->select('c.idcaso','c.nombre')
        ->where('c.idcaso','=',6)
        
        ->orderBy('c.nombre','asc')
        ->get();

        $queryN=trim($request->get('searchText'));  
        $query=trim($request->get('select'));

        $empleado=Empleado::join('nomytras as nt','empleado.idempleado','=','nt.idempleado')
        ->join('status as st','empleado.idstatus','=','st.idstatus')
        ->join('puesto as pu','nt.idpuesto','=','pu.idpuesto')
        ->join('afiliado as af','nt.idafiliado','=','af.idafiliado')
        ->join('caso as c','c.idcaso','=','nt.idcaso')
        ->select('empleado.idempleado','empleado.identificacion','empleado.nit','st.statusemp as statusn','pu.nombre as puesto','af.nombre as afiliado','c.idcaso',DB::raw('max(nt.idnomytas) as idnomytas'))
        ->where('empleado.idstatus','=', 2)
        ->groupBy('empleado.idempleado')      
        ->orderBy('empleado.idempleado','desc')
        ->paginate(15);

        $status = DB::table('status as st')
        ->select('st.idstatus','st.statusemp')
        ->where('st.idstatus','=',5)
        ->get();
        /*
    	       $puestos=Puesto::all();

        $caso=DB::table('caso as c')
        ->select('c.idcaso','c.nombre')
        ->where('c.idcaso','=',6)
        ->get();

        $jefesinmediato=DB::table('persona as per')
        ->join('empleado as em','per.identificacion','=','em.identificacion')
        ->join('status as sts','em.idstatus','=','sts.idstatus')
        ->select('per.identificacion','per.nombre1','per.nombre2','per.apellido1','per.apellido2')
        ->where('em.idstatus','=',2)
        ->get();


        return view("rrhh.empleados.nombramiento",["puestos"=>$puestos,"afiliados"=>$afiliados,"caso"=>$caso,"empleado"=>$empleado,"jefesinmediato"=>$jefesinmediato]);

        */
        return view("rrhh.empleados.indexnombramiento",["empleado"=>$empleado,"searchText"=>$queryN,"casos"=>$casos,"select"=>$query,"status"=>$status]);
    }
    

    public function busqueda($caso,$dato="")
    {

        $empleado= Empleado::Busqueda($caso,$dato)->join('nomytras as nt','empleado.idempleado','=','nt.idempleado')
        ->join('status as st','empleado.idstatus','=','st.idstatus')
        ->join('puesto as pu','nt.idpuesto','=','pu.idpuesto')
        ->join('afiliado as af','nt.idafiliado','=','af.idafiliado')
        ->join('caso as c','c.idcaso','=','nt.idcaso')
        ->select('empleado.idempleado','empleado.identificacion','empleado.nit','st.statusemp as statusn','pu.nombre as puesto','af.nombre as afiliado','c.idcaso',DB::raw('max(nt.idnomytas) as idnomytas'))
        ->where('empleado.idstatus','!=', 5)
        ->groupBy('empleado.idempleado')      
        ->orderBy('empleado.idempleado','desc')
        ->paginate(20);

        $status = DB::table('status as st')
        ->select('st.idstatus','st.statusemp')
        ->where('st.idstatus','=',5)
        ->get();

        return view('rrhh.empleados.indexnombramiento')
        ->with("empleado", $empleado )
        ->with("status", $status);
    }


    public function addnombramiento($id)
    {
        $puestos=Puesto::all();

        $empleado=DB::table('empleado as e')
        ->join('persona as p','e.identificacion','=','p.identificacion')
        ->select('e.idempleado','p.nombre1','p.apellido1','p.nombre2','p.apellido2','p.idpuesto','p.idafiliado')
        ->where('e.idempleado','=',$id)
        ->first();

        $afiliados=Afiliado::all();

        $caso=DB::table('caso as c')
        ->select('c.idcaso','c.nombre')
        ->where('c.idcaso','=',6)
        ->get();

        $jefesinmediato=DB::table('persona as per')
        ->join('empleado as em','per.identificacion','=','em.identificacion')
        ->join('status as sts','em.idstatus','=','sts.idstatus')
        ->select('per.identificacion','per.nombre1','per.nombre2','per.apellido1','per.apellido2')
        ->where('em.idstatus','=',2)
        ->get();

        $jefeasignado = DB::table('persona as per')
        ->join('empleado as em','per.identificacion','=','em.identificacion')
        ->join('asignajefe as aj','per.identificacion','=','aj.identificacion')
        ->select('per.identificacion','per.nombre1','per.nombre2','per.apellido1','per.apellido2')
        ->where('aj.idempleado','=',$id)
        ->get();

        $jefe1 = new Asignajefe();

        $jefes = $jefe1->selectQuery(Constants::ASIGNAJEFE_PROYECTO_QUERY,array($id));

        return view("rrhh.empleados.nombramiento",["puestos"=>$puestos,"afiliados"=>$afiliados,"caso"=>$caso,"empleado"=>$empleado,"jefesinmediato"=>$jefesinmediato,"jefeasignado"=>$jefeasignado,"jefes"=>$jefes]);
        //return Redirect::to('listados/pprueba/create');
    }

     public function modificar_dcontable(Request $request)
    {
        $empleado = Empleado::findOrFail($request->empleado);
        $empleado->l4 = $request->l4;
        $empleado->ctabanco = $request->cuentaban;
        $empleado->save();

        return response()->json($empleado);
    }

    public function asignar_jefeinmediato($idempleado,$identificacion,$notifica){

        $asignajefe = new asignajefe;
        $asignajefe->identificacion = $identificacion;
        $asignajefe->idempleado = $idempleado;
        if($notifica == "No")
        {
            $notifica =0;
        }
        if($notifica == "Si")
        {
            $notifica = 1;
        }
        $asignajefe->notifica = $notifica;

        $asignajefe->save();

        $usuario=Empleado::find($idempleado);
        $jefeasignado=$usuario->getpersonas();

       return json_encode ($jefeasignado); 
    }

    public function quitar_jefeinmediato($idempleado,$identificacion){

        $empleado=Empleado::find($idempleado);
        $empleado->revokePersona($identificacion);
        $jefeasignado=$empleado->getpersonas();
        return json_encode ($jefeasignado);
    }

    public function addasecenso(Nomrequest $request)
    {
        try 
        {
            
            $idem = $request->get('idempleado');
            $idco = $request->get('idcaso');
            //$idji = $request->get('idjefe');
            $today = Carbon::now();
            $year = $today->format('Y');

            $fecha=$request->get('fecha');
            $fecha=Carbon::createFromFormat('d/m/Y',$fecha);
            $fecha=$fecha->format('Y-m-d');

            
            $nomtras=new Nomytras;
            $nomtras-> idpuesto=$request->get('idpuesto');
            $nomtras-> idempleado=$idem;
            $nomtras-> fecha=$fecha;
            $nomtras-> salario=$request->get('salario');
            $nomtras-> descripcion=$request->get('descripcion');
            $nomtras-> idafiliado=$request->get('idafiliado');
            $nomtras-> idcaso=$idco;
            $nomtras->save();

            $empleado = Empleado::find($idem);
            $empleado->idstatus = 2;
            $empleado->save();

            $mjf = $request->get('mjf');
            if($mjf == 0)
            {
                $miArray = $request->items;

                $asignajefe = new Asignajefe;



                foreach ($miArray as $key => $value) {
                    $notifica = $value['1'];

                    if($notifica == "No")
                    {
                        $notifica =0;
                    }
                    if($notifica == "Si")
                    {
                        $notifica = 1;
                    }

                    $asignajefe->idempleado = $idem;
                    $asignajefe->identificacion = $value['0'];
                    $asignajefe->notifica = $notifica;
                    $asignajefe->save();
                }
            }            

        } catch (Exception $e) 
        {
            DB::rollback();
            return response()->json(array('error' => 'No se ha podido enviar la peticion de agregar nuevo nombramiento y/o asecenso'),404);         
        }
        $mjf = $request->get('mjf');
          if($mjf == 0)
            {
                return json_encode ($asignajefe); 
            }
            else{
                return json_encode ($nomtras);
            }

        //return Redirect::to('listados/pprueba');
    }
    
    public function store(Nomrequest $request)
    {
        try 
        {
            $idem = $request->get('idempleado');
            //dd($idem);
            $idco = $request->get('idcaso');
            //$idji = $request->get('idjefe');
            $today = Carbon::now();
            $year = $today->format('Y');
            $miArray = $request->items;
            if ($idco=="4")
            {
                //dd($idem,$idco);
                $fecha=$request->get('fecha');
                $fecha=Carbon::createFromFormat('d/m/Y',$fecha);
                $fecha=$fecha->format('Y-m-d');

                $nomtras=new Nomytras;
                $nomtras-> idpuesto=$request->get('idpuesto');
                $nomtras-> idempleado=$idem;
                $nomtras-> fecha=$fecha;
                $nomtras-> salario=$request->get('salario');
                $nomtras-> descripcion=$request->get('descripcion');
                $nomtras-> idafiliado=$request->get('idafiliado');
                $nomtras-> idcaso=$idco;
                $nomtras->save();

                $asignajefe = new Asignajefe;

            foreach ($miArray as $key => $value) {
                $notifica = $value['1'];

                if($notifica == "No")
                {
                    $notifica =0;
                }
                if($notifica == "Si")
                {
                    $notifica = 1;
                }

                $asignajefe->idempleado = $idem;
                $asignajefe->identificacion = $value['0'];
                $asignajefe->notifica = $notifica;
                $asignajefe->save();
            }

                if ($miArray > 0) 
                {
                    foreach ($miArray as $key => $value) {
                        $asjefe = new Asignajefe;
                        $asjefe-> identificacion=$value['0'];
                        $asjefe-> idempleado=$idem;
                        $asjefe-> notifica=$value['1'];
                        $asjefe->save();
                    }
                }

                $vacas=new Vacadetalle;
                $vacas-> idempleado=$idem;
                $vacas-> periodo=$year;
                $vacas-> acuhoras='0';
                $vacas-> acudias='0';
                $vacas-> solhoras='0';
                $vacas-> fecharegistro=$fecha;
                $vacas-> soldias='0';
                $vacas->save();

                $st=Empleado::find($idem);
                $st-> fechaingreso=$fecha;
                $st-> idstatus='9';
                $st-> update();
            }
            if ($idco=="6")
            {
                //dd($idem,$idco);
                $fecha=$request->get('fecha');
                $fecha=Carbon::createFromFormat('d/m/Y',$fecha);
                $fecha=$fecha->format('Y-m-d');

                $nomtras=new Nomytras;
                $nomtras-> idpuesto=$request->get('idpuesto');
                $nomtras-> idempleado=$idem;
                $nomtras-> fecha=$fecha;
                $nomtras-> salario=$request->get('salario');
                $nomtras-> descripcion=$request->get('descripcion');
                $nomtras-> idafiliado=$request->get('idafiliado');
                $nomtras-> idcaso=$idco;
                $nomtras->save();

                if ($miArray > 0) 
                {
                    foreach ($miArray as $key => $value) {
                        $asjefe = new Asignajefe;
                        $asjefe-> identificacion=$value['0'];
                        $asjefe-> idempleado=$idem;
                        $asjefe-> notifica=$value['1'];
                        $asjefe->save();
                    }
                }

                $vacas=new Vacadetalle;
                $vacas-> idempleado=$idem;
                $vacas-> periodo=$year;
                $vacas-> acuhoras='0';
                $vacas-> acudias='0';
                $vacas-> solhoras='0';
                $vacas-> fecharegistro=$fecha;
                $vacas-> soldias='0';
                $vacas->save();

                $st=Empleado::find($idem);
                $st-> fechaingreso=$fecha;
                //$st-> idjefeinmediato=$idji;
                $st-> idstatus='2';
                $st-> update();
            }

            if ($idco=="7") 
            {
                //dd($idem,$idco);
                $fecha=$request->get('fecha');
                $fecha=Carbon::createFromFormat('d/m/Y',$fecha);
                $fecha=$fecha->format('Y-m-d');

                $nomtras=new Nomytras;
                $nomtras-> idpuesto=$request->get('idpuesto');
                $nomtras-> idempleado=$idem;
                $nomtras-> fecha=$fecha;
                $nomtras-> salario=$request->get('salario');
                $nomtras-> descripcion=$request->get('descripcion');
                $nomtras-> idafiliado=$request->get('idafiliado');
                $nomtras-> idcaso=$idco;
                $nomtras->save();

                if ($miArray > 0) 
                {
                    foreach ($miArray as $key => $value) {
                        $asjefe = new Asignajefe;
                        $asjefe-> identificacion=$value['0'];
                        $asjefe-> idempleado=$idem;
                        $asjefe-> notifica=$value['1'];
                        $asjefe->save();
                    }
                }

                $st=Empleado::find($idem);
                $st-> fechaingreso=$fecha;
                //$st-> idjefeinmediato=$idji;
                $st-> idstatus='11';
                $st-> update();
            }

            return response()->json($nomtras);
        } catch (Exception $e) 
        {}
        //return Redirect::to('empleado/listadoR');    
    }
}
