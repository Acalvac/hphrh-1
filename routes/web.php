<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('solicitud','PersonaController@create');
Route::get('verificacion/{id}','PersonaController@verifica');
Route::get('towns/{id}', 'PersonaController@getTowns');
Route::post('solicitud/ds','PersonaController@store');
Route::resource('mintrabf','Controllermintrab');
Route::get('excel','Controllermintrab@excel');
Route::get('eventos','UController@listartablero');

Route::group(['prefix'=>'listados'],function(){
	Route::get('empleado','ListadoController@index');
	Route::get('laboral/{id}','ListadoController@laboral');
	Route::get('show/{id}','ListadoController@show');
	Route::get('historial/{id}','ListadoController@historial');
	Route::get('empleado/Acta/{id}','ListadoController@Acta');
	Route::post('empleado/agregar','ListadoController@store');
	Route::get('empleado/calculardias/{id}','ListadoController@calculardias');
	Route::get('vconfirmado','ListadoController@indexconfirmado')->middleware('roleshinobi:recurso');
	Route::get('vrechazado','ListadoController@indexrechazado')->middleware('roleshinobi:recurso');
	Route::get('vautorizado','ListadoController@indexautorizado')->middleware('roleshinobi:recurso');
	Route::get('vsolicitado','ListadoController@indexsolicitado')->middleware('roleshinobi:recurso');

	Route::get('psolicitado','RHPermiso@indexsolicitado')->middleware('roleshinobi:recurso');
	Route::get('prechazado','RHPermiso@indexrechazado')->middleware('roleshinobi:recurso');
	Route::get('pconfirmado','RHPermiso@indexconfirmado')->middleware('roleshinobi:recurso');

	Route::get('pprueba','Pprueba@index');
	Route::resource('confirmacion','Confirmacion');
	Route::resource('rechazados','Rechazados');
	Route::resource('interino','Interino');
	
	Route::post('pprueba/agregar','Pprueba@store');
	Route::get('update/{id}','Confirmacion@update');
	Route::get('rechazados/eliminar/{id}','Rechazados@eliminar');//prueba de eliminar

});

