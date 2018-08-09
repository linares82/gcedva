<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hacademica;
use App\Materium;
use App\AsignacionAcademica;
use App\Calificacion;
use App\Ponderacion;
use App\CalificacionPonderacion;
use App\CargaPonderacion;
use App\Cliente;
use App\TpoExamen;
use App\Inscripcion;
use App\Grado;
use PDF;
use App\Param;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHacademica;
use App\Http\Requests\createHacademica;
use DB;

class HacademicasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $hacademicas = Hacademica::getAllData($request);

        return view('hacademicas.index', compact('hacademicas'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('hacademicas.create')
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createHacademica $request) {

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
    public function show($id, Hacademica $hacademica) {
        $hacademica = $hacademica->find($id);
        return view('hacademicas.show', compact('hacademica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Hacademica $hacademica) {
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
    public function duplicate($id, Hacademica $hacademica) {
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
    public function update($id, Hacademica $hacademica, updateHacademica $request) {
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
    public function destroy($id, Hacademica $hacademica) {
        $hacademica = $hacademica->find($id);
        $c = $hacademica->cliente_id;
        $hacademica->delete();

        return redirect()->route('clientes.edit', $c)->with('message', 'Registro Borrado.');
    }

    public function getCalificaciones() {
        $examen = TpoExamen::where('id', '=', 1)->pluck('name', 'id');
        return view('hacademicas.calificaciones', compact('examen'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postCalificaciones(Request $request) {
        //dd($request->all());
        $input = $request->all();
        //dd($input['calificacion_parcial_id']);
        //dd($hacademicas);
        $aprobatoria = Param::where('llave', 'calificacion_aprobatoria')->value('valor');
        if (isset($input['calificacion_parcial_id'])) {
            foreach ($input['calificacion_parcial_id'] as $key => $value) {
                //dd($key . "->" . $value);
                $id = $value;
                $posicion = $key;
                $c = CalificacionPonderacion::find($id);

                //dd($input['calificacion_parcial'][$posicion]);

                $c->calificacion_parcial = $input['calificacion_parcial'][$posicion];
                $c->calificacion_parcial_calculada = $input['calificacion_parcial'][$posicion] * $c->ponderacion;
                $c->save();
                //dd($c->toArray());
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
                $calif_total = Calificacion::where('hacademica_id', '=', $h->id)->first();
                //dd($calif_total);
                if ($calif_total->calificacion >= $aprobatoria) {
                    $h->st_materium_id = 1;
                } else {
                    $h->st_materium_id = 2;
                }
                //dd($h->toArray());
                $h->save();
            }
        }

        if (isset($input['alumno_id']) and
                isset($input['tpo_examen_id']) and
                isset($input['materium_id']) and ! isset($input['excepcion'])) {
            $c = Cliente::where('id', '=', $input['alumno_id'])->first();
            $hacademicas = Hacademica::select('calif.id', DB::raw('concat(c.nombre, " ", c.ape_paterno," ", c.ape_materno) as nombre'), 'm.name as materia', 'te.name as examen', 'calif.calificacion', 'calif.fecha', 'g.name as grado', 'calif.calificacion', 'calif.fecha', 'calif.reporte_bnd', 'cpo.name as nombre_ponderacion', 'cp.ponderacion', 'cp.calificacion_parcial', 'cp.id as calificacion_parcial_id')
                    ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
                    ->join('calificacions as calif', 'hacademicas.id', '=', 'calif.hacademica_id')
                    ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
                    ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                    ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
                    ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                    ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                    ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
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
        } elseif (isset($input['alumno_id']) and
                isset($input['tpo_examen_id']) and
                isset($input['materium_id']) and
                isset($input['excepcion'])) {
            $c = Cliente::where('id', '=', $input['alumno_id'])->first();
            $hacademicas = Hacademica::select('calif.id', DB::raw('concat(c.nombre, " ", c.ape_paterno," ", c.ape_materno) as nombre'), 'm.name as materia', 'te.name as examen', 'calif.calificacion', 'calif.fecha', 'g.name as grado', 'calif.calificacion', 'calif.fecha', 'calif.reporte_bnd', 'cpo.name as nombre_ponderacion', 'cp.ponderacion', 'cp.calificacion_parcial', 'cp.id as calificacion_parcial_id')
                    ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
                    ->join('calificacions as calif', 'hacademicas.id', '=', 'calif.hacademica_id')
                    ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
                    ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                    ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
                    ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                    ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                    ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                    ->where('hacademicas.materium_id', '=', $input['materium_id'])
                    ->where('calif.tpo_examen_id', '=', $input['tpo_examen_id'])
                    ->where('c.id', '=', $input['alumno_id'])
                    ->get();
        }

        //dd($hacademicas->toArray());
        $examen = TpoExamen::pluck('name', 'id');
        return view('hacademicas.calificaciones', compact('hacademicas', 'examen'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function calculoCalificacionTotal($calificacion_id) {
        $calificacion_ponderacion = CalificacionPonderacion::where('calificacion_id', '=', $calificacion_id)->get();
        //dd($calificacion_ponderacion->toArray());
        $suma = 0;
        foreach ($calificacion_ponderacion as $cp) {
            $suma = $suma + $cp->calificacion_parcial_calculada;
        }
        return $suma;
    }

    public function getExamenes() {
        $examen = TpoExamen::where('id', '>', 1)->pluck('name', 'id');
        //$examen->reverse(); 
        //$examen->put(0,'Seleccionar Opción');
        //$examen->reverse(); 
        return view('hacademicas.examen', compact('examen'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postExamenes(Request $request) {
        //dd($request->all());
        $input = $request->all();
        //dd($input['calificacion'][0]);
        //dd($hacademicas);

        if (isset($input['cve_alumno']) and
                isset($input['grado_id']) and
                isset($input['materium_id']) and
                isset($input['examen_id'])) {
        //isset($input['calificacion']) and 
        //isset($input['fecha']) )
            $h = Inscripcion::select('h.id')
                    ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                    ->join('hacademicas as h', 'h.inscripcion_id', '=', 'inscripcions.id')
                    ->where('c.cve_alumno', '=', $input['cve_alumno'])
                    ->where('inscripcions.grado_id', '=', $input['grado_id'])
                    ->where('h.materium_id', '=', $input['materium_id'])
                    ->where('h.deleted_at', '=', null)
                    ->first();

            //dd($h->id);
            $c = new Calificacion;
            $c->hacademica_id = $h->id;
            $c->tpo_examen_id = $input['examen_id'];
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
            if ($input['examen_id'] == 2 and $g->name == "BACHILLERATO") {
                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 1)->get();
            } elseif ($input['examen_id'] == 2 and $g->name <> "BACHILLERATO") {
                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 2)->get();
            }
            foreach ($ponderaciones as $p) {
                $ponde['calificacion_id'] = $c->id;
                $ponde['carga_ponderacion_id'] = $p->id;
                $ponde['calificacion_parcial'] = 0;
                $ponde['ponderacion'] = $p->porcentaje;
                $ponde['usu_alta_id'] = Auth::user()->id;
                $ponde['usu_mod_id'] = Auth::user()->id;
                CalificacionPonderacion::create($ponde);
            }
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
        return view('hacademicas.examen', compact('examen'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function getRacademicas() {

        return view('hacademicas.rhacademica')
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postRacademicas(Request $request) {
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

    public function getCalificacionGrupo(Request $request) {
        $data=$request->all();
        $asignacion=$data['asignacion'];
        $examen=TpoExamen::pluck('name','id');
        
        $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
        $materia=Materium::find($asignacionAcademica->materium_id);
        //dd($asignacionAcademica);
        $carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->pluck('name','id');
        

        return view('hacademicas.calificacionGrupos', compact('asignacion','examen','carga_ponderaciones'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }

    public function postCalificacionGrupo(Request $request) {
        $data=$request->all();
        $asignacion=$data['asignacion'];
        $examen=TpoExamen::pluck('name','id');
        $asignacionAcademica = AsignacionAcademica::find($data['asignacion']);
        
        $materia=Materium::find($asignacionAcademica->materium_id);
        //dd($asignacionAcademica);
        //$carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->pluck('name','id');
        //dd($carga_ponderaciones->toArray());
        if(isset($data['excepcion'])){
            $hacademicas=HAcademica::select('cli.id', 'cli.nombre','cli.nombre2','cli.ape_paterno','cli.ape_materno','c.calificacion',
                                        'cp.calificacion_parcial_calculada','cp.id as calificacion_ponderacion_id','cp.calificacion_parcial',
                                        'cpo.name as ponderacion')
                                ->where('grupo_id','=',$asignacionAcademica->grupo_id)
                                ->join('calificacions as c','c.hacademica_id','=','hacademicas.id')
                                ->join('calificacion_ponderacions as cp','cp.calificacion_id','=','c.id')
                                ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                                ->join('clientes as cli','cli.id','=','hacademicas.cliente_id')
                                ->where('lectivo_id', '=', $asignacionAcademica->lectivo_id)
                                ->where('materium_id', '=', $asignacionAcademica->materium_id)
                                ->where('c.tpo_examen_id', '=', $data['tpo_examen_id'])
                                ->where('cp.carga_ponderacion_id', '=', $data['carga_ponderacion_id'])
                                ->orderBy('cliente_id')
                                ->get();
        }else{
            $hacademicas=HAcademica::select('cli.id', 'cli.nombre','cli.nombre2','cli.ape_paterno','cli.ape_materno','c.calificacion',
                                        'cp.calificacion_parcial_calculada','cp.id as calificacion_ponderacion_id','cp.calificacion_parcial')
                                ->where('grupo_id','=',$asignacionAcademica->grupo_id)
                                ->join('calificacions as c','c.hacademica_id','=','hacademicas.id')
                                ->join('calificacion_ponderacions as cp','cp.calificacion_id','=','c.id')
                                ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
                                ->join('clientes as cli','cli.id','=','hacademicas.cliente_id')
                                ->where('lectivo_id', '=', $asignacionAcademica->lectivo_id)
                                ->where('materium_id', '=', $asignacionAcademica->materium_id)
                                ->where('c.tpo_examen_id', '=', $data['tpo_examen_id'])
                                ->where('cp.carga_ponderacion_id', '=', $data['carga_ponderacion_id'])
                                ->orderBy('cliente_id')
                                ->whereExists(function ($query) {
                                    $query->from('calendario_evaluacions as ce')
                                    ->join('lectivos as lec', 'lec.id', '=', 'ce.lectivo_id')
                                    ->whereRaw('curdate() between ce.v_inicio and ce.v_fin')
                                    ->whereRaw('ce.carga_ponderacion_id = cpo.id')
                                    ->whereRaw('lec.id = hacademicas.lectivo_id');
                                })
                                ->get();
        }
        
        $hacademica=HAcademica::where('grupo_id','=',$asignacionAcademica->grupo_id)
                                ->where('lectivo_id', '=', $asignacionAcademica->lectivo_id)
                                ->where('materium_id', '=', $asignacionAcademica->materium_id)
                                ->first();
        
        $g = Grado::find($hacademica->grado_id)->first();
           //dd($g->toArray());
        if(isset($data['tpo_examen_id'])){
            if ($data['tpo_examen_id'] == 2 and $g->name == "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 1)->pluck('name','id');
            } elseif ($data['tpo_examen_id'] == 2 and $g->name <> "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 2)->pluck('name','id');
            } elseif($data['tpo_examen_id'] == 1){
                $carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->pluck('name','id');
            }
        }else{
            $carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->pluck('name','id');
        }
            
            
        //dd($hacademicas->toArray());
        return view('hacademicas.calificacionGrupos', compact('asignacion','examen','carga_ponderaciones','hacademicas'))
                        ->with('list', Hacademica::getListFromAllRelationApps());
    }
    
    public function actualizarCalificacion(Request $request){
        $data=$request->all();
        $calificacion_ponderacion= CalificacionPonderacion::find($data['calificacion_ponderacion']);
        $calificacion_ponderacion->calificacion_parcial=$data['calificacion_parcial'];
        $calificacion_ponderacion->calificacion_parcial_calculada=$data['calificacion_parcial']*$calificacion_ponderacion->ponderacion;
        $calificacion_ponderacion->save();
        $ponderaciones= CalificacionPonderacion::where('calificacion_id',$calificacion_ponderacion->calificacion_id)->get();
        $suma=0;
        //dd($ponderaciones->toArray());
        foreach($ponderaciones as $ponderacion){
            $suma=$suma+$ponderacion->calificacion_parcial_calculada;
        }
        //dd($suma);
        //dd($calificacion_ponderacion->calificacion_id);
        $calificacion=Calificacion::find($calificacion_ponderacion->calificacion_id);
        //dd($calificacion->toArray());
        $calificacion->calificacion=$suma;
        $aprobatoria = Param::where('llave', 'calificacion_aprobatoria')->value('valor');
        $h = Hacademica::find($calificacion->hacademica_id);
        if ($calificacion->calificacion >= $aprobatoria) {
                    $h->st_materium_id = 1;
                } else {
                    $h->st_materium_id = 2;
                }
        $calificacion->save();
        $h->save();
        return json_encode(array('calificacion'=>$calificacion->calificacion,
                                 'calificacion_parcial_calculada'=>round($calificacion_ponderacion->calificacion_parcial_calculada,2),
                                 'calificacion_parcial'=>$calificacion_ponderacion->calificacion_parcial));
    }

    public function cmbPonderaciones(Request $request){
        if ($request->ajax()) {
            //dd($request->all());
            $tpo_examen_id = $request->get('tpo_examen_id');
            $asignacion_id = $request->get('asignacion_id');
            $carga_ponderacion_id = $request->get('carga_ponderacion_id');
            
            $asignacion=AsignacionAcademica::find($asignacion_id);
            $materia=Materium::find($asignacion->materium_id);
            $hacademica=HAcademica::where('grupo_id','=',$asignacion->grupo_id)
                                ->where('lectivo_id', '=', $asignacion->lectivo_id)
                                ->where('materium_id', '=', $asignacion->materium_id)
                                ->first();
            
            $g = Grado::find($hacademica->grado_id)->first();
           //dd($g->toArray());
            if ($tpo_examen_id == 2 and $g->name == "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 1)->get();
            } elseif ($tpo_examen_id == 2 and $g->name <> "BACHILLERATO") {
                $carga_ponderaciones = CargaPonderacion::where('ponderacion_id', '=', 2)->get();
            } elseif($tpo_examen_id == 1){
                $carga_ponderaciones=CargaPonderacion::where('ponderacion_id','=',$materia->ponderacion_id)->get();
            }
            
            //dd($carga_ponderaciones->toArray());
            
            $final = array();
            
            //dd($r);
            if (isset($carga_ponderacion_id) and $carga_ponderacion_id <> 0) {
                foreach ($carga_ponderaciones as $r1) {
                    if ($r1->id == $carga_ponderacion_id) {
                        array_push($final, array('id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'));
                    } else {
                        array_push($final, array('id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''));
                    }
                }
                return $final;
            } else {
                return $carga_ponderaciones;
            }
        }
    }
}
