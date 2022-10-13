<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\ClientesaController;

use App\Hacademica;
use App\AsistenciaR;
use App\Inscripcion;
use App\Http\Requests;
use App\AsignacionAcademica;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createAsistenciaR;
use App\Http\Requests\updateAsistenciaR;

class AsistenciaRsController extends Controller
{

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
		$asignacion_academica_id = $id;
		return view('asistenciaRs.create', compact('asignacion_academica_id'))
			->with('list', AsistenciaR::getListFromAllRelationApps());
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
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		AsistenciaR::create($input);

		return redirect()->route('asistenciaRs.index')->with('message', 'Registro Creado.');
	}

	public function buscar($id)
	{

		$asignacion_academica_id = $id;
		$as = AsignacionAcademica::find($id);

		return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'as'))
			->with('list', AsistenciaR::getListFromAllRelationApps());
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
		//dd($input);
		$asignacionAcademica = AsignacionAcademica::find($input['asignacion_academica_id']);
		$as = $asignacionAcademica;
		$dias_validos = array();
		foreach ($asignacionAcademica->horarios as $horario) {
			array_push($dias_validos, $horario->dia_id);
		}
		//dd($dias_validos);

		if (isset($input['fecha'])) {
			$hoy = strtotime(date('Y-m-d'));
			$hoyCarbon = Carbon::createFromFormat('Y-m-d', $input['fecha']);
			//dd($hoyCarbon->dayOfWeekIso);
			if ((strtotime($input['fecha']) == $hoy && strtotime($as->fec_inicio) <= strtotime($input['fecha']) && strtotime($as->fec_fin) >= strtotime($input['fecha']))
				or isset($input['excepcion'])
			) {
				
				if (in_array($hoyCarbon->dayOfWeekIso, $dias_validos)) {
					$asistencias = AsistenciaR::select('asistencia_rs.*', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno','bnd_doc_oblig_entregados')
						->where('fecha', '=', $input['fecha'])
						->join('clientes as c', 'c.id', '=', 'asistencia_rs.cliente_id')
						->where('asignacion_academica_id', '=', $input['asignacion_academica_id'])
						//->orderBy('cliente_id')
						->whereNull('c.deleted_at')
						->orderBy('c.ape_paterno')
						->orderBy('c.ape_materno')
						->orderBy('c.nombre')
						->orderBy('c.nombre2')
						->get();

					$inscripciones = Hacademica::where('hacademicas.grupo_id', '=', $asignacionAcademica->grupo_id)
						->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
						->where('hacademicas.lectivo_id', '=', $asignacionAcademica->lectivo_id)
						->where('hacademicas.plantel_id', '=', $asignacionAcademica->plantel_id)
						->where('hacademicas.materium_id', $asignacionAcademica->materium_id)
						->orderBy('hacademicas.cliente_id')
						->whereNull('hacademicas.deleted_at')
						->whereNull('i.deleted_at')
						->get();
					//dd($asistencias);
					/*
					if ($asistencias->isEmpty()) {
						foreach ($inscripciones as $i) {
							if ($i->cliente->st_cliente_id <> 3) {
								$asistencia['asignacion_academica_id'] = $input['asignacion_academica_id'];
								$asistencia['fecha'] = $input['fecha'];
								$asistencia['cliente_id'] = $i->cliente_id;
								if($i->cliente->st_cliente_id==25 or 
									$i->cliente->st_cliente_id==26 or 
									$i->cliente->bnd_doc_oblig_entregados == 0){
									$asistencia['est_asistencia_id'] = 2;
								}else{
									$asistencia['est_asistencia_id'] = 1;
								}
								$asistencia['est_asistencia_id'] = 1;
								$asistencia['usu_alta_id'] = Auth::user()->id;
								$asistencia['usu_mod_id'] = Auth::user()->id;
								//dd($asistencia);
								AsistenciaR::create($asistencia);
							}


							//verifica adeudos y cambia estatus 

						}
						$asignacion_academica_id = $input['asignacion_academica_id'];
						$asistencias = AsistenciaR::select('asistencia_rs.*', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno','bnd_doc_oblig_entregados')
							->where('fecha', '=', $input['fecha'])
							->join('clientes as c', 'c.id', '=', 'asistencia_rs.cliente_id')
							->where('asignacion_academica_id', '=', $input['asignacion_academica_id'])
							->whereNull('c.deleted_at')
							->orderBy('c.ape_paterno')
							->orderBy('c.ape_materno')
							->orderBy('c.nombre')
							->orderBy('c.nombre2')
							->get();
						return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'asistencias', 'as'))
							->with('list', AsistenciaR::getListFromAllRelationApps());
					} elseif (count($asistencias) <> count($inscripciones)) {
						*/
						foreach ($inscripciones as $i) {
							$encontrado = 0;
							foreach ($asistencias as $a) {
								if ($a->cliente_id == $i->cliente_id) {
									$encontrado = 1;
								}
							}
							if ($encontrado == 0) {
								$asistencia['asignacion_academica_id'] = $input['asignacion_academica_id'];
								$asistencia['fecha'] = $input['fecha'];
								$asistencia['cliente_id'] = $i->cliente_id;
								$cliController=new ClientesController();
								if (optional($i->cliente)->st_cliente_id == 25 or 
									optional($i->cliente)->st_cliente_id == 26 or 
									optional($i->cliente)->st_cliente_id == 3 /*or 
									optional($i->cliente)->bnd_doc_oblig_entregados == 0*/ ){
									/*if($cliController->validaEntregaDocs3Meses($i->cliente_id)){
										$asistencia['est_asistencia_id'] = 1;
									}else{*/
										$asistencia['est_asistencia_id'] = 2;
									//}
								}elseif(optional($i->cliente)->bnd_doc_oblig_entregados == 0){
									if($cliController->validaEntregaDocs3Meses($i->cliente_id)){
										$asistencia['est_asistencia_id'] = 1;
									}
								} else {
									$asistencia['est_asistencia_id'] = 1;
								}

								$asistencia['usu_alta_id'] = Auth::user()->id;
								$asistencia['usu_mod_id'] = Auth::user()->id;
								//dd($asistencia);
								AsistenciaR::create($asistencia);
							}
						
						}
						$asignacion_academica_id = $input['asignacion_academica_id'];
						$asistencias = AsistenciaR::select('asistencia_rs.*', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno','bnd_doc_oblig_entregados')
							->where('fecha', '=', $input['fecha'])
							->join('clientes as c', 'c.id', '=', 'asistencia_rs.cliente_id')
							->where('asignacion_academica_id', '=', $input['asignacion_academica_id'])
							->whereNull('c.deleted_at')
							->orderBy('c.ape_paterno')
							->orderBy('c.ape_materno')
							->orderBy('c.nombre')
							->orderBy('c.nombre2')
							->get();
						return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'asistencias', 'as'))
							->with('list', AsistenciaR::getListFromAllRelationApps());
					/*
						} else {
						$asignacion_academica_id = $input['asignacion_academica_id'];
						return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'asistencias', 'as'))
							->with('list', AsistenciaR::getListFromAllRelationApps());
					}*/
				}
			}
		}

		$asignacion_academica_id = $asignacionAcademica->id;
		return view('asistenciaRs.buscar', compact('asignacion_academica_id', 'as'))
			->with('list', AsistenciaR::getListFromAllRelationApps());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AsistenciaR $asistenciaR)
	{
		$asistenciaR = $asistenciaR->find($id);
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
		$asistenciaR = $asistenciaR->find($id);
		return view('asistenciaRs.edit', compact('asistenciaR'))
			->with('list', AsistenciaR::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AsistenciaR $asistenciaR)
	{
		$asistenciaR = $asistenciaR->find($id);
		return view('asistenciaRs.duplicate', compact('asistenciaR'))
			->with('list', AsistenciaR::getListFromAllRelationApps());
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
		$input['id'] = $request->get('asistencia');
		$input['est_asistencia_id'] = $request->get('estatus');
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$asistenciaR = AsistenciaR::find($request->get('asistencia'));
		$asistenciaR->est_asistencia_id = $input['est_asistencia_id'];
		if ($asistenciaR->save()) {
			return "1";
		} else {
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
	public function destroy($id, AsistenciaR $asistenciaR)
	{
		$asistenciaR = $asistenciaR->find($id);
		$asistenciaR->delete();

		return redirect()->route('asistenciaRs.index')->with('message', 'Registro Borrado.');
	}
}