// Rutas Creados por LDRL
Route::group(['prefix'=>'empleado'],function(){

	//Listado general
	Route::get('listado/{page?}','ListadoController@listado'); 
	Route::get('busqueda/{rol}/{dato?}','ListadoController@busqueda'); 
	Route::get('empleados','ListadoController@index');
	//Route::get('empleados/calculardias/{id}','ListadoController@calculardias'); 
	Route::get('rechazados','Rechazados@index');
	Route::get('hlaboral/{id}','ListadoController@laboral');
	Route::get('show/{id}','ListadoController@show');

	//Rutas de despido de un empleado
	Route::get('personabaja/{id}','ListadoController@bajas');
	Route::post('addbaja','ListadoController@addbaja');
	Route::get('debaja','ListadoController@debaja');

	//Rutas de nombramiento y/o asecensos.
	Route::get('indexnombramiento','RHNombramientoEmpleado@index');
	Route::get('addnombramiento/{id}','RHNombramientoEmpleado@addnombramiento');
	Route::get('busquedaActivo/{rol}/{dato?}','RHNombramientoEmpleado@busqueda');
	Route::post('addasecenso','RHNombramientoEmpleado@addasecenso');

	//Asignar o quitar jefes inmediatos
	Route::get('asignar_jefeinmediato/{idempleado}/{identificacion}/{notifica}', 'RHNombramientoEmpleado@asignar_jefeinmediato');
	Route::get('quitar_jefeinmediato/{idempleado}/{identificacion}', 'RHNombramientoEmpleado@quitar_jefeinmediato');

	//Listado permisosvacaciones
	
	Route::get('vautorizadopv','RHPermiso@indexautorizado');

	//Listapo reclutamiento
/*##########################*/
	//Route::get('nombrelistr/{id}','Rechazados@nombrelistr');
	Route::get('listadoR','RHReclutamiento@listadoR');
	Route::get('solicitudes','RHReclutamiento@index');
	Route::get('solicitudes/show/{id}/{idv?}','RHPreentrevista@show');

	Route::get('solicitudesjf','RHReclutamiento@indexjf');
	Route::get('busquedas/{dato?}','RHReclutamiento@busquedas');//dssdsd//
	Route::get('update/{id}','Pprueba@update');
/*##########################*/
	//JI reclutamiento
	Route::get('precalificarjf/{id}','RHPrecalificado@precalificarjf');
	Route::get('upPreentrevistajf/{id}/{ids?}','RHPreentrevista@upPreentrevistajf');
	Route::get('solicitudesjf/show/{id}/{idv?}','RHPreentrevista@show');
	Route::get('pre_entrevistadoji/show/{id}/{idv?}','RHPreentrevista@show');
	Route::get('pre_calificadosjf/show/{id}/{idv?}','RHPreentrevista@show');

	//Preentrevistados
	Route::get('pre_entrevistado','RHPreentrevista@listadopreE');
	Route::get('pre_entrevistadoji','RHPreentrevista@prelistadojf');
	Route::get('upPreentrevista/{id}/{ids?}','RHPreentrevista@upPreentrevista');
	Route::get('preentre/{id}','RHPreentrevista@preentre');
	Route::post('preentre/prentrevista','RHPreentrevista@prentrevista');
	Route::get('preentre/towns/{id}', 'RHPreentrevista@getTowns');
	Route::post('preentre/adicionalacad','RHPreentrevista@adicionalacad');
	Route::post('preentre/agregarexperiencia','RHPreentrevista@agregarexperiencia');
	Route::get('pre_entrevistado/show/{id}/{idv?}','RHPreentrevista@show');
	Route::get('PDFpre/{id}','RHPreentrevista@PDFpre');
	Route::post('preentre/objtpre/','PersonaController@entreob');
/*######################*/
	Route::post('pre_entrevistado/show/upt/','SController@upt');// agregar una observacion
	Route::post('pre_entrevistado/show/1/expcomentaro/','PersonaController@expcomentaro');// agregar una observacion experiencia
	Route::post('pre_entrevistado/show/1/refcomentario/','PersonaController@refcomentario');// agregar una observacion referencia
	Route::post('pre_entrevistado/show/1/upsolicitudPE','PersonaController@upsolicitudPE');//update de la solicitud para precalificacion
/*######################*/
	//Precalificar
	Route::get('precalificar/{id}','RHPrecalificado@precalificar');
	Route::get('pre_calificados','RHPrecalificado@listadopreC');
	Route::get('pre_calificadosjf','RHPrecalificado@listadopreCjf');
	Route::get('pre_calificados/show/{id}/{idv?}','RHPreentrevista@show');
	Route::get('precali/{id}','RHPrecalificado@precali');
	Route::post('precali/prentrevista','RHPreentrevista@prentrevista');
	Route::get('precali/towns/{id}', 'RHPreentrevista@getTowns');
	Route::post('precali/adicionalacad','RHPreentrevista@adicionalacad');
	Route::post('precali/agregarexperiencia','RHPreentrevista@agregarexperiencia');
	Route::post('precali/objtpc/','PersonaController@entreob');
	Route::get('PDFpreC/{id}','RHPrecalificado@PDFpreC');
	Route::post('pre_calificados/show/upt/','SController@upt');// agregar una observacion 

	//Evaluaciones
	Route::get('busquedaeva/{dato?}','RHEvaluciones@busquedaevaluacion');//dssdsd//
	Route::get('envioaevaluar/{id}/{ids?}','RHEvaluciones@envioaevaluar');
	Route::get('resultados','RHEvaluciones@listadoev');
	Route::post('agregarnota','RHEvaluciones@agregarnota');
	Route::get('nombrelist/{id}','RHEvaluciones@nombrelist');
	Route::get('resultadosev','RHEvaluciones@listadores');
	Route::get('resultados/show/{id}/{idv?}','RHPreentrevista@show');
	Route::get('resultadosev/listadotablares/{id}','RHEvaluciones@listadotablares');
	Route::get('entrevista/{id}','RHEntrevista@entrevista');
	Route::get('listadoen','RHEntrevista@listadoentrevista');
	Route::post('resultados/show/upt/','SController@upt');// agregar una observacion

	//Entrevita
	Route::get('listadoen','RHEntrevista@listadoentrevista');
	Route::get('listadoen/show/{id}/{idv?}','RHPreentrevista@show');
	Route::get('entrevistarh/{id}','RHEntrevista@entrevistarh');
	Route::post('entrevistarh/prentrevista','RHPreentrevista@prentrevista');
	Route::get('entrevistarh/towns/{id}', 'RHPreentrevista@getTowns');
	Route::post('entrevistarh/adicionalacad','RHPreentrevista@adicionalacad');
	Route::post('entrevistarh/agregarexperiencia','RHPreentrevista@agregarexperiencia');
	Route::post('entrevistarh/obje/','PersonaController@entreob');
	Route::get('nombramiento1/{id}','RHEntrevista@nombramiento1');
	Route::get('PDFEntre/{id}','RHEntrevista@PDFEntre');
	Route::post('listadoen/show/upt/','SController@upt');// agregar una observacion 
	
	//Nombramiento
	Route::get('listadon1','RHEntrevista@listadonombramiento');
	Route::get('listadon1/show/{id}/{idv?}','RHPreentrevista@show');
	Route::post('nombraupdate','RHNombramientoEmpleado@store');

	//Reporte
	Route::get('Rmintrab','Controllermintrab@index');
	Route::post('cambiar_password', 'PCUsuarioController@cambiar_password'); 
	Route::get('solicitud','PerController@solicitud');
	Route::get('solicitudpermiso','PerController@solicitudpermiso');

	//rutas de permiso del usuario
	Route::get('permiso','PController@index');  // PController = PermisoController
	Route::get('permiso/create','PController@create');
	Route::post('permiso/store','PController@store');
	Route::get('diashatomar','PController@diashatomar');

	//Rutas de vacaciones del usuario
	Route::get('vacaciones','VController@index'); 
	Route::get('vacaciones/create','VController@create');
	Route::post('vacaciones/store','VController@store');
	Route::get('vacaciones/diashatomar','VController@diashatomar');
	Route::get('vacaciones/calculardias','VController@calculardias');

	Route::post('vacaciones/update','VController@update');
	Route::get('goce','VController@goce');
	Route::get('diastomado','VController@rangogoce');
	Route::post('Gpdf','VController@Gpdf');

	Route::get('Spdf/{id}', 'SController@Spdf');
	Route::get('perfil','PerController@index');		// PerController = PerfilController
	Route::get('contacto','PerController@contacto');
	//Rechazos de eempleados rutas
	Route::get('rechazo/{id}/{ids?}','SController@rechazo');
	Route::get('rechazope/{id}/{ids?}','SController@rechazope');
	Route::get('rechazopc/{id}/{ids?}','SController@rechazopc');
	Route::get('rechazoe/{id}/{ids?}','SController@rechazoe');
	Route::get('rechazoet/{id}/{ids?}','SController@rechazoet');
	Route::get('rechazon/{id}/{ids?}','SController@rechazon');
	Route::get('rechazojf/{id}/{ids?}','SController@rechazojf');
	Route::get('rechazopej/{id}/{ids?}','SController@rechazopej');
	Route::get('rechazojpc/{id}/{ids?}','SController@rechazojpc');
	//Route::put('uprechazo/{id}','Rechazados@uprechazo');
	//Route::get();
	Route::get('rechazoPP/{id}','SController@rechazoPP');
	Route::get('rechazoPI/{id}','SController@rechazoPI');
/*------------------------*/
	Route::post('solicitante/upt/','SController@upt');// agregar una observacion
/*------------------------*/
	//rutas del perfil
	Route::post('/updatefoto','UController@subirimagen'); 
	Route::get('galeria','UController@galeria');
	Route::get('buscar_personal/{dato?}', 'UController@buscar_personal');

	Route::get('empleado','HomeController@dgenerales');
	Route::get('listardgenerales','HomeController@listardgenerales');
	Route::put('updatedgenerales/{id}','HomeController@updatedgenerales');
	
	//Route academico crud
	Route::get('listaracademico','UController@listaracademico');
	Route::get('towns/{id}', 'UController@getTowns'); 
	Route::post('agregaracademico','UController@agregaracademico');
	Route::get('listaracademico1/{id}','UController@listaracademico1');
	Route::put('updateAca/{id}','UController@updateAca');
	Route::delete('deleteacad/{id}','UController@deleteacad');

	//Route familia crud
	Route::get('listarfamilia','UController@listarfamiliar');
	Route::post('agregarfamiliar','UController@agregarfamiliar');
	Route::get('listarfamilia1/{id}','UController@listarfamilia1');
	Route::put('updatefam/{id}','UController@updatefam');
	Route::delete('deletefam/{id}','UController@deletefam');

	//Route referencia curd
	Route::get('listarreferencia','UController@listarreferencia');
	Route::post('agregarreferencia','UController@agregarreferencia');
	Route::get('listarreferencia1/{id}','UController@listarreferencia1');
	Route::put('updateref/{id}','UController@updateref');
	Route::delete('deleteref/{id}','UController@deleteref');
	
	//Route credito crud
	Route::get('listarcredito','UController@listarcredito');
	Route::post('agregarcredito','UController@agregarcredito');
	Route::get('listarcredito1/{id}','UController@listarcredito1');
	Route::put('updateco/{id}','UController@updateco');
	Route::delete('deletecredito/{id}','UController@deletecredito');

	//Route padecimiento crud
	Route::get('listarpadecimiento','UController@listarpadecimiento');
	Route::post('agregarpadecimiento','UController@agregarpadecimiento');
	Route::get('listarpadecimiento1/{id}','UController@listarpadecimiento1');
	Route::put('updatepad/{id}','UController@updatepad');
	Route::delete('deletepad/{id}','UController@deletepad');

	//Route experiencia crud
	Route::get('listarexperiencia','UController@listarexperiencia');
	Route::post('agregarexperiencia','UController@agregarexperiencia');
	Route::get('listarexperiencia1/{id}','UController@listarexperiencia1');
	Route::put('updatexp/{id}','UController@updatexp');
	Route::delete('deletexp/{id}','UController@deletexp');
	
	//Route otros crud
	Route::get('listarotros','UController@listarotros');
	Route::post('agregarotros','UController@agregarotros');
	Route::get('listarotros1/{id}','UController@listarotros1');

	//Route idioma crud
	Route::get('listaridioma/{id}','UController@listaridioma');
	Route::post('agregaridioma','UController@agregaridioma');
	Route::put('updateidioma/{id}','UController@updateidioma');
	Route::delete('deleteidioma/{id}','UController@deleteidioma');

	//Route licencia crud
	Route::get('listarlicencia/{id}','UController@listarlicencia');
	Route::post('agregarlicencia','UController@agregarlicencia');
	Route::put('updatelic/{id}','UController@updatelic');
	Route::delete('deletelic/{id}','UController@deletelic');

	//Route puesto a aplicar
	Route::put('SolicitanteI','UController@SolicitanteI');

	Route::resource('solicitadospermis','PermisosController');
	
	Route::get('verificar/{idpersona}','PermisosController@verificar')->middleware('roleshinobi:jefeinmediato');
	Route::post('verificar/enviarpermiso','PermisosController@enviarpermiso')->middleware('roleshinobi:jefeinmediato');

	Route::get('detalleconfirmado/{idpersona}','PermisosController@detalleconfirmado')->middleware('roleshinobi:jefeinmediato');
	Route::get('detallerechazado/{idpersona}','PermisosController@detallerechazado')->middleware('roleshinobi:jefeinmediato');

	Route::resource('vsolicitado','VacacionesController');
	Route::get('vverificar/{idpersona}','VacacionesController@verificar')->middleware('roleshinobi:jefeinmediato');
	Route::get('dconfirmar/{idpersona}','VacacionesController@dconfirmar')->middleware('roleshinobi:jefeinmediato');
	
	Route::post('vverificar/enviarvacaciones','VacacionesController@enviarvacaciones')->middleware('roleshinobi:jefeinmediato');
	Route::get('vconfirmado','VacacionesController@indexconfirmado')->middleware('roleshinobi:jefeinmediato');
	Route::get('vrechazado','VacacionesController@indexrechazado')->middleware('roleshinobi:jefeinmediato');
	Route::get('vconfirmar/{idpersona}','VacacionesController@confirmar')->middleware('roleshinobi:jefeinmediato');
	Route::post('vconfirmar/enviarconfirmacion','VacacionesController@confirmavacaciones')->middleware('roleshinobi:jefeinmediato');
	
	Route::get('/logout', 'Auth\LoginController@logout');

	// Rutas del reclutamiento del jefeinmediato
	Route::get('reclutamiento','RHReclutamiento@listadoR');
	Route::get('autorizaciones','JIPermiso@indexdirector'); /// solicitud de vacaciones y permisos de los empleados que tiene un jefe x.
	Route::get('solicitadoVP','JIPermiso@index');
	Route::get('vautorizado','VacacionesController@indexautorizado')->middleware('roleshinobi:jefeinmediato');/////
	Route::get('rechazado/{pag?}','JIPermiso@indexrechazado')->middleware('roleshinobi:jefeinmediato');
	Route::get('confirmado/{page?}','JIPermiso@indexconfirmado')->middleware('roleshinobi:jefeinmediato');

	//Rutas de validacion de permisos y vacaciones JI

	Route::get('verificar/{idpersona}','JIPermiso@verificar')->middleware('roleshinobi:jefeinmediato');
	Route::post('verificar/enviarpermiso','JIPermiso@enviarpermiso')->middleware('roleshinobi:jefeinmediato');
	Route::get('confirmado','JIPermiso@indexconfirmado')->middleware('roleshinobi:jefeinmediato');
	Route::get('rechazado','JIPermiso@indexrechazado')->middleware('roleshinobi:jefeinmediato');

	Route::get('busquedaindexsolicitadoJI/{tipoausencia}/{dato?}','JIPermiso@busquedasolicitados');
	Route::get('busquedaindexaceptadoJI/{tipoausencia}/{dato?}','JIPermiso@busquedaconfirmados');
	Route::get('busquedaindexrechazadoJI/{tipoausencia}/{dato?}','JIPermiso@busquedarechazados');

	Route::get('detalleconfirmado/{idpersona}','JIPermiso@detalleconfirmado')->middleware('roleshinobi:jefeinmediato');
	Route::get('detallerechazado/{idpersona}','JIPermiso@detallerechazado')->middleware('roleshinobi:jefeinmediato');

//Solicita plaza vacante de un puesto en un afiliado.
	Route::get('plazavacante','JIvacante@add')->middleware('roleshinobi:jefeinmediato');
	Route::post('addplazavacante','JIvacante@store')->middleware('roleshinobi:jefeinmediato');

//Listado de puesto vacantes solicitados a RH
	Route::get('vacante','RHPuestoVacante@index')->middleware('roleshinobi:recurso');
	Route::get('puestosoliicatdo','RHPuestoVacante@vacante')->middleware('roleshinobi:recurso');
	Route::put('puestoupdate','RHPuestoVacante@update')->middleware('roleshinobi:recurso');

//Reportes
	Route::get('reporteEmpleado','Reporte@index')->middleware('roleshinobi:reporte');

//Excel
	Route::get('reporteEmpleadoExcel','Reporte@Empleadoexcel')->middleware('roleshinobi:reporte');
//Notificacion
	Route::get('notificacion','NotificacionController@notificacion');
	Route::post('leernotifica','NotificacionController@leernotifica');

	//FotoController@agregarimagen
	//Route::put('/colaboradores/{id}',['uses' => 'Colaboradores@update', 'middleware' => 'auth']);

//Viaje
	Route::get('viaje','EViajeController@index');
	Route::get('viaje/retornaindex','EViajeController@retornaindex');
	Route::get('viaje/status','EViajeController@obtenerstatus');
	Route::get('viaje/solicitar','EViajeController@viaje');
	Route::get('viaje/add','EViajeController@addv');
	Route::get('viaje/cargarbusqueda','EViajeController@cargarbusqueda');
	Route::post('viaje/store','EViajeController@store');

	Route::get('viaje/liquidar/pdf/{id}','EViajeController@descargardetalle');
	Route::get 	('viaje/liquidar/updatemonto','EViajeController@updateml');

	Route::get 	('viaje/liquidar/{id}','EViajeController@liquidar');
	Route::get 	('viaje/liquidar/add/{id}','EViajeController@addl');
	Route::post ('viaje/liquidar/store','EViajeController@storel');
	Route::get 	('viaje/liquidar/edit/{id}','EViajeController@editl');
	Route::put 	('viaje/liquidar/update/{id}','EViajeController@updatel');
	Route::delete('viaje/liquidar/delete/{id}','EViajeController@deletel');
	Route::post ('viaje/liquidar/envio','EViajeController@enviol');
	Route::post ('viaje/liquidar/cancelar','EViajeController@cancelarl');

	Route::get 	('viaje/vehiculo/edit/{id}','EViajeController@vehedit');
	Route::put 	('viaje/vehiculo/update/{id}','EViajeController@vehupdate');

	Route::get 	('viaje/indexhistorial','EViajeController@indexhistorial');
	Route::get 	('viaje/detallehistorial/{id}','EViajeController@detallehistorial');
	Route::get 	('viaje/detalleavance/{id}','EViajeController@detalle');

	Route::get 	('cajachica/add','ECajaChica@add');
	Route::post ('cajachica/store','ECajaChica@store');

	// Actualizar l4 y cuneta bancaria.
	Route::post('update_dcontable','RHNombramientoEmpleado@modificar_dcontable');

});

