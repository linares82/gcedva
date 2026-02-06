<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use Exception;
use App\StTarea;
use App\Prospecto;
use App\Http\Requests;
use App\ProspectoAviso;
use App\ProspectoStSeg;
use App\ProspectoTarea;
use App\ProspectoAsunto;
use App\ProspectoStTarea;
use App\ProspectoEtiquetum;
use App\ProspectoHactividad;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
use App\ProspectoParteInforme;
use App\ProspectoAsignacionTarea;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspectoSeguimiento;
use App\Http\Requests\updateProspectoSeguimiento;
use App\ProspectoInforme;

class ProspectoSeguimientosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoSeguimientos = ProspectoSeguimiento::getAllData($request);

		return view('prospectoSeguimientos.index', compact('prospectoSeguimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoSeguimientos.create')
			->with('list', ProspectoSeguimiento::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoSeguimiento $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		ProspectoSeguimiento::create($input);

		return redirect()->route('prospectoSeguimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->where('prospecto_id', $id)->first();
		//dd($prospectoSeguimiento);

		if (is_null($prospectoSeguimiento)) {
			$prospecto = Prospecto::find($id);
			$input['prospecto_id'] = $id;
			$input['mes'] = $prospecto->created_at->month;
			$input['contador_sms'] = 0;
			$input['prospecto_st_seg_id'] = 1;
			$input['usu_alta_id'] = Auth::user()->id;
			$input['usu_mod_id'] = Auth::user()->id;
			$prospectoSeguimiento = ProspectoSeguimiento::create($input);
		}
		//dd($prospectoSeguimiento);
		$prospectoAsignacionTareas = ProspectoAsignacionTarea::where('prospecto_id', '=', $prospectoSeguimiento->prospecto_id)->orderBy('created_at', 'desc')->get();
		//dd($prospectoAsignacionTareas->toArray());
		$prospectoAvisos = ProspectoAviso::select(
			'prospecto_avisos.id',
			'prospecto_avisos.activo',
			'a.name',
			'prospecto_avisos.detalle',
			'prospecto_avisos.fecha',
			DB::Raw('DATEDIFF(prospecto_avisos.fecha,CURDATE()) as dias_restantes')
		)
			->join('prospecto_asuntos as a', 'a.id', '=', 'prospecto_avisos.prospecto_asunto_id')
			->where('prospecto_seguimiento_id', '=', $prospectoSeguimiento->id)
			->get();

		$tareas = ProspectoTarea::pluck('name', 'id');
		$asuntos = ProspectoAsunto::pluck('name', 'id');
		$estatusTareas = ProspectoStTarea::pluck('name', 'id');
		$prospectoStSeg = ProspectoStSeg::pluck('name', 'id');
		$actividades = ProspectoHactividad::where('prospecto_seguimiento_id', '=', $prospectoSeguimiento->id)->orderBy('fecha')->orderBy('hora')->get();
		$partesInformes = ProspectoParteInforme::pluck('name', 'id');
		$etiquetas = ProspectoEtiquetum::pluck('name', 'id');
		$prospectoInformes = ProspectoInforme::where('prospecto_id', $prospectoSeguimiento->prospecto_id)->get();
		//dd($prospectoInformes->toArray());

		return view(
			'prospectoSeguimientos.show',
			compact(
				'prospectoSeguimiento',
				'tareas',
				'asuntos',
				'estatusTareas',
				'prospectoAsignacionTareas',
				'prospectoAvisos',
				'prospectoStSeg',
				'actividades',
				'partesInformes',
				'etiquetas',
				'prospectoInformes'
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		return view('prospectoSeguimientos.edit', compact('prospectoSeguimiento'))
			->with('list', ProspectoSeguimiento::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		return view('prospectoSeguimientos.duplicate', compact('prospectoSeguimiento'))
			->with('list', ProspectoSeguimiento::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoSeguimiento $prospectoSeguimiento, updateProspectoSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		$prospectoSeguimiento->update($input);

		return redirect()->route('prospectoSeguimientos.show', $prospectoSeguimiento->prospecto_id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		$prospectoSeguimiento->delete();

		return redirect()->route('prospectoSeguimientos.index')->with('message', 'Registro Borrado.');
	}
}
