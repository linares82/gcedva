<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AsistenciaR;
use App\AsignacionAcademica;
use App\Caja;
use App\Inscripcion;
use App\Grupo;
use App\Cliente;
use App\Hacademica;
use App\Lectivo;
use App\Empleado;
use App\Especialidad;
use App\Materium;
use App\Mese;
use App\Calificacion;
use App\Ponderacion;
use App\Pago;
use App\Plantel;
use App\CalificacionPonderacion;
use App\CargaPonderacion;
use App\PeriodoEstudio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateInscripcion;
use App\Http\Requests\createInscripcion;
use DB;
use PDF;
use Carbon\Carbon;

class InscripcionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inscripcions = Inscripcion::getAllData($request);

		return view('inscripcions.index', compact('inscripcions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inscripcions.create')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInscripcion $request)
	{
            
		$input = $request->all();
                //dd($input);
                
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                $input['st_inscripcion_id']=1;

		//create data
		$i=Inscripcion::create( $input );
                
                $lectivo=Lectivo::find($i->lectivo_id);
                $fecha=Carbon::createFromFormat('Y-m-d', $lectivo->inicio)->format('y-m-d');
                $especialidad=Especialidad::find($i->especialidad_id);
                //dd($especialidad);
                $relleno="0000000";
                $consecutivo=substr($relleno, 0, 7-strlen($i->cliente_id)).$i->cliente_id;
                //dd($consecutivo);
                if($especialidad->abreviatura<>""){
                    $entrada['matricula']=date('m',strtotime($fecha)).date('y',strtotime($fecha)).$especialidad->abreviatura.$consecutivo;
                    $i->update($entrada);
                }
                
                
                $combinacion= \App\CombinacionCliente::find($i->combinacion_cliente_id);
                if(count($combinacion)>0){
                    $combinacion->plantel_id=$i->plantel_id;
                    if($combinacion->plantel_id<>$i->plantel_id){
                    $cliente=Cliente::find($combinacion->cliente_id);
                    $cliente->plantel_id=$inscripcion->plantel_id;
                    $cliente->save();
                    $combinacion->especialidad_id=$i->especialidad_id;
                    $combinacion->nivel_id=$i->nivel_id;
                    $combinacion->grado_id=$i->grado_id;
                    $combinacion->save();
                    
                }
                }
                
		//dd($i);
			

		return redirect()->route('inscripcions.index')->with('message', 'Registro Creado.');
	}

	function registrarMaterias($id){
		$i=Inscripcion::find($id);
                //dd($periodo);
                $materias=PeriodoEstudio::find($i->periodo_estudio_id)->materias;
                //dd($materias);
		$materias_validar=Hacademica::where('grupo_id', '=', $i->grupo_id)
                                            ->where('cliente_id', '=', $i->cliente_id)
                                            ->where('grado_id', '=', $i->grado_id)
                                            ->where('lectivo_id', '=', $i->lectivo_id)
                                            ->whereNull('deleted_at')
                                            ->get();
		
                /*$materias_validar=Hacademica::where('inscripcion_id', '=', $i->id)
                                            ->whereNull('deleted_at')
                                            ->get();*/
		//dd($materias_validar->count());
		if($materias_validar->count()==0){
			foreach($materias as $m){
				$h['inscripcion_id']=$i->id;
				$h['cliente_id']=$i->cliente_id;
				$h['plantel_id']=$i->plantel_id;
				$h['especialidad_id']=$i->especialidad_id;
				$h['nivel_id']=$i->nivel_id;
				$h['grado_id']=$i->grado_id;
				$h['grupo_id']=$i->grupo_id;
				$h['materium_id']=$m->id;
				$h['st_materium_id']=0;
				$h['lectivo_id']=$i->lectivo_id;
				$h['usu_alta_id']=Auth::user()->id;
				$h['usu_mod_id']=Auth::user()->id;
				$ha=Hacademica::create($h);
				//$h=new Hacademica;
				//$h->save($h);
				$c['hacademica_id']=$ha->id;
				$c['tpo_examen_id']=1;
				$c['calificacion']=0;
				$c['fecha']=date('Y-m-d');
				$c['reporte_bnd']=0;
				$c['usu_alta_id']=Auth::user()->id;
				$c['usu_mod_id']=Auth::user()->id;
				$calif=Calificacion::create($c);
				
				$ponderaciones=CargaPonderacion::where('ponderacion_id','=', $m->ponderacion_id)->get();
				//dd($ponderaciones);
				foreach($ponderaciones as $p){
					$ponde['calificacion_id']=$calif->id;
					$ponde['carga_ponderacion_id']=$p->id;
					$ponde['calificacion_parcial']=0;
					$ponde['ponderacion']=$p->porcentaje;
					$ponde['usu_alta_id']=Auth::user()->id;
					$ponde['usu_mod_id']=Auth::user()->id;
                                        $ponde['tiene_detalle']=$p->tiene_detalle;
                                        $ponde['padre_id']=$p->padre_id;
					CalificacionPonderacion::create($ponde);
				}
			}
		}
		
		return redirect()->route('clientes.edit', $i->cliente_id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		return view('inscripcions.show', compact('inscripcion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
                
		return view('inscripcions.edit', compact('inscripcion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		return view('inscripcions.duplicate', compact('inscripcion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Inscripcion $inscripcion, updateInscripcion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inscripcion=$inscripcion->find($id);
		$inscripcion->update( $input );
                
                $lectivo=Lectivo::find($inscripcion->lectivo_id);
                $fecha=Carbon::createFromFormat('Y-m-d', $lectivo->inicio)->format('y-m-d');
                $especialidad=Especialidad::find($inscripcion->especialidad_id);
                //dd($especialidad);
                $relleno="0000000";
                $consecutivo=substr($relleno, 0, 7-strlen($inscripcion->cliente_id)).$inscripcion->cliente_id;
                //dd($consecutivo);
                if($especialidad->abreviatura<>""){
                    $entrada['matricula']=date('m',strtotime($fecha)).date('y',strtotime($fecha)).$especialidad->abreviatura.$consecutivo;
                $inscripcion->update($entrada);
                }
                
                
                if($inscripcion->combinacion_cliente_id<>0){
                    $combinacion= \App\CombinacionCliente::find($inscripcion->combinacion_cliente_id);
                    if($combinacion->plantel_id<>$inscripcion->plantel_id){
                        $cliente=Cliente::find($combinacion->cliente_id);
                        $cliente->plantel_id=$inscripcion->plantel_id;
                        $cliente->save();
                    }
                    if(count($combinacion)>0){
                        $combinacion->plantel_id=$inscripcion->plantel_id;
                        $combinacion->especialidad_id=$inscripcion->especialidad_id;
                        $combinacion->nivel_id=$inscripcion->nivel_id;
                        $combinacion->grado_id=$inscripcion->grado_id;
                        $combinacion->save();
                    }
                }
                
                
		return redirect()->route('inscripcions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		$inscripcion->delete();

		return redirect()->route('inscripcions.index')->with('message', 'Registro Borrado.');
	}

	public function destroyCli($id,Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
                //dd($id);
		$cli=$inscripcion->cliente_id;
		$inscripcion->delete();
                $hacademicas=Hacademica::where('inscripcion_id', $inscripcion->id)->get();
                if(count($hacademicas)>0){
                    foreach($hacademicas as $h){
                        $h->delete();
                    }
                }
                $hacademica->delete();

		return redirect()->route('clientes.edit', $cli)->with('message', 'Registro Borrado.');
	}

	public function getReinscripcion()
	{
            return view('inscripcions.reinscripcion')
                ->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	public function postReinscripcion(Request $request)
	{
		$input = $request->all();
		//dd($input);
                if(isset($input['id']) and isset($input['grupo_to']) and isset($input['lectivo_to'])){                                
                    
			foreach($input['id'] as $key=>$value){
				$id=$value;
				$posicion=$key;
				$i=Inscripcion::find($id);
                                if(isset($input['activar-field']) and 
                                    isset($input['especialidad_to']) and 
                                    isset($input['nivel_to']) and
                                    isset($input['grado_to'])){
                                    $i->especialidad=$input['especialidad_to'];
                                    $i->nivel=$input['nivel_to'];
                                    $i->grado=$input['grado_to'];
                                 }
                                //if($i->grupo_id<>$input['grupo_to'] and $i->lectivo_id<>$input['lectivo_to'] and $i->periodo_estudio_id<>$input['periodo_estudios_to']){
                                    $i->grupo_id=$input['grupo_to'];
                                    $i->lectivo_id=$input['lectivo_to'];
                                    $i->periodo_estudio_id=$input['periodo_estudios_to'];
                                    $i->save();
                                    if(isset($input['registrar_materias'])){
                                        $this->registrarMaterias($id);
                                    }
                                //}
			}
		}
		if(isset($input['plantel_id']) and isset($input['lectivo_id']) and isset($input['grupo_id'])){
                    $clientes=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
						->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                                                ->join('periodo_estudios as p','p.id','=','i.periodo_estudio_id')                            
						->select('i.id','clientes.id as cliente','p.name as periodo_estudio', 
                                                        DB::raw('concat(clientes.nombre," ",clientes.nombre2," ",clientes.ape_paterno," ",clientes.ape_materno) as nombre'))
                                                //->whereColumn('h.lectivo_id','i.lectivo_id')
						->where('i.plantel_id', '=', $input['plantel_id'])
						->where('i.especialidad_id', '=', $input['especialidad_id'])
						->where('i.nivel_id', '=', $input['nivel_id'])
						->where('i.grupo_id', '=', $input['grupo_id'])
						->where('i.lectivo_id', '=', $input['lectivo_id'])
                                                ->where('h.lectivo_id', '=', $input['lectivo_id'])
						->where('i.plantel_id', '=', $input['plantel_id'])
                                                //->where('h.st_materium_id',1)
                                                ->whereNull('i.deleted_at')
                                                ->distinct()
						->get();
                    //dd($clientes);
                    $resultado=collect();
                    $resultados=collect();
                    foreach($clientes as $c){
                        //dd($c);
                        $aprobadas=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                        ->join('periodo_estudios as p','p.id','=','i.periodo_estudio_id')
                        ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                        ->select(DB::raw('count(h.materium_id) as aprobadas'))
                        //->whereColumn('h.lectivo_id','i.lectivo_id')
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('i.especialidad_id', '=', $input['especialidad_id'])
                        ->where('i.nivel_id', '=', $input['nivel_id'])
                        ->where('i.grupo_id', '=', $input['grupo_id'])
                        ->where('i.lectivo_id', '=', $input['lectivo_id'])
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('clientes.id', '=', $c->cliente)        
                        ->where('h.st_materium_id', '=', 1)
                        ->whereNull('h.deleted_at')
                        ->first('aprobadas');
                        
                        $aprobadas_modulo=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                        ->join('periodo_estudios as p','p.id','=','i.periodo_estudio_id')
                        ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                        ->join('materia as m','m.id','=','h.materium_id')
                        ->select('m.id', 'm.name as materia','m.modulo_id','m.seriada_bnd')
                        //->whereColumn('h.lectivo_id','i.lectivo_id')
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('i.especialidad_id', '=', $input['especialidad_id'])
                        ->where('i.nivel_id', '=', $input['nivel_id'])
                        ->where('i.grupo_id', '=', $input['grupo_id'])
                        ->where('i.lectivo_id', '=', $input['lectivo_id'])
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('clientes.id', '=', $c->cliente)        
                        ->where('h.st_materium_id', '=', 1)
                        ->whereNull('h.deleted_at')
                        ->get();
                        //dd($aprobadas_modulo);
                        
                        
                        /*$no_aprobadas=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                        ->join('periodo_estudios as p','p.id','=','i.periodo_estudio_id')
                        ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                        ->select(DB::raw('count(h.materium_id) as no_aprobadas'))
                        //->whereColumn('h.lectivo_id','i.lectivo_id')
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('i.especialidad_id', '=', $input['especialidad_id'])
                        ->where('i.nivel_id', '=', $input['nivel_id'])
                        ->where('i.grupo_id', '=', $input['grupo_id'])
                        ->where('i.lectivo_id', '=', $input['lectivo_id'])
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('clientes.id', '=', $c->cliente)        
                        ->where('h.st_materium_id', '<>', 1)
                        ->whereNull('h.deleted_at')
                        ->first('no_aprobadas');
                        */
                        
                        $no_aprobadas_modulo=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                        ->join('periodo_estudios as p','p.id','=','i.periodo_estudio_id')
                        ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                        ->join('materia as m','m.id','=','h.materium_id')
                        ->select('m.id', 'm.name as materia','m.modulo_id','m.seriada_bnd')
                        //->whereColumn('h.lectivo_id','i.lectivo_id')
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('i.especialidad_id', '=', $input['especialidad_id'])
                        ->where('i.nivel_id', '=', $input['nivel_id'])
                        ->where('i.grupo_id', '=', $input['grupo_id'])
                        ->where('i.lectivo_id', '=', $input['lectivo_id'])
                        ->where('i.plantel_id', '=', $input['plantel_id'])
                        ->where('clientes.id', '=', $c->cliente)        
                        ->where('h.st_materium_id', '<>', 1)
                        ->whereNull('h.deleted_at')
                        ->get();
//                        $resultado->put('id',$c->id);
//                        $resultado->put('nombre',$c->nombre);
//                        $resultado->put('periodo_estudio',$c->periodo_estudio);
//                        $resultado->put('aprobadas',$aprobadas->aprobadas);
//                        $resultado->put('no_aprobadas',$no_aprobadas->no_aprobadas);
                        $contar_materias_no_aprobadas=0;
                        foreach($no_aprobadas_modulo as $no_aprobada){
                            if($no_aprobada->seriada_bnd==1){
                                $marcador=0;
                                foreach($aprobadas_modulo as $aprobada){
                                    if($aprobada->seriada_bnd==1 and $aprobada->modulo_id==$no_aprobada->modulo_id){
                                        $marcador=1;
                                    }else{
                                        //$contar_materias++;
                                    }
                                }
                                if($marcador==0){
                                    $contar_materias_no_aprobadas++;
                                }
                        }else{
                            $contar_materias_no_aprobadas++;
                        }
                            
                        }
                        //dd($aprobadas_modulo->toArray());
                        
                        //dd($contar_materias);
                        $resultados->push(['id'=>$c->id,
                                           'nombre'=>$c->nombre,
                                           'cliente'=>$c->cliente,
                                           'periodo_estudio'=>$c->periodo_estudio,
                                           'aprobadas'=>$aprobadas->aprobadas,
                                           'no_aprobadas'=>$contar_materias_no_aprobadas,
                                           'aprobadas_modulo'=>$aprobadas_modulo,
                                           'no_aprobadas_modulo'=>$no_aprobadas_modulo]);
                    }
                    
                    
		}	
		
		//dd($clientes->toArray());
                //dd($resultados);
		return view('inscripcions.reinscripcion', compact('resultados'))
			->with( 'list', Hacademica::getListFromAllRelationApps() );
	}
        
        public function lista(Request $request)
	{
            $datos=$request->all();
            $asignacion= AsignacionAcademica::find($datos['asignacion']);
            //dd($asignacion->toArray());
            $meses=Mese::pluck('name','id');
            $materias=Materium::pluck('name','id');
            $instructores=Empleado::where('puesto_id',3)->pluck('nombre','id');
		return view('inscripcions.reportes.lista_alumnos',compact('meses','materias','instructores','asignacion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function listar(Request $request)
	{
                $data=$request->all();
                //dd($data);
                $registros= Inscripcion::select('c.nombre','c.nombre2','c.ape_paterno','c.ape_materno', 'g.name as grupo','l.name as lectivo',
                                               DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),'gra.name as grado',
                                               'p.razon as plantel', 'p.logo','aa.id as asignacion','c.id as cliente','p.id as p_id','inscripcions.plantel_id',
					       'inscripcions.lectivo_id','inscripcions.grupo_id','inscripcions.grado_id')
                                       ->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
                                       ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                                       ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
                                       ->join('lectivos as l','l.id', '=', 'inscripcions.lectivo_id')
                                       ->join('asignacion_academicas as aa', 'aa.grupo_id','=','g.id')
                                       //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
                                       ->join('empleados as e','e.id','=','aa.empleado_id')
                                       ->join('grados as gra','gra.id','=','inscripcions.grado_id')
                                       ->join('plantels as p','p.id','=','c.plantel_id')
                                       ->where('inscripcions.plantel_id', $data['plantel_f'])
                                       ->where('inscripcions.lectivo_id',$data['lectivo_f'])
                                       //->where('inscripcions.grado_id',$data['grado_f'])
                                       ->where('aa.id',$data['asignacion'])
                                       ->where('aa.plantel_id', $data['plantel_f'])
                                       ->where('aa.lectivo_id',$data['lectivo_f'])
                                       ->where('aa.grupo_id',$data['grupo_f'])
                                       ->where('aa.empleado_id',$data['instructor_f'])
                                       ->where('aa.materium_id',$data['materia_f'])
                                       ->where('h.materium_id',$data['materia_f'])
                                       ->whereNull('h.deleted_at')
                                       ->whereNull('inscripcions.deleted_at')
                                       ->orderBy('inscripcions.plantel_id')
                                       ->orderBy('inscripcions.lectivo_id')
                                       ->orderBy('inscripcions.grupo_id')
                                       ->orderBy('inscripcions.grado_id')
				       ->distinct()
                                       ->get();

                
                //dd($registros->toArray());
                
                
                //Agregar fechas
                $asignacion=AsignacionAcademica::find($data['asignacion']);
                /*foreach($registros as $registro){
                    $asignacion= AsignacionAcademica::find($registro->asignacion);
                    break;
                }*/
                
                
                
                $dias=array();
                //dd($asignacion);
                foreach($asignacion->horarios as $horario){
                    array_push($dias,$horario->dia->name);
                }
                //dd($dias);
                
                
                $fechas=array();
                $lectivo=Lectivo::find($data['lectivo_f']);
                //dd($lectivo);
                $no_habiles=array();
                foreach($lectivo->diasNoHabiles as $no_habil){
                    array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                }
                //dd($no_habiles);    
                //$inicio=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
                //$fin=Carbon::createFromFormat('Y-m-d', $lectivo->fin);
                $pinicio=Carbon::createFromFormat('Y-m-d', $asignacion->fec_inicio);
                $pfin=Carbon::createFromFormat('Y-m-d', $asignacion->fec_fin);
                //dd($pfin->toDateString());
                //array_push($fechas,$pinicio);
                //$fecha=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
                $total_asistencias=0;
                while($pfin->greaterThanOrEqualTo($pinicio) ){
                    
                    if(in_array('Lunes',$dias)){
                        //dd("hay lunes");
                        if($pinicio->isMonday() and !in_array($pinicio,$no_habiles)){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                        //dd($fechas);
                    }
                    if(in_array('Martes',$dias)){
                        //dd("hay martes");
                        if($pinicio->isTuesday() and !in_array($pinicio,$no_habiles)){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    if(in_array('Miercoles',$dias)){
                        //dd("hay miercoles");
                        if($pinicio->isWednesday() and !in_array($pinicio,$no_habiles)){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    if(in_array('Jueves',$dias)){
                        //dd("hay jueves");
                        if($pinicio->isThursday() and !in_array($pinicio,$no_habiles)){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    if(in_array('Viernes',$dias)){
                        //dd("hay viernes");
                        if($pinicio->isFriday() and !in_array($pinicio,$no_habiles)){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }if(in_array('Sabado',$dias)){
                        
                        if($pinicio->isSaturday()  and !in_array($pinicio,$no_habiles)){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    $pinicio->addDay();
                    //dd($fechas);
                }
                
                $contador=0;
                foreach($fechas as $fecha){
                    $contador++;
                }
                //dd($fechas);
                //dd($registros->grupo);
                                         
		/*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
                 * */
                
/*                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
  */              
                return view('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,
                                                                          'fechas_enc'=>$fechas,
                                                                          'asignacion'=>$asignacion,
                                                                          'total_asistencias'=>$total_asistencias,
                                                                          'contador'=>$contador));
	}
        
        public function listaCalificaciones(Request $request)
	{
                $datos=$request->all();
                $asignacion= AsignacionAcademica::find($datos['asignacion']);
                $materias=Materium::pluck('name','id');
                $instructores=Empleado::where('puesto_id',3)->pluck('nombre','id');
		return view('inscripcions.reportes.lista_calificaciones',compact('materias','instructores','asignacion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function listarCalificaciones(Request $request)
	{
                $data=$request->all();
                //dd($data);
                $registros= Inscripcion::select('c.nombre','c.nombre2','c.ape_paterno','c.ape_materno', 'g.name as grupo','l.name as lectivo',
                                               DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),'gra.name as grado',
                                               'p.razon as plantel', 'p.logo','aa.id as asignacion','c.id as cliente','mate.name as materia',
                                               'mate.ponderacion_id as ponderacion','h.id as hacademica','p.id as p_id','c.matricula',
						'inscripcions.plantel_id','inscripcions.lectivo_id','inscripcions.grupo_id','inscripcions.grado_id')
                                       ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                                       ->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
                                       ->join('seguimientos as s','s.cliente_id','=','c.id')
                                       ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
                                       ->join('lectivos as l','l.id', '=', 'inscripcions.lectivo_id')
                                       ->join('asignacion_academicas as aa', 'h.grupo_id','=','g.id')
                                       ->join('materia as mate','mate.id','=','h.materium_id')
                                       ->join('empleados as e','e.id','=','aa.empleado_id')
                                       ->join('grados as gra','gra.id','=','inscripcions.grado_id')
                                       ->join('plantels as p','p.id','=','c.plantel_id')
                                       ->where('aa.id',$data['asignacion'])
                                       ->where('inscripcions.plantel_id', $data['plantel_f'])
                                       ->where('inscripcions.lectivo_id',$data['lectivo_f'])
                                       ->where('aa.plantel_id', $data['plantel_f'])
                                       ->where('aa.lectivo_id',$data['lectivo_f'])
                                       ->where('inscripcions.grupo_id',$data['grupo_f'])
				       ->where('aa.grupo_id',$data['grupo_f'])
                                       ->where('aa.empleado_id',$data['instructor_f'])
                                       ->where('h.materium_id',$data['materia_f'])
				       ->where('aa.materium_id',$data['materia_f'])
				       ->where('s.st_seguimiento_id',2)
				       ->whereNull('h.deleted_at')
                                       //->where('inscripcions.grado_id',$data['grado_f'])
                                       ->orderBy('inscripcions.plantel_id','inscripcions.lectivo_id','inscripcions.grupo_id','inscripcions.grado_id')
				       ->distinct()
                                       ->get(); 
        
                //Agregar fechas
                //dd($registros->toArray());
                $carga_ponderacion=collect();
                $asignacion=collect();
                foreach($registros as $registro){
                    $carga_ponderacion= CargaPonderacion::where('ponderacion_id',$registro->ponderacion)->get();
                    $asignacion = AsignacionAcademica::find($registro->asignacion);
                    break;
                }
                
                $contador=0;
                foreach($carga_ponderacion as $carga){
                    $contador++;
                }
                
                //dd($carga_ponderacion->toArray());
                /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
                return view('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,
                                                                                 'carga_ponderacions_enc'=>$carga_ponderacion,
                                                                                 'asignacion'=>$asignacion,
                                                                                 'contador'=>$contador,
                                                                                 'data'=>$data));
	}
        
        public function boletas()
	{
                $materias=Materium::pluck('name','id');
                $instructores=Empleado::where('puesto_id',3)->pluck('nombre','id');
		return view('inscripcions.reportes.boletas',compact('materias','instructores'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function boletasr(Request $request)
	{
                $data=$request->all();
                //dd($data);
                $registros= Inscripcion::select('c.nombre','c.nombre2','c.ape_paterno','c.ape_materno', 'g.name as grupo','l.name as lectivo',
                                               DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),'gra.name as grado',
                                               'p.razon as plantel', 'p.logo','aa.id as asignacion','c.id as cliente','mate.name as materia',
                                               'mate.ponderacion_id as ponderacion','h.id as hacademica','p.id as p_id','c.matricula')
                                       ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                                       ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
                                       ->join('lectivos as l','l.id', '=', 'inscripcions.lectivo_id')
                                       ->join('asignacion_academicas as aa', 'aa.grupo_id','=','g.id')
                                       ->join('materia as mate','mate.id','=','aa.materium_id')
                                       ->join('empleados as e','e.id','=','aa.empleado_id')
                                       ->join('grados as gra','gra.id','=','inscripcions.grado_id')
                                       ->join('plantels as p','p.id','=','c.plantel_id')
                                       ->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
                                       ->where('inscripcions.plantel_id', $data['plantel_f'])
                                       ->where('inscripcions.lectivo_id',$data['lectivo_f'])
                                       ->where('aa.plantel_id', $data['plantel_f'])
                                       ->where('aa.lectivo_id',$data['lectivo_f'])
                                       ->where('aa.grupo_id',$data['grupo_f'])
                                       ->where('aa.empleado_id',$data['instructor_f'])
                                       //->where('inscripcions.grado_id',$data['grado_f'])
                                       ->orderBy('inscripcions.plantel_id')
                                       ->orderBy('inscripcions.lectivo_id')
                                       ->orderBy('inscripcions.grupo_id')
                                       ->orderBy('inscripcions.grado_id')
                                       ->orderBy('inscripcions.cliente_id')
                                       ->get();
                //Agregar fechas
                //dd($registros->toArray());
                $carga_ponderacion=collect();
                $asignacion=collect();
                foreach($registros as $registro){
                    $carga_ponderacion= CargaPonderacion::where('ponderacion_id',$registro->ponderacion)->get();
                    $asignacion = AsignacionAcademica::find($registro->asignacion);
                    break;
                }
                
                $contador=0;
                foreach($carga_ponderacion as $carga){
                    $contador++;
                }
                
                //dd($carga_ponderacion->toArray());
                /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
                return view('inscripcions.reportes.boletasr', array('registros'=>$registros,
                                                                                 'carga_ponderacions_enc'=>$carga_ponderacion,
                                                                                 'asignacion'=>$asignacion,
                                                                                 'contador'=>$contador,
                                                                                 'data'=>$data));
	}
        
        public function InscritosUnPago()
	{
                
		return view('inscripcions.reportes.inscritosUnPago')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function InscritosUnPagoR(Request $request)
	{
                $data=$request->all();
                $plantel=Plantel::find($data['plantel_f']);
                //dd($data);
                $registros= Inscripcion::select('c.id',DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
                        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, caj.id as caja, p.fecha, m.name as medio, '
                        . 'c.beca_bnd, esp.name as especialidad'))
                            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                            ->join('medios as m','m.id','=','c.medio_id')
                            ->join('especialidads as esp','esp.id','=','inscripcions.especialidad_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                            ->join('cajas as caj','caj.cliente_id','=','c.id')
                            ->join('caja_lns as clns','clns.caja_id','=','caj.id')
                            ->join('caja_conceptos as cc','cc.id','=','clns.caja_concepto_id')
                            ->join('pagos as p','p.caja_id','=','caj.id')
                            ->where('inscripcions.plantel_id', '>=', $data['plantel_f'])
                            ->where('inscripcions.plantel_id', '<=',$data['plantel_t'])
                            ->where('p.fecha','>=',$data['fecha_f'])
                            ->where('p.fecha','<=',$data['fecha_t'])
                            //->where('c.empleado_id', $data['empleado_f'])
                            ->whereIn('caj.st_caja_id',[1,3])
                            ->where(function ($query) {
                                 $query->orWhere('cc.name','LIKE','INSCRIP%')
                                       ->orWhere('cc.name','LIKE','SEGUR%')
                                       ->orWhere('cc.name','LIKE','UNIFORM%');  
                             })
                            ->orderBy('colaborador')
                            ->distinct()
                            ->get();
                //dd($registros->toArray());
                                        
                                        
                /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
                return view('inscripcions.reportes.inscritosUnPagoR', array('registros'=>$registros,
                                                                                 'plantel'=>$plantel,
                                                                                 'data'=>$data));
	}
        
        public function InscritosLectivo()
	{
                
		return view('inscripcions.reportes.inscritosLectivo')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function InscritosLectivoR(Request $request)
	{
                $data=$request->all();
                $plantel=Plantel::find($data['plantel_f']);
                //dd($data);
                $lectivo=Lectivo::find($data['lectivo_f']);
                $registros= Inscripcion::select('c.id',DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as instructor, '
                        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente,'
                        . 'c.beca_bnd, esp.name as especialidad, inscripcions.fec_inscripcion, aa.id as asignacion,'
                        . 'gru.name as grupo, gru.id as gru, mat.name as materi, stc.name as estatus_cliente'))
                            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                            ->join('st_clientes as stc','stc.id','=','c.st_cliente_id')
                            ->join('medios as m','m.id','=','c.medio_id')
                            ->join('especialidads as esp','esp.id','=','inscripcions.especialidad_id')
                            ->join('grupos as gru','gru.id','=','inscripcions.grupo_id')
                            ->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
                            ->join('materia as mat','mat.id','=','h.materium_id')
                            ->join('asignacion_academicas as aa','aa.materium_id','=','h.materium_id')
                            ->whereColumn('aa.grupo_id','h.grupo_id')
                            ->whereColumn('aa.plantel_id','inscripcions.plantel_id')
                            ->whereColumn('aa.lectivo_id','inscripcions.lectivo_id')
                            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
                            ->where('inscripcions.plantel_id', $data['plantel_f'])
                            ->where('inscripcions.lectivo_id', $data['lectivo_f'])
                            ->where('h.lectivo_id', $data['lectivo_f'])
                            ->whereNull('inscripcions.deleted_at')
                            ->whereNull('h.deleted_at')
                            ->orderBy('aa.id','esp.name','gru.id')
                            ->distinct()
                            ->get();
                //dd($registros->toArray());
                                        
                                        
                /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
                return view('inscripcions.reportes.inscritosLectivoR', array('registros'=>$registros,
                                                                                 'plantel'=>$plantel,
                                                                                 'lectivo'=>$lectivo));
	}
        
        public function listaMes(Request $request)
	{
            $datos=$request->all();
            $asignacion= AsignacionAcademica::find($datos['asignacion']);
            $meses=Mese::pluck('name','id');
            $pinicio=Carbon::createFromFormat('Y-m-d', $asignacion->fec_inicio);
            $pfin=Carbon::createFromFormat('Y-m-d', $asignacion->fec_fin);
            //dd($meses);
            $i=1;
            foreach($meses as $mes){
                //dd($meses[$i]);
                if($i>=$pinicio->month and $i<=$pfin->month){
                    
                }else{
                    $meses->forget($i);
                }
                $i++;
            }
            //dd($meses);
            
            $materias=Materium::pluck('name','id');
            $instructores=Empleado::where('puesto_id',3)->pluck('nombre','id');
		return view('inscripcions.reportes.lista_mes',compact('meses','materias','instructores','asignacion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function listaMesR(Request $request)
	{
                $data=$request->all();
                //dd($data);
                $registros= Inscripcion::select('inscripcions.grupo_id','inscripcions.grado_id','inscripcions.lectivo_id','inscripcions.plantel_id',
                                                'c.nombre','c.nombre2','c.ape_paterno','c.ape_materno', 'g.name as grupo','l.name as lectivo',
                                               DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),'gra.name as grado',
                                               'p.razon as plantel', 'p.logo','aa.id as asignacion','c.id as cliente','p.id as p_id','c.tel_fijo')
                                       ->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
                                       ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                                       ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
                                       ->join('lectivos as l','l.id', '=', 'inscripcions.lectivo_id')
                                       ->join('asignacion_academicas as aa', 'aa.grupo_id','=','g.id')
                                       //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
                                       ->join('empleados as e','e.id','=','aa.empleado_id')
                                       ->join('grados as gra','gra.id','=','inscripcions.grado_id')
                                       ->join('plantels as p','p.id','=','c.plantel_id')
                                       ->where('aa.id',$data['asignacion'])
                                       ->where('inscripcions.plantel_id', $data['plantel_f'])
                                       ->where('inscripcions.lectivo_id',$data['lectivo_f'])
				       ->where('inscripcions.grupo_id',$data['grupo_f'])
                                       //->where('inscripcions.grado_id',$data['grado_f'])
                                       ->where('aa.plantel_id', $data['plantel_f'])
                                       ->where('aa.lectivo_id',$data['lectivo_f'])
                                       ->where('aa.grupo_id',$data['grupo_f'])
                                       ->where('aa.empleado_id',$data['instructor_f'])
                                       ->where('aa.materium_id',$data['materia_f'])
                                       ->where('h.materium_id',$data['materia_f'])
                                       ->whereNull('h.deleted_at')
                                       ->whereNull('inscripcions.deleted_at')
                                       ->orderBy('inscripcions.plantel_id')
                                       ->orderBy('inscripcions.lectivo_id')
                                       ->orderBy('inscripcions.grupo_id')
                                       ->orderBy('inscripcions.grado_id')
				       ->distinct()
                                       ->get();
                
                //dd($registros->toArray());
                
                
                //Agregar fechas
                $asignacion=AsignacionAcademica::find($data['asignacion']);
                /*foreach($registros as $registro){
                    $asignacion= AsignacionAcademica::find($registro->asignacion);
                    break;
                }*/
                
                
                
                $dias=array();
                //dd($asignacion);
                foreach($asignacion->horarios as $horario){
                    array_push($dias,$horario->dia->name);
                }
                //dd($dias);
                
                
                $fechas=array();
                $lectivo=Lectivo::find($data['lectivo_f']);
                //dd($lectivo);
                $no_habiles=array();
                foreach($lectivo->diasNoHabiles as $no_habil){
                    array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                }
                //dd($no_habiles);    
                //$inicio=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
                //$fin=Carbon::createFromFormat('Y-m-d', $lectivo->fin);
                $pinicio=Carbon::createFromFormat('Y-m-d', $asignacion->fec_inicio);
                $pfin=Carbon::createFromFormat('Y-m-d', $asignacion->fec_fin);
                //dd($pfin->toDateString());
                //array_push($fechas,$pinicio);
                //$fecha=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
                $total_asistencias=0;
                while($pfin->greaterThanOrEqualTo($pinicio) ){
                    
                    if(in_array('Lunes',$dias)){
                        //dd("hay lunes");
                        if($pinicio->isMonday() and !in_array($pinicio,$no_habiles) and $pinicio->month==$data['mes']){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                        //dd($fechas);
                    }
                    if(in_array('Martes',$dias)){
                        //dd("hay martes");
                        if($pinicio->isTuesday() and !in_array($pinicio,$no_habiles) and $pinicio->month==$data['mes']){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    if(in_array('Miercoles',$dias)){
                        //dd("hay miercoles");
                        if($pinicio->isWednesday() and !in_array($pinicio,$no_habiles) and $pinicio->month==$data['mes']){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    if(in_array('Jueves',$dias)){
                        //dd("hay jueves");
                        if($pinicio->isThursday() and !in_array($pinicio,$no_habiles) and $pinicio->month==$data['mes']){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    if(in_array('Viernes',$dias)){
                        //dd("hay viernes");
                        if($pinicio->isFriday() and !in_array($pinicio,$no_habiles) and $pinicio->month==$data['mes']){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }if(in_array('Sabado',$dias)){
                        
                        if($pinicio->isSaturday()  and !in_array($pinicio,$no_habiles) and $pinicio->month==$data['mes']){
                            array_push($fechas,$pinicio->toDateString());
                            $total_asistencias++;
                        }
                    }
                    $pinicio->addDay();
                    //dd($fechas);
                }
                
                $contador=0;
                foreach($fechas as $fecha){
                    $contador++;
                }
                
                $mes=Mese::find($data['mes']);
                //dd($fechas);
                //dd($registros->grupo);
                                         
		/*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
                 * */
                
/*                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
  */              
                return view('inscripcions.reportes.lista_mesr', array('registros'=>$registros,
                                                                          'fechas_enc'=>$fechas,
                                                                          'asignacion'=>$asignacion,
                                                                          'total_asistencias'=>$total_asistencias,
                                                                          'contador'=>$contador,
                                                                          'mes'=>$mes));
	}
        
        public function historial(Request $request){
            $datos=$request->all();
            $inscripcion=Inscripcion::find($datos['inscripcion']);
            //dd($inscripcion);
            /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
                 * */
                
/*                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
  */              
                return view('inscripcions.reportes.historial', array('inscripcion'=>$inscripcion));
        }
        
        public function sepICP08Boletas(){
            return view('inscripcions.reportes.sepICP08Boletas')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
        }
        
        public function sepICP08BoletasR(Request $request){
            $data=$request->all();
                //dd($data);
            $plantel=Plantel::find($data['plantel_f']);
                $registros= Inscripcion::select('c.id as cliente_id','c.nombre','c.nombre2','c.ape_paterno','c.ape_materno','l.name as lectivo',
                                               'gra.name as grado','aa.id as asignacion','c.curp',
                                               'p.razon as plantel', 'e.name as especialidad','e.ccte', 'p.logo','c.id as cliente',
                                               'p.id as p_id','c.matricula',
					       'inscripcions.plantel_id','inscripcions.lectivo_id','inscripcions.grupo_id','inscripcions.grado_id')
                                       ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                                       ->join('seguimientos as s','s.cliente_id','=','c.id')
                                       ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
                                       ->join('lectivos as l','l.id', '=', 'inscripcions.lectivo_id')
                                       ->join('grados as gra','gra.id','=','inscripcions.grado_id')
                                       ->join('plantels as p','p.id','=','c.plantel_id')
                                       ->join('asignacion_academicas as aa', 'aa.plantel_id','=','p.id')
                                       ->join('especialidads as e','e.id','=','inscripcions.especialidad_id')
                                       ->where('inscripcions.plantel_id', $data['plantel_f'])
                                       ->where('inscripcions.especialidad_id', $data['especialidad_f'])
                                       ->where('inscripcions.nivel_id', $data['nivel_f'])
                                       ->where('inscripcions.grado_id', $data['grado_f'])
                                       ->where('inscripcions.lectivo_id',$data['lectivo_f'])
                                        ->where('aa.lectivo_id',$data['lectivo_f'])
                                        ->whereColumn('aa.grupo_id','inscripcions.grupo_id')
				       ->whereNull('inscripcions.deleted_at')
                                       //->where('inscripcions.grado_id',$data['grado_f'])
                                       ->orderBy('inscripcions.plantel_id','inscripcions.lectivo_id','inscripcions.grupo_id','inscripcions.grado_id')
				       ->distinct()
                                       ->get(); 

                //Agregar fechas
                //dd($registros->toArray());
                
                $asignacion=collect();
                foreach($registros as $registro){
                    
                    $asignacion = AsignacionAcademica::find($registro->asignacion);
                    break;
                }
                
                
                
                //dd($carga_ponderacion->toArray());
                /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
                return view('inscripcions.reportes.sepICP08BoletasR', array('registros'=>$registros,
                                                                                 'asignacion'=>$asignacion,
                                                                                 'plantel'=>$plantel,
                                                                                 'data'=>$data));
        }
}
