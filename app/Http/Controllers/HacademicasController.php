<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Session;
use App\Grado;
use App\Param;
use Exception;
use App\Cliente;
use App\Lectivo;
use App\Plantel;
use App\Materium;
use App\TpoExamen;
use Carbon\Carbon;
use App\Hacademica;
use App\Inscripcion;
use App\Ponderacion;
use App\Calificacion;
use App\Http\Requests;
use App\PeriodoExamen;
use App\CargaPonderacion;
use App\AsignacionAcademica;
use Illuminate\Http\Request;
use App\CalificacionPonderacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\createHacademica;
use App\Http\Requests\updateHacademica;

class HacademicasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $hacademicas = Hacademica::getAllData($request);

        return view('hacademicas.index', compact('hacademicas'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('hacademicas.create')
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createHacademica $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Hacademica::create($input);

        return redirect()->route('hacademicas.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Hacademica $hacademica)
    {
        $hacademica = $hacademica->find($id);
        return view('hacademicas.show', compact('hacademica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Hacademica $hacademica)
    {
        $hacademica = $hacademica->find($id);
        //dd($hacademica);
        return view('hacademicas.edit', compact('hacademica'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Hacademica $hacademica)
    {
        $hacademica = $hacademica->find($id);
        return view('hacademicas.duplicate', compact('hacademica'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Hacademica $hacademica, updateHacademica $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $hacademica = $hacademica->find($id);
        $hacademica->update($input);

        return redirect()->route('hacademicas.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Hacademica $hacademica)
    {
        $hacademica = $hacademica->find($id);
        $vhacademica = $hacademica->id;
        $c = $hacademica->cliente_id;
        $hacademica->delete();

        $calificacions = Calificacion::where('hacademica_id', $vhacademica)->get();
        foreach ($calificacions as $d) {
            $d->delete();
        }

        return redirect()->route('clientes.edit', $c)->with('message', 'Registro Borrado.');
    }

    public function getCalificaciones()
    {
        $examen = TpoExamen::pluck('name', 'id');
        return view('hacademicas.calificaciones', compact('examen'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postCalificaciones(Request $request)
    {
        //dd($request->all());
        $input = $request->all();
        //dd($input['calificacion_parcial_id']);
        //dd($hacademicas);

        $aprobatoria = Param::where('llave', 'calificacion_aprobatoria')->value('valor');
        $c = Cliente::where('id', '=', $input['alumno_id'])->first();
        if ($aprobatoria == 0) {
            $plantel = Plantel::find($c->plantel_id);
            $aprobatoria = $plantel->calificacion_aprobatoria;
        }

        if (isset($input['calificacion_parcial_id'])) {
            foreach ($input['calificacion_parcial_id'] as $key => $value) {
                //dd($key . "->" . $value);
                $id = $value;
                $posicion = $key;
                //dd($input);
                $c = CalificacionPonderacion::find($id);

                //dd($input['calificacion_parcial'][$posicion]);

                //calculo de la calificacion en la linea de acuerdo a su ponderacion en la misma linea
                $c->calificacion_parcial = $input['calificacion_parcial'][$posicion];
                $c->calificacion_parcial_calculada = round(($input['calificacion_parcial'][$posicion] * $c->ponderacion), 2);
                $c->save();



                //calculo de la calificacion padre de acuerdo a todos los hijos que tenga
                if ($c->padre_id > 0) {
                    //dd($c->padre_id);
                    $suma_calificacion_padre = $this->calculoCalificacionPadre($c->padre_id, $c->calificacion_id);
                    $calif_padre = CalificacionPonderacion::where('carga_ponderacion_id', $c->padre_id)->where('calificacion_id', $c->calificacion_id)->first();
                    //dd($calif_padre->toArray());
                    $calif_padre->calificacion_parcial = $suma_calificacion_padre;
                    $calif_padre->calificacion_parcial_calculada = round(($suma_calificacion_padre * $calif_padre->ponderacion), 2);
                    $calif_padre->save();
                }

                //dd("fil");

                //dd($c->toArray());
                //Calculo de la calificacion en la tabla de calificaciones
                $suma_calificacion = $this->calculoCalificacionTotal($c->calificacion_id);

                $calif = Calificacion::find($c->calificacion_id);

                $calif->calificacion = $this->calculoCalificacionTotal($c->calificacion_id);
                $calif->fecha = $input['fecha'];
                $calif->reporte_bnd = 0;
                if (isset($input['reporte_bnd'])) {
                    $c->reporte_bnd = 1;
                }
                $calif->save();
                $h = Hacademica::find($calif->hacademica_id);
                //$calif_total = Calificacion::where('hacademica_id', '=', $h->id)->first();
                //dd($h);
                if ($calif->calificacion >= $aprobatoria) {
                    $h->st_materium_id = 1;
                } else {
                    $h->st_materium_id = 2;
                }
                //dd($h->toArray());
                $h->save();
            }
        }

        if (
            isset($input['alumno_id']) and
            isset($input['tpo_examen_id']) and
            isset($input['materium_id']) and !isset($input['excepcion'])
        ) {

            $hacademicas = Hacademica::select(
                'calif.id',
                DB::raw('concat(c.nombre, " ", c.ape_paterno," ", c.ape_materno) as nombre'),
                'm.name as materia',
                'te.name as examen',
                'calif.calificacion',
                'calif.fecha',
                'g.name as grado',
                'calif.calificacion',
                'calif.fecha',
                'calif.reporte_bnd',
                'cpo.name as nombre_ponderacion',
                'cp.ponderacion',
                'cp.calificacion_parcial',
                'cp.id as calificacion_parcial_id',
                'cp.tiene_detalle',
                'cp.padre_id'
            )
                ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
                ->join('calificacions as calif', 'hacademicas.id', '=', 'calif.hacademica_id')
                ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
                ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->whereNull('cp.deleted_at')
                ->where('hacademicas.materium_id', '=', $input['materium_id'])
                ->where('calif.tpo_examen_id', '=', $input['tpo_examen_id'])
                ->where('c.id', '=', $input['alumno_id'])
                ->whereExists(function ($query) {
                    $query->from('calendario_evaluacions as ce')
                        ->join('lectivos as lec', 'lec.id', '=', 'ce.lectivo_id')
                        ->whereRaw('curdate() between ce.v_inicio and ce.v_fin')
                        ->whereRaw('ce.carga_ponderacion_id = cpo.id')
                        ->whereRaw('lec.id = hacademicas.lectivo_id');
                })
                ->get();
        } elseif (
            isset($input['alumno_id']) and
            isset($input['tpo_examen_id']) and
            isset($input['materium_id']) and
            isset($input['excepcion'])
        ) {
            $c = Cliente::where('id', '=', $input['alumno_id'])->first();
            $hacademicas = Hacademica::select(
                'calif.id',
                DB::raw('concat(c.nombre, " ", c.ape_paterno," ", c.ape_materno) as nombre'),
                'm.name as materia',
                'te.name as examen',
                'calif.calificacion',
                'calif.fecha',
                'g.name as grado',
                'calif.calificacion',
                'calif.fecha',
                'calif.reporte_bnd',
                'cpo.name as nombre_ponderacion',
                'cp.ponderacion',
                'cp.calificacion_parcial',
                'cp.id as calificacion_parcial_id',
                'cp.tiene_detalle',
                'cp.padre_id'
            )
                ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
                ->join('calificacions as calif', 'hacademicas.id', '=', 'calif.hacademica_id')
                ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
                ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->whereNull('cp.deleted_at')
                ->where('hacademicas.materium_id', '=', $input['materium_id'])
                ->where('calif.tpo_examen_id', '=', $input['tpo_examen_id'])
                ->where('c.id', '=', $input['alumno_id'])
                ->get();
        }

        //dd($hacademicas->toArray());
        $examen = TpoExamen::pluck('name', 'id');


        return view('hacademicas.calificaciones', compact('hacademicas', 'examen', 'input'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function calculoCalificacionTotal($calificacion_id)
    {
        $calificacion_ponderacion = CalificacionPonderacion::where('calificacion_id', '=', $calificacion_id)->where('padre_id', '=', 0)->get();
        //dd($calificacion_ponderacion->toArray());
        $suma = 0;
        foreach ($calificacion_ponderacion as $cp) {
            $suma = $suma + $cp->calificacion_parcial_calculada;
        }
        return round($suma, 2);
    }

    public function calculoCalificacionPadre($padre_id, $calificacion_id)
    {
        $calificacion_ponderacion = CalificacionPonderacion::where('padre_id', '=', $padre_id)->where('calificacion_id', $calificacion_id)->get();
        //dd($calificacion_ponderacion->toArray());
        $suma = 0;
        foreach ($calificacion_ponderacion as $cp) {
            $suma = $suma + $cp->calificacion_parcial_calculada;
        }
        return $suma;
    }

    public function getExamenes()
    {
        $examen = TpoExamen::where('id', '>', 1)->pluck('name', 'id');
        //$examen->reverse();
        //$examen->put(0,'Seleccionar Opción');
        //$examen->reverse();
        $lectivos = Lectivo::pluck('name', 'id');
        return view('hacademicas.examen', compact('examen', 'lectivos'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postExamenes(Request $request)
    {
        //dd($request->all());
        $input = $request->all();
        //dd($input['calificacion'][0]);
        //dd($input);

        if (
            isset($input['cliente_id']) and
            isset($input['grado_id']) and
            isset($input['materium_id']) and
            isset($input['examen_id']) and
            isset($input['lectivo_id'])
        ) {
            //isset($input['calificacion']) and
            //isset($input['fecha']) )
            $h = Inscripcion::select('h.id')
                ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                ->join('hacademicas as h', 'h.inscripcion_id', '=', 'inscripcions.id')
                ->where('c.id', '=', $input['cliente_id'])
                ->where('inscripcions.grado_id', '=', $input['grado_id'])
                ->where('h.materium_id', '=', $input['materium_id'])
                //->where('h.lectivo_id', '=', $input['lectivo_id']) // Se comenta para que tome la materia aunque no sea del lectivo actual
                ->where('h.deleted_at', '=', null)
                ->first();
            $calificacion_extraordinaria = Calificacion::where('hacademica_id', $h->id)->where('tpo_examen_id', 2)->first();


            //dd($h->id);
            //if (!is_object($calificacion_extraordinaria)) {
            $c = new Calificacion;
            $c->hacademica_id = $h->id;
            $c->tpo_examen_id = $input['examen_id'];
            $c->lectivo_id = $input['lectivo_id'];
            $c->calificacion = 0;
            $c->fecha = date('Y-m-d');
            $c->reporte_bnd = 0;
            if (isset($input['reporte_bnd'])) {
                $c->reporte_bnd = 1;
            }
            $c->usu_alta_id = Auth::user()->id;
            $c->usu_mod_id = Auth::user()->id;
            $c->save();

            $g = Grado::find($input['grado_id'])->first();
            $extra_bachillerato = Param::where('llave', 'extra_bachillerato')->first();
            $extra_no_bachillerato = Param::where('llave', 'extra_no_bachillerato')->first();
            $final = Param::where('llave', 'final')->first();
            if ($input['examen_id'] == 2 and $g->name == "BACHILLERATO") {
                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $extra_bachillerato->valor)->get();
            } elseif ($input['examen_id'] == 2 and $g->name <> "BACHILLERATO") {
                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $extra_no_bachillerato->valor)->get();
            } elseif ($input['examen_id'] == 3) {
                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $final->valor)->get();
            }
            //dd($ponderaciones);
            foreach ($ponderaciones as $p) {
                $ponde['calificacion_id'] = $c->id;
                $ponde['carga_ponderacion_id'] = $p->id;
                $ponde['calificacion_parcial'] = 0;
                $ponde['ponderacion'] = $p->porcentaje;
                $ponde['usu_alta_id'] = Auth::user()->id;
                $ponde['usu_mod_id'] = Auth::user()->id;
                $ponde['tiene_detalle'] = $p->tiene_detalle;
                $ponde['padre_id'] = $p->padre_id;
                $c_nueva = CalificacionPonderacion::create($ponde);

                //Log::info($c_nueva->id . "- nuevo registro de ponderacion");
            }
            //}
        }
        /* if(isset($input['cve_alumno']) and isset($input['grado_id']) and isset($input['materium_id'])){
          $hacademicas=Hacademica::select('calif.id',
          DB::raw('concat(c.nombre, " ", c.ape_paterno," ", c.ape_materno) as nombre'),
          'm.name as materia','te.name as examen', 'calif.calificacion', 'calif.fecha',
          'g.name as grado', 'calif.calificacion', 'calif.fecha', 'calif.reporte_bnd')
          ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
          ->join('calificacions as calif', 'hacademicas.id', '=', 'calif.hacademica_id')
          ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
          ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
          ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
          ->where('hacademicas.plantel_id', '=', $input['plantel_id'])
          ->where('hacademicas.grupo_id', '=', $input['grupo_id'])
          ->where('hacademicas.lectivo_id', '=', $input['lectivo_id'])
          ->where('hacademicas.materium_id', '=', $input['materium_id'])
          ->get();
          } */

        //dd($hacademicas->toArray());
        $examen = TpoExamen::where('id', '>', 1)->pluck('name', 'id');
        //$examen->reverse();
        //$examen->put(0,'Seleccionar Opción');
        //$examen->reverse();
        Session::flash('msj', 'Registro Creado');
        /*return view('hacademicas.examen', compact('examen'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
         * 
         */
        return redirect()->route('hacademicas.examenes', compact('examen'))->with('message', 'Registro Creado.');
    }

    public function getRacademicas()
    {

        return view('hacademicas.rhacademica')
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postRacademicas(Request $request)
    {
        $input = $request->all();
        $fecha = date('d-m-Y');

        $hacademicas = Hacademica::select(DB::raw('concat(c.nombre," ", c.nombre2," ",c.ape_paterno," ",c.ape_paterno) as nombre'), 'p.razon as plantel', 'e.name as especialidad', 'n.name as nivel', 'g.name as grado', 'gr.name as grupo', 'm.name as materia', 'l.name as lectivo', 'st.name as estatus', 'te.name as tipo_examen', 'calif.calificacion', 'calif.fecha')
            ->join('plantels as p', 'p.id', '=', 'hacademicas.plantel_id')
            ->join('especialidads as e', 'e.id', '=', 'hacademicas.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
            ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('grupos as gr', 'gr.id', '=', 'hacademicas.grupo_id')
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->join('st_materias as st', 'st.id', '=', 'hacademicas.st_materium_id')
            ->join('calificacions as calif', 'calif.hacademica_id', '=', 'hacademicas.id')
            ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
            ->where('hacademicas.plantel_id', '=', $input['plantel_id'])
            ->where('hacademicas.especialidad_id', '=', $input['especialidad_id'])
            ->where('hacademicas.nivel_id', '=', $input['nivel_id'])
            ->where('hacademicas.grado_id', '=', $input['grado_id']);
        //->where('hacademicas.lectivo_id', '=', $input['lectivo_id'])
        //->where('hacademicas.grupo_id', '=', $input['grupo_id']);

        /* $hacademicas=Hacademica::where('hacademicas.plantel_id', '=', $input['plantel_id'])
          ->where('hacademicas.especialidad_id', '=', $input['especialidad_id'])
          ->where('hacademicas.nivel_id', '=', $input['nivel_id'])
          ->where('hacademicas.grado_id', '=', $input['grado_id']); */
        if (isset($input['cve_alumno'])) {
            $hacademicas = $hacademicas->where('c.cve_alumno', '=', $input['cve_alumno']);
        }
        $hacademicas = $hacademicas->get();
        //dd($hacademicas->toArray());
        //dd($seguimientos->toArray());
        PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('hacademicas.rhacademicar', array('hacademicas' => $hacademicas, 'fecha' => $fecha))
            ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');

        //return view('hacademicas.rhacademicar', compact('fecha', 'hacademicas'));

        /* Excel::create('Laravel Excel', function($excel) use($seguimientos) {
          $excel->sheet('Productos', function($sheet) use($seguimientos) {
          $sheet->fromArray($seguimientos);
          });
          })->export('xls');
         */
    }

    public function getCalificacionGrupo(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $asignacion = $data['asignacion'];
        $examen = TpoExamen::pluck('name', 'id');

        $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
        $materia = Materium::find($asignacionAcademica->materium_id);
        //dd($asignacionAcademica);
        $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)
            ->where('bnd_activo', 1)
            ->pluck('name', 'id');


        return view('hacademicas.calificacionGrupos', compact('asignacion', 'examen', 'carga_ponderaciones'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postCalificacionGrupo(Request $request)
    {
        $data = $request->all();
        $ponderacion_seleccionada = CargaPonderacion::find($data['carga_ponderacion_id']);
        //dd($data);
        $asignacion = $data['asignacion'];
        $examen = TpoExamen::pluck('name', 'id');
        $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
        $lectivo = Lectivo::find($asignacionAcademica->lectivo_id);
        //dd($lectivo);
        //$calificacion_inicio=Carbon::createFromFormat('Y-m-d',$lectivo->calificacion_inicio);
        //$calificacion_fin = Carbon::createFromFormat('Y-m-d', $lectivo->calificacion_fin);
        $dentroPeriodoExamenes = 0;
        $dentroPeriodoExamenesAsignacion = 0;
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $periodos_capturados_total = 0;
        //dd($lectivo->periodoExamens->ToArray());
        foreach ($lectivo->periodoExamens as $periodoExamen) {
            //periodos de examen asociados al lectivo            
            $calificacion_inicio = Carbon::createFromFormat('Y-m-d', $periodoExamen->inicio);
            $calificacion_fin = Carbon::createFromFormat('Y-m-d', $periodoExamen->fin);
            //dd($periodoExamen);
            if ($calificacion_inicio->lessThanOrEqualTo($hoy)  and $calificacion_fin->greaterThanOrEqualTo($hoy)) {
                //$dentroPeriodoExamenesAsignacion = $periodoExamen->id; Se deshabilita la opcion de periodos de examen directo en el lectivo
            }

            $periodos_capturados_total++;
        }
        //dd($dentroPeriodoExamenes);
        //dd($lectivo->calendarioEvaluacions->toArray());
        foreach ($lectivo->calendarioEvaluacions as $fechaCalendario) {
            $calificacion_inicio = Carbon::createFromFormat('Y-m-d', $fechaCalendario->v_inicio);
            $calificacion_fin = Carbon::createFromFormat('Y-m-d', $fechaCalendario->v_fin);
            if ($calificacion_inicio->lessThanOrEqualTo($hoy)  and $calificacion_fin->greaterThanOrEqualTo($hoy)) {
                $dentroPeriodoExamenes = $fechaCalendario->id;
            }
        }

        //dd($periodos_capturados_total);
        //$periodo_examen = PeriodoExamen::find($dentroPeriodoExamenes);

        $materia = Materium::find($asignacionAcademica->materium_id);
        //dd($asignacionAcademica);
        //$carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->pluck('name','id');
        //dd($carga_ponderaciones->toArray());
        $msj = "";
        $hacademicas = null;
        //dd($periodos_capturados_total);
        //if (isset($data['excepcion']) or $periodos_capturados_total == 0) {
        if (isset($data['excepcion']) /*or $dentroPeriodoExamenesAsignacion > 0*/) {
            //dd('flc');
            $hacademicas = HAcademica::select(
                'cli.id',
                'cli.plantel_id',
                'cli.nombre',
                'cli.nombre2',
                'cli.ape_paterno',
                'cli.ape_materno',
                'cli.bnd_doc_oblig_entregados',
                'c.calificacion',
                'cp.calificacion_parcial_calculada',
                'cp.id as calificacion_ponderacion_id',
                'cp.calificacion_parcial',
                'cpo.name as ponderacion',
                'stc.name as estatus_cliente',
                'stc.id as estatus_cliente_id',
                'af.fecha as fecha_acta',
                'af.consecutivo as consecutivo_acta'
            )
                ->where('hacademicas.grupo_id', '=', $asignacionAcademica->grupo_id)
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
                ->leftJoin('acta_finals as af', 'af.id', 'c.acta_final_id')
                ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'c.id')
                ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                ->join('clientes as cli', 'cli.id', '=', 'hacademicas.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'cli.st_cliente_id')
                ->where('hacademicas.lectivo_id', '=', $asignacionAcademica->lectivo_id)
                ->where('hacademicas.materium_id', '=', $asignacionAcademica->materium_id)
                ->where('c.tpo_examen_id', '=', $data['tpo_examen_id'])
                ->where('cp.carga_ponderacion_id', '=', $data['carga_ponderacion_id'])
                ->where('cli.st_cliente_id', '<>', 27)
                ->orderBy('cli.ape_paterno')
                ->orderBy('cli.ape_materno')
                ->orderBy('cli.nombre')
                ->orderBy('cli.nombre2')
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('c.deleted_at')
                ->whereNull('cli.deleted_at')
                ->whereNull('i.deleted_at')
                ->whereNull('cp.deleted_at')
                ->orderBy('cli.ape_paterno')
                ->orderBy('cli.ape_materno')
                ->orderBy('cli.nombre')
                ->orderBy('cli.nombre2')
                ->get();
            //dd($hacademicas);
        } else {
            //if($calificacion_inicio<=$hoy and $calificacion_fin>=$hoy){

            if ($dentroPeriodoExamenes > 0) {
                $hacademicas = HAcademica::select(
                    'cli.id',
                    'cli.plantel_id',
                    'cli.nombre',
                    'cli.nombre2',
                    'cli.ape_paterno',
                    'cli.ape_materno',
                    'cli.bnd_doc_oblig_entregados',
                    'c.calificacion',
                    'cp.calificacion_parcial_calculada',
                    'cp.id as calificacion_ponderacion_id',
                    'cp.calificacion_parcial',
                    'stc.name as estatus_cliente',
                    'stc.id as estatus_cliente_id',
                    'cpo.name as ponderacion'
                )
                    ->where('hacademicas.grupo_id', '=', $asignacionAcademica->grupo_id)
                    ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                    ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
                    ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'c.id')
                    ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                    ->join('clientes as cli', 'cli.id', '=', 'hacademicas.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'cli.st_cliente_id')
                    ->where('hacademicas.lectivo_id', '=', $asignacionAcademica->lectivo_id)
                    ->where('hacademicas.materium_id', '=', $asignacionAcademica->materium_id)
                    ->where('c.tpo_examen_id', '=', $data['tpo_examen_id'])
                    ->where('cp.carga_ponderacion_id', '=', $data['carga_ponderacion_id'])
                    ->orderBy('cli.ape_paterno')
                    ->orderBy('cli.ape_materno')
                    ->orderBy('cli.nombre')
                    ->orderBy('cli.nombre2')
                    ->whereExists(function ($query) {
                        $query->from('calendario_evaluacions as ce')
                            ->join('lectivos as lec', 'lec.id', '=', 'ce.lectivo_id')
                            ->whereRaw('curdate() between ce.v_inicio and ce.v_fin')
                            ->whereRaw('ce.carga_ponderacion_id = cpo.id')
                            ->whereRaw('lec.id = hacademicas.lectivo_id');
                    })
                    ->whereNull('hacademicas.deleted_at')
                    ->whereNull('i.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->whereNull('cp.deleted_at')
                    ->get();
            }
        }

        /*if(!is_object($hacademicas)){
                $msj= "Lo sentimos usted no es el profesor de la materia o la fecha limite del perido lectivo ha finalizado";
            }*/

        $hacademica = HAcademica::where('grupo_id', '=', $asignacionAcademica->grupo_id)
            ->where('lectivo_id', '=', $asignacionAcademica->lectivo_id)
            ->where('materium_id', '=', $asignacionAcademica->materium_id)
            ->first();

        if (is_null($hacademica)) {
            $asignacion = $data['asignacion'];
            $examen = TpoExamen::pluck('name', 'id');

            $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
            $materia = Materium::find($asignacionAcademica->materium_id);
            $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)
                ->where('bnd_activo', 1)
                ->pluck('name', 'id');

            return view('hacademicas.calificacionGrupos', compact('asignacion', 'examen', 'carga_ponderaciones', 'ponderacion_seleccionada'))
                ->with('list', Hacademica::getListFromAllRelationApps())
                ->with('msj', $msj);
        }

        $g = Grado::find($hacademica->grado_id)->first();
        //dd($g->toArray());
        $carga_ponderaciones = collect();
        if (isset($data['tpo_examen_id'])) {
            if ($data['tpo_examen_id'] == 2 and $g->name == "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 1)->pluck('name', 'id');
            } elseif ($data['tpo_examen_id'] == 2 and $g->name <> "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 2)->pluck('name', 'id');
            } elseif ($data['tpo_examen_id'] == 1) {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)->pluck('name', 'id');
            }
        } else {
            $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)->pluck('name', 'id');
        }



        //dd($hacademicas->toArray());
        return view('hacademicas.calificacionGrupos', compact('asignacion', 'examen', 'carga_ponderaciones', 'hacademicas', 'ponderacion_seleccionada'))
            ->with('list', Hacademica::getListFromAllRelationApps())
            ->with('msj', $msj);
    }

    public function actualizarCalificacion(Request $request)
    {
        $data = $request->all();
        //calcula calificacion de la linea
        try {
            $calificacion_ponderacion = CalificacionPonderacion::find($data['calificacion_ponderacion']);
            //dd($calificacion_ponderacion);
            $calificacion_ponderacion->calificacion_parcial = $data['calificacion_parcial'];
            $calificacion_ponderacion->calificacion_parcial_calculada = $data['calificacion_parcial'] * $calificacion_ponderacion->ponderacion;
            $calificacion_ponderacion->save();

            //Calula calificacion del padre
            if ($calificacion_ponderacion->padre_id > 0) {
                //dd($c->padre_id);
                $suma_calificacion_padre = $this->calculoCalificacionPadre($calificacion_ponderacion->padre_id, $calificacion_ponderacion->calificacion_id);
                $calif_padre = CalificacionPonderacion::where('carga_ponderacion_id', $calificacion_ponderacion->padre_id)->where('calificacion_id', $calificacion_ponderacion->calificacion_id)->first();
                //dd($calif_padre->toArray());
                $calif_padre->calificacion_parcial = $suma_calificacion_padre;
                $calif_padre->calificacion_parcial_calculada = round(($suma_calificacion_padre * $calif_padre->ponderacion), 2);
                $calif_padre->save();
            }

            //Calcula la calificacion en la tabla de calificaciones
            $suma = $this->calculoCalificacionTotal($calificacion_ponderacion->calificacion_id);

            //dd($suma);
            //dd($calificacion_ponderacion->calificacion_id);
            $calificacion = Calificacion::find($calificacion_ponderacion->calificacion_id);
            //dd($calificacion->toArray());
            $calificacion->calificacion = $suma;

            $aprobatoria = Param::where('llave', 'calificacion_aprobatoria')->value('valor');

            if ($aprobatoria == 0) {
                $plantel = Plantel::find($calificacion->hacademica->plantel_id);
                $aprobatoria = $plantel->calificacion_aprobatoria;
            }

            $h = Hacademica::find($calificacion->hacademica_id);
            if ($calificacion->calificacion >= $aprobatoria) {
                $h->st_materium_id = 1;
            } else {
                $h->st_materium_id = 2;
            }
            $calificacion->save();
            $h->save();

            //Revisar si la materia es ponderacion de otra materia, calcular la calificacion de la materia padre
            if ($h->st_materium_id == 1) {
                $materia = $h->materia;
                if ($materia->bnd_ponderacion == true) {
                    //dd($materia->padres);
                    foreach ($materia->padre as $padre) {
                        $padreHacademicas = Hacademica::where('cliente_id', $h->cliente_id)->where('materium_id', $padre->id)->first();
                        if (!is_null($padreHacademicas)) {
                            $ponderacionesMateriasAprobadas = 1;
                            $sumaCalificaciones = 0;
                            foreach ($padre->ponderacionMaterias as $materiaH) {
                                $hijaHacademicas = Hacademica::where('cliente_id', $h->cliente_id)->where('materium_id', $materiaH->id)->first();
                                //dd($hijaHacademicas->toArray());
                                if ($hijaHacademicas->st_materium_id <> 1) {
                                    $ponderacionesMateriasAprobadas = 0;
                                } else {
                                    $calificacionAprobatoria = $hijaHacademicas->calificaciones->last();
                                    $sumaCalificaciones = $sumaCalificaciones + $calificacionAprobatoria->calificacion;
                                }
                            }
                            //dd($ponderacionesMateriasAprobadas);
                            if ($ponderacionesMateriasAprobadas == 1) {
                                $calificacionPromedio = $sumaCalificaciones / $padre->ponderacionMaterias->count();

                                $padreHacademicas->st_materium_id = 1;
                                $padreHacademicas->save();
                                //dd($padreHacademicas->calificaciones->first()->toArray());
                                $calificacionPadre = $padreHacademicas->calificaciones->first();
                                $calificacionPadre->calificacion = $calificacionPromedio;
                                $calificacionPadre->save();
                            }
                        }
                    }
                }
            }


            return json_encode(array(
                'calificacion' => $calificacion->calificacion,
                'calificacion_parcial_calculada' => round($calificacion_ponderacion->calificacion_parcial_calculada, 2),
                'calificacion_parcial' => $calificacion_ponderacion->calificacion_parcial
            ));
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function cmbPonderaciones(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $tpo_examen_id = $request->get('tpo_examen_id');
            $asignacion_id = $request->get('asignacion_id');
            $carga_ponderacion_id = $request->get('carga_ponderacion_id');

            $asignacion = AsignacionAcademica::find($asignacion_id);
            $materia = Materium::find($asignacion->materium_id);
            $hacademica = HAcademica::where('grupo_id', '=', $asignacion->grupo_id)
                ->where('lectivo_id', '=', $asignacion->lectivo_id)
                ->where('materium_id', '=', $asignacion->materium_id)
                ->first();

            $g = Grado::find($hacademica->grado_id)->first();

            //dd($g->toArray());
            $extra_bachillerato = Param::where('llave', 'extra_bachillerato')->first();
            $extra_no_bachillerato = Param::where('llave', 'extra_no_bachillerato')->first();
            $titulo_suficiencia = Param::where('llave', 'titulo_suficiencia')->first();
            if ($tpo_examen_id == 2 and $g->name == "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $extra_bachillerato->valor)
                    ->where('tiene_detalle', '=', 0)
                    ->where('bnd_activo', 1)
                    ->get();
            } elseif ($tpo_examen_id == 2 and $g->name <> "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $extra_no_bachillerato->valor)
                    ->where('tiene_detalle', '=', 0)
                    ->where('bnd_activo', 1)
                    ->get();
            } elseif ($tpo_examen_id == 3) {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $titulo_suficiencia->valor)
                    ->where('tiene_detalle', '=', 0)
                    ->where('bnd_activo', 1)
                    ->get();
            } elseif ($tpo_examen_id == 1) {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)
                    ->where('tiene_detalle', '=', 0)
                    ->where('bnd_activo', 1)
                    ->get();
            }

            //dd($carga_ponderaciones->toArray());

            $final = array();

            //dd($r);
            if (isset($carga_ponderacion_id) and $carga_ponderacion_id <> 0) {
                foreach ($carga_ponderaciones as $r1) {
                    if ($r1->id == $carga_ponderacion_id) {
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
                return $carga_ponderaciones;
            }
        }
    }

    public function lectivosXalumno(Request $request)
    {
        $datos = $request->all();
        $lectivos = Hacademica::select('l.id', 'l.name')->where('cliente_id', $datos['cliente'])
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->get();
        $registros = array();
        if (count($lectivos) == 0) {
            return response()->json([
                'message' => 'Sin lectivos'
            ], 404);
        }
        foreach ($lectivos as $lectivo) {
            array_push($registros, array('id' => $lectivo->id, 'lectivo' => $lectivo->name));
        }
        return response()->json(['resultado' => $registros]);
    }

    public function gruposXalumno(Request $request)
    {
        $datos = $request->all();
        $grupos = Hacademica::select('g.id', 'g.name')->where('cliente_id', $datos['cliente'])
            ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
            ->get();
        $registros = array();
        if (count($grupos) == 0) {
            return response()->json([
                'message' => 'Sin grupos'
            ], 404);
        }
        foreach ($grupos as $grupo) {
            array_push($registros, array('id' => $grupo->id, 'lectivo' => $grupo->name));
        }
        return response()->json(['resultado' => $registros]);
    }

    public function materiasXalumno(Request $request)
    {
        $datos = $request->all();
        $materias = Hacademica::select('m.id', 'm.name')->where('cliente_id', $datos['cliente'])
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->get();
        $registros = array();
        if (count($materias) == 0) {
            return response()->json([
                'message' => 'Sin materias'
            ], 404);
        }
        foreach ($materias as $materia) {
            array_push($registros, array('id' => $materia->id, 'materia' => $materia->name));
        }
        return response()->json(['resultado' => $registros]);
    }

    public function examenesVarios()
    {
        $examen = TpoExamen::where('id', '>', 1)->pluck('name', 'id');
        //$examen->reverse();
        //$examen->put(0,'Seleccionar Opción');
        //$examen->reverse();
        $plantels = Plantel::pluck('razon', 'id');
        $lectivos = Lectivo::pluck('name', 'id');
        return view('hacademicas.examenesVarios', compact('examen', 'lectivos', 'plantels'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function examenesVariosR(Request $request)
    {
        $datos = $request->all();
        $alumnos = Hacademica::select('hacademicas.*', 'cali.calificacion')->join('calificacions as cali', 'cali.hacademica_id', 'hacademicas.id')
            ->where('hacademicas.plantel_id', $datos['plantel_id'])
            ->where('hacademicas.especialidad_id', $datos['especialidad_id'])
            ->where('hacademicas.nivel_id', $datos['nivel_id'])
            ->where('hacademicas.grado_id', $datos['grado_id'])
            ->where('hacademicas.lectivo_id', $datos['lectivo_id'])
            ->where('cali.tpo_examen_id', 1)
            ->where('hacademicas.st_materium_id', 2)
            ->with('cliente')
            ->with('calificaciones')
            ->get();
        //dd($alumnos->toArray());
        $lectivos = Lectivo::pluck('name', 'id');
        $tpo_examen = TpoExamen::where('id', '>', 1)->pluck('name', 'id');
        return view('hacademicas.examenesVariosR', compact('alumnos', 'tpo_examen', 'lectivos'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function crearEvaluacion(Request $request)
    {

        $datos = $request->all();
        //dd($datos);
        $hacademica = Hacademica::find($datos['hacademica']);
        $c = new Calificacion;
        $c->hacademica_id = $datos['hacademica'];
        $c->tpo_examen_id = $datos['tpo_examen'];
        if ($datos['bnd_lectivo'] == 1) {
            $c->lectivo_id = $datos['lectivo'];
        } else {
            $c->lectivo_id = $hacademica->lectivo_id;
        }

        $c->calificacion = 0;
        $c->fecha = date('Y-m-d');
        $c->reporte_bnd = 0;
        if (isset($input['reporte_bnd'])) {
            $c->reporte_bnd = 1;
        }
        $c->usu_alta_id = Auth::user()->id;
        $c->usu_mod_id = Auth::user()->id;
        $c->save();
        //dd($c->toArray());

        $g = Grado::find($hacademica->grado_id)->first();
        $extra_bachillerato = Param::where('llave', 'extra_bachillerato')->first();
        $extra_no_bachillerato = Param::where('llave', 'extra_no_bachillerato')->first();
        $final = Param::where('llave', 'final')->first();
        if (($datos['tpo_examen'] == 2) and $g->name == "BACHILLERATO") {
            $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $extra_bachillerato->valor)->get();
        } elseif (($datos['tpo_examen'] == 2) and $g->name <> "BACHILLERATO") {
            $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $extra_no_bachillerato->valor)->get();
        } elseif ($datos['tpo_examen'] == 3) {
            $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $final->valor)->get();
        }
        //dd($ponderaciones);
        foreach ($ponderaciones as $p) {
            $ponde['calificacion_id'] = $c->id;
            $ponde['carga_ponderacion_id'] = $p->id;
            $ponde['calificacion_parcial'] = 0;
            $ponde['ponderacion'] = $p->porcentaje;
            $ponde['usu_alta_id'] = Auth::user()->id;
            $ponde['usu_mod_id'] = Auth::user()->id;
            $ponde['tiene_detalle'] = $p->tiene_detalle;
            $ponde['padre_id'] = $p->padre_id;
            $c_nueva = CalificacionPonderacion::create($ponde);

            //Log::info($c_nueva->id . "- nuevo registro de ponderacion");
        }
        //}
        return $c;
    }

    public function getCalificacionIncidencia(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $asignacion = $data['asignacion'];
        $examen = TpoExamen::pluck('name', 'id');

        $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
        $materia = Materium::find($asignacionAcademica->materium_id);
        //dd($asignacionAcademica);
        $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)
            ->where('bnd_activo', 1)
            ->pluck('name', 'id');


        return view('hacademicas.calificacionIncidencias', compact('asignacion', 'examen', 'carga_ponderaciones'))
            ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postCalificacionIncidencia(Request $request)
    {
        $data = $request->all();
        $ponderacion_seleccionada = CargaPonderacion::find($data['carga_ponderacion_id']);
        //dd($data);
        $asignacion = $data['asignacion'];
        $examen = TpoExamen::pluck('name', 'id');
        $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
        $lectivo = Lectivo::find($asignacionAcademica->lectivo_id);
        //dd($lectivo);
        //$calificacion_inicio=Carbon::createFromFormat('Y-m-d',$lectivo->calificacion_inicio);
        //$calificacion_fin = Carbon::createFromFormat('Y-m-d', $lectivo->calificacion_fin);
        $dentroPeriodoExamenes = 0;
        $dentroPeriodoExamenesAsignacion = 0;
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $periodos_capturados_total = 0;
        //dd($lectivo->periodoExamens->ToArray());
        foreach ($lectivo->periodoExamens as $periodoExamen) {
            //periodos de examen asociados al lectivo            
            $calificacion_inicio = Carbon::createFromFormat('Y-m-d', $periodoExamen->inicio);
            $calificacion_fin = Carbon::createFromFormat('Y-m-d', $periodoExamen->fin);
            //dd($periodoExamen);
            if ($calificacion_inicio->lessThanOrEqualTo($hoy)  and $calificacion_fin->greaterThanOrEqualTo($hoy)) {
                //$dentroPeriodoExamenesAsignacion = $periodoExamen->id; Se deshabilita la opcion de periodos de examen directo en el lectivo
            }

            $periodos_capturados_total++;
        }
        //dd($dentroPeriodoExamenes);
        //dd($lectivo->calendarioEvaluacions->toArray());
        foreach ($lectivo->calendarioEvaluacions as $fechaCalendario) {
            $calificacion_inicio = Carbon::createFromFormat('Y-m-d', $fechaCalendario->v_inicio);
            $calificacion_fin = Carbon::createFromFormat('Y-m-d', $fechaCalendario->v_fin);
            if ($calificacion_inicio->lessThanOrEqualTo($hoy)  and $calificacion_fin->greaterThanOrEqualTo($hoy)) {
                $dentroPeriodoExamenes = $fechaCalendario->id;
            }
        }

        //dd($periodos_capturados_total);
        //$periodo_examen = PeriodoExamen::find($dentroPeriodoExamenes);

        $materia = Materium::find($asignacionAcademica->materium_id);
        //dd($asignacionAcademica);
        //$carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->pluck('name','id');
        //dd($carga_ponderaciones->toArray());
        $msj = "";
        $hacademicas = null;

        $hacademicas = HAcademica::select(
            'cli.id',
            'cli.plantel_id',
            'cli.nombre',
            'cli.nombre2',
            'cli.ape_paterno',
            'cli.ape_materno',
            'cli.bnd_doc_oblig_entregados',
            'c.calificacion',
            'cp.calificacion_parcial_calculada',
            'cp.id as calificacion_ponderacion_id',
            'cp.calificacion_parcial',
            'cpo.name as ponderacion',
            'stc.name as estatus_cliente',
            'stc.id as estatus_cliente_id',
            'af.fecha as fecha_acta',
            'af.consecutivo as consecutivo_acta'
        )
            ->where('hacademicas.grupo_id', '=', $asignacionAcademica->grupo_id)
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
            ->leftJoin('acta_finals as af', 'af.id', 'c.acta_final_id')
            ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'c.id')
            ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
            ->join('clientes as cli', 'cli.id', '=', 'hacademicas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'cli.st_cliente_id')
            ->where('hacademicas.lectivo_id', '=', $asignacionAcademica->lectivo_id)
            ->where('hacademicas.materium_id', '=', $asignacionAcademica->materium_id)
            ->where('c.tpo_examen_id', '=', $data['tpo_examen_id'])
            ->where('cp.carga_ponderacion_id', '=', $data['carga_ponderacion_id'])
            ->orderBy('cli.ape_paterno')
            ->orderBy('cli.ape_materno')
            ->orderBy('cli.nombre')
            ->orderBy('cli.nombre2')
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('i.deleted_at')
            ->whereNull('cp.deleted_at')
            ->orderBy('cli.ape_paterno')
            ->orderBy('cli.ape_materno')
            ->orderBy('cli.nombre')
            ->orderBy('cli.nombre2')
            ->get();
        //dd($hacademicas);


        /*if(!is_object($hacademicas)){
                $msj= "Lo sentimos usted no es el profesor de la materia o la fecha limite del perido lectivo ha finalizado";
            }*/

        $hacademica = HAcademica::where('grupo_id', '=', $asignacionAcademica->grupo_id)
            ->where('lectivo_id', '=', $asignacionAcademica->lectivo_id)
            ->where('materium_id', '=', $asignacionAcademica->materium_id)
            ->first();

        if (is_null($hacademica)) {
            $asignacion = $data['asignacion'];
            $examen = TpoExamen::pluck('name', 'id');

            $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
            $materia = Materium::find($asignacionAcademica->materium_id);
            $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)
                ->where('bnd_activo', 1)
                ->pluck('name', 'id');

            return view('hacademicas.calificacionIncidencias', compact('asignacion', 'examen', 'carga_ponderaciones', 'ponderacion_seleccionada'))
                ->with('list', Hacademica::getListFromAllRelationApps())
                ->with('msj', $msj);
        }

        $g = Grado::find($hacademica->grado_id)->first();
        //dd($g->toArray());
        $carga_ponderaciones = collect();
        if (isset($data['tpo_examen_id'])) {
            if ($data['tpo_examen_id'] == 2 and $g->name == "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 1)->pluck('name', 'id');
            } elseif ($data['tpo_examen_id'] == 2 and $g->name <> "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 2)->pluck('name', 'id');
            } elseif ($data['tpo_examen_id'] == 1) {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)->pluck('name', 'id');
            }
        } else {
            $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)->pluck('name', 'id');
        }



        //dd($hacademicas->toArray());
        return view('hacademicas.calificacionIncidencias', compact('asignacion', 'examen', 'carga_ponderaciones', 'hacademicas', 'ponderacion_seleccionada'))
            ->with('list', Hacademica::getListFromAllRelationApps())
            ->with('msj', $msj);
    }
}
