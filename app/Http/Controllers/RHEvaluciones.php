<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\EmpleadoFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Empleado;
use App\Persona;
use App\Entrevista;
use App\Resultado;
use DB;
use PDF;
use DateTime;
use Carbon\Carbon;  // para poder usar la fecha y hora
use Response;
use Illuminate\Support\Collection;
use Mail;
use App\Constants;

class RHEvaluciones extends Controller
{
  public function envioaevaluar ($id,$em)
  {
    $emp=DB::table('empleado as e')
        ->select('e.idstatus')
        ->where('e.idempleado','=',$id)
        ->first();
        //dd($emp->idstatus);
    if ($emp->idstatus==4) {	
        $od=Empleado::find($id);
        $od-> idstatus = 14;
        $od->save();
    }
    if ($emp->idstatus==17) {   
        $od=Empleado::find($id);
        $od-> idstatus = 18;
        $od->save();
    }

    /*$calculo = array($em);
    Mail::send('emails.envevaluacion',['calculo' => $calculo], function($msj) use ($em){
			$msj->subject('Solicitud de empleo');
        $msj->to($em);
      });*/

        return Redirect::to('empleado/listadoR');
  }

    public function listadoev ()
    {
        $resultado=new Resultado;
        $empleados = $resultado->selectQuery(Constants::listadoresultadosji,array(Auth::user()->id));
        //dd($empleados);
        return view('rrhh.evaluaciones.resultados',["empleados"=>$empleados]);
    }

    public function busquedaevaluacion($dato="")
    {
                $resultado=new Resultado;

                $empleados = $resultado->selectQuery(Constants::busquedaresultadosji,array($dato, Auth::user()->id));

        //$empleados = $resultado->selectQuery(Constants::listadoresultadosji,array(Auth::user()->id));
        //dd($empleados);
        return view('rrhh.evaluaciones.contresultado',["empleados"=>$empleados,"datos"=>$dato]);
    }

    public function listadores (Request $request)
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
            ->where('e.idstatus','=',14)
            ->orwhere('e.idstatus','=',18)
            //->where('p.nombre1','LIKE','%'.$query.'%')
            //->orwhere('p.apellido1','LIKE','%'.$query.'%')

            ->groupBy('e.idempleado','e.identificacion','e.nit','p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','ec.estado','s.statusemp','pu.nombre','af.nombre')
            ->orderBy('e.fechasolicitud','desc')
            
