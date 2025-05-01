<?php namespace App\Http\Controllers;

use DB;
use Log;
use Auth;

use App\Adeudo;
use App\Cliente;
use App\Plantel;
use Carbon\Carbon;
use App\Hacademica;
use App\PlanEstudio;
use App\Calificacion;
use App\Http\Requests;
use App\PivotDocCliente;
use Illuminate\Http\Request;
use App\PeriodoEstudioPlanEstudio;
use App\Http\Controllers\Controller;
use App\Http\Requests\createPlanEstudio;
use App\Http\Requests\updatePlanEstudio;

class PlanEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$planEstudios = PlanEstudio::getAllData($request);
		$planteles= Plantel::pluck('razon','id');
		
		return view('planEstudios.index', compact('planEstudios','planteles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('planEstudios.create')
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlanEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlanEstudio::create( $input );

		return redirect()->route('planEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.show', compact('planEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->with('periodosEstudio')->find($id);
		return view('planEstudios.edit', compact('planEstudio'))
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.duplicate', compact('planEstudio'))
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlanEstudio $planEstudio, updatePlanEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$planEstudio=$planEstudio->find($id);
		$planEstudio->update( $input );

		if(isset($input['periodo_estudio_id'])){
			PeriodoEstudioPlanEstudio::create(array(
				'plan_estudio_id'=>$planEstudio->id, 
				'periodo_estudio_id'=>$input['periodo_estudio_id']
			));
		}

		return redirect()->route('planEstudios.edit',$planEstudio->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		$planEstudio->delete();

		return redirect()->route('planEstudios.index')->with('message', 'Registro Borrado.');
	}

	public function cmbPlanEstudios(Request $request){
		if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel');
            $planEstudio = $request->get('planEstudio');
            
            $final = array();
            $r = DB::table('plan_estudios as pe')
                ->join('periodo_estudios as pes','pes.plan_estudio_id','=','pe.id')
                ->select('pe.id', 'pe.name')
                ->where('pes.plantel_id', '=', $plantel)
                ->where('pe.id', '>', '0')
                ->whereNull('pe.deleted_at')
                ->distinct()
                ->get();
            
            //dd($r);
            if (isset($planEstudio) and $planEstudio != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $planEstudio) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected',
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => '',
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
	}

	public function destroyPeriodo(Request $request){
		//dd($request->all());
		$datos=$request->all();
		$plan_estudios=PlanEstudio::find($datos['plan_estudio_id']);
		$plan_estudios->periodosEstudio()->detach($datos['periodo_estudio_id']);
		return redirect()->route('planEstudios.edit', $datos['plan_estudio_id'])->with('message', 'Registro Borrado.');
	}

	public function egresadosTecnica(){
		$planteles= Plantel::pluck('razon','id');
		return view('planEstudios.reportes.egresadosTecnica', compact('planteles'));
	}

	public function egresadosTecnicaR(Request $request){
		$datos=$request->all();

		$plantel=Plantel::find($datos['plantel_f']);
		$plan_estudio=PlanEstudio::find($datos['plan_estudio_f']);
		//dd($formatoDgcfts->sepGrupo->secciones);
		$secciones=explode(',',$datos['secciones']);
		$mesanio_matricula=explode(',',$datos['inicio_matricula']);
		//dd($mesanio_matricula);
		$inicios_matricula=array();
		$i=0;
		
		foreach($mesanio_matricula as $mes_anio){
			foreach($secciones as $seccion){
				$inicios_matricula[$i]=$mes_anio.$seccion;
				$i++;
			}
		}

		$alumnos_aux=Cliente::select('id','nombre','nombre2','ape_paterno','ape_materno','matricula','st_cliente_id')->with('stCliente');

		$cadenaLike="";
		foreach($inicios_matricula as $inicio_matricula){
			$cadenaLike=$cadenaLike."matricula like '".$inicio_matricula."%' or ";
		}
		//dd(substr($cadenaLike, 0, strlen($cadenaLike)-4));
		$clientes=$alumnos_aux
		->whereRaw("(".substr($cadenaLike, 0, strlen($cadenaLike)-4).
						') and plantel_id=?',[$datos['plantel_f']])
		->get();

		$materias=PlanEstudio::select('m.id','m.name as materia')
		->join('periodo_estudio_plan_estudio as pepe','pepe.plan_estudio_id', 'plan_estudios.id')
		->join('periodo_estudios as pe','pe.id','pepe.periodo_estudio_id')
		->join('materium_periodos as mp','mp.periodo_estudio_id','pe.id')
		->join('materia as m','m.id','mp.materium_id')
		->where('plan_estudios.id',$datos['plan_estudio_f'])
		->whereNull('m.deleted_at')
		->get();
		//dd($materias->toArray());
		
		$resultados=array();
		foreach($clientes as $cliente){
			$row=array();
			$row['matricula']=$cliente->matricula;
			$row['cliente_id']=$cliente->id;
			$row['nombre']=$cliente->nombre." ".$cliente->nombre2;
			$row['apellidos']=$cliente->ape_paterno." ".$cliente->ape_materno;
			$row['st_cliente_id']=$cliente->st_cliente_id;
			$suma_calificaciones=0;
			$cuenta_materias=0;
			foreach($materias as $materia){
				$hacademica=Hacademica::where('cliente_id',$cliente->id)->where('materium_id',$materia->id)->whereNull('deleted_at')->first();
				//dd($hacademica);
				//dd($row);
				//Log::info($hacademica->id);
				$hoy=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
				if($row['st_cliente_id']==3 or $row['st_cliente_id']==27){
					$row[$materia->materia]="N/A";	
				}elseif(is_null($hacademica) and $row['st_cliente_id']<>3 and $row['st_cliente_id']<>27){
					$row[$materia->materia]="Pendiente por Cursar";	
				}elseif($hacademica->st_materium_id<>1){
					$lectivo_inicio=Carbon::createFromFormat('Y-m-d',$hacademica->lectivo->inicio);
					$lectivo_fin=Carbon::createFromFormat('Y-m-d',$hacademica->lectivo->fin);
				
					$calificacion_revision=0;
					$calificacion=Calificacion::where('hacademica_id',$hacademica->id)->orderBy('id','desc')->first();
					$calificacion_revision=$calificacion->calificacion;

					if($lectivo_inicio->lessThanOrEqualTo($hoy) and $lectivo_fin->greaterThanOrEqualTo($hoy)){
						$row[$materia->materia]="Cursando";		
					}elseif($calificacion_revision==0){
						$row[$materia->materia]="Pendiente por Cursar";		
					}elseif($calificacion_revision>0){
						$row[$materia->materia]="Reprobada";		
					}	
				}elseif($hacademica->st_materium_id==1){
					$calificacion=Calificacion::where('hacademica_id',$hacademica->id)->orderBy('id','desc')->first();
					$row[$materia->materia]=$calificacion->calificacion;
					$suma_calificaciones=$suma_calificaciones+$calificacion->calificacion;
					$cuenta_materias++;
				}
				
			}
			if($cuenta_materias==0){
				$row['promedio']="N/A";	
			}else{
				$row['promedio']=$suma_calificaciones/$cuenta_materias;
			}
			$row['st_cliente']=$cliente->stCliente->name;

			//Estatus para caja
			$cantidad_adeudos_pendientes=Adeudo::where('cliente_id', $cliente->id)->where('pagado_bnd', 0)->whereNull('deleted_at')->count();
			//dd($cantidad_adeudos_pendientes);
			$adeudos_pendientes=Adeudo::with('cajaConcepto')->where('cliente_id', $cliente->id)->where('pagado_bnd', 0)->whereNull('deleted_at')->get();
			$row['estatus_caja']="";
			if($cantidad_adeudos_pendientes==0){
				$row['estatus_caja']="Sin Adeudo";
			}else{
				foreach($adeudos_pendientes as $adeudo_pendiente){
					$row['estatus_caja']=$row['estatus_caja']." ".$adeudo_pendiente->cajaConcepto->name;
				}
				
			}
			//Documentos faltantes
			$row['documentos_faltantes']="";
			$cantidad_documentos_pendientes=PivotDocCliente::join('doc_alumnos as da','da.id','pivot_doc_clientes.doc_alumno_id')
			->where('cliente_id',$cliente->id)
			->where('doc_obligatorio',1)
			->whereNull('doc_entregado')
			->count();
			//dd($cantidad_documentos_pendientes);
			$documentos_pendientes=PivotDocCliente::join('doc_alumnos as da','da.id','pivot_doc_clientes.doc_alumno_id')
			->where('cliente_id',$cliente->id)
			->where('doc_obligatorio',1)
			->whereNull('doc_entregado')
			->get();
			//dd($documentos_pendientes);
			if($cantidad_documentos_pendientes==0){
				$row['documentos_faltantes']="Documentos Completos";
			}else{
				foreach($documentos_pendientes as $documento_pendiente){
					$row['documentos_faltantes']=$row['documentos_faltantes']." ".$documento_pendiente->name;	
				}
				
			}
			
			
			array_push($resultados,$row);
		}

		//dd($resultados);
		return view('planEstudios.reportes.egresadosTecnicaR', compact('resultados','plantel','plan_estudio','materias'));
	}

	public function planesEstudioXPlantel(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->get('plantel_id'));
            $plantel = $request->get('plantel_id');
            

            $final = array();
            $r = DB::table('plan_estudios as pe')
                ->select('pe.id', 'pe.name')
                ->where('pe.plantel_id', '=', $plantel)
                ->whereNull('pe.deleted_at')
                ->get();
            //dd($r);
            if (isset($periodo) and $periodo <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $periodo) {
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

}
