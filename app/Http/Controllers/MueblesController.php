<?php

namespace App\Http\Controllers;

use Auth;
use App\Mueble;
use App\Plantel;

use App\Articulo;
use App\Empleado;
use App\UbicacionArt;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\createMueble;
use App\Http\Requests\updateMueble;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class MueblesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$muebles = Mueble::getAllData($request);

		return view('muebles.index', compact('muebles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$articulos = Articulo::where('tpo_articulo_id', 1)->pluck('name', 'id');
		return view('muebles.create', compact('articulos'))
			->with('list', Mueble::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMueble $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		$anterior = Mueble::select('no_inv')->where('plantel_id', $input['plantel_id'])->orderBy('id','desc')->first();
		//dd($anterior);
		$plantel = Plantel::find($input['plantel_id']);
		$ubicacion = UbicacionArt::find($input['ubicacion_art_id']);
		$numero = 1;
		if (!is_null($anterior)) {
			$numero = $anterior->no_inv + 1;
		}
		$input['no_inv'] = $numero;
		//dd($input);

		//create data
		$mueble = Mueble::create($input);


		return redirect()->route('muebles.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Mueble $mueble)
	{
		$mueble = $mueble->find($id);
		return view('muebles.show', compact('mueble'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Mueble $mueble)
	{
		$articulos = Articulo::where('tpo_articulo_id', 1)->pluck('name', 'id');
		$mueble = $mueble->find($id);
		

		return view('muebles.edit', compact('mueble', 'articulos'))
			->with('list', Mueble::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Mueble $mueble)
	{
		$mueble = $mueble->find($id);
		return view('muebles.duplicate', compact('mueble'))
			->with('list', Mueble::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Mueble $mueble, updateMueble $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$mueble = $mueble->find($id);
		$mueble->update($input);

		return redirect()->route('muebles.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Mueble $mueble)
	{
		$mueble = $mueble->find($id);
		$mueble->delete();

		return redirect()->route('muebles.index')->with('message', 'Registro Borrado.');
	}

	public function resguardos()
	{

		$empleados = Empleado::select('id', 
		DB::raw('concat(nombre, " ",ape_paterno, " ",ape_materno) as nombre'))
		->pluck('nombre', 'id');
		//dd($empleados);
		$articulos=Mueble::get();
		return view('muebles.reportes.resguardos', compact('articulos', 'empleados'))
			->with('list', Articulo::getListFromAllRelationApps());
	}

	public function resguardosR(Request $request)
	{
		$datos = $request->all();
		
		$registros = Mueble::select(
			'muebles.id',
			'p.razon',
			'a.name as articulo',
			'fecha_alta',
			'u.ubicacion',
			'e.id as empleado',
			'e.nombre',
			'e.ape_paterno',
			'e.ape_materno',
			'muebles.marca',
			'muebles.modelo',
			'muebles.no_serie',
			'observaciones',
			'stm.name as estatus',
			'stmu.name as estatus_uso'
		)
			->join('plantels as p', 'p.id', '=', 'muebles.plantel_id')
			->join('articulos as a', 'a.id', '=', 'muebles.articulo_id')
			->join('ubicacion_arts as u', 'u.id', '=', 'muebles.ubicacion_art_id')
			->join('empleados as e', 'e.id', '=', 'muebles.empleado_id')
			->join('st_muebles as stm', 'stm.id', '=', 'muebles.st_mueble_id')
			->join('st_mueble_usos as stmu', 'stmu.id', '=', 'muebles.st_mueble_uso_id')
			//->where('muebles.plantel_id', $datos['plantel_f']);
			->where('muebles.empleado_id', $datos['empleado_id'])
			//->whereIn('muebles.ubicacion_art_id', $datos['ubicacion_art_id'])
			->get();

		//dd($registros);
		return view('muebles.reportes.resguardosR', compact('registros'));
	}

	public function transferenciaMuebles(Request $request){
		$responsables=Empleado::select('id', DB::raw('concat(ape_paterno, " ",ape_materno, " ",nombre) as nombre_completo'))->pluck('nombre_completo', 'id');
		return view('muebles.transferencia', compact('responsables'));
	}

	public function consultaBienesXResponsable(Request $request){
		$datos=$request->all();
		//dd($datos);
		$muebles=Mueble::select('muebles.id', DB::raw('concat(a.name, "-",ua.ubicacion) as articulo'))
		->join('articulos as a', 'a.id','muebles.articulo_id')
		->join('ubicacion_arts as ua','ua.id','muebles.ubicacion_art_id')
		->where('empleado_id', $datos['responsable_origen'])->get();
		//dd($muebles->toArray());
		return $muebles->toJson();
	}

	public function transferenciaMueblesR(Request $request){
		$datos=$request->all();
		
		$destino=$datos['responsable_destino'];

		$muebles_actuales=array();
		foreach($datos['muebles'] as $mueble){
			array_push($muebles_actuales,$mueble['id']);
		}
		/*Mueble::whereIn('id', $muebles_actuales)
		->update(['empleado_id'=>$destino]);
		*/
		$consulta=Mueble::whereIn('id', $muebles_actuales)->get();
		foreach($consulta as $m){
			$m->empleado_id=$destino;
			$m->save();
		}
		return json_encode(array('destino'=>$destino));
		//$responsables=Empleado::select('id', DB::raw('concat(ape_paterno, " ",ape_materno, " ",nombre) as nombre_completo'))->pluck('nombre_completo', 'id');
		//return view('muebles.transferenciaResponsable', compact('responsables'));
	}
}
