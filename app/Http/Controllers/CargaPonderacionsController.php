<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Calificacion;
use App\CalificacionPonderacion;
use App\CargaPonderacion;
use App\Hacademica;
use App\Inscripcion;
use App\Materium;
use App\Ponderacion;
use App\PeriodoEstudio;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests\updateCargaPonderacion;
use App\Http\Requests\createCargaPonderacion;
use DB;
use Log;
use Response;

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
        $currentDate=Date('Y-m-d');

        $calificacion_ponderacions_borrar = CalificacionPonderacion::select('calificacion_ponderacions.*')->join('calificacions as cali','cali.id','calificacion_ponderacions.calificacion_id')
            ->join('hacademicas as h','h.id','cali.hacademica_id')
            ->join('lectivos as l','l.id','h.lectivo_id')
            ->whereIn('carga_ponderacion_id', $carga_ponderacions_borrar)
            ->whereDate('l.fin', '>=', $currentDate) 
            ->whereNull('calificacion_ponderacions.deleted_at')
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


                    Log::info("hacademica_id: " . $hacademica->id);

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

    public function ponderacionesXMateria(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $materia = $request->get('materia_id');
            $materium = Materium::find($materia);

            $final = array();
            $r = DB::table('carga_ponderacions as cp')
                ->select('cp.id', 'cp.name')
                ->where('cp.ponderacion_id', '=', $materium->ponderacion_id)
                ->where('cp.id', '>', '0')
                ->where('cp.bnd_activo', 1)
                ->distinct()
                ->get();

            //dd($r);
            return $r;
        }
    }

    public function descargarCsv(){
        $registros=CargaPonderacion::select('id','name','porcentaje','padre_id','tiene_detalle')->where('bnd_activo',1)->get();
        //dd($registros->toArray());
        $encabezado=array('ID','NOMBRE','PORCENTAJE','PADRE','TIENE DETALLE');
        $handle = fopen('ponderaciones.csv', 'w');
        fputcsv($handle, $encabezado, ',');
        foreach ($registros as $registro) {
            fputcsv($handle, $registro->toArray(), ',');
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
            'charset'=>'utf-8',
            'lang'=>'es'
        );
        return Response::download('ponderaciones.csv', 'ponderaciones.csv', $headers);
    }

    public function cargarCsv(){
        
    }
}
