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
Route::get('towns/{id}', 'PersonaController@getTowns');
Route::post('solicitud/ds','PersonaController@store');

Route::group(['prefix'=>'listados'],function(){
	Route::resource('empleado','ListadoController');
	Route::resource('pprueba','Pprueba');
	Route::resource('confirmacion','Confirmacion');
	Route::resource('rechazados','Rechazados');
	Route::resource('interino','Interino');
	Route::get('update/{id}','Pprueba@update');
	Route::get('update/{id}','Confirmacion@update');
});



// Rutas Creados por LDRL

Route::group(['prefix'=>'empleado'],function(){
	Route::resource('permiso','PController');       // PController = PermisoController 
	Route::get('vacaciones','VController@create');
	Route::post('vacaciones','VController@store');
	Route::resource('solicitante','SController'); 	// SController = SolicitanteController
	Route::get('Spdf/{id}', 'SController@Spdf');
	Route::resource('perfil','PerController');
//	Route::post('updatefoto', 'FotoController@agregarimagen'); 		// PerController = PerfilController
	Route::post('/updatefoto','UController@subirimagen');

	//Route::get('update/{id}','SController@update');

	Route::get('rechazo/{id}','SController@rechazo');

	Route::get('galeria','UController@galeria');
	Route::get('listaracademico','UController@listaracademico');
	Route::get('towns/{id}', 'UController@getTowns'); 
	Route::post('agregaracademico','UController@agregaracademico');
	Route::get('listarfamilia','UController@listarfamiliar');
	Route::post('agregarfamiliar','UController@agregarfamiliar');

//FotoController@agregarimagen
	//Route::put('/colaboradores/{id}',['uses' => 'Colaboradores@update', 'middleware' => 'auth']);

});


Route::get('/', function () {
    return view('auth/login');
});
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('pdf','SController@pdf');


///
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::resource('seguridad/usuario','UController'); 