Route::get('totalvacaciones','RHMintrab@ttvacaciones');

//Errores
Route::get('error404',function(){
	abort(404);
});
Route::get('error401',function(){
	abort(401);
});

Route::get('/', function () {
    return view('auth/login');
});
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('pdf','SController@pdf');

///
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	Route::get('/{slug?}','HomeController@index');

});

//Rutas para RH
Route::group(['prefix'=>'rh'],function(){
	

	Route::get('listado/{page?}','ListadoController@listado');
	Route::get('busqueda/{rol}/{dato?}','ListadoController@busqueda');
	Route::get('calculardias/{id}','ListadoController@calculardias');
	Route::get('empleados/calculardias/{id}','ListadoController@calculardias');


	//Rutas de despido de un empleado
	Route::get('personabaja/{id}','ListadoController@bajas');
	Route::post('addbaja','ListadoController@addbaja');
	Route::get('debaja','ListadoController@debaja');



	//Rutas de nombramiento y/o asecensos.
	Route::get('indexnombramiento','RHNombramientoEmpleado@index');
	Route::get('addnombramiento/{id}','RHNombramientoEmpleado@addnombramiento');
	Route::get('busquedaActivo/{rol}/{dato?}','RHNombramientoEmpleado@busqueda');
	Route::post('addasecenso','RHNombramientoEmpleado@addasecenso');

	//Asignar o quitar jefes inmediatos
	Route::get('asignar_jefeinmediato/{idempleado}/{identificacion}/{notifica}', 'RHNombramientoEmpleado@asignar_jefeinmediato');
	Route::get('quitar_jefeinmediato/{idempleado}/{identificacion}', 'RHNombramientoEmpleado@quitar_jefeinmediato');

	//Listado permisosvacaciones
	Route::get('listadoPV','RHPermiso@listadoPV');
	Route::get('psolicitado/{page?}','RHPermiso@indexsolicitado');
	Route::get('pconfirmado','RHPermiso@indexconfirmado');
	Route::get('prechazado','RHPermiso@indexrechazado');
	Route::get('vautorizadopv','RHPermiso@indexautorizado');
	Route::get('busquedaindexsolicitado/{tipoausencia}/{dato?}','RHPermiso@busquedasolicitados');
	Route::get('busquedaindexaceptado/{tipoausencia}/{dato?}','RHPermiso@busquedaconfirmados');
	Route::get('busquedaindexrechazado/{tipoausencia}/{dato?}','RHPermiso@busquedarechazados');

	//Listado de puesto vacantes solicitados a RH
	Route::get('vacante','RHPuestoVacante@index')->middleware('roleshinobi:recurso');
	Route::get('puestosoliicatdo','RHPuestoVacante@vacante')->middleware('roleshinobi:recurso');
	Route::put('puestoupdate','RHPuestoVacante@update')->middleware('roleshinobi:recurso');
	Route::get('plazasautorizadas','RHPuestoVacante@plazaautorizada')->middleware('roleshinobi:recurso');

	Route::get('reporte/vpempleado', 'RHReporte@vpempleado')->middleware('roleshinobi:recurso');
	Route::get('reporte/vpempleado/index', 'RHReporte@vpindex')->middleware('roleshinobi:recurso');
	Route::get('reporte/vacaciones/{id}', 'RHReporte@vempleado')->middleware('roleshinobi:recurso');
	Route::get('reporte/permiso/{id}', 'RHReporte@pempleado')->middleware('roleshinobi:recurso');

	//Listapo reclutamiento
	Route::get('nombrelistr/{id}','Rechazados@nombrelistr');
	Route::put('uprechazo/{id}','Rechazados@uprechazo');
});

