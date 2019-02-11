<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AsistenciaR;
use App\AsignacionAcademica;
use App\Inscripcion;
use App\Grupo;
use App\Cliente;
use App\Hacademica;
use App\Lectivo;
use App\Mese;
use App\Calificacion;
use App\Ponderacion;
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
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$i=Inscripcion::create( $input );
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
                                            ->get();
		
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
		if(isset($input['plantel_id']) and isset($input['lectivo_id']) and isset($input['grupo_id'])){
			$clientes=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
						->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
						->join('calificacions as c', 'c.hacademica_id', '=', 'h.id')
						->join('materia as m', 'm.id', 'h.materium_id')
						->join('grados as g', 'g.id', 'h.grado_id')
						->select('i.id',
								 DB::raw('concat(clientes.nombre," ",clientes.nombre2," ",clientes.ape_paterno," ",clientes.ape_materno) as nombre'),
								 DB::raw('count(m.name) as materias_aprobadas'))
						->where('i.plantel_id', '=', $input['plantel_id'])
						->where('i.especialidad_id', '=', $input['especialidad_id'])
						->where('i.nivel_id', '=', $input['nivel_id'])
						->where('i.grupo_id', '=', $input['grupo_id'])
						->where('i.lectivo_id', '=', $input['lectivo_id'])
						->where('i.plantel_id', '=', $input['plantel_id'])
						->where('h.st_materium_id', '=', 1)
						->groupBy('nombre', 'nombre2', 'ape_paterno', 'ape_materno', 'i.id')
						->get();
		}	
		if(isset($input['id']) and isset($input['grupo_to']) and isset($input['lectivo_to'])){
			foreach($input['id'] as $key=>$value){
				$id=$value;
				$posicion=$key;
				$i=Inscripcion::find($id);
				$i->grupo_id=$input['grupo_to'];
				$i->lectivo_id=$input['lectivo_to'];
				$i->save();
				$this->registrarMaterias($id);
			}
		}
		//dd($clientes->toArray());
		return view('inscripcions.reinscripcion', compact('clientes'))
			->with( 'list', Hacademica::getListFromAllRelationApps() );
	}
        
        public function lista()
	{
            $meses=Mese::pluck('name','id');
		return view('inscripcions.reportes.lista_alumnos',compact('meses'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}
        
        public function listar(Request $request)
	{
                $data=$request->all();
                //dd($data);
                $registros= Inscripcion::select('c.nombre','c.nombre2','c.ape_paterno','c.ape_materno', 'g.name as grupo','g.name as lectivo',
                                               DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),'gra.name as grado',
                                               'p.razon as plantel','aa.id as asignacion','c.id as cliente')
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
                                       ->where('aa.plantel_id', $data['plantel_f'])
                                       ->where('aa.lectivo_id',$data['lectivo_f'])
                                       ->where('inscripcions.grupo_id',$data['grupo_f'])
                                       ->where('inscripcions.grado_id',$data['grado_f'])
                                       ->orderBy('inscripcions.plantel_id')
                                       ->orderBy('inscripcions.lectivo_id')
                                       ->orderBy('inscripcions.grupo_id')
                                       ->orderBy('inscripcions.grado_id')
                                       ->get();
                //Agregar fechas
                $asignacion=collect();
                foreach($registros as $registro){
                    $asignacion= AsignacionAcademica::find($registro->asignacion);
                    break;
                }
                $dias=array();
                
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
                $inicio=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
                $fin=Carbon::createFromFormat('Y-m-d', $lectivo->fin);
                //dd($fin->toDateString());
                array_push($fechas,$inicio);
                $fecha=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
                while($fin->greaterThanOrEqualTo($fecha) and $fecha->month==$data['mes']){
                    
                    if(in_array('Lunes',$dias)){
                        //dd("hay lunes");
                        if($fecha->isMonday() and !in_array($fecha,$no_habiles)){
                            array_push($fechas,$fecha->toDateString());
                        }
                        //dd($fechas);
                    }
                    if(in_array('Martes',$dias)){
                        //dd("hay martes");
                        if($fecha->isTuesday() and !in_array($fecha,$no_habiles)){
                            array_push($fechas,$fecha->toDateString());
                        }
                    }
                    if(in_array('Miercoles',$dias)){
                        //dd("hay miercoles");
                        if($fecha->isWednesday() and !in_array($fecha,$no_habiles)){
                            array_push($fechas,$fecha->toDateString());
                        }
                    }
                    if(in_array('Jueves',$dias)){
                        //dd("hay jueves");
                        if($fecha->isThursday() and !in_array($fecha,$no_habiles)){
                            array_push($fechas,$fecha->toDateString());
                        }
                    }
                    if(in_array('Viernes',$dias)){
                        //dd("hay viernes");
                        if($fecha->isFriday() and !in_array($fecha,$no_habiles)){
                            array_push($fechas,$fecha->toDateString());
                        }
                    }if(in_array('Sabado',$dias)){
                        
                        if($fecha->isSaturday()  and !in_array($fecha,$no_habiles)){
                            array_push($fechas,$fecha->toDateString());
                        }
                    }
                    $fecha->addDay();
                    //dd($fechas);
                }
                //dd($fechas);
                //dd($registros->grupo);
                                         
		/*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
                 * */
                
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                
                //return view('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas));
	}
}
