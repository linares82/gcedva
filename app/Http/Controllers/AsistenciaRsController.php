<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AsistenciaR;
use App\AsignacionAcademica;
use App\Inscripcion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAsistenciaR;
use App\Http\Requests\createAsistenciaR;

class AsistenciaRsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
            
		$asistenciaRs = AsistenciaR::getAllData($request);

		return view('asistenciaRs.index', compact('asistenciaRs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
                $asignacion_academica_id=$id;
		return view('asistenciaRs.create', compact('asignacion_academica_id'))
			->with( 'list', AsistenciaR::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAsistenciaR $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		AsistenciaR::create( $input );

		return redirect()->route('asistenciaRs.index')->with('message', 'Registro Creado.');
	}
        
        public function buscar($id)
	{
            
                $asignacion_academica_id=$id;
                $as= AsignacionAcademica::find($id);
                
                return view('asistenciaRs.buscar', compact('asignacion_academica_id','as'))
                    ->with( 'list', AsistenciaR::getListFromAllRelationApps() );
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function procesar(createAsistenciaR $request)
	{
		$input = $request->all();
                $asignacionAcademica= AsignacionAcademica::find($input['asignacion_academica_id']);
                $as=$asignacionAcademica;
                
                if(isset($input['fecha'])){
                    $hoy=strtotime(date('Y-m-d'));
                    if((strtotime($input['fecha'])==$hoy && strtotime($as->fec_inicio) <= strtotime($input['fecha']) && strtotime($as->fec_fin) >= strtotime($input['fecha'])) 
                        or isset($input['excepcion'])){
                        $asistencias = AsistenciaR::where('fecha','=', $input['fecha'])
                                         ->where('asignacion_academica_id', '=', $input['asignacion_academica_id'])
                                         ->orderBy('cliente_id')
                                         ->get();
                        $inscripciones=Inscripcion::where('inscripcions.grupo_id','=',$asignacionAcademica->grupo_id)
                                        ->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
                                        ->where('inscripcions.lectivo_id', '=', $asignacionAcademica->lectivo_id)
                                        ->where('inscripcions.plantel_id', '=', $asignacionAcademica->plantel_id)
                                        ->where('h.materium_id',$asignacionAcademica->materium_id)
                                        ->orderBy('inscripcions.cliente_id')
                                        ->whereNull('inscripcions.deleted_at')
                                        ->whereNull('h.deleted_at')
                                        ->get();
                        //dd($asistencias);

                        if($asistencias->isEmpty()){
                            foreach($inscripciones as $i){
                                $asistencia['asignacion_academica_id']=$input['asignacion_academica_id'];
                                $asistencia['fecha']=$input['fecha'];
                                $asistencia['cliente_id']=$i->cliente_id;
                                $asistencia['est_asistencia_id']=1;
                                $asistencia['usu_alta_id']=Auth::user()->id;
                                $asistencia['usu_mod_id']=Auth::user()->id;
                                //dd($asistencia);
                                AsistenciaR::create( $asistencia );
                            }
                            $asignacion_academica_id=$input['asignacion_academica_id'];
                            $asistencias= AsistenciaR::where('fecha','=', $input['fecha'])
                                                 ->where('asignacion_academica_id', '=', $input['asignacion_academica_id'])
                                                 ->get();
                            return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'asistencias','as'))
                                    ->with( 'list', AsistenciaR::getListFromAllRelationApps() );
                        }elseif(count($asistencias)<>count($inscripciones)){
                            foreach($inscripciones as $i){
                                $encontrado=0;
                                foreach($asistencias as $a){
                                    if($a->cliente_id==$i->cliente_id){
                                        $encontrado=1;
                                    }         
                                }
                                if($encontrado==0){
                                    $asistencia['asignacion_academica_id']=$input['asignacion_academica_id'];
                                    $asistencia['fecha']=$input['fecha'];
                                    $asistencia['cliente_id']=$i->cliente_id;
                                    $asistencia['est_asistencia_id']=1;
                                    $asistencia['usu_alta_id']=Auth::user()->id;
                                    $asistencia['usu_mod_id']=Auth::user()->id;
                                    //dd($asistencia);
                                    AsistenciaR::create( $asistencia );
                                }

                            }
                            $asignacion_academica_id=$input['asignacion_academica_id'];
                            $asistencias= AsistenciaR::where('fecha','=', $input['fecha'])
                                                 ->where('asignacion_academica_id', '=', $input['asignacion_academica_id'])
                                                 ->get();
                            return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'asistencias','as'))
                                    ->with( 'list', AsistenciaR::getListFromAllRelationApps() );

                        }else{
                            $asignacion_academica_id=$input['asignacion_academica_id'];
                            return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'asistencias','as'))
                                    ->with( 'list', AsistenciaR::getListFromAllRelationApps() );
                        }
                    }
                }
            
            $asignacion_academica_id=$asignacionAcademica->id;
            return view('asistenciaRs.buscar', compact('asignacion_academica_id','as'))
                    ->with( 'list', AsistenciaR::getListFromAllRelationApps() );    
                
                
                
                
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AsistenciaR $asistenciaR)
	{
		$asistenciaR=$asistenciaR->find($id);
		return view('asistenciaRs.show', compact('asistenciaR'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AsistenciaR $asistenciaR)
	{
		$asistenciaR=$asistenciaR->find($id);
		return view('asistenciaRs.edit', compact('asistenciaR'))
			->with( 'list', AsistenciaR::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AsistenciaR $asistenciaR)
	{
		$asistenciaR=$asistenciaR->find($id);
		return view('asistenciaRs.duplicate', compact('asistenciaR'))
			->with( 'list', AsistenciaR::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
        public function update(Request $request)
	{
                //dd($request->all());
		$input = $request->all();
                $input['id']=$request->get('asistencia');
                $input['est_asistencia_id']=$request->get('estatus');
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$asistenciaR=AsistenciaR::find($request->get('asistencia'));
                $asistenciaR->est_asistencia_id=$input['est_asistencia_id'];
                if($asistenciaR->save()){
                    return "1";
                }else{
                    return "0";
                }
                
		
	}
        /*
	public function update($id, AsistenciaR $asistenciaR, updateAsistenciaR $request)
	{
                dd($request->all());
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$asistenciaR=$asistenciaR->find($id);
		$asistenciaR->update( $input );

		return redirect()->route('asistenciaRs.index')->with('message', 'Registro Actualizado.');
	}*/

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,AsistenciaR $asistenciaR)
	{
		$asistenciaR=$asistenciaR->find($id);
		$asistenciaR->delete();

		return redirect()->route('asistenciaRs.index')->with('message', 'Registro Borrado.');
	}

}