            ->paginate(19);
        }
        $var='4';
        return view('rrhh.evaluaciones.listadoresultados',["empleados"=>$empleados,"searchText"=>$query,"var"=>$var]); 
    }

    public function listadotablares ($id)
    {
        $persona=DB::table('persona as p')
        ->join('empleado as em','p.identificacion','=','em.identificacion')
        ->join('afiliado as a','p.idafiliado','=','a.idafiliado')
        ->join('puesto as pu','p.idpuesto','=','pu.idpuesto')
        ->select('p.identificacion','p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3','p.celular as telefono','p.fechanac','p.barriocolonia','a.nombre as afiliado','pu.nombre as puesto','em.idempleado','em.nit','em.idstatus')
        ->where('em.idempleado','=',$id)
        ->first();

        $resultados=DB::table('empleado as e')
        ->join('resultado as r','r.idempleado','=','e.idempleado')
        ->join('users as urs','urs.id','=','r.evaluador')
        ->join('persona as p','urs.identificacion','=','p.identificacion')
        ->join('evaluadores as es','p.identificacion','=','es.identificacion')
        ->join('unidadmin as udn','udn.idunidad','=','es.idunidad')
        ->select('r.observacion','r.nota','udn.unidadadmin','p.nombre1','p.nombre2','p.apellido1','p.apellido2')
        ->where('e.idempleado','=',$id)
        ->get();
        
        $promedio=DB::table('resultado as r')
        ->select(DB::raw('AVG(r.nota) as promed'),'r.idempleado')
        ->where('r.idempleado','=',$id)
        ->groupBy('r.idempleado')
        ->first();

        return view('rrhh.evaluaciones.resultadose',["persona"=>$persona,"resultados"=>$resultados,"promedio"=>$promedio]); 
    }
    public function nombrelist($id)
    {
        $empleado=DB::table('empleado as e')
        ->join('persona as p','p.identificacion','=','e.identificacion')
        ->select('p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3')
        ->where('e.idempleado','=',$id)
        ->first();

        return response()->json($empleado);
    }   


    public function show ($id)
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
            ->select('p.identificacion','p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3','p.celular as telefono','p.fechanac','p.barriocolonia','a.nombre as afiliado','pu.nombre as puesto','p.finiquitoive')
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
            ->select('p.identificacion','p.nombre1','p.nombre2','p.nombre3','p.apellido1','p.apellido2','p.apellido3','p.celular as telefono','p.fechanac','p.barriocolonia','dp.nombre as departamento','m.nombre as municipio','a.nombre as afiliado','pu.nombre as puesto','p.finiquitoive')
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
        ->select('e.idempleado','e.identificacion','e.afiliacionigss','e.numerodependientes','e.aportemensual','e.vivienda','e.alquilermensual','e.otrosingresos','e.pretension','e.nit','e.fechasolicitud','ec.idcivil','ec.estado as estadocivil','e.observacion','e.idstatus')
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
        ->select('pe.idpexperiencia' ,'pe.empresa','pe.puesto','pe.jefeinmediato','pe.motivoretiro','pe.ultimosalario','pe.fingresoex','pe.fsalidaex','pe.observacion','pe.recomiendaexp','pe.confirmadorexp')
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
        ->select('pr.idpreferencia' ,'pr.nombrer','pr.telefonor','pr.profesion','pr.tiporeferencia','pr.observacion','pr.recomiendaper','pr.confirmadorref')
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

        $entrev=DB::table('persona as p')
        ->join('empleado as e','e.identificacion','=','p.identificacion')
        ->join('entrevista as en','en.perentrevista','=','p.identificacion')
        ->select('en.identrevista')
        ->where('p.identificacion','=',$id)
        ->first();

        $observaciones=DB::table('persona as p')
        ->join('personaacademico as pa','pa.identificacion','=','p.identificacion')
        ->join('personafamilia as pf','pf.identificacion','=','p.identificacion')
        ->join('personareferencia as pr','pr.identificacion','=','p.identificacion')
        ->join('personaexperiencia as pe','pe.identificacion','=','p.identificacion')
        ->select('pa.observacion as obpa','pf.observacion as obpf','pr.observacion as obpr','pe.observacion as obpe')
        ->where('p.identificacion','=',$id)
        ->first();

        $observaR=DB::table('observaciones as ob')
            ->join('persona as p','p.identificacion','=','ob.identificacion')
            ->join('personareferencia as pr','pr.idpreferencia','=','ob.obreferencia')
            ->select('p.identificacion','ob.descripcion','pr.idpreferencia')
            ->where('p.identificacion','=',$id)
            ->get();
        
        $observaE=DB::table('observaciones as ob')
            ->join('persona as p','p.identificacion','=','ob.identificacion')
            ->join('personaexperiencia as pe','pe.idpexperiencia','=','ob.obexperiencia')
            ->select('p.identificacion','ob.descripcion','pe.idpexperiencia')
            ->where('p.identificacion','=',$id)
            ->get();
      
        $nivelacademico = DB::table('nivelacademico')->get();
        $estadocivil=DB::table('estadocivil')->get();


        return view('rrhh.evaluaciones.show',["persona"=>$persona,"empleado"=>$empleado,"academicos"=>$academicos,"experiencias"=>$experiencias,"familiares"=>$familiares,"idiomas"=>$idiomas,"referencias"=>$referencias,"deudas"=>$deudas,"padecimientos"=>$padecimientos,"pais"=>$pais,"pariente"=>$pariente,"nivelacademico"=>$nivelacademico,"estadocivil"=>$estadocivil,"observaciones"=>$observaciones,'entrev'=>$entrev,"observaR"=>$observaR,"observaE"=>$observaE]);     
    }

    public function agregarnota (Request $request)
    {
        $idempleado =$request->get("idempleado");
        $nota =$request->get("nota");
        $observacion =$request->get("observacion");
        $id=Auth::user()->id;

        $result = new Resultado;
        $result-> idempleado=$idempleado;
        $result-> observacion=$observacion;
        $result-> nota=$nota;
        $result-> evaluador=$id;        
        $result->save();

        //return view('rrhh.evaluaciones.resultados');
        return response()->json($result);
    }
}
