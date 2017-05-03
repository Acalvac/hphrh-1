<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\UFormRequest;
use App\Empleado;
use App\Persona;
use App\User;  
use DB;

use Validator;


use App\Academico;
use App\Familia;
use Illuminate\Http\File;

use Carbon\Carbon;  // para poder usar la fecha y hora
use Response;
use Illuminate\Support\Collection;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UController extends Controller
{
	public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function index(Request $request)
	{
		if($request)
		{
			$query=trim($request->get('searchText'));
			$usuarios=DB::table('users')->where('name','LIKE','%'.$query.'%')
				->orderBy('id','desc')
				->paginate(7);
			return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
		}
	}
	
	public function create()
	{
		//return view("seguridad.usuario.create",["personas"=>$personas,"articulos"=>$articulos]);
		//$empleados=DB::table('persona')->where('tipo_persona','=','empleado')->get();
		//return view("seguridad.usuario.create",["empleados"=>$empleados]);
		$usuario = user::all();
		return view("seguridad.usuario.create",["usuario"=>$usuario]);
	}
	public function store(UFormRequest $request)
	{
		$usuario=new User;
		$usuario->name=$request->get('name');
		$usuario->email=$request->get('email');
		$usuario->password=bcrypt($request->get('password'));
		$usuario->identificacion=$request->get('identificacion');
		$usuario->save();
		return Redirect::to('seguridad/usuario');		
	}
	public function edit($id)
	{
		return view('seguridad.usuario.edit',["usuario"=>User::findOrFail($id)]);
	}
	
	public function update(UsuarioFormRequest $request, $id)
	{
		$usuario=User::findOrFail($id);
		$usuario->name=$request->get('name');
		$usuario->email=$request->get('email');
		$usuario->password=bcrypt($request->get('password'));
		$usuario->id_persona=$request->get('id_persona');
		$usuario->update();
		return Redirect::to('seguridad/usuario');
	}
	
	public function destroy($id)
	{
		$usuario =DB::table('users')->where('idusuario','=',$id)->delete();
		return Redirect::to('seguridad/usuario');
	}

	public function galeria()
	{
		$users = User::all();
		/*
		$data =  array("users"=>$users);
		return json_encode($data);*/
		return view("hr.galeria",["usuario"=>$users]);
		
	}


	 public function subirimagen(Request $request)
    {
        $id=$request->input('idusuario');
        $user =User::findOrFail($id);
      	
    	$fotoperfil = $request->file('fotoperfil');
        

        $input  = array('image' => $fotoperfil) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,png|max:2000');
        $validacion = Validator::make($input,  $reglas);

        if ($validacion->fails())
        {
           
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {  
            $file = $user->fotoperfil;
            Storage::delete(public_path().$file);

            $nombre_original=$fotoperfil->getClientOriginalName();
            $extension=$fotoperfil->getClientOriginalExtension();
            $nuevo_nombre="userimagen-".$id.".".$extension;
            $r1=Storage::disk('fotografias')->put($nuevo_nombre,  \File::get($fotoperfil) );
            $rutadelaimagen=$nuevo_nombre;

        
            if ($r1){

                $usuario=User::find($id);
                $usuario->fotoperfil=$rutadelaimagen;
                $r2=$usuario->save();
                 return view("mensajes.msj_correcto")->with("msj","Imagen agregada correctamente");
            }
            else
            {
                return view("mensajes.msj_rechazado")->with("msj","no se cargo la imagen");
            }

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

    public function listaracademico()
    {
        
        $departamento=DB::table('departamento')->get();
        $nivelacademico = DB::table('nivelacademico')->get();
        $empleado = DB::table('empleado as e')
        ->join('persona as p','e.identificacion','=','p.identificacion')
        ->join('personaacademico as pa','e.identificacion','=','pa.identificacion')
        ->join('users as u','p.identificacion','=','u.identificacion')
        ->join('nivelacademico as na','pa.idnivel','=','na.idnivel')
        ->select('e.idempleado','p.identificacion','pa.titulo','pa.establecimiento','pa.duracion','pa.fingreso','pa.fsalida','pa.idmunicipio','pa.identificacion','pa.idnivel','pa.periodo','na.nombrena')
        ->where('u.id','=',Auth::user()->id)
        ->get();
     
        /*
        $data =  array("users"=>$users);
        return json_encode($data);*/
        return view("hr.academico",["departamento"=>$departamento,"nivelacademico"=>$nivelacademico,"empleado"=>$empleado]);
        
    }

    public function listarfamiliar()
    {
        $familia = familia::all();
        $empleado = DB::table('empleado as e')
        ->join('persona as p','e.identificacion','=','p.identificacion')
        ->join('users as u','p.identificacion','=','u.identificacion')
        ->join('personafamilia as pf','e.identificacion','=','pf.identificacion')
        ->select('e.idempleado','p.identificacion','pf.parentezco','pf.ocupacion','pf.edad','pf.nombref','pf.apellidof','pf.telefonof','pf.emergencia')
        ->where('u.id','=',Auth::user()->id)
        ->get();
         return view("hr.familia",["familia"=>$familia,"empleado"=>$empleado]);
    }

     public function listarpersonal()
    {

    }

    public function agregaracademico(Request $request)
    {        
        $this->validateRequest($request);
        $academico = new Academico;

        $fechaingreso = $request->fecha_ingreso; 
        $fechasalida = $request->fecha_salida;


        $fechaingreso = Carbon::createFromFormat('d-m-Y',$fechaingreso);
        $fechasalida = Carbon::createFromFormat('d-m-Y',$fechasalida);

        $fechaingreso = $fechaingreso->toDateString();
        $fechasalida = $fechasalida->toDateString();

        $academico->titulo = $request->get('titulo');
        $academico->establecimiento = $request->get('establecimiento');
        $academico->duracion = $request->get('duracion');
        $academico->fingreso = $fechaingreso;
        $academico->fsalida = $fechasalida;
        $academico->idmunicipio = $request->get('idmunicipio');
        $academico->idempleado = $request->get('idempleado');
        $academico->identificacion = $request->get('identificacion');
        $academico->idnivel = $request->get('idnivel');
        $academico->periodo = $request->get('periodo');

        //$data = $request->toArray();
        //$academico = Academico::create($data);
        $academico->save();
                
        return response()->json($academico);

    }

    public function agregarfamiliar(Request $request)
    {
        $this->validateRequestF($request);
        $familia = new Familia;
        $familia->parentezco = $request->get('parentezco');
        $familia->ocupacion = $request->get('ocupacion');
        $familia->edad = $request->get('edad');
        $familia->nombref = $request->nombre;
        $familia->apellidof = $request->apellido;
        $familia->telefonof = $request->get('telefonof');
        $familia->idempleado = $request->get('idempleado');
        $familia->identificacion = $request->get('identificacion');
        $familia->emergencia = $request->get('emergencia');

        $familia->save();

        return response()->json($familia);
    }

    public function validateRequest($request){
        $rules=[
        'titulo' => 'required|max:100',
        'establecimiento' => 'required|max:100',
        'duracion'=> 'required|max:2',
        'fecha_salida'=>'required',
        'fecha_ingreso'=>'required',

        ];
        $messages=[
        'required' => 'Debe ingresar :attribute.',
        'max'  => 'La capacidad del campo :attribute es :max',
        ];
        $this->validate($request, $rules,$messages);        
    }

    public function validateRequestF($request){
        $rules=[
        'parentezco' => 'required|max:40',
        'ocupacion' => 'required|max:40',
        'edad'=> 'required|max:3',
        'nombre'=>'required|max:40',
        'apellido'=>'required|max:40',


        ];
        $messages=[
        'required' => 'Debe ingresar :attribute.',
        'max'  => 'La capacidad del campo :attribute es :max',
        ];
        $this->validate($request, $rules,$messages);        
    }
}
