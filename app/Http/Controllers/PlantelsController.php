<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File as Archi;
use App\AsignacionAcademica;
use App\ConceptoMultipago;
use App\Cliente;
use App\DocPlantelPlantel;
use App\Grado;
use App\FormaPago;
use App\Hacademica;
use App\Plantel;
use App\Empleado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantel;
use App\Http\Requests\createPlantel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use DB;

class PlantelsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index(Request $request)
	{
		$plantels = Plantel::getAllData($request);

		return view('plantels.index', compact('plantels'))->with('list', Plantel::getListFromAllRelationApps());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//dd("fil");
		$directores = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->where('puesto_id', 4)->pluck('name', 'id');
		//dd($directores);
		$responsables = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->where('puesto_id', 23)->pluck('name', 'id');
		$enlaces = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->where('puesto_id', 15)->pluck('name', 'id');
		$lista_conceptosMultipago = ConceptoMultipago::pluck('name', 'id');
		$lista_formaPagos = FormaPago::pluck('name', 'id');
		$matrices = Plantel::pluck('razon', 'id');
		$plantel=new Plantel;
		$documentos_faltantes=null;
		return view('plantels.create', compact('matrices', 'directores', 'responsables', 'enlaces', 'lista_conceptosMultipago', 'lista_formaPagos','plantel',
		'documentos_faltantes'))
			->with('list', Plantel::getListFromAllRelationApps())
			->with('list1', DocPlantelPlantel::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantel $request)
	{
		$input = $request->except('concepto_multipago_id', 'forma_pago_id');
		$conceptos = $request->only('concepto_multipagos_id');
		$formas_pago = $request->only('forma_pago_id');
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		//$input['logo']="";
		$r = $request->hasFile('logo_file');
		if ($r) {
			$logo_file = $request->file('logo_file');
			$input['logo'] = $logo_file->getClientOriginalName();
		}
		$r = $request->hasFile('slogan_file');
		if ($r) {
			$slogan_file = $request->file('slogan_file');
			$input['slogan'] = $slogan_file->getClientOriginalName();
		}
		$r = $request->hasFile('membrete_file');
		if ($r) {
			$membrete_file = $request->file('membrete_file');
			$input['membrete'] = $membrete_file->getClientOriginalName();
		}
		$r = $request->hasFile('img_firma_file');
		if ($r) {
			$img_firma_file = $request->file('img_firma_file');
			$input['img_firma'] = $img_firma_file->getClientOriginalName();
		}

		//create data
		$e = Plantel::create($input);

		if (!is_null($conceptos['concepto_multipagos_id']) or !is_null($formas_pago['forma_pago_id'])) {
			$e->conceptoMultipagos()->sync($conceptos['concepto_multipagos_id']);
			$e->formaPagos()->sync($formas_pago['forma_pago_id']);
		}

		if ($e) {
			$ruta = public_path() . "/imagenes/planteles/" . $e->id . "/";
			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if ($request->file('logo_file')) {
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('logo_file')->move($ruta, $input['logo']);
			}
			if ($request->file('slogan_file')) {
				//\Storage::disk('local')->put($input['slogan'],  \File::get($slogan_file));
				$request->file('slogan_file')->move($ruta, $input['slogan']);
			}
			if ($request->file('membrete_file')) {
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('membrete_file')->move($ruta, $input['membrete']);
			}
			if ($request->file('img_firma_file')) {
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('img_firma_file')->move($ruta, $input['img_firma']);
			}
		}

		return redirect()->route('plantels.index')->with('message', 'Registro creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Plantel $plantel)
	{
		$plantel = $plantel->find($id);
		return view('plantels.show', compact('plantel', 'ruta'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Plantel $plantel)
	{
		$plantel = $plantel->find($id);
		$directores = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->where('puesto_id', 4)->pluck('name', 'id');
		//dd($directores);
		$responsables = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->whereIn('puesto_id', array(4,23))->pluck('name', 'id');
		$enlaces = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->where('puesto_id', 15)->pluck('name', 'id');
		$ruta = public_path() . "\\imagenes\\planteles\\" . $id . "\\";
		$lista_formaPagos = FormaPago::pluck('name', 'id');
		$matrices = Plantel::pluck('razon', 'id');

		$doc_existentes = DB::table('doc_plantel_plantels as dpp')->select('doc_plantel_id')
			->join('plantels as p', 'p.id', '=', 'dpp.plantel_id')
			->where('p.id', '=', $id)
			->get();

		$de_array = array();
		if ($doc_existentes->isNotEmpty()) {
			foreach ($doc_existentes as $de) {
				array_push($de_array, $de->doc_plantel_id);
			}
			//dd($de_array);
		}

		$documentos_faltantes = DB::table('doc_plantels')
			->select()
			->whereNotIn('id', $de_array)
			->get();

		$lista_conceptosMultipago = ConceptoMultipago::pluck('name', 'id');

		return view('plantels.edit', compact(
			'plantel',
			'ruta',
			'directores',
			'responsables',
			'documentos_faltantes',
			'enlaces',
			'lista_conceptosMultipago',
			'lista_formaPagos',
			'matrices'
		))
			->with('list', Plantel::getListFromAllRelationApps())
			->with('list1', DocPlantelPlantel::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Plantel $plantel)
	{
		$plantel = $plantel->find($id);
		return view('plantels.duplicate', compact('plantel'))
			->with('list', Plantel::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Plantel $plantel, updatePlantel $request)
	{
		//dd($request->all());
		$input = $request->except('concepto_multipagos_id', 'forma_pago_id');
		$conceptos = $request->only('concepto_multipagos_id');
		$formas_pago = $request->only('forma_pago_id');
		$input['usu_mod_id'] = Auth::user()->id;

		//$input['logo']="";
		$r = $request->hasFile('logo_file');
		if ($r) {
			$logo_file = $request->file('logo_file');
			$input['logo'] = $logo_file->getClientOriginalName();
		}
		$r = $request->hasFile('slogan_file');
		if ($r) {
			$slogan_file = $request->file('slogan_file');
			$input['slogan'] = $slogan_file->getClientOriginalName();
		}
		$r = $request->hasFile('membrete_file');
		if ($r) {
			$membrete_file = $request->file('membrete_file');
			$input['membrete'] = $membrete_file->getClientOriginalName();
		}
		$r = $request->hasFile('img_firma_file');
		if ($r) {
			$img_firma_file = $request->file('img_firma_file');
			$input['img_firma'] = $img_firma_file->getClientOriginalName();
		}
		//dd($input);
		$plantel = $plantel->find($id);

		//update data
		$e = $plantel->update($input);

		if (isset($conceptos['concepto_multipagos_id']) or isset($formas_pago['forma_pago_id'])) {
			$plantel->conceptoMultipagos()->sync($conceptos['concepto_multipagos_id']);
			$plantel->formaPagos()->sync($formas_pago['forma_pago_id']);
		}

		if ($e) {
			$ruta = public_path() . "/imagenes/planteles/" . $id . "/";
			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if ($request->file('logo_file')) {
				//$logo_file = $request->file('logo_file');
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('logo_file')->move($ruta, $input['logo']);
			}
			if ($request->file('slogan_file')) {
				//\Storage::disk('local')->put($input['slogan'],  \File::get($slogan_file));
				$request->file('slogan_file')->move($ruta, $input['slogan']);
			}
			if ($request->file('membrete_file')) {
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('membrete_file')->move($ruta, $input['membrete']);
			}
			if ($request->file('img_firma_file')) {
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('img_firma_file')->move($ruta, $input['img_firma']);
			}
		}

		return redirect()->route('plantels.index')->with('message', 'Registro actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Plantel $plantel)
	{
		$plantel = $plantel->find($id);

		$plantel->delete();

		return redirect()->route('plantels.index')->with('message', 'Registro borrado.');
	}

	public function getCmbPlantels()
	{
		$r = Plantel::select('razon', 'id')->get();
		$final = array();
		foreach ($r as $r1) {
			array_push($final, array(
				'id' => $r1->id,
				'name' => $r1->razon,
				'selectec' => ''
			));
		}
		return $final;
	}

	public function cargarImg(Request $request)
	{

		$r = $request->hasFile('file');
		$datos = $request->all();
		//dd($request->all());
		if ($r) {
			$logo_file = $request->file('file');
			$input['file'] = $logo_file->getClientOriginalName();
			$ruta_web = asset("/imagenes/plantels/" . $datos['plantel']);
			//dd($ruta_web);
			$ruta = public_path() . "/imagenes/plantels/" . $datos['plantel'] . "/";
			if (!file_exists($ruta)) {
				File::makedirectory($ruta, 0777, true, true);
			}
			if ($request->file('file')->move($ruta, $input['file'])) {
				$documento = new DocPlantelPlantel();
				$documento->plantel_id = $datos['plantel'];
				$documento->doc_plantel_id = $datos['doc_plantel_id'];
				$documento->archivo = $input['file'];
				$documento->fec_vigencia = $datos['fec_vigencia'];
				$documento->usu_alta_id = Auth::user()->id;
				$documento->usu_mod_id = Auth::user()->id;
				$documento->save();
				echo json_encode($ruta_web . "/" . $input['file']);
			} else {
				echo json_encode(0);
			}
		}
		//echo json_encode(0);
	}

	public function listaPlanteles()
	{
		$planteles = Plantel::all();
		$plantels=Plantel::pluck('razon','id');
		return view('combinacionClientes.reportes.cargas', compact('planteles','plantels'));
	}

	public function apiLista()
	{
		$lista = Plantel::select('id', 'razon')->get();
		if (count($lista) == 0) {
			return response()->json(['msj' => 'Sin registros'], 500);
		}
		return response()->json(['resultado' => $lista]);
	}

	public function madre()
	{
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = $empleado->plantels()->pluck('razon', 'id');
		return view('plantels.reportes.madre', compact('planteles'));
	}

	public function madreR(Request $request)
	{
		$datos = $request->all();
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = $empleado->plantels()->pluck('razon', 'id');
		switch ($datos['valor_reporte']) {
			case 'planteles':
				$plantels = Plantel::select(
					'plantels.logo',
					'plantels.razon',
					'plantels.denominacion',
					'plantels.nombre_corto',
					'plantels.rfc',
					'plantels.calle',
					'plantels.no_int',
					'plantels.colonia',
					'plantels.municipio',
					'plantels.estado',
					'plantels.cp',
					'plantels.cve_multipagos',
					'plantels.cuenta_contable',
					'dir.nombre',
					'dir.ape_paterno',
					'dir.ape_materno',
					'plantels.tel',
					'dir.tel_cel',
					'dir.tel_fijo',
					'dir.mail',
					'dir.mail_empresa'
				)
					->leftJoin('empleados as dir', 'dir.id', '=', 'plantels.director_id')
					->where('plantels.id', '>', 0)
					->get();
				return view('plantels.reportes.madre', compact('plantels', 'planteles'));
				break;
			case 'multipagos':
				$multipagos = Plantel::select(
					'plantels.razon',
					'plantels.denominacion',
					'plantels.nombre_corto',
					'plantels.cve_multipagos',
					'plantels.cuenta_contable',
					'fp.name as forma_pago',
					'fp.cve_multipagos as fp_cve',
					'cm.name as concepto',
					'cc.cve_multipagos as cc_cve'
				)
					->leftJoin('forma_pago_plantel as fpp', 'fpp.plantel_id', '=', 'plantels.id')
					->leftJoin('forma_pagos as fp', 'fp.id', '=', 'fpp.forma_pago_id')
					->leftJoin('concepto_multipago_plantel as cmp', 'cmp.plantel_id', '=', 'plantels.id')
					->leftJoin('concepto_multipagos as cm', 'cm.id', '=', 'cmp.concepto_multipago_id')
					->leftJoin('caja_conceptos as cc', 'cc.cve_multipagos', '=', 'cm.id')
					->where('plantels.id', '>', 0)
					->get();
				return view('plantels.reportes.madre', compact('multipagos', 'planteles'));
				break;
			case 'combinaciones':
				$combinaciones = Grado::select(
					//'p.razon as plantel',
					'e.name as especialidad',
					'n.name as nivel',
					'grados.name as grado',
					'grados.rvoe',
					'grados.fec_rvoe',
					'grados.cct',
					'grados.denominacion as denominacion_grado',
					'grados.seccion',
					'grados.nombre2',
					'p.logo',
					'p.razon',
					'p.denominacion as denominacion_plantel',
					'p.nombre_corto',
					'p.rfc',
					'p.calle',
					'p.no_int',
					'p.colonia',
					'p.municipio',
					'p.estado',
					'p.cp',
					'p.cve_multipagos',
					'p.cuenta_contable',
					'dir.nombre',
					'dir.ape_paterno',
					'dir.ape_materno',
					'p.tel',
					'dir.tel_cel',
					'dir.tel_fijo',
					'dir.mail',
					'dir.mail_empresa',
					'ce.clabe',
					'ce.no_cuenta as cuenta_banco'
				)
					->leftJoin('especialidads as e', 'e.id', '=', 'grados.especialidad_id')
					->leftJoin('nivels as n', 'n.id', '=', 'grados.especialidad_id')
					->leftJoin('plantels as p', 'p.id', '=', 'grados.plantel_id')
					->leftJoin('cuentas_efectivo_plantels as cep', 'cep.plantel_id', '=', 'p.id')
					->leftJoin('cuentas_efectivos as ce', 'ce.id', '=', 'cep.cuentas_efectivo_id')
					->leftJoin('empleados as dir', 'dir.id', '=', 'p.director_id')
					//->where('grados.plantel_id', $datos['plantel_f'])
					->where('p.id', '>', 0)
					->orderBy('p.razon')
					->orderBy('especialidad')
					->orderBy('nivel')
					->orderBy('grado')
					->get();
				//dd($combinaciones->toArray());

				return view('plantels.reportes.madre', compact('combinaciones', 'planteles'));
				break;
			case 'asignaciones':
				$asignaciones = AsignacionAcademica::select(
					'p.razon',
					'l.name as lectivo',
					'lo.name as lectivo_oficial',
					'g.name as grupo',
					'm.name as materia',
					'd.nombre',
					'd.ape_paterno',
					'd.ape_materno',
					'd.curp',
					'd.direccion',
					'd.fec_nacimiento',
					'd.genero',
					'ed.name as estado',
					'd.pais_nacimiento',
					'ned.name as nivel_estudios',
					'd.profesion',
					'd.cedula',
					'd.anios_servicio_escuela',
					'do.nombre as do_nombre',
					'do.ape_paterno as do_ape_paterno',
					'do.ape_materno as do_ape_materno',
					'do.curp as do_curp',
					'do.direccion as do_direccion',
					'do.fec_nacimiento as do_fec_nacimiento',
					'do.genero as do_genero',
					'edo.name as do_estado',
					'do.pais_nacimiento as do_pais_nacimiento',
					'edo.name as do_nivel_estudios',
					'do.profesion as do_profesion',
					'do.cedula as do_cedula',
					'do.anios_servicio_escuela as do_anios_servicio_escuela',
					DB::raw('(select count(cliente_id) from hacademicas as h2 where h2.plantel_id=p.id and h2.lectivo_id=l.id and h2.grupo_id=g.id and h2.materium_id=m.id) as total_alumnos')
				)
					->leftJoin('plantels as p', 'p.id', 'asignacion_academicas.plantel_id')
					->leftJoin('lectivos as l', 'l.id', 'asignacion_academicas.lectivo_id')
					->leftJoin('lectivos as lo', 'lo.id', 'asignacion_academicas.lectivo_oficial_id')
					->leftJoin('materia as m', 'm.id', '=', 'asignacion_academicas.materium_id')
					->leftJoin('grupos as g', 'g.id', '=', 'asignacion_academicas.grupo_id')
					->leftJoin('empleados as d', 'd.id', '=', 'asignacion_academicas.empleado_id')
					->leftJoin('estados as ed', 'ed.id', '=', 'd.estado_nacimiento_id')
					->leftJoin('nivel_estudios as ned', 'ned.id', '=', 'd.nivel_estudio_id')
					->leftJoin('empleados as do', 'do.id', '=', 'asignacion_academicas.docente_oficial_id')
					->leftJoin('estados as edo', 'edo.id', '=', 'do.estado_nacimiento_id')
					->where('p.id', $datos['plantel_f'])
					->orderBy('lectivo')
					->orderBy('grupo')
					->orderBy('materia')
					->get();
				//dd($asignaciones->toArray());
				return view('plantels.reportes.madre', compact('asignaciones', 'planteles'));
				break;
			case 'alumnos':
				$alumnos = Cliente::select(
					'clientes.id as cliente_id',
					'p.razon',
					'clientes.nombre',
					'clientes.nombre2',
					'clientes.ape_paterno',
					'clientes.ape_materno',
					'clientes.curp',
					'clientes.calle',
					'clientes.no_exterior',
					'clientes.colonia',
					'clientes.cp',
					'clientes.matricula',
					'e.name as estado',
					'm.name as municipio',
					'clientes.fec_nacimiento',
					'clientes.genero',
					'clientes.curp',
					'stc.name as st_cliente',
					'clientes.created_at',
					'clientes.nacionalidad',
					'clientes.mail',
					'clientes.tel_fijo',
					'ec.name as estado_civil',
					'clientes.edad',
					'en.name as estado_nacimiento',
					'i.created_at as fecha_inscripcion',
					'clientes.nombre_padre',
					'clientes.dir_padre',
					'clientes.curp_padre',
					'clientes.mail_padre',
					'clientes.tel_padre',
					'clientes.nombre_madre',
					'clientes.dir_madre',
					'clientes.curp_madre',
					'clientes.mail_madre',
					'clientes.tel_madre',
					DB::raw('(select fecha from historia_clientes as hc2 where hc2.cliente_id=clientes.id and hc2.evento_cliente_id=2) as fecha_baja'),
					DB::raw('(select tb2.name 
					from autorizacion_becas as ab2 
					inner join tipo_becas as tb2 on tb2.id=ab2.tipo_beca_id
					where ab2.cliente_id=clientes.id and ab2.lectivo_id=i.lectivo_id) as tipo_beca'),
					DB::raw('(select ab3.monto_mensualidad 
					from autorizacion_becas as ab3 
					inner join tipo_becas as tb3 on tb3.id=ab3.tipo_beca_id
					where ab3.cliente_id=clientes.id and ab3.lectivo_id=i.lectivo_id) as porcentaje_beca'),
					DB::raw('(select ab4.mensualidad_sep 
					from autorizacion_becas as ab4 
					inner join tipo_becas as tb4 on tb4.id=ab4.tipo_beca_id
					where ab4.cliente_id=clientes.id and ab4.lectivo_id=i.lectivo_id) as mensualidad_sep')
				)
					->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
					->leftJoin('municipios as m', 'm.id', '=', 'clientes.municipio_id')
					->leftJoin('estados as e', 'e.id', '=', 'clientes.estado_id')
					->leftJoin('estados as en', 'en.id', '=', 'clientes.estado_nacimiento_id')
					->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
					->leftJoin('estado_civils as ec', 'ec.id', '=', 'clientes.estado_civil_id')
					->join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
					->whereNull('i.deleted_at')
					->where('clientes.plantel_id', $datos['plantel_f'])
					//->where('clientes.st_cliente_id=')
					->orderBY('clientes.plantel_id')
					->orderBY('clientes.ape_paterno')
					->orderBY('clientes.ape_materno')
					->orderBY('clientes.nombre')
					->orderBY('clientes.nombre2')
					//->where('clientes.id', 14127)
					->get();
				//dd($alumnos->toArray());
				return view('plantels.reportes.madre', compact('alumnos', 'planteles'));
				break;
			case 'alumnosCalificaciones':
				$alumnosCalificaciones = Hacademica::select(
					'c.id as cliente_id',
					'c.nombre',
					'c.nombre2',
					'c.ape_paterno',
					'c.ape_materno',
					'c.matricula',
					'p.razon',
					'e.name as especialidad',
					'n.name as nivel',
					'gra.name as grado',
					'g.name as grupo',
					'm.name as materia',
					'te.name as tipo_examen',
					'calif.calificacion',
					't.name as turno',
					'l.name as lectivo',
					'pe.name as periodo_estudio',
					'm.creditos',
					'm.codigo',
					DB::raw('(select count(cliente_id) 
					from asistencia_rs as a2 
					inner join asignacion_academicas as aa2 on aa2.id=a2.asignacion_academica_id
					inner join lectivos as l2 on l2.id=aa2.lectivo_id
					where aa2.plantel_id=hacademicas.plantel_id and
					aa2.lectivo_id=hacademicas.lectivo_id and
					aa2.materium_id=hacademicas.materium_id and
					aa2.grupo_id=hacademicas.grupo_id and
					a2.fecha>=l2.inicio and
					a2.fecha<=l2.fin and
					a2.est_asistencia_id=4) as faltas')
				)
					->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
					->join('turnos as t', 't.id', '=', 'i.turno_id')
					->join('lectivos as l', 'l.id', '=', 'i.lectivo_id')
					->join('periodo_estudios as pe', 'pe.id', '=', 'i.periodo_estudio_id')
					->join('plantels as p', 'p.id', '=', 'hacademicas.plantel_id')
					->join('especialidads as e', 'e.id', '=', 'hacademicas.especialidad_id')
					->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
					->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
					->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
					->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
					->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
					->join('calificacions as calif', 'calif.hacademica_id', '=', 'hacademicas.id')
					->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
					->whereNull('hacademicas.deleted_at')
					->where('hacademicas.plantel_id', $datos['plantel_f'])
					->orderBy('p.razon')
					->orderBy('especialidad')
					->orderBy('nivel')
					->orderBy('grado')
					->orderBy('ape_paterno')
					->orderBy('ape_materno')
					->orderBy('nombre')
					->orderBy('nombre2')
					->get();
				//dd($alumnosCalificaciones->toArray());
				return view('plantels.reportes.madre', compact('alumnosCalificaciones', 'planteles'));
				break;
		}
	}
}
