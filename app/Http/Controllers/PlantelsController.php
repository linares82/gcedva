<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File as Archi;
use App\DocPlantelPlantel;
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

		return view('plantels.index', compact('plantels'));
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
		return view('plantels.create', compact('directores', 'responsables', 'enlaces'))
			->with('list', Plantel::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantel $request)
	{
		$input = $request->all();
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
			->where('puesto_id', 23)->pluck('name', 'id');
		$enlaces = Empleado::select(DB::raw("CONCAT(nombre,' ',ape_paterno,' ',ape_materno) AS name"), 'id')
			->where('puesto_id', 15)->pluck('name', 'id');
		$ruta = public_path() . "\\imagenes\\planteles\\" . $id . "\\";

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

		return view('plantels.edit', compact('plantel', 'ruta', 'directores', 'responsables', 'documentos_faltantes', 'enlaces'))
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
		$input = $request->all();
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
		return view('combinacionClientes.reportes.cargas', compact('planteles'));
	}

	public function apiLista()
	{
		$lista = Plantel::select('id', 'razon')->get();
		if (count($lista) == 0) {
			return response()->json(['msj' => 'Sin registros'], 500);
		}
		return response()->json(['resultado' => $lista]);
	}
}
