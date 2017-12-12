<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Response;
use Validator;
use Carbon\Carbon;  // para poder usar la fecha y hora

use App\Http\Requests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PCProyecto extends Controller
{
    public function index(Request $request)
    {
    	$proyectos = DB::table('proyecto as pca')
    		->select('pca.idproyecto','pca.nombreproyecto as proyecto','pca.montoproyecto as monto','pca.descripcion','pca.status','pca.saldoproyecto as saldo')
    		->get();

        return view('seguridad.proyecto.index',["proyectos"=>$proyectos]);
    }
}