//Rutas para Jefe Inmediato
Route::group(['prefix'=>'ji'],function(){

	//viajejf
		Route::get('viajejf','JIViajeController@index');
		Route::get('viajejf/solicitados','JIViajeController@solicitados');
		Route::get('viajejf/autorizados','JIViajeController@autorizados');
		Route::get('viajejf/revisionji','JIViajeController@revisionji');
		Route::get('viajejf/rechazados','JIViajeController@rechazados');
		Route::get('viajejf/detallesolicitud/{id}','JIViajeController@detallesolicitud');
		Route::put('viajejf/respuesta','JIViajeController@respuestaviaje');
		Route::delete('viajejf/delvhc/{id}','JIViajeController@delvhc');
		Route::get('viajejf/detallesliq/{id}','JIViajeController@detalleautoas');
		Route::put('viajejf/revok','JIViajeController@revok');
		Route::put('viajejf/revretorna','JIViajeController@revretorna');

	//Reporte de vacaciones y permisos.
		Route::get('reporte/vpempleado', 'JIReporte@reportevp')->middleware('roleshinobi:jefeinmediato');
		Route::get('reporte/vpempleado/index', 'JIReporte@vpindex')->middleware('roleshinobi:jefeinmediato');
		Route::get('reporte/vacaciones/{id}', 'JIReporte@vempleado')->middleware('roleshinobi:jefeinmediato');
		Route::get('reporte/permiso/{id}', 'JIReporte@pempleado')->middleware('roleshinobi:jefeinmediato');

});

