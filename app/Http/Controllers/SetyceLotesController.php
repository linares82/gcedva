<?php

namespace App\Http\Controllers;

use Auth;
use App\SetyceLote;

use App\Titulacion;
use App\Inscripcion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createSetyceLote;
use App\Http\Requests\updateSetyceLote;
use App\SetyceTitulo;

class SetyceLotesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$setyceLotes = SetyceLote::getAllData($request);

		return view('setyceLotes.index', compact('setyceLotes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('setyceLotes.create')
			->with('list', SetyceLote::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSetyceLote $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		SetyceLote::create($input);

		return redirect()->route('setyceLotes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SetyceLote $setyceLote)
	{
		$setyceLote = $setyceLote->find($id);
		$lineas = SetyceTitulo::where('setyce_lote_id', $setyceLote->id)
			->with(
				'cliente',
				'cliente.titulacions',
				'cliente.procedenciaAlumno',
				'cliente.procedenciaAlumno.sepTEstudioAntecedente',
				'cliente.combinacionCliente',
				'cliente.combinacionCliente.grado',
				'cliente.combinacionCliente.grado.carrera',
				'cliente.combinacionCliente.grado.autorizacionReconocimiento'
			)
			->get();
		//dd($lineas);
		return view('setyceLotes.show', compact('setyceLote', 'lineas'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SetyceLote $setyceLote)
	{
		$setyceLote = $setyceLote->find($id);
		return view('setyceLotes.edit', compact('setyceLote'))
			->with('list', SetyceLote::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SetyceLote $setyceLote)
	{
		$setyceLote = $setyceLote->find($id);
		return view('setyceLotes.duplicate', compact('setyceLote'))
			->with('list', SetyceLote::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SetyceLote $setyceLote, updateSetyceLote $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$setyceLote = $setyceLote->find($id);
		$setyceLote->update($input);

		return redirect()->route('setyceLotes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, SetyceLote $setyceLote)
	{
		$setyceLote = $setyceLote->find($id);
		$setyceLote->delete();

		return redirect()->route('setyceLotes.index')->with('message', 'Registro Borrado.');
	}

	public function addAlumnos(SetyceLote $setyceLote)
	{
		$clientes_ids = explode(",", $setyceLote->clientes);
		$clientes_grupo = Titulacion::where('titulacion_grupo_id', $setyceLote->titulacion_grupo_id)
			->pluck('cliente_id');
		$ids = array_merge($clientes_ids, $clientes_grupo->toArray());
		//dd($ids);
		$consultaLineas = Inscripcion::whereIn('cliente_id', $ids)
			->distinct()
			->get();
		//dd($consultaLineas);

		foreach ($consultaLineas as $linea) {
			$validar_existencia = SetyceTitulo::where('setyce_lote_id', $setyceLote->id)
				->where('cliente_id', $linea->cliente_id)
				->first();
			if (is_null($validar_existencia)) {
				$inputLinea['setyce_lote_id'] = $setyceLote->id;
				$inputLinea['cliente_id'] = $linea->cliente_id;
				$inputLinea['usu_alta_id'] = Auth::user()->id;
				$inputLinea['usu_mod_id'] = Auth::user()->id;
				//dd($inputLinea);
				SetyceTitulo::create($inputLinea);
			}
		}
		return redirect()->route('setyceLotes.show', $setyceLote->id)->with('message', 'Registro Actualizado.');
	}
}
