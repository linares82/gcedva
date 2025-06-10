<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Empleado;
use App\SepCargo;
use App\TpoExamen;
use App\Hacademica;
use App\Inscripcion;
use App\Calificacion;
use App\Http\Requests;
use App\SepCertificado;
use App\SepCertificadoL;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createSepCertificado;
use App\Http\Requests\updateSepCertificado;

class SepCertificadosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCertificados = SepCertificado::getAllData($request);

		return view('sepCertificados.index', compact('sepCertificados'));
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
		$cargos = SepCargo::select(DB::raw('concat(id_Cargo,"-",cargo) as name, id'))
			->pluck('name', 'id');
		$cargos->prepend('seleccionar opcion');
		return view('sepCertificados.create', compact('planteles', 'empleados', 'cargos'))
			->with('list', SepCertificado::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCertificado $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$r = SepCertificado::create($input);

		return redirect()->route('sepCertificados.show', $r->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCertificado $sepCertificado)
	{
		$sepCertificado = $sepCertificado->with([
			'plantel',
			'responsable',
			'cargo',
			'grado',
			'grado.planEstudio',
			'lectivo'
		])
			->find($id);
		$lineas = SepCertificadoL::where('sep_certificado_id', $sepCertificado->id)
			->with([
				'cliente',
				'sepCertTipo',
				'hacademica',
				'lectivo',
				'hacademica.materia',
				'sepCertObservacion'
			])
			->get();
		//dd($lineas);
		//dd($lineas[1]->load('hacademica.lectivo', 'hacademica.materia'));
		$this->crearLineas($sepCertificado);
		//dd($sepCertificado);
		return view('sepCertificados.show', compact('sepCertificado', 'lineas'));
	}

	public function crearLineas(SepCertificado $sepCertificado)
	{
		$consultarInscripciones = Inscripcion::where('plantel_id', $sepCertificado->plantel_id)
			//->left('titulacions as t', 't.cliente_id', 'inscripcions.cliente_id')
			//->left('procedencia_alumnos as pa', 'pa.cliente_id', 'inscripcions.cliente_id')
			->where('especialidad_id', $sepCertificado->especialidad_id)
			->where('nivel_id', $sepCertificado->nivel_id)
			->where('grado_id', $sepCertificado->grado_id)
			->where('lectivo_id', $sepCertificado->lectivo_id)
			->where('grupo_id', $sepCertificado->grupo_id)
			//->with('lectivo')
			//->with('grado')	
			//->with('plantel')
			//	->orderBy('cliente_id')
			->get();
		//dd($consultarInscripciones);
		$hacademicas_existentes = SepCertificadoL::where('sep_certificado_id', $sepCertificado->id)->pluck('hacademica_id');
		foreach ($consultarInscripciones as $inscripcion) {
			$consultaMaterias = Hacademica::select('hacademicas.id', 'hacademicas.cliente_id', 'hacademicas.lectivo_id', 'hacademicas.materium_id')
				->where('inscripcion_id', $inscripcion->id)
				->join('materia as m', 'm.id', 'hacademicas.materium_id')
				->where('m.bnd_oficial', 1)
				->whereNotIn('hacademicas.id', $hacademicas_existentes)
				//where('plantel_id', $sepCertificado->plantel_id)
				//->left('titulacions as t', 't.cliente_id', 'inscripcions.cliente_id')
				//->left('procedencia_alumnos as pa', 'pa.cliente_id', 'inscripcions.cliente_id')
				//->where('especialidad_id', $sepCertificado->especialidad_id)
				//->where('nivel_id', $sepCertificado->nivel_id)
				//->where('grado_id', $sepCertificado->grado_id)
				//->where('lectivo_id', $sepCertificado->lectivo_id)
				//->where('grupo_id', $sepCertificado->grupo_id)
				->get();
			//dd($consultaMaterias->toArray());
			$contador = $sepCertificado->id_asignatura;
			$cliente = 0;
			$contarMaterias = 0;
			$promedioGeneral = array();
			$calificacion_materia = array();
			foreach ($consultaMaterias as $linea) {
				$contador++;
				//dd($linea);
				/*$validar_existencia = SepCertificadoL::where('sep_certificado_id', $sepCertificado->id)
					->where('cliente_id', $linea->cliente_id)
					->where('hacademica_id', $linea->id)
					->first();
					*/
				//if (is_null($validar_existencia)) {
				if ($cliente <> $linea->cliente_id) {
					$contarMaterias = $this->contarMateriasOficiales($linea->cliente_id);
					$promedioGeneral = $this->calcularPromedioGeneral($inscripcion->id);
					$cliente = $linea->cliente_id;
				}

				//dd($promedioGeneral);
				/*$tipoEvaluacion = TpoExamen::with('sepCertObservacion')->find(Calificacion::where('hacademica_id', $linea->id)
					->max('tpo_examen_id'));
					*/
				//dd($promedioGeneral[0]['detalle_calificaciones']);
				//dd($linea);
				$calificacion_materia = array_filter($promedioGeneral[0]['detalle_calificaciones'], function ($calificacion) use ($linea) {
					//dd($calificacion);
					if ($calificacion['hacademica_id'] === $linea->id) {
						return $calificacion;
					}
				});
				//dd($calificacion_materia);
				$registro_detalle = array();
				foreach ($calificacion_materia as $calificacion) {
					$registro_detalle = $calificacion;
				}
				//dd($registro_detalle);

				$inputLinea['sep_certificado_id'] = $sepCertificado->id;
				$inputLinea['cliente_id'] = $linea->cliente_id;
				$inputLinea['hacademica_id'] = $linea->id;
				$inputLinea['materium_id'] = $linea->materium_id;
				$inputLinea['lectivo_id'] = $linea->lectivo_id;
				$inputLinea['sep_cert_tipo_id'] = 1;
				$inputLinea['fecha_expedicion'] = $sepCertificado->fecha_expedicion;
				$inputLinea['id_carrera'] = $sepCertificado->id_carrera;
				$inputLinea['id_asignatura'] = $contador;
				$inputLinea['numero_asignaturas_cursadas'] = $contarMaterias;
				$inputLinea['promedio_general'] = $promedioGeneral[0]['promedio_general'];
				$inputLinea['calificacion_materia'] = $registro_detalle['calificacion'];
				$inputLinea['sep_cert_observacion_id'] = $registro_detalle['sep_cert_observacion_id']; //isset($tipoEvaluacion->sepCertObservacion) ? $tipoEvaluacion->sepCertObservacion->id : "";
				$inputLinea['bnd_descargar'] = 0;
				$inputLinea['usu_alta_id'] = Auth::user()->id;
				$inputLinea['usu_mod_id'] = Auth::user()->id;
				//dd($inputLinea);
				SepCertificadoL::create($inputLinea);
				//dd($inputLinea);
				//}

			}
		}
		//dd($consultaLineas);
	}

	public function contarMateriasOficiales($cliente)
	{
		return Hacademica::where('cliente_id', $cliente)
			->join('materia as m', 'm.id', 'hacademicas.materium_id')
			->where('m.bnd_oficial', 1)
			->where('st_materium_id', 1)
			->count();
	}

	public function calcularPromedioGeneral($inscripcionId)
	{

		$inscripcion = Inscripcion::find($inscripcionId);

		$resultados = array();
		//dd($inscripcion->toArray());

		$hacademicas = Hacademica::select(
			/*'m.name as materia',
			'm.bnd_tiene_nombre_oficial',
			'm.nombre_oficial',
			'm.codigo',
			'm.creditos',*/
			'hacademicas.id',
			'hacademicas.cliente_id'
		)

			->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
			->where('cliente_id', $inscripcion->cliente_id)
			->where('m.bnd_oficial', 1)
			->whereNull('hacademicas.deleted_at')
			->get();


		foreach ($hacademicas as $hacademica) {
			$tpo_examen_max = Calificacion::where('hacademica_id', $hacademica->id)->max('tpo_examen_id');
			$calificacion = Calificacion::select(
				'calificacions.calificacion',
				'te.sep_cert_observacion_id',
				'sco.id_observacion',
				'sco.descripcion as observacion',
				'te.name as tipo_examen'
			)
				->join('tpo_examens as te', 'te.id', 'calificacions.tpo_examen_id')
				->join('sep_cert_observacions as sco', 'sco.id', 'te.sep_cert_observacion_id')
				//->with(['tpoExamen', 'tpoExamen.sepCertObservacion'])
				->where('hacademica_id', $hacademica->id)
				->where('tpo_examen_id', $tpo_examen_max)
				->first();
			//dd($calificacion);
			$resultado = array(
				'hacademica_id' => $hacademica->id,
				'calificacion' => ($calificacion->calificacion < 6 ? ($calificacion->calificacion % 1) : round($calificacion->calificacion, 0)),
				'tipo_examen' => $calificacion->tipo_examen,
				'tipo_obs_id' => $calificacion->id_observacion,
				'tipo_obs' => $calificacion->observacion,
				'sep_cert_observacion_id' => $calificacion->sep_cert_observacion_id
			);
			//dd($resultado);
			array_push($resultados, $resultado);
		}
		//dd($resultados);
		$suma_calificaciones = 0;
		$total_materias = 0;
		foreach ($resultados as $resultado) {
			$cali_redondeada = $resultado['calificacion'];
			$suma_calificaciones = $suma_calificaciones + $cali_redondeada;
			$total_materias = $total_materias + 1;
		}

		$r = array();
		array_push($r, array(
			'promedio_general' => round(($suma_calificaciones / $total_materias), 2),
			'detalle_calificaciones' => $resultados
		));
		//dd($r);
		return $r;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCertificado $sepCertificado)
	{
		$sepCertificado = $sepCertificado->find($id);
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
		return view('sepCertificados.edit', compact('sepCertificado', 'planteles', 'empleados', 'cargos'))
			->with('list', SepCertificado::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCertificado $sepCertificado)
	{
		$sepCertificado = $sepCertificado->find($id);
		return view('sepCertificados.duplicate', compact('sepCertificado'))
			->with('list', SepCertificado::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCertificado $sepCertificado, updateSepCertificado $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$sepCertificado = $sepCertificado->find($id);
		$sepCertificado->update($input);

		return redirect()->route('sepCertificados.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, SepCertificado $sepCertificado)
	{
		$sepCertificado = $sepCertificado->find($id);
		$sepCertificado->delete();

		return redirect()->route('sepCertificados.index')->with('message', 'Registro Borrado.');
	}

	public function limpiarLineas($id)
	{
		$sepCertificadoL = SepCertificadoL::where('sep_certificado_id', $id)->delete();
		return redirect()->route('sepCertificados.show', $id)->with('message', 'Registro Creado.');
	}
}