//Rutas asistente o conta
Route::group(['prefix'=>'asistete'],function()
{
	//viaje

		Route::get('viaje','AsistenteC@index');
		Route::get('viaje/avancesol','AsistenteC@vasistentes');
		Route::get('viaje/avance','AsistenteC@revasistentes');
		Route::get('viaje/detallesliq/{id}','AsistenteC@detalleautoas');
		Route::put('viaje/revision','AsistenteC@revision');
		Route::put('viaje/revision2','AsistenteC@revision2');
		Route::get('viaje/liquidar/add/{id}/{ids?}','AsistenteC@addl');
		Route::put('viaje/revisado','AsistenteC@revisado');
		Route::put('viaje/tramite','AsistenteC@tramite');
		Route::delete('viaje/delete/{id}','AsistenteC@elimina');
		Route::get('viaje/updatemonto/{id}','AsistenteC@updateml');
		Route::get('viaje/edit/{id}','AsistenteC@editl');

});

Route::group(['prefix'=>'asistente'],function()
{
	//Aperturar Caja chica
		Route::get 	('cajachica','ACajaChica@index');
		Route::get 	('cajachica/create','ACajaChica@create');
		Route::post ('cajachica/store','ACajaChica@store');
		Route::get 	('cajachica/indexliquidar','ACajaChica@indexliquidar');
		Route::get  ('cajachica/liquidando','ACajaChica@indexliquidar');
		Route::get 	('cajachica/liquidar/{id}','ACajaChica@liquidar');

});

