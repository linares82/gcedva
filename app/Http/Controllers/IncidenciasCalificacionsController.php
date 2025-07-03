<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use File;

use App\Param;
use Exception;
use App\Plantel;
use App\Hacademica;
use App\Calificacion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Mail\AvisoIncidencia;
use App\CalificacionPonderacion;
use App\IncidenciasCalificacion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\createIncidenciasCalificacion;
use App\Http\Requests\updateIncidenciasCalificacion;

class IncidenciasCalificacionsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$incidenciasCalificacions = IncidenciasCalificacion::getAllData($request);

		return view('incidenciasCalificacions.index', compact('incidenciasCalificacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$calificacion_ponderacion_id = $datos['calificacion_ponderacion_id'];
		return view('incidenciasCalificacions.create', compact('calificacion_ponderacion_id'))
			->with('list', IncidenciasCalificacion::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createIncidenciasCalificacion $request)
	{

		$input = $request->all();
		//dd($input);
		$calificacionPonderacion = CalificacionPonderacion::find($input['calificacion_ponderacion_id']);
		$input['calificacion_id'] = $calificacionPonderacion->calificacion_id;
		$input['materium_id'] = $calificacionPonderacion->calificacion->hacademica->materium_id;
		$input['hacademica_id'] = $calificacionPonderacion->calificacion->hacademica_id;
		$input['cliente_id'] = $calificacionPonderacion->calificacion->hacademica->cliente_id;
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$incidenciaCalificacion = IncidenciasCalificacion::create($input);
		if ($request->hasFile('file')) {
			$file = $request->file('file');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();

			$r = Storage::disk('img_incidencias_calificacions')->put($nombre, File::get($file));

			//$incidenciaCalificacion = IncidenciasCalificacion::find($request->get('incidencia_calificacion'));
			if ($incidenciaCalificacion->imagen != "") {
				Storage::disk('img_incidencias_calificacions')->delete($incidenciaCalificacion->imagen);
				$incidenciaCalificacion->imagen = $nombre;
			} else {
				$incidenciaCalificacion->imagen = $nombre;
			}
			$incidenciaCalificacion->save();
		}

		return redirect()->route('incidenciasCalificacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, IncidenciasCalificacion $incidenciasCalificacion)
	{
		$incidenciasCalificacion = $incidenciasCalificacion->find($id);
		return view('incidenciasCalificacions.show', compact('incidenciasCalificacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, IncidenciasCalificacion $incidenciasCalificacion)
	{
		$incidenciasCalificacion = $incidenciasCalificacion->find($id);
		$calificacion_ponderacion_id = $incidenciasCalificacion->calificacion_ponderacion_id;
		return view('incidenciasCalificacions.edit', compact('incidenciasCalificacion', 'calificacion_ponderacion_id'))
			->with('list', IncidenciasCalificacion::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, IncidenciasCalificacion $incidenciasCalificacion)
	{
		$incidenciasCalificacion = $incidenciasCalificacion->find($id);
		return view('incidenciasCalificacions.duplicate', compact('incidenciasCalificacion'))
			->with('list', IncidenciasCalificacion::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, IncidenciasCalificacion $incidenciasCalificacion, updateIncidenciasCalificacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$incidenciasCalificacion = $incidenciasCalificacion->find($id);
		$incidenciasCalificacion->update($input);

		return redirect()->route('incidenciasCalificacions.show', $incidenciasCalificacion->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, IncidenciasCalificacion $incidenciasCalificacion)
	{
		$incidenciasCalificacion = $incidenciasCalificacion->find($id);
		$incidenciasCalificacion->delete();

		return redirect()->route('incidenciasCalificacions.index')->with('message', 'Registro Borrado.');
	}

	public function Autorizar(Request $request)
	{
		$datos = $request->all();
		$incidenciasCalificacion = IncidenciasCalificacion::find($datos['id']);
		$input['usu_mod_id'] = Auth::user()->id;
		$input['bnd_autorizada'] = 1;
		$input['bnd_rechazada'] = 0;
		$input['fecha_ar'] = date('Y-m-d');

		$incidenciasCalificacion->update($input);

		if ($incidenciasCalificacion->bnd_autorizada == 1) {
			$this->actualizarCalificacion(
				array(
					'calificacion_ponderacion' => $incidenciasCalificacion->calificacion_ponderacion_id,
					'calificacion_parcial' => $incidenciasCalificacion->calificacion_nueva
				)
			);
		}

		//dd($incidenciasCalificacion->usu_alta->email);
		Mail::to($incidenciasCalificacion->usu_alta->email)
			->send(new AvisoIncidencia($incidenciasCalificacion));

		return redirect()->route('incidenciasCalificacions.show', $datos['id']);
	}

	public function Rechazar(Request $request)
	{
		$datos = $request->all();
		$incidenciasCalificacion = IncidenciasCalificacion::find($datos['id']);
		$input['usu_mod_id'] = Auth::user()->id;
		$input['bnd_rechazada'] = 1;
		$input['bnd_autorizada'] = 0;
		$input['fecha_ar'] = date('Y-m-d');
		$incidenciasCalificacion->update($input);
		//dd($incidenciasCalificacion->usu_alta->email);

		Mail::to($incidenciasCalificacion->usu_alta->email)
			->send(new AvisoIncidencia($incidenciasCalificacion));

		return redirect()->route('incidenciasCalificacions.show', $datos['id']);
	}

	public function actualizarCalificacion($data)
	{
		//dd($data);
		//calcula calificacion de la linea
		try {
			$calificacion_ponderacion = CalificacionPonderacion::find($data['calificacion_ponderacion']);
			//dd($calificacion_ponderacion);
			$calificacion_ponderacion->calificacion_parcial = $data['calificacion_parcial'];
			$calificacion_ponderacion->calificacion_parcial_calculada = $data['calificacion_parcial'] * $calificacion_ponderacion->ponderacion;
			$calificacion_ponderacion->save();

			//Calula calificacion del padre
			if ($calificacion_ponderacion->padre_id > 0) {
				//dd($c->padre_id);
				$suma_calificacion_padre = $this->calculoCalificacionPadre($calificacion_ponderacion->padre_id, $calificacion_ponderacion->calificacion_id);
				$calif_padre = CalificacionPonderacion::where('carga_ponderacion_id', $calificacion_ponderacion->padre_id)->where('calificacion_id', $calificacion_ponderacion->calificacion_id)->first();
				//dd($calif_padre->toArray());
				$calif_padre->calificacion_parcial = $suma_calificacion_padre;
				$calif_padre->calificacion_parcial_calculada = round(($suma_calificacion_padre * $calif_padre->ponderacion), 2);
				$calif_padre->save();
			}

			//Calcula la calificacion en la tabla de calificaciones
			$suma = $this->calculoCalificacionTotal($calificacion_ponderacion->calificacion_id);

			//dd($suma);
			//dd($calificacion_ponderacion->calificacion_id);
			$calificacion = Calificacion::find($calificacion_ponderacion->calificacion_id);
			//dd($calificacion->toArray());
			$calificacion->calificacion = $suma;

			$aprobatoria = Param::where('llave', 'calificacion_aprobatoria')->value('valor');

			if ($aprobatoria == 0) {
				$plantel = Plantel::find($calificacion->hacademica->plantel_id);
				$aprobatoria = $plantel->calificacion_aprobatoria;
			}

			$h = Hacademica::find($calificacion->hacademica_id);
			if ($calificacion->calificacion >= $aprobatoria) {
				$h->st_materium_id = 1;
			} else {
				$h->st_materium_id = 2;
			}
			$calificacion->save();
			$h->save();

			//Revisar si la materia es ponderacion de otra materia, calcular la calificacion de la materia padre
			if ($h->st_materium_id == 1) {
				$materia = $h->materia;
				if ($materia->bnd_ponderacion == true) {
					//dd($materia->padres);
					foreach ($materia->padre as $padre) {
						$padreHacademicas = Hacademica::where('cliente_id', $h->cliente_id)->where('materium_id', $padre->id)->first();
						if (!is_null($padreHacademicas)) {
							$ponderacionesMateriasAprobadas = 1;
							$sumaCalificaciones = 0;
							foreach ($padre->ponderacionMaterias as $materiaH) {
								$hijaHacademicas = Hacademica::where('cliente_id', $h->cliente_id)->where('materium_id', $materiaH->id)->first();
								//dd($hijaHacademicas->toArray());
								if ($hijaHacademicas->st_materium_id <> 1) {
									$ponderacionesMateriasAprobadas = 0;
								} else {
									$calificacionAprobatoria = $hijaHacademicas->calificaciones->last();
									$sumaCalificaciones = $sumaCalificaciones + $calificacionAprobatoria->calificacion;
								}
							}
							//dd($ponderacionesMateriasAprobadas);
							if ($ponderacionesMateriasAprobadas == 1) {
								$calificacionPromedio = $sumaCalificaciones / $padre->ponderacionMaterias->count();

								$padreHacademicas->st_materium_id = 1;
								$padreHacademicas->save();
								//dd($padreHacademicas->calificaciones->first()->toArray());
								$calificacionPadre = $padreHacademicas->calificaciones->first();
								$calificacionPadre->calificacion = $calificacionPromedio;
								$calificacionPadre->save();
							}
						}
					}
				}
			}
		} catch (Exception $e) {
			dd($e);
		}
	}

	public function calculoCalificacionTotal($calificacion_id)
	{
		$calificacion_ponderacion = CalificacionPonderacion::where('calificacion_id', '=', $calificacion_id)->where('padre_id', '=', 0)->get();
		//dd($calificacion_ponderacion->toArray());
		$suma = 0;
		foreach ($calificacion_ponderacion as $cp) {
			$suma = $suma + $cp->calificacion_parcial_calculada;
		}
		return round($suma, 2);
	}

	public function calculoCalificacionPadre($padre_id, $calificacion_id)
	{
		$calificacion_ponderacion = CalificacionPonderacion::where('padre_id', '=', $padre_id)->where('calificacion_id', $calificacion_id)->get();
		//dd($calificacion_ponderacion->toArray());
		$suma = 0;
		foreach ($calificacion_ponderacion as $cp) {
			$suma = $suma + $cp->calificacion_parcial_calculada;
		}
		return $suma;
	}

	public function cargaArchivo(Request $request)
	{
		if ($request->hasFile('file')) {
			$file = $request->file('file');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$r = Storage::disk('img_incidencias_calificacions')->put($nombre, File::get($file));
			$incidenciaCalificacion = IncidenciasCalificacion::find($request->get('incidencia_calificacion'));
			if ($incidenciaCalificacion->imagen != "") {
				Storage::disk('img_incidencias_calificacions')->delete($incidenciaCalificacion->imagen);
				$incidenciaCalificacion->imagen = $nombre;
			} else {
				$incidenciaCalificacion->imagen = $nombre;
			}
			$incidenciaCalificacion->save();
		} else {

			return "no";
		}

		if ($r) {
			return $nombre;
		} else {
			return "Error vuelva a intentarlo";
		}
	}
}
