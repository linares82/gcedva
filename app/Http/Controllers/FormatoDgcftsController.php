<?php

namespace App\Http\Controllers;

use Auth;
use App\Grado;

use App\Cliente;
use Carbon\Carbon;
use App\Hacademica;
use App\SepMaterium;
use App\Calificacion;
use App\FormatoDgcft;
use App\Http\Requests;
use App\FormatoDgcftDetalle;

use Illuminate\Http\Request;
use App\FormatoDgcftMatCalif;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\Http\Requests\createFormatoDgcft;
use App\Http\Requests\updateFormatoDgcft;

class FormatoDgcftsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$formatoDgcfts = FormatoDgcft::getAllData($request);


		return view('formatoDgcfts.index', compact('formatoDgcfts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('formatoDgcfts.create')
			->with('list', FormatoDgcft::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFormatoDgcft $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$registro = FormatoDgcft::create($input);

		return redirect()->route('formatoDgcfts.edit', $registro->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->find($id);
		return view('formatoDgcfts.show', compact('formatoDgcft'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->with('formatoDgcftDetalles')->find($id);

		$sep_materias = SepMaterium::whereIn('id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('sep_materia_id'))->get();
		//dd($sep_materias);
		//dd($formatoDgcft);
		return view('formatoDgcfts.edit', compact('formatoDgcft', 'sep_materias'))
			->with('list', FormatoDgcft::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->find($id);
		$sep_materias = SepMaterium::whereIn('id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('sep_materia_id'))->get();

		return view('formatoDgcfts.duplicate', compact('formatoDgcft', 'sep_materias'))
			->with('list', FormatoDgcft::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FormatoDgcft $formatoDgcft, updateFormatoDgcft $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$formatoDgcft = $formatoDgcft->find($id);
		$formatoDgcft->update($input);

		return redirect()->route('formatoDgcfts.edit', $formatoDgcft->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->find($id);
		$formatoDgcft->delete();

		return redirect()->route('formatoDgcfts.index')->with('message', 'Registro Borrado.');
	}

	public function generarLineas(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$clientes_id = explode(",", $formatoDgcft->clientes);
		//$controls = explode(",", $formatoDgcft->control);
		//$escolaridads = explode(",", $formatoDgcft->escolaridad);
		//$becas = explode(",", $formatoDgcft->beca);
		//$resultados = explode(",", $formatoDgcft->resultados);
		//$finals = explode(",", $formatoDgcft->final);
		$contador = 1;
		$control_inicio = $datos['control_inicio'];
		//dd($clientes_id);
		foreach ($clientes_id as $llave => $cliente_id) {
			//dd($llave."-".$cliente_id);
			//Log::info($llave);
			$existe_cliente = FormatoDgcftDetalle::where('formato_dgcft_id', $formatoDgcft->id)
				->where('cliente_id', trim($cliente_id))
				->first();

			if (is_null($existe_cliente)) {

				$cliente = Cliente::find(trim($cliente_id));
				$inputFormatoDgcftdetalle['formato_dgcft_id'] = $formatoDgcft->id;
				$inputFormatoDgcftdetalle['num'] = $contador;
				//$inputFormatoDgcftdetalle['control'] = trim($controls[$llave]);
				$inputFormatoDgcftdetalle['control'] = $datos['control_parte_fija'] . str_pad($control_inicio, 7, "0", STR_PAD_LEFT);
				$inputFormatoDgcftdetalle['cliente_id'] = $cliente->id;
				$inputFormatoDgcftdetalle['nombre'] = $cliente->ape_paterno . " " . $cliente->ape_materno . " " . $cliente->nombre . " " . $cliente->nombre2;
				$inputFormatoDgcftdetalle['curp'] = $cliente->curp;
				$fecha_referencia = Carbon::createFromFormat("Y-m-d", $formatoDgcft->fec_edad);
				$edad = Carbon::createFromFormat("Y-m-d", $cliente->fec_nacimiento)->diffInYears($fecha_referencia);
				$inputFormatoDgcftdetalle['edad'] = $edad;
				$inputFormatoDgcftdetalle['fec_sexo'] = $cliente->genero == 1 ? "H" : "M";
				//$inputFormatoDgcftdetalle['escolaridad'] = trim($escolaridads[$llave]);
				$inputFormatoDgcftdetalle['escolaridad'] = $cliente->escolaridad_id;
				//$inputFormatoDgcftdetalle['beca'] = trim($becas[$llave]);
				$beca = $cliente->autorizacionBecas->where('st_beca_id', 4)->last();
				$inputFormatoDgcftdetalle['beca'] = "-";
				if (!is_null($beca)) {
					$inputFormatoDgcftdetalle['beca'] = ($beca->monto_inscripcion * 100) . "%";
				}

				//$inputFormatoDgcftdetalle['resultado'] = trim($resultados[$llave]);
				//$inputFormatoDgcftdetalle['final'] = trim($finals[$llave]);
				$inputFormatoDgcftdetalle['usu_alta_id'] = Auth::user()->id;
				$inputFormatoDgcftdetalle['usu_mod_id'] = Auth::user()->id;
				//dd($inputFormatoDgcftdetalle);
				FormatoDgcftDetalle::create($inputFormatoDgcftdetalle);
				$contador++;
				$control_inicio++;
			}
		}
		return redirect()->route('formatoDgcfts.edit', $datos['id']);
	}



	public function generarCalificaciones(Request $request)
	{
		$datos = $request->all();
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$materias = explode(',', $formatoDgcft->materias);
		$grados = explode(',', $formatoDgcft->grados);
		$ids = FormatoDgcftDetalle::where('formato_dgcft_id', $formatoDgcft->id)
			->pluck('id');
		//dd($ids->toArray());
		foreach ($materias as $llave_materia => $materia) {
			$series = explode('-', $formatoDgcft->calificaciones);
			//dd($series);
			foreach ($series as $llave_serie => $serie) {
				if ($llave_materia == $llave_serie) {
					$calificaciones = explode(',', $serie);
					foreach ($calificaciones as $llave => $calificacion) {
						$formatoDgcftMatCalif = FormatoDgcftMatCalif::where('formato_dgcft_detalle_id', $ids[$llave])
							->where('materia', trim($materia))
							->first();
						if (is_null($formatoDgcftMatCalif)) {
							$input['formato_dgcft_detalle_id'] = $ids[$llave];
							$input['grado'] = trim($grados[$llave_materia]);
							$input['materia'] = trim($materia);
							$input['calificacion'] = $calificacion;
							$input['usu_alta_id'] = Auth::user()->id;
							$input['usu_mod_id'] = Auth::user()->id;

							FormatoDgcftMatCalif::create($input);
						}
					}
				}
			}
		}

		/*
		$resultados = explode(",", $formatoDgcft->resultados);
		$finals = explode(",", $formatoDgcft->final);

		foreach ($formatoDgcft->formatoDgcftDetalles as $detalle) {
			$detalle->update(
				['resultado' => trim($resultados[$detalle->num - 1])]
			);
			$detalle->update(
				['final' => trim($finals[$detalle->num - 1])]
			);
		}*/



		return redirect()->route('formatoDgcfts.edit', $datos['id']);
	}

	public function destroyCalificacion(Request $request)
	{
		$datos = $request->all();
		$calificacion = FormatoDgcftMatCalif::find($datos['id']);
		$calificacion->delete();
		return redirect()->route('formatoDgcfts.edit', $datos['formato_dgcft_id']);
	}

	public function limpiarLineas(Request $request)
	{
		$datos = $request->all();
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		foreach ($formatoDgcft->formatoDgcftDetalles as $detalle) {
			$detalle->delete();
		}
		return redirect()->route('formatoDgcfts.edit', $datos['id']);
	}

	public function ieap04(Request $request)
	{
		$datos = $request->all();
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$secciones = explode(',', $formatoDgcft->sepGrupo->secciones);
		$grado = Grado::where('plantel_id', $formatoDgcft->plantel_id)->whereIn('seccion', $secciones)->first();
		//dd($grado);
		$materias = explode(',', $formatoDgcft->materias);
		if ($datos['v'] == 1) {

			return view('formatoDgcfts.reportes.ieap04', compact('formatoDgcft', 'materias'));
		} else {
			//$materias=SepMaterium::whereIn('id',$formatoDgcft->sepGrupo->sepMateriasRels->pluck('sep_materia_id'))->get();
			$materias = DB::table('sep_grupo_sep_materia as sgsm')
				->select('sgsm.grado', 'sm.duracion_horas', 'sm.id as sep_materia_id', 'sm.name as sep_materia')
				->join('sep_materias as sm', 'sm.id', 'sgsm.sep_materia_id')
				->join('materia_sep_materia as msm', 'msm.sep_materia_id', 'sm.id')
				->join('materia as m', 'm.id', 'msm.materia_id')
				->whereIn('sgsm.id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('id')->toArray())
				->distinct()
				->get();
			//dd($materias);
			return view('formatoDgcfts.reportes.ieap04_2', compact('formatoDgcft', 'materias', 'grado'));
		}
	}

	public function riap02(Request $request)
	{
		$datos = $request->all();
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$materias = explode(',', $formatoDgcft->materias);
		$secciones = explode(',', $formatoDgcft->sepGrupo->secciones);
		$grado = Grado::where('plantel_id', $formatoDgcft->plantel_id)->whereIn('seccion', $secciones)->first();
		//dd($grado);
		if ($datos['v'] == 1) {

			return view('formatoDgcfts.reportes.riap02', compact('formatoDgcft', 'materias'));
		} else {
			//$materias=SepMaterium::whereIn('id',$formatoDgcft->sepGrupo->sepMateriasRels->pluck('sep_materia_id'))->get();
			$materias = DB::table('sep_grupo_sep_materia as sgsm')
				->select('sgsm.grado', 'sm.duracion_horas', 'sm.id as sep_materia_id', 'sm.name')
				->join('sep_materias as sm', 'sm.id', 'sgsm.sep_materia_id')
				->join('materia_sep_materia as msm', 'msm.sep_materia_id', 'sm.id')
				->join('materia as m', 'm.id', 'msm.materia_id')
				->whereIn('sgsm.id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('id')->toArray())
				->distinct()
				->get();
			//dd($materias->toArray());
			return view('formatoDgcfts.reportes.riap02_2', compact('formatoDgcft', 'materias', 'grado'));
		}
	}

	public function icp08(Request $request)
	{
		$datos = $request->all();

		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$detalles = $formatoDgcft->formatoDgcftDetalles;
		$secciones = explode(',', $formatoDgcft->sepGrupo->secciones);
		$grado = Grado::where('plantel_id', $formatoDgcft->plantel_id)->whereIn('seccion', $secciones)->first();
		$materias = explode(',', $formatoDgcft->materias);
		if ($datos['v'] == 1) {
			return view('formatoDgcfts.reportes.icp08', compact('formatoDgcft', 'materias', 'detalles'));
		} else {
			$sep_materias = SepMaterium::whereIn('id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('sep_materia_id'))->get();
			return view('formatoDgcfts.reportes.icp08_2', compact('formatoDgcft', 'sep_materias', 'detalles', 'grado'));
		}
	}

	public function icp08XMateria(Request $request)
	{
		$datos = $request->all();
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$detalles = FormatoDgcftDetalle::select()
			->join('formato_dgcft_mat_califs as mc', 'mc.formato_dgcft_detalle_id', 'formato_dgcft_detalles.id')
			->where('mc.sep_materia_id', $datos['sep_materia_id'])
			->where('formato_dgcft_detalles.formato_dgcft_id', $datos['id'])
			->get();
		$secciones = explode(',', $formatoDgcft->sepGrupo->secciones);
		$grado = Grado::where('plantel_id', $formatoDgcft->plantel_id)->whereIn('seccion', $secciones)->first();

		$materias = explode(',', $formatoDgcft->materias);
		if ($datos['v'] == 1) {
			return view('formatoDgcfts.reportes.icp08XMateria', compact('formatoDgcft', 'detalles'));
		} else {
			$sep_materias = SepMaterium::whereIn('id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('sep_materia_id'))->get();
			return view('formatoDgcfts.reportes.icp08XMateria_2', compact('formatoDgcft', 'detalles', 'grado'));
		}
	}

	public function buscarAlumnos(Request $request)
	{
		$formatoDgcft = FormatoDgcft::with('sepGrupo')->find($request['id']);
		//dd($formatoDgcft->sepGrupo);
		$matricula_mes_anio = $formatoDgcft->inicio_matricula;
		//dd($formatoDgcfts->sepGrupo->secciones);
		$secciones = explode(',', $formatoDgcft->sepGrupo->secciones);
		$mesanio_matricula = explode(',', $formatoDgcft->inicio_matricula);
		//dd($mesanio_matricula);
		$inicios_matricula = array();
		$i = 0;

		foreach ($mesanio_matricula as $mes_anio) {
			foreach ($secciones as $seccion) {
				$inicios_matricula[$i] = $mes_anio . $seccion;
				$i++;
			}
		}
		//dd($inicios_matricula);

		$alumnos_aux = Cliente::query();
		$cadenaLike = "";
		foreach ($inicios_matricula as $inicio_matricula) {
			$cadenaLike = $cadenaLike . "matricula like '" . $inicio_matricula . "%' or ";
		}
		//dd(substr($cadenaLike, 0, strlen($cadenaLike)-4));
		$clientes = $alumnos_aux
			->whereRaw("(" . substr($cadenaLike, 0, strlen($cadenaLike) - 4) .
				') and plantel_id=?', [$formatoDgcft->plantel_id])
			->pluck('id');
		//dd($clientes->toArray());

		$contador = 1;
		$control_inicio = $formatoDgcft->control_inicio;
		//dd($clientes_id);
		foreach ($clientes as $llave => $cliente_id) {
			//dd($llave."-".$cliente_id);
			//Log::info($llave);
			$existe_cliente_formato_actual = FormatoDgcftDetalle::where('formato_dgcft_id', $formatoDgcft->id)
				->where('cliente_id', trim($cliente_id))
				->first();
			//dd($existe_cliente_formato_actual);	
			//$existe_cliente_formato_anterior=null;
			//if($formatoDgcft->sepGupo->bnd_tiene_otro_grupo==1){
			$existe_cliente_formato_anterior = FormatoDgcftDetalle::where('cliente_id', trim($cliente_id))
				->where('bnd_satisfactorio', 1)
				->first();
			//}
			//dd($existe_cliente_formato_anterior);
			//dd($formatoDgcft->sepGrupo);			
			if (
				(is_null($existe_cliente_formato_actual) and is_null($existe_cliente_formato_anterior)) or
				(is_null($existe_cliente_formato_actual) and !is_null($existe_cliente_formato_anterior) and $formatoDgcft->sepGrupo->bnd_tiene_otro_grupo == 1)
			) {

				$cliente = Cliente::find(trim($cliente_id));
				//dd($cliente);
				$inputFormatoDgcftdetalle['formato_dgcft_id'] = $formatoDgcft->id;
				$inputFormatoDgcftdetalle['num'] = $contador;
				//$inputFormatoDgcftdetalle['control'] = trim($controls[$llave]);
				//$inputFormatoDgcftdetalle['control']=$formatoDgcft->control_parte_fija.str_pad($control_inicio,7,"0",STR_PAD_LEFT); 
				$inputFormatoDgcftdetalle['cliente_id'] = $cliente->id;
				$inputFormatoDgcftdetalle['nombre'] = $cliente->ape_paterno . " " . $cliente->ape_materno . " " . $cliente->nombre . " " . $cliente->nombre2;
				$inputFormatoDgcftdetalle['curp'] = $cliente->curp;
				$fecha_referencia = Carbon::createFromFormat("Y-m-d", $formatoDgcft->fec_edad);
				$edad = "N/A";
				if (!is_null($cliente->fec_nacimiento)) {
					$edad = Carbon::createFromFormat("Y-m-d", $cliente->fec_nacimiento)->diffInYears($fecha_referencia);
				}
				$inputFormatoDgcftdetalle['edad'] = $edad;
				$inputFormatoDgcftdetalle['fec_sexo'] = $cliente->genero == 1 ? "H" : "M";
				//$inputFormatoDgcftdetalle['escolaridad'] = trim($escolaridads[$llave]);
				$inputFormatoDgcftdetalle['escolaridad'] = $cliente->escolaridad_id;
				//$inputFormatoDgcftdetalle['beca'] = trim($becas[$llave]);
				$beca = $cliente->autorizacionBecas->where('st_beca_id', 4)->last();
				$inputFormatoDgcftdetalle['beca'] = "-";
				if (!is_null($beca)) {
					$inputFormatoDgcftdetalle['beca'] = ($beca->monto_inscripcion * 100) . "%";
				}

				//$inputFormatoDgcftdetalle['resultado'] = trim($resultados[$llave]);
				//$inputFormatoDgcftdetalle['final'] = trim($finals[$llave]);
				$inputFormatoDgcftdetalle['usu_alta_id'] = Auth::user()->id;
				$inputFormatoDgcftdetalle['usu_mod_id'] = Auth::user()->id;
				//dd($inputFormatoDgcftdetalle);

				$formatoDgcftDetalle = FormatoDgcftDetalle::create($inputFormatoDgcftdetalle);

				$this->calcularCalificaciones($formatoDgcft, $formatoDgcftDetalle, $cliente_id);
				$satisfactorio = 0;
				if ($formatoDgcftDetalle->formatoDgcftMatCalifs->count() > 0) {
					$satisfactorio = 1;
				}
				$formatoDgcftDetalle->bnd_satisfactorio = $satisfactorio;
				if ($formatoDgcftDetalle->bnd_satisfactorio == 1) {
					//dd($formatoDgcft->sepGrupo);
					if (!is_null($existe_cliente_formato_anterior) and $formatoDgcft->sepGrupo->bnd_tiene_otro_grupo == 1) {
						$formatoDgcftDetalle->control = $existe_cliente_formato_anterior->control;
					} else {
						$formatoDgcftDetalle->control = str_pad($control_inicio, 7, "0", STR_PAD_LEFT);
						$control_inicio++;
					}
				} else {
					$formatoDgcftDetalle->control = "";
				}
				//dd($inputFormatoDgcftdetalle);
				$formatoDgcftDetalle->save();
				//dd($formatoDgcftDetalle);
				$contador++;
			}
		}



		//dd($sep_materias->toArray());
		return redirect()->route('formatoDgcfts.edit', $formatoDgcft->id);
	}

	public function calcularCalificaciones($formatoDgcft, $formatoDgcftDetalle, $cliente_id)
	{
		$rel_sep_materias = DB::table('sep_grupo_sep_materia as sgsm')
			->select('sgsm.grado', 'sgsm.duracion_horas', 'sm.id as sep_materia_id')
			->join('sep_materias as sm', 'sm.id', 'sgsm.sep_materia_id')
			->join('materia_sep_materia as msm', 'msm.sep_materia_id', 'sm.id')
			->join('materia as m', 'm.id', 'msm.materia_id')
			->whereIn('sgsm.id', $formatoDgcft->sepGrupo->sepMateriasRels->pluck('id')->toArray())
			->distinct()
			->get();
		//dd($rel_sep_materias);
		$satisfactorio = 0;
		foreach ($rel_sep_materias as $rel_sep_materia) {
			$satisfactorio = 1;
			$sep_materia = SepMaterium::with('materias')->find($rel_sep_materia->sep_materia_id);
			//dd($sep_materia);

			$materias_cliente = Hacademica::whereIn('materium_id', $sep_materia->materias->pluck('id'))
				->where('st_materium_id', 1)
				->where('cliente_id', $cliente_id)
				->get();
			//dd($materias_cliente->toArray());
			if (count($materias_cliente) < $sep_materia->cantidad_materias_para_aprobar) {
				$satisfactorio = 0;
				return $satisfactorio;
			}
			$suma_calificaciones = 0;
			$cuenta_calificaciones = 0;
			if ($satisfactorio == 1) {
				foreach ($materias_cliente as $materia) {
					$calificacion = Calificacion::where('hacademica_id', $materia->id)->orderBy('id', 'desc')->first();
					$suma_calificaciones = $suma_calificaciones + $calificacion->calificacion;
					//Log::info($calificacion);
					$cuenta_calificaciones++;
				}
			}

			if ($cuenta_calificaciones == 0) {
				$satisfactorio = 0;
				return $satisfactorio;
			}
			$input['formato_dgcft_detalle_id'] = $formatoDgcftDetalle->id;
			$input['grado'] = $rel_sep_materia->grado;
			$input['materia'] = $sep_materia->name;
			$input['sep_materia_id'] = $sep_materia->id;
			$input['calificacion'] = $suma_calificaciones / $cuenta_calificaciones;
			$input['usu_alta_id'] = Auth::user()->id;
			$input['usu_mod_id'] = Auth::user()->id;

			FormatoDgcftMatCalif::create($input);
		}
		return $satisfactorio;
	}
}
