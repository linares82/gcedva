<?php

namespace App\Http\Controllers;

use Auth;
use App\Empleado;

use App\SepCargo;
use App\SepTitulo;
use App\SepTituloL;
use App\Inscripcion;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\createSepTitulo;
use App\Http\Requests\updateSepTitulo;

class SepTitulosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepTitulos = SepTitulo::getAllData($request);

		return view('sepTitulos.index', compact('sepTitulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)
			->where('st_empleado_id', '<>', 3)
			->first()
			->plantels
			->pluck('razon', 'id');
		//dd($planteles);
		$empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');
		$cargos = SepCargo::select(DB::raw('concat(id_cargo,"-",cargo) as name, id'))
			->pluck('name', 'id');
		$cargos->prepend('seleccionar opcion');
		return view('sepTitulos.create', compact('planteles', 'empleados', 'cargos'))
			->with('list', SepTitulo::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepTitulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$r = SepTitulo::create($input);

		return redirect()->route('sepTitulos.show', $r->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepTitulo $sepTitulo)
	{
		$sepTitulo = $sepTitulo->with(
			'grado',
			'grado.carrera',
			'grado.autorizacionReconocimiento',
			'grado.sepFundamentoLegalServicioSocial',
			'lectivo',
			'r1',
			'r1Cargo',
			'r2',
			'r2Cargo',
			'plantel',
			'plantel.sepInstitucionEducativa'
		)->find($id);
		$lineas = SepTituloL::where('sep_titulo_id', $sepTitulo->id)
			->with(
				'cliente',
				'cliente.titulacions',
				'cliente.procedenciaAlumno',
				'cliente.procedenciaAlumno.sepTEstudioAntecedente'
			)
			->get();
		$this->addAlumnos($sepTitulo);
		return view('sepTitulos.show', compact('sepTitulo', 'lineas'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepTitulo $sepTitulo)
	{
		$sepTitulo = $sepTitulo->find($id);
		//dd($sepTitulo);
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)
			->where('st_empleado_id', '<>', 3)
			->first()
			->plantels
			->pluck('razon', 'id');
		//dd($planteles);
		$empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');
		$cargos = SepCargo::select(DB::raw('concat(id_Cargo,"-",cargo) as name, id'))
			->pluck('name', 'id');
		$cargos->prepend('seleccionar opcion');
		return view('sepTitulos.edit', compact('sepTitulo', 'planteles', 'empleados', 'cargos'))
			->with('list', SepTitulo::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepTitulo $sepTitulo)
	{
		$sepTitulo = $sepTitulo->find($id);
		return view('sepTitulos.duplicate', compact('sepTitulo'))
			->with('list', SepTitulo::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepTitulo $sepTitulo, updateSepTitulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$sepTitulo = $sepTitulo->find($id);
		$sepTitulo->update($input);

		return redirect()->route('sepTitulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, SepTitulo $sepTitulo)
	{
		$sepTitulo = $sepTitulo->find($id);
		$sepTitulo->delete();

		return redirect()->route('sepTitulos.index')->with('message', 'Registro Borrado.');
	}

	public function addAlumnos(SepTitulo $sepTitulo)
	{
		$consultaLineas = Inscripcion::where('plantel_id', $sepTitulo->plantel_id)
			//->left('titulacions as t', 't.cliente_id', 'inscripcions.cliente_id')
			//->left('procedencia_alumnos as pa', 'pa.cliente_id', 'inscripcions.cliente_id')
			->where('especialidad_id', $sepTitulo->especialidad_id)
			->where('nivel_id', $sepTitulo->nivel_id)
			->where('grado_id', $sepTitulo->grado_id)
			->where('lectivo_id', $sepTitulo->lectivo_id)
			->where('grupo_id', $sepTitulo->grupo_id)
			//->with('cliente')
			//->with('grado')
			//->with('plantel')
			->get();
		//dd($consultaLineas);

		foreach ($consultaLineas as $linea) {
			$validar_existencia = SepTituloL::where('sep_titulo_id', $sepTitulo->id)
				->where('cliente_id', $linea->cliente_id)
				->first();
			if (is_null($validar_existencia)) {
				$inputLinea['sep_titulo_id'] = $sepTitulo->id;
				$inputLinea['cliente_id'] = $linea->cliente_id;
				$inputLinea['bnd_descargar'] = 0;
				$inputLinea['usu_alta_id'] = Auth::user()->id;
				$inputLinea['usu_mod_id'] = Auth::user()->id;
				SepTituloL::create($inputLinea);
			}
		}
	}

	public function limpiarLineas($id)
	{
		$sepTituloL = SepTituloL::where('sep_titulo_id', $id)->delete();
		return redirect()->route('sepTitulos.show', $id)->with('message', 'Registro Creado.');
	}
}
