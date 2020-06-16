<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Calificacion;
use App\CalificacionPonderacion;
use App\CargaPonderacion;
use App\Hacademica;
use App\Inscripcion;
use App\Ponderacion;
use App\PeriodoEstudio;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests\updateCargaPonderacion;
use App\Http\Requests\createCargaPonderacion;
use DB;
use Log;

class CargaPonderacionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cargaPonderacions = CargaPonderacion::getAllData($request);
        $ponderaciones = Ponderacion::pluck('name', 'id');
        return view('cargaPonderacions.index', compact('cargaPonderacions', 'ponderaciones'))
            ->with('list', CargaPonderacion::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $padre = CargaPonderacion::where('tiene_detalle', 1)->pluck('name', 'id');
        $ponderaciones = Ponderacion::pluck('name', 'id');
        $padre->prepend('Seleccionar opcion', '0');
        return view('cargaPonderacions.create', compact('ponderaciones', 'padre'))
            ->with('list', CargaPonderacion::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createCargaPonderacion $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        if (isset($input['tiene_detalle'])) {
            $input['tiene_detalle'] = 1;
        } else {
            $input['tiene_detalle'] = 0;
        }
        if (isset($input['bnd_activo'])) {
            $input['bnd_activo'] = 1;
        } else {
            $input['bnd_activo'] = 0;
        }

        //create data
        CargaPonderacion::create($input);

        return redirect()->route('cargaPonderacions.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, CargaPonderacion $cargaPonderacion)
    {
        $cargaPonderacion = $cargaPonderacion->find($id);
        return view('cargaPonderacions.show', compact('cargaPonderacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, CargaPonderacion $cargaPonderacion)
    {
        $cargaPonderacion = $cargaPonderacion->find($id);
        $padre = CargaPonderacion::where('tiene_detalle', 1)->pluck('name', 'id');
        $ponderaciones = Ponderacion::pluck('name', 'id');

        $padre->prepend('Seleccionar opcion', '0');
        return view('cargaPonderacions.edit', compact('cargaPonderacion', 'ponderaciones', 'padre'))
            ->with('list', CargaPonderacion::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, CargaPonderacion $cargaPonderacion)
    {
        $cargaPonderacion = $cargaPonderacion->find($id);
        return view('cargaPonderacions.duplicate', compact('cargaPonderacion'))
            ->with('list', CargaPonderacion::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, CargaPonderacion $cargaPonderacion, updateCargaPonderacion $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        if (isset($input['tiene_detalle'])) {
            $input['tiene_detalle'] = 1;
        } else {
            $input['tiene_detalle'] = 0;
        }
        if (isset($input['bnd_activo'])) {
            $input['bnd_activo'] = 1;
        } else {
            $input['bnd_activo'] = 0;
        }
        //update data
        $cargaPonderacion = $cargaPonderacion->find($id);
        $cargaPonderacion->update($input);

        return redirect()->route('cargaPonderacions.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, CargaPonderacion $cargaPonderacion)
    {
        $cargaPonderacion = $cargaPonderacion->find($id);
        $cargaPonderacion->delete();

        return redirect()->route('cargaPonderacions.index')->with('message', 'Registro Borrado.');
    }

    public function getCmbCarga(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $ponderacion = $request->get('ponderacion_id');
            $carga_ponderacion = $request->get('carga_ponderacion_id');

            $final = array();
            $r = DB::table('carga_ponderacions as cp')
                ->select('cp.id', 'cp.name')
                ->where('cp.ponderacion_id', '=', $ponderacion)
                ->where('cp.id', '>', '0')
                ->get();
            //dd($r);
            if (isset($carga_ponderacion) and $carga_ponderacion <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $carga_ponderacion) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function ajustarMaterias(Request $request)
    {
        $datos = $request->all();

        $ponderacion = Ponderacion::find($datos['ponderacion']);
        $carga_ponderacions_borrar = array();
        foreach ($ponderacion->cargaPonderacions as $cp) {
            if ($cp->bnd_activo == 0) {
                array_push($carga_ponderacions_borrar, $cp->id);
            }
        }
        //dd($carga_ponderacions_borrar);

        $calificacion_ponderacions_borrar = CalificacionPonderacion::whereIn('carga_ponderacion_id', $carga_ponderacions_borrar)
            //->where('calificacion_parcial', 0)
            ->whereNull('deleted_at')
            ->get();
        //dd($calificacion_ponderacions_borrar->toArray());
        if ($calificacion_ponderacions_borrar->count() > 0) {
            foreach ($calificacion_ponderacions_borrar as $calificacion_ponderacion_borrar) {
                //dd($calificacion_ponderacion_borrar->calificacion->calificacion);
                if ($calificacion_ponderacion_borrar->calificacion->calificacion == 0) {
                    //dd($calificacion_ponderacion_borrar->calificacion->calificacion);
                    $calificacion = $calificacion_ponderacion_borrar->calificacion;
                    $hacademica = $calificacion->hacademica;
                    //dd($hacademica);

                    //inicion
                    //foreach ($materias as $m) {
                    //$ha=$m;
                    //dd($m);
                    Log::info("hacademica_id: " . $hacademica->id);
                    /*$calif = Calificacion::where('hacademica_id', $m->id)
                            ->where('tpo_examen_id', 1)
                            ->wherenull('deleted_at')
                            ->where('calificacion', 0)
                            ->first();
                        */

                    //if (!is_null($calif)) {
                    //dd($calif);
                    $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $hacademica->materia->ponderacion_id)
                        ->where('bnd_activo', 1)
                        ->get();

                    //dd($ponderaciones);

                    $ponderaciones_validar = array();
                    foreach ($ponderaciones as $ponderacion) {
                        array_push($ponderaciones_validar, $ponderacion->id);
                    }
                    //dd($ponderaciones_validar);

                    $contar_registros = CalificacionPonderacion::where('calificacion_id', $calificacion->id)
                        ->whereIn('carga_ponderacion_id', $ponderaciones_validar)
                        ->count();

                    //dd($contar_registros==0);
                    //dd($calif->calificacion==0);
                    if ($contar_registros == 0 and $calificacion->calificacion == 0) {
                        //dd($ponderaciones   );
                        foreach ($ponderaciones as $p) {
                            $ponde['calificacion_id'] = $calificacion->id;
                            $ponde['carga_ponderacion_id'] = $p->id;
                            $ponde['calificacion_parcial'] = 0;
                            $ponde['ponderacion'] = $p->porcentaje;
                            $ponde['usu_alta_id'] = Auth::user()->id;
                            $ponde['usu_mod_id'] = Auth::user()->id;
                            $ponde['tiene_detalle'] = $p->tiene_detalle;
                            $ponde['padre_id'] = $p->padre_id;
                            CalificacionPonderacion::create($ponde);
                        }
                    }
                    //}
                    //}
                    //FIn


                    $calificacion_ponderacion_borrar->delete();
                }
            }
        }

        /*
        $inscripciones=Hacademica::select('hacademicas.inscripcion_id','hacademicas.cliente_id')
        ->join('materia as m','m.id','=','hacademicas.materium_id')
        ->where('m.ponderacion_id',$datos['ponderacion'])
        ->whereNull('m.deleted_at')
        ->whereNull('hacademicas.deleted_at')
        ->orderBy('hacademicas.cliente_id')
        ->distinct()
        //->limit(10)
        //->whereIn('hacademicas.cliente_id', array(9334, 3279, 3299, 3506, 3536))
        ->get();
*/
        /*
        $inscripciones = Hacademica::select('hacademicas.inscripcion_id', 'hacademicas.cliente_id', 'calif.calificacion')
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->join('calificacions as calif', 'calif.hacademica_id', '=', 'hacademicas.id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->where('m.ponderacion_id', $datos['ponderacion'])
            ->where('calif.calificacion', 0)
            ->whereNull('m.deleted_at')
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            //->where('hacademicas.cliente_id', 9210)
            ->orderBy('hacademicas.cliente_id')
            ->distinct()
            ->limit(10)
            ->orderBy('hacademicas.cliente_id')
            ->chunk(10, function ($inscripcions) {
                foreach ($inscripcions as $inscripcion) {

                    if ($inscripcion->calificacion == 0) {
                        //Log::info(($inscripcion->calificacion == 0) . "inscriopcion:" . $inscripcion->inscripcion_id . " - caifica:" . $inscripcion->calificacion);
                        //dd($inscripcion);
                        $this->registrarMaterias($inscripcion->inscripcion_id);
                        //Log::info("Ajuste de ponderaciones" . $inscripcion->cliente_id);
                    }
                }
            });
*/

        //dd($inscripciones->toArray());
        /*foreach ($inscripciones as $inscripcion) {
            $this->registrarMaterias($inscripcion->inscripcion_id);
            Log::info("Ajuste de ponderaciones" . $inscripcion->cliente_id);
            //break;
        }*/

        return redirect()->back();
    }

    public function registrarMaterias($id)
    {
        $i = Inscripcion::find($id);
        //dd($i);

        $materias = Hacademica::select('hacademicas.id', 'materium_id')
            ->where('hacademicas.inscripcion_id', '=', $i->id)
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
            ->where('c.calificacion', '=', 0)
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            ->distinct()
            ->get();
        //dd($materias->toArray());
        //Log::info($materias);
        foreach ($materias as $m) {
            //$ha=$m;
            //dd($m);
            Log::info("hacademica_id: " . $m->id);
            $calif = Calificacion::where('hacademica_id', $m->id)
                ->where('tpo_examen_id', 1)
                ->wherenull('deleted_at')
                ->where('calificacion', 0)
                ->first();


            if (!is_null($calif)) {
                //dd($calif);
                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $m->materia->ponderacion_id)
                    ->where('bnd_activo', 1)
                    ->get();

                //dd($ponderaciones);

                $ponderaciones_validar = array();
                foreach ($ponderaciones as $ponderacion) {
                    array_push($ponderaciones_validar, $ponderacion->id);
                }
                //dd($ponderaciones_validar);

                $contar_registros = CalificacionPonderacion::where('calificacion_id', $calif->id)
                    ->whereIn('carga_ponderacion_id', $ponderaciones_validar)
                    ->count();

                //dd($contar_registros==0);
                //dd($calif->calificacion==0);
                if ($contar_registros == 0 and $calif->calificacion == 0) {
                    //dd($ponderaciones   );
                    foreach ($ponderaciones as $p) {
                        $ponde['calificacion_id'] = $calif->id;
                        $ponde['carga_ponderacion_id'] = $p->id;
                        $ponde['calificacion_parcial'] = 0;
                        $ponde['ponderacion'] = $p->porcentaje;
                        $ponde['usu_alta_id'] = Auth::user()->id;
                        $ponde['usu_mod_id'] = Auth::user()->id;
                        $ponde['tiene_detalle'] = $p->tiene_detalle;
                        $ponde['padre_id'] = $p->padre_id;
                        CalificacionPonderacion::create($ponde);
                    }
                }
            }
        }
    }
}