//rutas del controlador de Usuario

Route::group(['prefix'=>'seguridad'],function()
{
	Route::get('usuario', 'PCUsuarioController@contenedor')->middleware('roleshinobi:informatica');
	Route::get('usuarios/{page?}','PCUsuarioController@index')->middleware('roleshinobi:informatica');
	Route::get('usuario/create','PCUsuarioController@add')->middleware('roleshinobi:informatica');
	Route::post('usuario/store','PCUsuarioController@store')->middleware('roleshinobi:informatica');
	Route::get('usuario/editar_usuario/{id}', 'PCUsuarioController@editar_usuario')->middleware('roleshinobi:informatica');

	// Rutas del proyecto de liquidacion, caja chica.

	Route::get ('proyecto','PCProyecto@index')->middleware('roleshinobi:informatica');
	Route::post('proyecto/store','PCProyecto@store')->middleware('roleshinobi:informatica');
	Route::put ('proyecto/determinado','PCProyecto@default')->middleware('roleshinobi:informatica');
	
});

Route::delete('destroy/{id}','PCUsuarioController@destroy')->middleware('roleshinobi:informatica');
Route::get('asignar_rol/{idusu}/{idrol}', 'PCUsuarioController@asignar_rol')->middleware('roleshinobi:informatica');
Route::get('quitar_rol/{idusu}/{idrol}','PCUsuarioController@quitar_rol')->middleware('roleshinobi:informatica');
Route::get('cambiarclave/{id}/{clave}','PCUsuarioController@cambiarclave')->middleware('roleshinobi:informatica');

//Route::get('form_nuevo_usuario', 'UsuariosController@form_nuevo_usuario');
Route::get('seguridad/usuario/form_nuevo_rol', 'PCUsuarioController@form_nuevo_rol')->middleware('roleshinobi:informatica');
Route::get('seguridad/buscar_usuarios/{rol}/{dato?}', 'PCUsuarioController@buscar_usuarios'); 

Route::post('crear_rol', 'PCUsuarioController@crear_rol')->middleware('roleshinobi:informatica');
Route::get('borrar_rol/{idrol}', 'PCUsuarioController@borrar_rol')->middleware('roleshinobi:informatica');




//reporte empleado vacaciones y permisos.

