<?php

use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
});
 */
Route::get(
    '/cliente/findBy',
    array(
        'as' => 'cliente.findBy',
        'uses' => 'ClientesController@findBy',
    )
);

Route::post(
    '/ebanxes/notificacion',
    array(
        'as' => 'ebanxes.notificacion',
        'uses' => 'EbanxesController@notificacion',
    )
);

Route::get('/ebanxes/paisesWeb', 'EbanxesController@paisesWeb');

Route::get(
    '/ebanxes/ofertaEmm',
    array(
        'as' => 'ebanxes.ofertaEmm',
        'uses' => 'EbanxesController@ofertaEmm',
    )
);

Route::get(
    '/ebanxes/cmbOfertaEmm',
    array(
        'as' => 'ebanxes.cmbOfertaEmm',
        'uses' => 'EbanxesController@cmbOfertaEmm',
    )
);

Route::get(
    '/ebanxes/ofertaCedva',
    array(
        'as' => 'ebanxes.ofertaCedva',
        'uses' => 'EbanxesController@ofertaCedva',
    )
);

Route::get(
    '/ebanxes/cmbOfertaCedva',
    array(
        'as' => 'ebanxes.cmbOfertaCedva',
        'uses' => 'EbanxesController@cmbOfertaCedva',
    )
);

Route::post(
    '/ebanxes/cargaCliente',
    array(
        'as' => 'ebanxes.cargaCliente',
        'uses' => 'EbanxesController@cargaCliente',
    )
);

//Api para consultas en la web del cliente
/*
Route::post('test', function () {
echo json_encode(array('saludo' => "Hola fil"));
})->middleware('APIToken');

Route::middleware('auth:api')->post('test1', function (Request $request) {
echo json_encode(array('saludo' => "Hola fil2"));
//return $request->user();
});

Route::post('test2', function (Request $request) {
//echo json_encode(array('saludo' => "Hola fil3"));
return $request->user();
})->middleware('auth:api');
 */
Route::post(
    '/user/apiLogin',
    array(
        'as' => 'users.apiLogin',
        'uses' => 'User1Controller@apiLogin',
    )
);
Route::get(
    '/adeudos/adeudosXCliente',
    array(
        'as' => 'adeudos.adeudosXCliente',
        'uses' => 'AdeudosController@adeudosXCliente',
    )
);

Route::get(
    '/inscripcions/historiaCalificaciones',
    array(
        'as' => 'inscripcions.historiaCalificaciones',
        'uses' => 'InscripcionsController@historiaCalificaciones',
    )
);

Route::get(
    '/hacademicas/lectivosXalumno',
    array(
        'as' => 'hacademicas.lectivosXalumno',
        'uses' => 'HacademicasController@lectivosXalumno',
    )
);

Route::get(
    '/hacademicas/materiasXalumno',
    array(
        'as' => 'hacademicas.materiasXalumno',
        'uses' => 'HacademicasController@materiasXalumno',
    )
);

Route::get(
    '/hacademicas/gruposXalumno',
    array(
        'as' => 'hacademicas.gruposXalumno',
        'uses' => 'HacademicasController@gruposXalumno',
    )
);

Route::get(
    '/asignacion_academicas/asistenciasXAsignacion',
    array(
        'as' => 'asignacion_academicas.asistenciasXAsignacion',
        'uses' => 'AsignacionAcademicasController@asistenciasXAsignacion',
    )
);
