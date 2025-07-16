<?php

namespace App\Http\Controllers;

use Auth;
use App\Prebeca;
use DB;

use App\Empleado;
use App\Inscripcion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createPrebeca;
use App\Http\Requests\updatePrebeca;

class PrebecasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prebecas = Prebeca::getAllData($request);

		return view('prebecas.index', compact('prebecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prebecas.create')
			->with('list', Prebeca::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPrebeca $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		Prebeca::create($input);

		return redirect()->route('prebecas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Prebeca $prebeca)
	{
		$prebeca = $prebeca->find($id);
		return view('prebecas.show', compact('prebeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Prebeca $prebeca)
	{
		$prebeca = $prebeca->find($id);
		return view('prebecas.edit', compact('prebeca'))
			->with('list', Prebeca::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Prebeca $prebeca)
	{
		$prebeca = $prebeca->find($id);
		return view('prebecas.duplicate', compact('prebeca'))
			->with('list', Prebeca::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Prebeca $prebeca, updatePrebeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$prebeca = $prebeca->find($id);
		$prebeca->update($input);

		return redirect()->route('prebecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Prebeca $prebeca)
	{
		$prebeca = $prebeca->find($id);
		$prebeca->delete();

		return redirect()->route('prebecas.index')->with('message', 'Registro Borrado.');
	}

	public function prebecaBeca()
	{
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)
			->where('st_empleado_id', '<>', 3)
			->first()->plantels->pluck('razon', 'id');
		$planteles->prepend('Seleccionar Opcion', "");
		return view('prebecas.reportes.prebecas-becas', compact('planteles'));
	}

	public function prebecaBecaR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$registros = Inscripcion::where('inscripcions.plantel_id', $datos['plantel_id'])
			/*select(
			'inscripcions.plantel_id',
			'inscripcions.cliente_id',
			'ab.*'
		)*/

			->with(['plantel', 'especialidad', 'nivel', 'grado'])
			->with('cliente')
			->with('cliente.autorizacionBeca')
			->with('cliente.prebeca')
			->with('cliente.prebeca.motivoBeca')
			->with('cliente.prebeca.porcentajeBeca')
			//->join('clientes as c', 'c.id', 'inscripcions.cliente_id')
			//->leftJoin('prebecas as pb', 'pb.cliente_id', 'inscripcions.cliente_id')
			//->leftJoin('autorizacion_becas as ab', 'ab.cliente_id', 'inscripcions.cliente_id')
			->where('inscripcions.especialidad_id', $datos['especialidad_id'])
			->where('inscripcions.nivel_id', $datos['nivel_id'])
			->where('inscripcions.grado_id', $datos['grado_id'])
			->where('inscripcions.lectivo_id', $datos['lectivo_id'])
			->where('inscripcions.grupo_id', $datos['grupo_id'])
			->get();
		//dd($registros);
		$prebeca_sin_inscripcion = Prebeca::select(
			'c.plantel_id',
			'prebecas.*',
			DB::raw('(select count(i.id) from inscripcions as i 
					where i.cliente_id=prebecas.cliente_id and 
					i.deleted_at is null) as cuenta_inscripcion')
		)
			->join('clientes as c', 'c.id', 'prebecas.cliente_id')
			->with('cliente')
			->with('cliente.plantel')
			->where('c.plantel_id', $datos['plantel_id'])
			->havingRaw('cuenta_inscripcion=0')
			->get();
		//dd($prebeca_sin_inscripcion->toArray());
		return view('prebecas.reportes.prebecas-becasR', compact('registros', 'prebeca_sin_inscripcion'));
	}
}
