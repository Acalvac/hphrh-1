<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\EmpleadoFormRequest;
use App\Empleado;
use App\Persona;
use DB;
use PDF;
use DateTime;
use Carbon\Carbon;  // para poder usar la fecha y hora
use Response;
use Illuminate\Support\Collection;

class SController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function pdf()
    {
        $empleados = Persona::all();
        $pdf= PDF::loadView('empleado.solicitante.pdf',['empleados' => $empleados]);
        return $pdf->download('empleados.pdf');
    }
    public function Spdf($id)
    {
        $persona=DB::table('persona as p')
        ->join('municipio as m','p.idmunicipio','=','m.idmunicipio')
        ->join('departamento as dp','m.iddepartamento','=','dp.iddepartamento')
        ->join('empleado as em','p.identificacion','=','em.identificacion')
        ->join('afiliado as a','p.idafiliado','=','a.idafiliado')
        ->join('puesto as pu','p.idpuesto','=','pu.idpuesto')
        ->select('p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3','p.telefono','p.celular','p.fechanac','p.avenida','p.calle','p.nomenclatura','p.zona','p.barriocolonia','dp.nombre as departamento','m.nombre as municipio','a.nombre as afiliado','pu.nombre as puesto')
        ->where('em.identificacion','=',$id)
        ->first();



        $fedad = new DateTime($persona->fechanac);
        
        $month = $fedad->format('m');
        $day = $fedad->format('d');
        $year = $fedad->format('Y');
        $fnac = Carbon::createFromDate($year,$month,$day)->age;


        $empleado=DB::table('empleado as e')
        ->join('estadocivil as ec','e.idcivil','=','ec.idcivil')
        ->select('e.identificacion','e.afiliacionigss','e.numerodependientes','e.aportemensual','e.vivienda','e.alquilermensual','e.otrosingresos','e.pretension','e.nit','e.fechasolicitud','ec.estado as estadocivil')
        ->where('e.identificacion','=',$id)
        ->first();

        $academicos=DB::table('personaacademico as pc')
        ->join('persona as p','pc.identificacion','=','p.identificacion')
        ->join('nivelacademico as na','pc.idnivel','=','na.idnivel')
        ->select('pc.titulo','pc.establecimiento','pc.duracion','na.nombrena as nivel','pc.fingreso','pc.fsalida')
        ->where('pc.identificacion','=',$id)

        ->get();

        $experiencias=DB::table('personaexperiencia as pe')
        ->join('persona as p','pe.identificacion','=','p.identificacion')
        ->select('pe.empresa','pe.puesto','pe.jefeinmediato','pe.motivoretiro','pe.ultimosalario','pe.fingresoex','pe.fsalidaex')
        ->where('pe.identificacion','=',$id)
        ->get();

        $familiares=DB::table('personafamilia as pf')
        ->join('persona as p','pf.identificacion','=','p.identificacion')
        ->select('pf.nombref','pf.apellidof','pf.telefonof','pf.parentezco','pf.ocupacion','pf.edad','pf.emergencia')
        ->where('p.identificacion','=',$id)
        ->get();

        $idiomas=DB::table('empleadoidioma as ei')
        ->join('idioma as i','ei.ididioma','=','i.ididioma')
        ->join('empleado as e','ei.idempleado','=','e.idempleado')
        ->join('persona as p','e.identificacion','=','p.identificacion')
        ->select('i.nombre as idioma','ei.nivel')
        ->where('p.identificacion','=',$id)
        ->get();

        $referencias=DB::table('personareferencia as pr')
        ->join('persona as p','pr.identificacion','=','p.identificacion')
        ->select('pr.nombrer','pr.telefonor','pr.profesion','pr.tiporeferencia')
        ->where('p.identificacion','=',$id)
        ->get();

        $deudas=DB::table('personadeudas as pd')
        ->join('persona as p','pd.identificacion','=','p.identificacion')
        ->select('pd.acreedor','pd.amortizacionmensual as pago','pd.montodeuda')
        ->where('p.identificacion','=',$id)
        ->get();

        $padecimientos =DB::table('personapadecimientos as pad')
        ->join('persona as p','pad.identificacion','=','p.identificacion')
        ->select('pad.nombre')
        ->where('p.identificacion','=',$id)
        ->get();

        $factual = Carbon::now('America/Guatemala');
        $factual = $factual->format('d-m-Y h:i A'); 
        //$factual = $factual->toDateTimeString();
        /*
        return view ('empleado.solicitante.pdf',["persona"=>$persona,"empleado"=>$empleado,"academicos"=>$academicos,"experiencias"=>$experiencias,"familiares"=>$familiares,"idiomas"=>$idiomas,"referencias"=>$referencias,"deudas"=>$deudas,"padecimientos"=>$padecimientos,"factual"=>$factual,"fnac"=>$fnac]);
        */
        
        $pdf= PDF::loadView('empleado.solicitante.pdf',["persona"=>$persona,"empleado"=>$empleado,"academicos"=>$academicos,"experiencias"=>$experiencias,"familiares"=>$familiares,"idiomas"=>$idiomas,"referencias"=>$referencias,"deudas"=>$deudas,"padecimientos"=>$padecimientos,"factual"=>$factual,"fnac"=>$fnac]);
        return $pdf->download('solicitante.pdf');        
    }
    public function index(Request $request)
    {
        if($request)
        {
            $query=trim($request->get('searchText'));
            $empleados=DB::table('empleado as e')
            ->join('persona as p','e.identificacion','=','p.identificacion')
            ->join('estadocivil as ec','e.idcivil','=','ec.idcivil')
            ->join('puesto as pu','p.idpuesto','=','pu.idpuesto')
            ->join('afiliado as af','p.idafiliado','=','af.idafiliado')
            ->join('status as s','e.idstatus','=','s.idstatus')
            ->select('e.idempleado','e.identificacion','e.nit','p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','ec.estado as estadocivil','s.idstatus','s.statusemp as status','pu.nombre as puesto','af.nombre as afnombre')
            //->where('p.nombre1','LIKE','%'.$query.'%')
            //->andwhere('p.apellido1','LIKE','%'.$query.'%')

            ->where('s.statusemp','=','Aspirante')
            ->orwhere('s.statusemp','=','Solicitante Interno')

            ->where('p.nombre1','LIKE','%'.$query.'%')
            //->orwhere('p.apellido1','LIKE','%'.$query.'%')

            ->groupBy('e.idempleado','e.identificacion','e.nit','p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','ec.estado','s.statusemp','pu.nombre','af.nombre')
            ->orderBy('e.idempleado','desc')
            
            ->paginate(12);

            return view('empleado.solicitante.index',["empleados"=>$empleados,"searchText"=>$query]);
        }
    }
    public function show($id)
    {
        $municipio=DB::table('persona as p')
        ->join('municipio as m','p.idmunicipio','=','m.idmunicipio')
        ->select('m.idmunicipio')
        ->where('p.identificacion','=',$id)
        ->first();

        if (empty($municipio->idmunicipio)) {
          $persona=DB::table('persona as p')
            ->join('empleado as em','p.identificacion','=','em.identificacion')
            ->join('afiliado as a','p.idafiliado','=','a.idafiliado')
            ->join('puesto as pu','p.idpuesto','=','pu.idpuesto')
            ->select('p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3','p.celular as telefono','p.fechanac','p.barriocolonia','a.nombre as afiliado','pu.nombre as puesto','p.finiquitoive')
            ->where('em.identificacion','=',$id)
            ->first();
        }
        else
        {    
            $persona=DB::table('persona as p')
            ->join('municipio as m','p.idmunicipio','=','m.idmunicipio')
            ->join('departamento as dp','m.iddepartamento','=','dp.iddepartamento')
            ->join('empleado as em','p.identificacion','=','em.identificacion')
            ->join('afiliado as a','p.idafiliado','=','a.idafiliado')
            ->join('puesto as pu','p.idpuesto','=','pu.idpuesto')
            ->select('p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3','p.celular as telefono','p.fechanac','p.barriocolonia','dp.nombre as departamento','m.nombre as municipio','a.nombre as afiliado','pu.nombre as puesto','p.finiquitoive')
            ->where('em.identificacion','=',$id)
            ->first();
        }
        //dd($persona,$municipio);
        /*$downloads=DB::table('persona as p')
        ->select('p.finiquitoive')
        ->where('p.identificacion','=',$id)
        ->first();*/

        $empleado=DB::table('empleado as e')
        ->join('estadocivil as ec','e.idcivil','=','ec.idcivil')
        ->select('e.idempleado','e.identificacion','e.afiliacionigss','e.numerodependientes','e.aportemensual','e.vivienda','e.alquilermensual','e.otrosingresos','e.pretension','e.nit','e.fechasolicitud','ec.idcivil','ec.estado as estadocivil','e.observacion')
        ->where('e.identificacion','=',$id)
        ->first();

        $academicos=DB::table('personaacademico as pc')
        ->join('persona as p','pc.identificacion','=','p.identificacion')
        ->join('nivelacademico as na','pc.idnivel','=','na.idnivel')
        ->select('pc.idpacademico' ,'pc.titulo','pc.establecimiento','pc.duracion','na.idnivel','na.nombrena as nivel','pc.fingreso','pc.fsalida','pc.observacion')
        ->where('pc.identificacion','=',$id)
        ->get();

        $experiencias=DB::table('personaexperiencia as pe')
        ->join('persona as p','pe.identificacion','=','p.identificacion')
        ->select('pe.idpexperiencia' ,'pe.empresa','pe.puesto','pe.jefeinmediato','pe.motivoretiro','pe.ultimosalario','pe.fingresoex','pe.fsalidaex')
        ->where('pe.identificacion','=',$id)
        ->get();

        $familiares=DB::table('personafamilia as pf')
        ->join('persona as p','pf.identificacion','=','p.identificacion')
        ->select('pf.idpfamilia','pf.nombref','pf.apellidof','pf.telefonof','pf.parentezco','pf.ocupacion','pf.edad','pf.emergencia')
        ->where('p.identificacion','=',$id)
        ->get();

        $familiares1=DB::table('personafamilia as pf')
        ->join('persona as p','pf.identificacion','=','p.identificacion')
        ->select('pf.observacion')
        ->where('p.identificacion','=',$id)
        ->first();

        $idiomas=DB::table('empleadoidioma as ei')
        ->join('idioma as i','ei.ididioma','=','i.ididioma')
        ->join('empleado as e','ei.idempleado','=','e.idempleado')
        ->join('persona as p','e.identificacion','=','p.identificacion')
        ->select('i.nombre as idioma','ei.nivel')
        ->where('p.identificacion','=',$id)
        ->get();

        $referencias=DB::table('personareferencia as pr')
        ->join('persona as p','pr.identificacion','=','p.identificacion')
        ->select('pr.idpreferencia' ,'pr.nombrer','pr.telefonor','pr.profesion','pr.tiporeferencia')
        ->where('p.identificacion','=',$id)
        ->get();

        $deudas=DB::table('personadeudas as pd')
        ->join('persona as p','pd.identificacion','=','p.identificacion')
        ->select('pd.idpdeudas','pd.acreedor','pd.amortizacionmensual as pago','pd.montodeuda','pd.motivodeuda')
        ->where('p.identificacion','=',$id)
        ->get();

        $padecimientos =DB::table('personapadecimientos as pad')
        ->join('persona as p','pad.identificacion','=','p.identificacion')
        ->select('pad.idppadecimientos','pad.nombre')
        ->where('p.identificacion','=',$id)
        ->get();

        $pais=DB::table('trabajoextranjero as te')
        ->join('pais as ps','te.idpais','=','ps.idpais')
        ->join('persona as p','te.identificacion','=','p.identificacion')
        ->select('te.trabajoext','te.forma','te.motivofin','ps.nombre')
        ->where('p.identificacion','=',$id)
        ->get();

        $pariente=DB::table('puestopublico as pp')
        ->join('persona as p','pp.identificacion','=','p.identificacion')
        ->select('pp.nombre','pp.puesto','pp.dependencia')
        ->where('p.identificacion','=',$id)
        ->get();

        $observaciones=DB::table('persona as p')
        ->join('personaacademico as pa','pa.identificacion','=','p.identificacion')
        ->join('personafamilia as pf','pf.identificacion','=','p.identificacion')
        ->join('personareferencia as pr','pr.identificacion','=','p.identificacion')
        ->join('personaexperiencia as pe','pe.identificacion','=','p.identificacion')
        ->select('pa.observacion as obpa','pf.observacion as obpf','pr.observacion as obpr','pe.observacion as obpe')
        ->where('p.identificacion','=',$id)
        ->first();
      
        $nivelacademico = DB::table('nivelacademico')->get();
        $estadocivil=DB::table('estadocivil')->get();

        return view('empleado.solicitante.show',["persona"=>$persona,"empleado"=>$empleado,"academicos"=>$academicos,"experiencias"=>$experiencias,"familiares"=>$familiares,"idiomas"=>$idiomas,"referencias"=>$referencias,"deudas"=>$deudas,"padecimientos"=>$padecimientos,"pais"=>$pais,"pariente"=>$pariente,"nivelacademico"=>$nivelacademico,"estadocivil"=>$estadocivil,"observaciones"=>$observaciones]);
    }
    public function rechazo($idE,$idS)
    {
        if ($idS=="12") {
            $st=Empleado::find($idE);
            $st-> idstatus='2';
            $st->update();
        }
        if ($idS=="1") {
            $st=Empleado::find($idE);
            $st-> idstatus='10';
            $st->update();
        }
        return Redirect::to('empleado/solicitante');
    }
    public function rechazoPP($idE)
    {

        $st=Empleado::find($idE);
        $st-> idstatus='10';
        $st->update();
        return Redirect::to('listados/pprueba');
    }
    public function rechazoPI($idE)
    {

        $st=Empleado::find($idE);
        $st-> idstatus='10';
        $st->update();
        return Redirect::to('listados/interino');
    }
    public function upt (Request $request)
    {
        $id = $request->get('idempleado');

        $od=Empleado::findOrFail($id);
        $od-> observacion=$request->get('observacion');
        $od->save();
        return response()->json($od);
    }
}
