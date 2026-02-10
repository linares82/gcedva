<?php

namespace App\Http\Controllers;

use App\CicloMatricula;
use Auth;
use App\Lead;

use App\Medio;
use App\Empleado;
use App\Prospecto;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\createLead;
use App\Http\Requests\updateLead;
use App\Http\Controllers\Controller;

class LeadsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		//dd($request->all());
		$leads = Lead::getAllData($request);
		$medios = \App\Medio::pluck('name', 'id');
		$st_leads = \App\StLead::pluck('name', 'id');
		$st_leads->prepend('Selecciona una opción', '');
		$ciclosInteresados = CicloMatricula::pluck('name', 'id');
		$ciclosInteresados->prepend('Selecciona una opción', '');
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first()->plantels->pluck('razon', 'id');
		return view('leads.index', compact('leads', 'medios', 'st_leads', 'planteles', 'ciclosInteresados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first()->plantels->pluck('razon', 'id');
		$medios = Medio::where('bnd_prospectos', '=', 1)->pluck('name', 'id');
		$cicloMatriculas = CicloMatricula::where('bnd_activo', '=', 1)->pluck('name', 'id');

		return view('leads.create', compact('planteles', 'medios', 'cicloMatriculas'))
			->with('list', Lead::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createLead $request)
	{

		$input = $request->all();
		$input['st_lead_id'] = 1; // Estatus "Nuevo"
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		Lead::create($input);

		return redirect()->route('leads.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Lead $lead)
	{
		$lead = $lead->find($id);
		return view('leads.show', compact('lead'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Lead $lead)
	{
		$lead = $lead->find($id);
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first()->plantels->pluck('razon', 'id');
		$medios = Medio::where('bnd_prospectos', '=', 1)->pluck('name', 'id');
		$cicloMatriculas = CicloMatricula::where('bnd_activo', '=', 1)->pluck('name', 'id');
		return view('leads.edit', compact('lead', 'planteles', 'medios', 'cicloMatriculas'))
			->with('list', Lead::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Lead $lead)
	{
		$lead = $lead->find($id);
		return view('leads.duplicate', compact('lead'))
			->with('list', Lead::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Lead $lead, updateLead $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$lead = $lead->find($id);
		$lead->update($input);

		return redirect()->route('leads.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Lead $lead)
	{
		$lead = $lead->find($id);
		$lead->delete();

		return redirect()->route('leads.index')->with('message', 'Registro Borrado.');
	}

	public function agregarLlamada(Lead $lead)
	{
		//$lead = $lead->find($id);
		//dd($lead);
		$lead->contador_llamadas = $lead->contador_llamadas + 1;
		if ($lead->contador_llamadas == 10) {
			$lead->st_lead_id = 2; // Cambiar estatus a "Contactado"
		}
		$lead->save();

		return redirect()->route('leads.index')->with('message', 'Llamada agregada.');
	}

	public function quitarLlamada(Lead $lead)
	{
		//$lead = $lead->find($id);
		//dd($lead);
		if ($lead->contador_llamadas > 0) {
			$lead->contador_llamadas = $lead->contador_llamadas - 1;
			$lead->save();
		}

		return redirect()->route('leads.index')->with('message', 'Llamada agregada.');
	}

	public function generarProspecto(Lead $lead)
	{
		$lead->st_lead_id = 3; // Cambiar estatus a "Convertido a Prospecto"
		$lead->save();

		$inputProspecto = [
			'plantel_id' => $lead->plantel_id,
			'nombre' => $lead->nombre,
			//'nombre2' => $lead->nombre2,
			//'ape_paterno' => $lead->ape_paterno,
			//'ape_materno' => $lead->ape_materno,
			//'tel_fijo' => $lead->tel_fijo,
			'tel_cel' => $lead->tel_cel,
			//'email' => $lead->email,
			'medio_id' => $lead->medio_id,
			'ciclo_interesado' => $lead->ciclo_interesado,
			'ciclo_matricula_id' => $lead->ciclo_matricula_id,
			'observaciones' => $lead->observaciones,
			'lead_id' => $lead->id,
			'st_prospecto_id' => 2, // Estatus "Nuevo"
			'usu_alta_id' => Auth::user()->id,
			'usu_mod_id' => Auth::user()->id,
		];
		$prospecto = Prospecto::create($inputProspecto);
		return redirect()->route('prospectos.edit', $prospecto->id)->with('message', 'Prospecto generado.');
	}

	public function rechazar(Lead $lead)
	{
		$lead->st_lead_id = 2; // Cambiar estatus a "Rechazado"
		$lead->save();

		return redirect()->route('leads.index')->with('message', 'Lead rechazado.');
	}
}
