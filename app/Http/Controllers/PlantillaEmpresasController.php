<?php namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlantillaEmpresa;
use App\PlantillaEmpresaCond;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantillaEmpresa;
use App\Http\Requests\createPlantillaEmpresa;
use App\PlantillaEmpresaCampo;
use Storage;

class PlantillaEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantillaEmpresas = PlantillaEmpresa::getAllData($request);

		return view('plantillaEmpresas.index', compact('plantillaEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantillaEmpresas.create')
			->with( 'list', PlantillaEmpresa::getListFromAllRelationApps())->with('list1', PlantillaEmpresaCond::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantillaEmpresa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		if (!isset($input['sms_bnd'])) {
			$input['sms_bnd'] = 0;
		}
		if (!isset($input['mail_bnd'])) {
			$input['mail_bnd'] = 0;
		}

		//create data
		PlantillaEmpresa::create( $input );

		return redirect()->route('plantillaEmpresas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlantillaEmpresa $plantillaEmpresa)
	{
		$plantillaEmpresa=$plantillaEmpresa->find($id);
		return view('plantillaEmpresas.show', compact('plantillaEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlantillaEmpresa $plantillaEmpresa)
	{
		$plantillaEmpresa=$plantillaEmpresa->find($id);
		return view('plantillaEmpresas.edit', compact('plantillaEmpresa'))
			->with( 'list', PlantillaEmpresa::getListFromAllRelationApps() )
			->with('list1', PlantillaEmpresaCond::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlantillaEmpresa $plantillaEmpresa)
	{
		$plantillaEmpresa=$plantillaEmpresa->find($id);
		return view('plantillaEmpresas.duplicate', compact('plantillaEmpresa'))
			->with( 'list', PlantillaEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlantillaEmpresa $plantillaEmpresa, updatePlantillaEmpresa $request)
	{
		$input = $request->all();
		//dd($input);
		$input['usu_mod_id']=Auth::user()->id;
		if (!isset($input['sms_bnd'])) {
			$input['sms_bnd'] = 0;
		}
		if (!isset($input['mail_bnd'])) {
			$input['mail_bnd'] = 0;
		}
		//update data
		$plantillaEmpresa=$plantillaEmpresa->find($id);
		$plantillaEmpresa->update( $input );

		return redirect()->route('plantillaEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlantillaEmpresa $plantillaEmpresa)
	{
		$plantillaEmpresa=$plantillaEmpresa->find($id);
		$plantillaEmpresa->delete();

		return redirect()->route('plantillaEmpresas.index')->with('message', 'Registro Borrado.');
	}

	public function comprobarCantidad(Request $request)
	{
		if ($request->ajax()) {
			$p = $request->all();
			//dd($p);
			$condiciones = PlantillaEmpresaCond::where('plantilla_empresa_id', '=', $p['plantilla'])->get();
			//dd($condiciones->toArray());
			$resultado = Empresa::select('razon_social');
			if ($p['sms_bnd'] == 1) {
				$resultado->whereNotNull('empresas.tel_cel');
			}
			if ($p['mail_bnd'] == 1) {
				$resultado->whereNotNull('empresas.correo1');
			}
			foreach ($condiciones as $c) {
				switch ($c->plantillaEmpresaCampo->campo) {
					case 'Estatus':
						if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
							$resultado->where('empresas.id', $c->signo_comparacion, $c->valor_condicion);
						} else {
							$resultado->orWhere('empresas.id', $c->signo_comparacion, $c->valor_condicion);
						}

						break;
					case 'Plantel':
						if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
							$resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
						} else {
							$resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
						}
						break;
					case 'Giro':
						if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
							$resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
						} else {
							$resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
						}
						break;	
					case 'Especialidad':
						if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
							if ($c->signo_comparacion == "like") {
								$resultado->where('e.name', $c->signo_comparacion, $c->interpretacion);
							} else {
								$resultado->where('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
							}
						} else {
							if ($c->signo_comparacion == "like") {
								$resultado->orWhere('e.name', $c->signo_comparacion, $c->interpretacion);
							} else {
								$resultado->orWhere('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
							}
						}

						break;
					case 'Nivel':
						if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
							if ($c->signo_comparacion == "like") {
								$resultado->where('n.name', $c->signo_comparacion, $c->interpretacion);
							} else {
								$resultado->where('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
							}
						} else {
							if ($c->signo_comparacion == "like") {
								$resultado->orWhere('n.name', $c->signo_comparacion, $c->interpretacion);
							} else {
								$resultado->orWhere('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
							}
						}

						break;
					case 'Grado':
						if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
							if ($c->signo_comparacion == "like") {
								$resultado->where('g.name', $c->signo_comparacion, $c->interpretacion);
							} else {
								$resultado->where('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
							}
						} else {
							if ($c->signo_comparacion == "like") {
								$resultado->orWhere('g.name', $c->signo_comparacion, $c->interpretacion);
							} else {
								$resultado->orWhere('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
							}
						}

						break;
				}
			}
			return $resultado->count();
			
		}
	}

	public function crearCondicion(Request $request)
	{
		if ($request->ajax()) {
			$p = $request->all();
			//dd($p);
			$condicion = new PlantillaEmpresaCond();
			$condicion->plantilla_empresa_id = $p['plantilla'];
			$condicion->plantilla_empresa_campo_id = $p['campo'];
			$condicion->interpretacion = $p['interpretacion'];
			$condicion->operador_condicion = $p['operador_condicion'];
			/*switch ($p['operador_condicion']) {
				case 0:
					$condicion->operador_condicion = 'Primera Condición';
					break;
				case 1:
					$condicion->operador_condicion = 'and';
					break;
				case 2:
					$condicion->operador_condicion = 'or';
					break;
			}*/
			$condicion->signo_comparacion = $p['signo'];
			/*switch ($p['signo']) {
				case 1:
					$condicion->signo_comparacion = '>=';
					break;
				case 2:
					$condicion->signo_comparacion = '>';
					break;
				case 3:
					$condicion->signo_comparacion = '=';
					break;
				case 4:
					$condicion->signo_comparacion = 'like';
					break;
				case 5:
					$condicion->signo_comparacion = '<>';
					break;
				case 6:
					$condicion->signo_comparacion = '<=';
					break;
				case 7:
					$condicion->signo_comparacion = '<';
					break;
			}*/
			$condicion->valor_condicion = $p['valor'];
			$condicion->usu_alta_id = 1;
			$condicion->usu_mod_id = 1;
			$condicion->save();
			$todas = 0;
			if (isset($p['todas_condiciones'])) {
				if ($p['todas_condiciones'] == 1) {
					switch ($p['campo']) {
						/*case 3:
							$condicion2 = new PlanCondicionFiltro();
							$condicion2->plantilla_id = $p['plantilla'];
							$condicion2->operador_condicion = 'and';
							$condicion2->plan_campo_filtro_id = 2;
							$condicion2->interpretacion = $p['interpretacion_plantel'];
							$condicion2->signo_comparacion = '=';
							$condicion2->valor_condicion = $p['valor_plantel'];
							$condicion2->usu_alta_id = 1;
							$condicion2->usu_mod_id = 1;
							$condicion2->save();
							break;*/
						case 4:
							$condicion2 = new PlanCondicionFiltro();
							$condicion2->plantilla_id = $p['plantilla'];
							$condicion2->operador_condicion = 'and';
							$condicion2->plan_campo_filtro_id = 2;
							$condicion2->interpretacion = $p['interpretacion_plantel'];
							$condicion2->signo_comparacion = '=';
							$condicion2->valor_condicion = $p['valor_plantel'];
							$condicion2->usu_alta_id = 1;
							$condicion2->usu_mod_id = 1;
							$condicion2->save();
							$condicion3 = new PlanCondicionFiltro();
							$condicion3->plantilla_id = $p['plantilla'];
							$condicion3->operador_condicion = 'and';
							$condicion3->plan_campo_filtro_id = 3;
							$condicion3->interpretacion = $p['interpretacion_especialidad'];
							$condicion3->signo_comparacion = '=';
							$condicion3->valor_condicion = $p['valor_especialidad'];
							$condicion3->usu_alta_id = 1;
							$condicion3->usu_mod_id = 1;
							$condicion3->save();
							break;
						case 5:
							$condicion2 = new PlanCondicionFiltro();
							$condicion2->plantilla_id = $p['plantilla'];
							$condicion2->operador_condicion = 'and';
							$condicion2->plan_campo_filtro_id = 2;
							$condicion2->interpretacion = $p['interpretacion_plantel'];
							$condicion2->signo_comparacion = '=';
							$condicion2->valor_condicion = $p['valor_plantel'];
							$condicion2->usu_alta_id = 1;
							$condicion2->usu_mod_id = 1;
							$condicion2->save();
							$condicion3 = new PlanCondicionFiltro();
							$condicion3->plantilla_id = $p['plantilla'];
							$condicion3->operador_condicion = 'and';
							$condicion3->plan_campo_filtro_id = 3;
							$condicion3->interpretacion = $p['interpretacion_especialidad'];
							$condicion3->signo_comparacion = '=';
							$condicion3->valor_condicion = $p['valor_especialidad'];
							$condicion3->usu_alta_id = 1;
							$condicion3->usu_mod_id = 1;
							$condicion3->save();
							$condicion4 = new PlanCondicionFiltro();
							$condicion4->operador_condicion = 'and';
							$condicion4->plantilla_id = $p['plantilla'];
							$condicion4->plan_campo_filtro_id = 4;
							$condicion4->interpretacion = $p['interpretacion_nivel'];
							$condicion4->signo_comparacion = '=';
							$condicion4->valor_condicion = $p['valor_nivel'];
							$condicion4->usu_alta_id = 1;
							$condicion4->usu_mod_id = 1;
							$condicion4->save();
							break;
					}
				}
			}
		}
	}

	public function cargaArchivoCorreo(Request $request)
	{
		if ($request->hasFile('file')) {

			$file = $request->file('file');
			$extension = $file->getClientOriginalExtension();
			$nombre = $file->getClientOriginalName();
			$r = Storage::disk('plantillas_correos_empresas')->put($nombre, \File::get($file));
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
