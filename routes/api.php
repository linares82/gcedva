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
//Api para crear formularios en paginas web
Route::get(
    '/planteles/lista',
    array(
        'as' => 'planteles.lista',
        'uses' => 'PlantelsController@apiLista',
    )
);

Route::get(
    '/especialidades/listaXplantel',
    array(
        'as' => 'especialidades.listaXplantel',
        'uses' => 'EspecialidadsController@apiListaXPlantel',
    )
);

Route::get(
    '/niveles/listaXplantelYespecialidad',
    array(
        'as' => 'nivels.listaXplantelYespecialidad',
        'uses' => 'NivelsController@apiListaXplantelYespecialidad',
    )
);

Route::get(
    '/grados/listaXplantelYespecialidadYgrado',
    array(
        'as' => 'grados.listaXplantelYespecialidadYgrado',
        'uses' => 'GradosController@apiListaXplantelYespecialidadYgrado',
    )
);

Route::get(
    '/turnos/listaXplantelYespecialidadYgradoYnivel',
    array(
        'as' => 'turnos.listaXplantelYespecialidadYgradoYnivel',
        'uses' => 'TurnosController@apiListaXplantelYespecialidadYgradoYnivel',
    )
);

Route::get(
    '/medios/lista',
    array(
        'as' => 'medios.lista',
        'uses' => 'MediosController@apiLista',
    )
);

Route::get(
    '/estados/lista',
    array(
        'as' => 'estados.lista',
        'uses' => 'EstadosController@apiLista',
    )
);

Route::get(
    '/municipios/listaXestado',
    array(
        'as' => 'municipios.listaXestado',
        'uses' => 'MunicipiosController@apiListaXestado',
    )
);

Route::post(
    '/clientes/apiCreate',
    array(
        'as' => 'clientes.apiCreate',
        'uses' => 'ClientesController@apiStore',
    )
);

//Api para crear registros con ebanx
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

//Multipagos inicio
Route::post(
    '/multipagos/successMultipagos',
    array(
        'as' => 'multipagos.successMultipagos',
        'uses' => 'PagosController@successMultipagos',
    )
);

Route::post(
    '/multipagos/failMultipagos',
    array(
        'as' => 'multipagos.failMultipagos',
        'uses' => 'PagosController@failMultipagos',
    )
);
//Multipagos fin

Route::post(
    '/user/apiLoginCliente',
    array(
        'as' => 'users.apiLoginCliente',
        'uses' => 'User1Controller@apiLoginCliente',
    )
);
Route::post(
    '/user/apiLoginUsuario',
    array(
        'as' => 'users.apiLoginUsuario',
        'uses' => 'User1Controller@apiLoginUsuario',
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
