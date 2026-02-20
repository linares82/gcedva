<?php

namespace App\Http\Controllers;

use Auth;
use App\Lead;
use App\Medio;
use Log;

use App\Empleado;
use App\Prospecto;
use App\Http\Requests;
use App\CicloMatricula;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
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
		$leads->load('prospecto');
		//dd($leads);
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
			'especialidad_id' => 0,
			'nivel_id' => 0,
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

	public function funnelVenta()
	{
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first()->plantels->pluck('razon', 'id');
		return view('leads.reportes.funnelVenta', compact('planteles'));
	}

	public function funnelVentaR(Request $request)
	{
		$datos = $request->all();

		$planteles = Empleado::select(
			'p.razon as plantel',
			'p.id as plantel_id'
		)
			->join('plantels as p', 'p.id', 'empleados.plantel_id')
			->where('p.id', '>', 0)
			->where('empleados.st_prospecto_id', 2)
			->whereIn('p.id', $datos['plantel_id'])
			->orderBy('p.id')
			->distinct()
			->get();
		$registros_plantel = array();

		foreach ($planteles as $plantel) {
			$leads_creados = Lead::where('plantel_id', $plantel->plantel_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->count();
			$prospectos_creados = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('pros.plantel_id', $plantel->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->count();
			$prospectos_seguimiento = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('pros.plantel_id', $plantel->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 3)
				->count();
			$prospectos_promesa_pago = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('pros.plantel_id', $plantel->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 4)
				->count();
			$clientes = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('pros.plantel_id', $plantel->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->whereNotNull('cliente_id')
				->count();
			$prospectos_descartado = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('pros.plantel_id', $plantel->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 1)
				->count();
			$leads_rechazado = Lead::where('plantel_id', $plantel->plantel_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->where('st_lead_id', 2)
				->count();
			$linea = [
				'plantel' => $plantel->plantel,
				'leads_creados' => $leads_creados,
				'prospectos_creados' => $prospectos_creados,
				'prospectos_seguimiento' => $prospectos_seguimiento,
				'prospectos_promesa_pago' => $prospectos_promesa_pago,
				'clientes' => $clientes,
				'prospectos_descartado' => $prospectos_descartado,
				'leads_rechazado' => $leads_rechazado,
				'total' => $leads_creados + $prospectos_creados + $prospectos_seguimiento + $prospectos_promesa_pago + $clientes + $prospectos_descartado + $leads_rechazado
			];
			array_push($registros_plantel, $linea);
		}
		//dd($registros_plantel);

		$empleados = Empleado::select(
			'empleados.id',
			'empleados.user_id',
			'empleados.nombre',
			'empleados.ape_paterno',
			'empleados.ape_materno',
			'p.razon as plantel',
			'p.id as plantel_id'
		)
			->join('plantels as p', 'p.id', 'empleados.plantel_id')
			->where('p.id', '>', 0)
			->where('empleados.st_prospecto_id', 2)
			->whereIn('p.id', $datos['plantel_id'])
			->orderBy('p.id')
			->orderBy('empleados.id')
			->get();
		$registros_plantel_empleado = array();
		foreach ($empleados as $empleado) {
			$leads_creados = Lead::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->count();
			$prospectos_creados = ProspectoSeguimiento::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->count();
			$prospectos_seguimiento = ProspectoSeguimiento::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 3)
				->count();
			$prospectos_promesa_pago = ProspectoSeguimiento::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 4)
				->count();
			$clientes = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('prospecto_seguimientos.usu_alta_id', $empleado->user_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->whereNotNull('cliente_id')
				->count();
			$prospectos_descartado = ProspectoSeguimiento::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 1)
				->count();
			$leads_rechazado = Lead::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->where('st_lead_id', 2)
				->count();
			$linea = [
				'plantel' => $empleado->plantel,
				'empleado' => $empleado->nombre . ' ' . $empleado->ape_materno . ' ' . $empleado->ape_paterno,
				'leads_creados' => $leads_creados,
				'prospectos_creados' => $prospectos_creados,
				'prospectos_seguimiento' => $prospectos_seguimiento,
				'prospectos_promesa_pago' => $prospectos_promesa_pago,
				'clientes' => $clientes,
				'prospectos_descartado' => $prospectos_descartado,
				'leads_rechazado' => $leads_rechazado,
				'total' => $leads_creados + $prospectos_creados + $prospectos_seguimiento + $prospectos_promesa_pago + $clientes + $prospectos_descartado + $leads_rechazado
			];

			//Log::info($linea);
			array_push($registros_plantel_empleado, $linea);
		}
		//dd($registros_plantel_empleado);

		$registros_seccion = array();
		$secciones = Prospecto::select('p.razon', 'p.id as plantel_id', 'g.seccion')
			->join('grados as g', 'g.id', 'prospectos.grado_id')
			->join('plantels as p', 'p.id', 'prospectos.plantel_id')
			->whereDate('prospectos.created_at', '<=', $datos['fecha_t'])
			->whereDate('prospectos.created_at', '>=', $datos['fecha_f'])
			->whereIn('p.id', $datos['plantel_id'])
			->distinct()
			->get();
		foreach ($secciones as $seccion) {
			$prospectos_creados = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('grados as g', 'g.id', 'pros.grado_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('g.seccion', $seccion->seccion)
				->where('p.id', $seccion->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->count();
			$prospectos_seguimiento = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('grados as g', 'g.id', 'pros.grado_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('g.seccion', $seccion->seccion)
				->where('p.id', $seccion->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 3)
				->count();
			$prospectos_promesa_pago = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('grados as g', 'g.id', 'pros.grado_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('g.seccion', $seccion->seccion)
				->where('p.id', $seccion->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 4)
				->count();
			$clientes = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('grados as g', 'g.id', 'pros.grado_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('g.seccion', $seccion->seccion)
				->where('p.id', $seccion->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->whereNotNull('cliente_id')
				->count();
			$prospectos_descartado = ProspectoSeguimiento::join('prospectos as pros', 'pros.id', 'prospecto_seguimientos.prospecto_id')
				->join('grados as g', 'g.id', 'pros.grado_id')
				->join('plantels as p', 'p.id', 'pros.plantel_id')
				->where('g.seccion', $seccion->seccion)
				->where('p.id', $seccion->plantel_id)
				->whereDate('pros.created_at', '>=', $datos['fecha_f'])
				->whereDate('pros.created_at', '<=', $datos['fecha_t'])
				->where('prospecto_st_seg_id', 1)
				->count();

			$linea = [
				'seccion' => $seccion->seccion,
				'plantel' => $seccion->razon,
				'prospectos_creados' => $prospectos_creados,
				'prospectos_seguimiento' => $prospectos_seguimiento,
				'prospectos_promesa_pago' => $prospectos_promesa_pago,
				'clientes' => $clientes,
				'prospectos_descartado' => $prospectos_descartado,
				'total' => $prospectos_creados + $prospectos_seguimiento + $prospectos_promesa_pago + $clientes + $prospectos_descartado
			];

			array_push($registros_seccion, $linea);
			//Log::info($linea);
		}
		//dd($registros_seccion);

		return view('leads.reportes.funnelVentaR', compact(
			'registros_plantel',
			'registros_plantel_empleado',
			'registros_seccion',
			'datos'
		));
	}
}
