<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Session\SessionManager;
use App\Http\Requests\PersonaRequest;
use App\Academico;
use App\Persona;
use App\Empleado;
use App\Deudas;
use App\Experiencia;
use App\Familia;
use App\Padecimientos;
use App\Referencia;
use App\Idioma;
use App\Licencia;
use App\PuestoPublico;
use App\Textranjero;
use App\Observacion;
Use Session;
use Storage;
use DB;
use Carbon\Carbon;  // para poder usar la fecha y hora
use Response;
use Illuminate\Support\Collection;
use Validator;
use Mail;

class PersonaController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function index (Request $request)
    {
        if ($request)
        {
        }
    }
    public function show(Request $request)
    {
        if ($request)
        {
        }
    }
    public static function  getTowns(Request $request, $id)
    {
        if ($request->ajax())
        {
            $towns = DB::table('departamento as depa')
            ->join('municipio as muni','depa.iddepartamento','=','muni.iddepartamento')
            ->select ('muni.idmunicipio','muni.nombre')
            ->where('muni.iddepartamento','=',$id)
            ->get();
            return response()->json($towns);
        }
    }

    public function create(SessionManager $sessionManager)
    {
        Session::flash('message','Use Navegador Chrome o Firefox para llenar este formulario');
        //$sessionManager->flash('mensaje', 'Llene este formulario en Navegador Chorme');

        $departamento=DB::table('departamento')->get();
        $estadocivil=DB::table('estadocivil')->get();
        $puestos=DB::table('puesto as p')
        ->where('p.statusp','=','2')
        ->orderBy('p.nombre','asc')
        ->get();
        $afiliados=DB::table('afiliado as a')
        ->where('a.statusa','=','2')
        ->orderBy('a.nombre','asc')
        ->get();
        $idiomas = DB::table('idioma')->get();
        $licencia = DB::table('licencia')->get();
        $etnia = DB::table('etnia')->get();
        $nacionalidad = DB::table('nacionalidad')->get();
        $tdocumento = DB::table('documento')->get();
        $nivelacademico = DB::table('nivelacademico')->get();
        $pais=DB::table('pais')->get();
        //return view("solicitud1",["departamento"=>$departamento,"estadocivil"=>$estadocivil,"idiomas"=>$idiomas,"puestos"=>$puestos,"afiliados"=>$afiliados,"licencia"=>$licencia,"etnia"=>$etnia,"nacionalidad"=>$nacionalidad,"tdocumento"=>$tdocumento,"nivelacademico"=>$nivelacademico,'pais'=>$pais]);

        return view("solicitud",["departamento"=>$departamento,"estadocivil"=>$estadocivil,"idiomas"=>$idiomas,"puestos"=>$puestos,"afiliados"=>$afiliados,"licencia"=>$licencia,"etnia"=>$etnia,"nacionalidad"=>$nacionalidad,"tdocumento"=>$tdocumento,"nivelacademico"=>$nivelacademico,'pais'=>$pais]);
    }
    public function store(PersonaRequest $request)
    {
        $identificacion=$request->get('identificacion');
        $nombre1=$request->get('nombre1');
        $apellido1=$request->get('apellido1');
        $img=$request->file('archivo');
        $forma=$request->get('formate');
        $trabE=$request->get('trabajoext');
        $paisTe=$request->get('paisTe');
        $motivofint=$request->get('finmotivo');
        $envcorreo=$request->get('correo');
        //dd($trabE);
        $paisP = $request->get('idpaisPS');
        //dd($paisP);


                    try 
                    {
                        DB::beginTransaction();
                     //Datos persona
                        $persona = new Persona;
                        $persona-> identificacion = $identificacion;
                        $persona-> nombre1 = $nombre1;
                        $persona-> nombre2 = $request->get('nombre2');
                        $persona-> nombre3 = $request->get('nombre3');
                        $persona-> apellido1 = $apellido1;
                        $persona-> apellido2 = $request->get('apellido2');
                        $persona-> apellido3 = $request->get('apellido3');
                        $persona-> telefono = $request->get('telefono');
                        $persona-> celular = $request->get('celular');
                        $fechanacs=$request->get('fechanac');
                        $fechanacc=Carbon::createFromFormat('d/m/Y',$fechanacs);
                        $fecha=$fechanacc->format('Y-m-d');
                        $persona-> fechanac = $fecha;
                        /*$persona-> avenida = $request->get('avenida');
                        $persona-> calle = $request->get('calle');
                        $persona-> nomenclatura = $request->get('nomenclatura');
                        $persona-> zona = $request->get('zona');*/
                        $persona-> barriocolonia = $request->get('barriocolonia');

                        if ($paisP === "73") 
                        {
                            $persona-> idmunicipio = $request->get('idmunicipio');
                        }
                        else
                        {
                            $persona-> idmunicipio =NULL;
                        }

                        $persona-> ive = $request->get('ive');
                        $persona-> parientepolitico = $request->get('parientepolitico');
                        $persona-> idpuesto= $request->get('idpuesto');
                        $persona-> idafiliado= $request->get('idafiliado');
                        
                        if($img === null)
                        {
                            $persona->finiquitoive="";
                        }
                        else
                        {
                            $file_route=time().'_'.$img->getClientOriginalName();
                            Storage::disk('archivos')->put($file_route, file_get_contents($img->getRealPath() ) );
                            $persona-> finiquitoive=$file_route;    
                        }
                        $persona-> correo=$envcorreo;
                        $persona-> genero=$request->get('genero');
                        $persona-> idetnia=$request->get('idetnia');
                        $persona-> idnacionalidad=$request->get('idnacionalidad');
                        $persona-> iddocumento=$request->get('iddocumento');
                        $persona-> idpais=$paisP;
                        $persona->save();
                        //dd($paisP,$persona);
                     //Datos empleado
                        $empleado = new Empleado;
                        $empleado-> identificacion= $request->get('identificacion');
                        $empleado-> afiliacionigss= $request->get('afiliacionigss');
                        $empleado-> numerodependientes= $request->get('numerodependientes');
                        $empleado-> aportemensual= $request->get('aportemensual');
                        $empleado-> vivienda= $request->get('vivienda');
                        $empleado-> alquilermensual= $request->get('alquilermensual');
                        $empleado-> otrosingresos= $request->get('otrosingresos');
                        $empleado-> pretension= $request->get('pretension');
                        $empleado-> nit= $request->get('nit');
                        $mytime = Carbon::now('America/Guatemala');
                        $empleado-> fechasolicitud=$mytime->toDateTimeString();
                        $empleado-> idcivil= $request->get('idcivil');
                        $empleado-> idstatus='1';
                        $empleado-> observacion=$request->get('observacion');
                        $empleado-> save();
                        //dd($persona,$empleado);
                     //Datos Puesto Publico
                        $nombrep=$request->get('nombrep');
                        $puestop=$request->get('puestop');
                        $dependencia=$request->get('dependencia');

                        if ($nombrep===null) {
                            # code...
                            $ppublico= new PuestoPublico;
                            $ppublico-> nombre="";
                        }
                        else
                        {
                            $ppublico= new PuestoPublico;
                            $ppublico-> nombre=$nombrep;
                            $ppublico-> puesto=$puestop;
                            $ppublico-> dependencia=$dependencia;
                            $ppublico-> identificacion= $request->get('identificacion');
                            $ppublico-> save();
                        }

                        //dd($persona,$empleado,$ppublico);
                    //Datos trabajo extranjer
                        $contTE=0;
                        if ($trabE === "No" ) 
                        {   
                            $ptextra=new Textranjero;
                            $ptextra-> idpais=NULL;
                            $ptextra-> identificacion=$request->get('identificacion');
                            $ptextra-> trabajoext=$trabE; 
                            $ptextra-> forma="";
                            $ptextra-> motivofin="";
                            $ptextra->save();
                            
                        }
                        else 
                        {
                            while($contTE < count($forma))
                            {
                                $ptextra=new Textranjero;
                                $ptextra-> idpais=$paisTe[$contTE];
                                $ptextra-> identificacion=$request->get('identificacion');
                                $ptextra-> trabajoext=$trabE;
                                $ptextra-> forma=$forma[$contTE];
                                $ptextra-> motivofin=$motivofint[$contTE];
                                $ptextra->save();
                                $contTE=$contTE +1;
                            }   
                        }

                        //dd($persona,$empleado,$ptextra);
                     //Datos familia
                        $nombref=$request->get('nombref');
                        $apellidof=$request->get('apellidof');
                        $edad=$request->get('edad');
                        $telefonof=$request->get('telefonof');
                        $parentezco=$request->get('parentezco');
                        $ocupacion=$request->get('ocupacion');
                        $emergencia=$request->get('emergencia');
                     //Datos academicos
                        $titulo=$request->get('titulo');
                        $establecimiento=$request->get('establecimiento');
                        $duracion=$request->get('duracion');
                        $idnivel=$request->get('nivelid');
                        $fsalida = $request->get('fsalida');
                        $fechai=$request->get('fingreso');
                        $periodo=$request->get('periodo');
                        $pidmunicipio=$request->get('pidmunicipio');
                        //dd($pidmunicipio);
                        $idpaisA=$request->get('idpaisPAAT');
                     //Datos Experiencia
                        $empresa=$request->get('empresa');
                        $puesto=$request->get('puesto');
                        $jefeinmediato=$request->get('jefeinmediato');
                        $motivoretiro=$request->get('motivoretiro');
                        $ultimosalario=$request->get('ultimosalario');
                        $fingresoex=$request->get('fingresoex');
                        $fsalidaex=$request->get('fsalidaex');
                     //Datos referencias
                        $nombrer=$request->get('nombrer');
                        $telefonor=$request->get('telefonor');
                        $profesion=$request->get('profesion');
                        $tiporeferencia=$request->get('tiporeferencia');
                     //Datos deudas
                        $acreedor=$request->get('acreedor');
                        $amortizacionmensual=$request->get('amortizacionmensual');
                        $montodeuda=$request->get('montodeuda');
                        $modeuda=$request->get('mdeuda');
                     //Datos padecimientos
                        $nombre=$request->get('nombre');
                        //otros datos 
                        //otros datos 
                     //Datos Idioma
                        $nivelI=$request->get('niveli');
                        $eidioma=$request->get('eidioma');
                     //Datos licemcia
                        $vigencia=$request->get('vigencia');
                        $licenciaid=$request->get('licenciape');

                        //dd($vigencia,$licenciaid);
                     //contadores
                        $cont = 0;
                        $conts = 0;
                        $cont2 = 0;
                        $cont3 = 0;
                        $cont4 = 0;
                        $cont5 = 0;
                        $cont6 = 0;
                        $cont7 = 0;
                     //while Licencia
                        if ($vigencia === null)
                        {
                            $licencias = new Licencia;
                            $licencias-> vigencia = "";
                        }
                        else 
                        {
                            while($cont7 < count($vigencia))
                            {
                                $licencias = new Licencia;
                                $licencias-> vigencia = $vigencia[$cont7];
                                $licencias-> idlicencia = $licenciaid[$cont7];
                                $licencias-> identificacion = $empleado->identificacion;
                                $licencias->save();
                                $cont7=$cont7 + 1;
                            }
                        }         
                     //dd($persona,$empleado,$licencias);
                     //while Familia
                        if ($nombref === null)
                        {
                            $familia = new Familia;
                            $familia->nombref="El usuario no ingreso datos";
                            $familia-> idempleado = $empleado->idempleado;
                            $familia-> identificacion = $empleado->identificacion;
                            $familia->save();

                        }
                        else
                        {
                            while($cont3 < count($nombref))
                            {
                                $familia = new Familia;
                                $familia-> nombref = $nombref[$cont3];
                                $familia-> apellidof = $apellidof[$cont3];
                                $familia-> edad = $edad[$cont3];
                                $familia-> telefonof = $telefonof[$cont3];
                                $familia-> parentezco = $parentezco[$cont3];
                                $familia-> ocupacion = $ocupacion[$cont3]; 
                                $familia-> emergencia = $emergencia[$cont3];
                                $familia-> idempleado = $empleado->idempleado;
                                $familia-> identificacion = $empleado->identificacion;
                                $familia->save();
                                $cont3=$cont3 + 1;
                            }      
                        }
                     //dd($persona,$empleado,$familia);
                     //while Academico
                        if ($titulo === null)
                        {
                            $academicos = new Academico;
                            $academicos-> titulo = "El usuario no ingreso datos";
                            
                        }
                        else 
                        {
                            while($cont5 < count($titulo))
                            {
                                
                                    $fechai[$cont5]=Carbon::createFromFormat('d/m/Y',$fechai[$cont5]);
                                    $fechai[$cont5]=$fechai[$cont5]->format('Y-m-d');
                                    $fsalida[$cont5]=Carbon::createFromFormat('d/m/Y',$fsalida[$cont5]);
                                    $fsalida[$cont5]=$fsalida[$cont5]->format('Y-m-d');
                                    $academicos = new Academico;
                                    $academicos-> titulo = $titulo[$cont5];
                                    $academicos-> establecimiento = $establecimiento[$cont5];
                                    $academicos-> duracion = $duracion[$cont5];
                                    $academicos-> idnivel = $idnivel[$cont5];
                                    $academicos-> fsalida=$fsalida[$cont5];
                                    $academicos-> fingreso =$fechai[$cont5];
                                    $academicos-> periodo =$periodo[$cont5];
                                    if ($idpaisA[$cont5] ==="73") 
                                    {
                                        $academicos-> idmunicipio = $pidmunicipio[$cont5];
                                        $academicos-> idpais = $idpaisA[$cont5];
                                    }
                                    else
                                    {
                                        //$academicos-> idmunicipio = NULL;
                                        $academicos-> idpais = $idpaisA[$cont5];
                                    }
                                    
                                    $academicos-> idempleado = $empleado->idempleado;
                                    $academicos-> identificacion = $empleado->identificacion;
                                    $academicos-> save();
                                    $cont5=$cont5 + 1;   
                            }
                        }           
                     //dd($persona,$empleado,$familia,$academicos);
                     //while Idioma
                        if ($nivelI === null)
                        {
                            $idioma = new Idioma;
                            $idioma-> nivel = "";
                        }
                        else 
                        {
                            while($cont6 < count($nivelI))
                            {
                                $idioma = new Idioma;
                                $idioma-> nivel = $nivelI[$cont6];
                                $idioma-> ididioma = $eidioma[$cont6];
                                $idioma-> idempleado = $empleado->idempleado;
                                $idioma->save();
                                $cont6=$cont6 + 1;
                            }
                        }         
                        //dd($persona,$empleado,$familia,$academicos,$idioma);
                     //while Experiencia
                        if ($empresa === null) 
                        {
                            $experiencia = new Experiencia;
                            $experiencia-> empresa="El usuario no presenta experiencia laboral";
                            $experiencia-> idempleado=$empleado->idempleado;
                            $experiencia-> identificacion=$empleado->identificacion; 
                            $experiencia->save();

                        }
                        else 
                        {
                            while($cont4 < count($empresa))
                            {
                                $experiencia = new Experiencia;
                                $experiencia-> empresa=$empresa[$cont4];
                                $experiencia-> puesto=$puesto[$cont4];
                                $experiencia-> jefeinmediato=$jefeinmediato[$cont4];
                                $experiencia-> motivoretiro=$motivoretiro[$cont4];
                                $experiencia-> ultimosalario=$ultimosalario[$cont4];
                                $experiencia-> fingresoex=$fingresoex[$cont4];
                                $experiencia-> fsalidaex=$fsalidaex[$cont4];
                                $experiencia-> idempleado=$empleado->idempleado;
                                $experiencia-> identificacion=$empleado->identificacion; 
                                $experiencia->save();
                                $cont4=$cont4 + 1;
                            }    
                        }            
                        //dd($persona,$empleado,$familia,$academicos,$experiencia); 
                     //while Referencia
                       if ($nombrer === null) 
                        {
                            $referencia = new Referencia;
                            $referencia-> nombrer="El usuario no ingreso datos";
                            $referencia-> idempleado=$empleado->idempleado;
                            $referencia-> identificacion=$empleado->identificacion; 
                            $referencia->save();
                        }
                        else 
                        {
                            while($cont2 < count($nombrer))
                            {
                                $referencia = new Referencia;
                                $referencia-> nombrer=$nombrer[$cont2];
                                $referencia-> telefonor=$telefonor[$cont2];
                                $referencia-> profesion=$profesion[$cont2];
                                $referencia-> tiporeferencia=$tiporeferencia[$cont2];
                                $referencia-> idempleado=$empleado->idempleado;
                                $referencia-> identificacion=$empleado->identificacion; 
                                $referencia->save();
                                $cont2=$cont2 + 1;
                            }
                        }
                     //dd($persona,$empleado,$familia,$academicos,$experiencia,$referencia);
                     //while deudas
                        if ($acreedor === null) 
                        {
                            $deuda = new Deudas;
                            $deuda-> acreedor="";
                        }
                        else 
                        {
                            while($conts < count($acreedor))
                            {
                                $deuda = new Deudas;
                                $deuda-> acreedor=$acreedor[$conts];
                                $deuda-> amortizacionmensual=$amortizacionmensual[$conts];
                                $deuda-> montodeuda=$montodeuda[$conts];
                                $deuda-> idempleado=$empleado->idempleado;
                                $deuda-> identificacion=$empleado->identificacion;
                                $deuda-> motivodeuda=$modeuda[$conts];
                                $deuda->save();
                                $conts=$conts + 1;
                            }
                        }            
                     //dd($persona,$empleado,$familia,$academicos,$experiencia,$referencia,$deuda);
                     //while padecimientos
                        if ($nombre === null) 
                        {
                            $padecimiento= new Padecimientos;
                            $padecimiento-> nombre = " ";
                        }
                        else 
                        {
                            while($cont < count($nombre))
                            {
                                $padecimiento= new Padecimientos;
                                $padecimiento-> nombre = $nombre[$cont];
                                $padecimiento-> idempleado = $empleado->idempleado;
                                $padecimiento-> identificacion = $empleado->identificacion;
                                $padecimiento->save();
                                $cont=$cont + 1;
                            }
                        }
                     //dd($persona,$empleado,$familia,$academicos,$experiencia,$referencia,$deuda,$padecimiento,$ppublico,$idioma);
                     //dd($persona,$empleado,$familia,$padecimiento);
                     //commit
                        //Mail::send('emails.envsolicitud', function($msj){

                        
                        /*$calculo = array($envcorreo);

                        Mail::send('emails.envsolicitud',['calculo' => $calculo], function($msj) use ($request){

                            $msj->subject('Solicitud de empleo');
                            //dd($persona-> correo);
                            $msj->to($request->get('correo'));

                            
                        
                          });*/

                         /*Mail::send('emails.welcome', $data, function ($message) {
                            $message->from('us@example.com', 'Laravel');

                            $message->to('foo@example.com')->cc('bar@example.com');
                        });*/
                        DB::commit();
                        
                    }catch (\Exception $e) 
                    {
                        DB::rollback();
                        dd('Error al enviar los datos, por favor intente mas tarde');         
                    }

                    /*return response()->json(["valid" => true], 200);
                }
                else{
                    return response()->json(array('error'=>'Error revise datos'),200);
                }
            }
        }*/
        return Redirect::to('https://www.habitatguate.org/');
    }

    public function upsolicitudPE(Request $request)
    {
        $idper=$request->get('identificacionup');
        $idempleado=$request->get('idempleado');
        $miArray = $request->items;
        $miArrayR = $request->itemsR;
        $miArrayF = $request->itemsF;
        $miArrayE = $request->itemsE;
        $miArrayD = $request->itemsD;
        $miArrayA = $request->itemsA;

        $persona = Persona::findOrFail($idper);
        $persona-> nombre1 = $request->get('nombre1');
        $persona-> nombre2 = $request->get('nombre2');
        $persona-> apellido1 = $request->get('apellido1');
        $persona-> apellido2 = $request->get('apellido2');
        $persona-> telefono = $request->get('telefono');
        $fechanacs=$request->get('fechanac');
        $fechanacc=Carbon::createFromFormat('d-m-Y',$fechanacs);
        $fecha=$fechanacc->format('Y-m-d');
        $persona-> fechanac = $fecha;             
        $persona-> barriocolonia = $request->get('barriocolonia');
        $persona->save();

        $empleado = Empleado::findOrFail($idempleado);
        $empleado-> afiliacionigss= $request->get('iggs');
        $empleado-> numerodependientes= $request->get('dependientes');
        $empleado-> aportemensual= $request->get('aportemensual');
        $empleado-> vivienda= $request->get('vivienda');
        $empleado-> alquilermensual= $request->get('alquilermensual');
        $empleado-> otrosingresos= $request->get('otrosingresos');
        $empleado-> nit= $request->get('nit');
        $empleado-> idcivil= $request->get('selectpicker1');
        $empleado-> save();

        if ($miArray > 0) {
            foreach ($miArray as $key => $value) {
                $padecimiento= Padecimientos::findOrFail($value['0']);
                $padecimiento-> nombre = $value['1'];
                $padecimiento->save();
            }
        }

        if ($miArrayR > 0) {
            foreach ($miArrayR as $key => $value) {
                $referencia = Referencia::findOrFail($value['0']);
                $referencia-> nombrer=$value['1'];
                $referencia-> telefonor=$value['2'];
                $referencia-> profesion=$value['3'];
                $referencia-> tiporeferencia=$value['4'];
                $referencia-> recomiendaper=$value['5'];
                $referencia-> confirmadorref=$value['6'];
                $referencia-> observacion = $value['7'];
                $referencia->save();
            }
        }
        if ($miArrayF > 0) {
            foreach ($miArrayF as $key => $value) {
                $familia = Familia::findOrFail($value['0']);
                $familia-> nombref = $value['1'];
                $familia-> parentezco = $value['2'];
                $familia-> telefonof = $value['3'];
                $familia-> ocupacion = $value['4'];
                //$familia-> apellidof = $apellidof;
                $familia-> edad = $value['5'];            
                $familia->save();
            }
        }
        if ($miArrayE > 0) {
            foreach ($miArrayE as $key => $value) {
                $experiencia = Experiencia::findOrFail($value['0']);
                $experiencia-> empresa=$value['1'];
                $experiencia-> puesto=$value['2'];
                $experiencia-> jefeinmediato=$value['3'];
                $experiencia-> motivoretiro=$value['4'];
                $experiencia-> ultimosalario=$value['5'];
                $experiencia-> fingresoex=$value['6'];
                $experiencia-> fsalidaex=$value['7'];
                $experiencia-> recomiendaexp=$value['8'];
                $experiencia-> confirmadorexp=$value['9'];
                $experiencia-> observacion = $value['10'];
                $experiencia->save();
            }
        }
        if ($miArrayD > 0) {
            foreach ($miArrayD as $key => $value) {
                $deuda = Deudas::findOrFail($value['0']);
                $deuda-> acreedor=$value['1'];
                $deuda-> amortizacionmensual=$value['2'];
                $deuda-> montodeuda=$value['3'];
                $deuda-> motivodeuda=$value['4'];
                $deuda->save();
            }
        }
        if ($miArrayA > 0) {
            foreach ($miArrayA as $key => $value) {
                $academicos = Academico::findOrFail($value['0']);
                $academicos-> titulo = $value['1'];
                $academicos-> establecimiento = $value['2'];
                $academicos-> duracion = $value['3'];
                $academicos-> idnivel = $value['4'];
                $academicos-> fingreso =$value['5'];
                $academicos-> fsalida=$value['6'];
                $academicos-> save();
            }
        }
        return response()->json($persona);
    }

    public function refcomentario(Request $request)
    {
        $this->validateRequestOb($request);
        $idper=$request->get('identificacion');
        $observacionG = $request->get('observacion');
        $idobservacionGR = $request->get('referenciaid');

        $obs= new observacion;
        $obs-> descripcion=$observacionG;
        $obs-> identificacion=$idper;
        $obs-> obreferencia=$idobservacionGR;
        $obs->save();

        return response()->json($obs);
    }
    public function expcomentaro(Request $request)
    {
        $this->validateRequestObE($request);
        $idper=$request->get('identificacion');
        $observacionGE = $request->get('observacion');
        $idpexperienciaGE = $request->get('explaboral');

        $obs= new observacion;
        $obs-> descripcion=$observacionGE;
        $obs-> identificacion=$idper;
        $obs-> obexperiencia=$idpexperienciaGE;
        $obs->save();
        return response()->json($obs);
    }
    public function entreob(Request $request)
    {
        $this->validateRequestObE($request);
        $idper=$request->get('identificacion');
        $observacionGE = $request->get('observacion');
        $identrevista = $request->get('identrevista');

        $obs= new observacion;
        $obs-> descripcion=$observacionGE;
        $obs-> identificacion=$idper;
        $obs-> identrevista=$identrevista;
        $obs->save();
        return response()->json($obs);
    }
    public function validateRequestOb($request){
            $rules=[
            'observacion' => 'required|max:300',

            ];
            $messages=[
            'required' => 'Debe ingresar :attribute.',
            'max'  => 'La capacidad del campo :attribute es :max',
            ];
            $this->validate($request, $rules,$messages);        
        }
    public function validateRequestObE($request){
            $rules=[
            'observacion' => 'required|max:300',

            ];
            $messages=[
            'required' => 'Debe ingresar :attribute.',
            'max'  => 'La capacidad del campo :attribute es :max',
            ];
            $this->validate($request, $rules,$messages);        
        }
}
