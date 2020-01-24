<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Articulo;
use App\Existencium;
use App\Plantel;
use App\UnidadUso;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateArticulo;
use App\Http\Requests\createArticulo;
use App\UbicacionArt;

class ArticulosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$articulos = Articulo::getAllData($request);

		return view('articulos.index', compact('articulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$unidades = UnidadUso::pluck('name', 'name');
		return view('articulos.create', compact('unidades'))
			->with('list', Articulo::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createArticulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$a = Articulo::create($input);

		$plantels = Plantel::get();
		foreach ($plantels as $plantel) {
			$ubicaciones = UbicacionArt::where('plantel_id', $plantel->id)->get();
			foreach ($ubicaciones as $ubicacion) {
				$existencia['plantel_id'] = $plantel->id;
				$existencia['articulo_id'] = $a->id;
				$existencia['existencia'] = 0;
				$existencia['usu_alta_id'] = Auth::user()->id;
				$existencia['usu_mod_id'] = Auth::user()->id;
				$existencia['ubiacion_art_id'] = $ubicacion->id;
				Existencium::create($existencia);
			}
		}

		return redirect()->route('articulos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Articulo $articulo)
	{
		$articulo = $articulo->find($id);
		return view('articulos.show', compact('articulo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Articulo $articulo)
	{
		$unidades = UnidadUso::pluck('name', 'name');
		$articulo = $articulo->find($id);
		return view('articulos.edit', compact('articulo', 'unidades'))
			->with('list', Articulo::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Articulo $articulo)
	{
		$articulo = $articulo->find($id);
		return view('articulos.duplicate', compact('articulo'))
			->with('list', Articulo::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Articulo $articulo, updateArticulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$articulo = $articulo->find($id);
		$articulo->update($input);

		return redirect()->route('articulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Articulo $articulo)
	{
		$articulo = $articulo->find($id);
		$articulo->delete();

		return redirect()->route('articulos.index')->with('message', 'Registro Borrado.');
	}

	public function existenciasActuales()
	{
		$articulos = Articulo::pluck('name', 'id');
		$plantels = Plantel::pluck('razon', 'id');
		return view('articulos.reportes.existenciasActuales', compact('articulos', 'plantels'))
			->with('list', Articulo::getListFromAllRelationApps());
	}

	public function existenciasActualesR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$registros = Articulo::select(
			'articulos.name as articulo',
			'articulos.unidad_uso',
			'ca.name as categoria',
			'p.razon as plantel',
			'e.existencia',
			'ua.ubicacion'
		)
			->join('existencia as e', 'e.articulo_id', '=', 'articulos.id')
			->join('categoria_articulos as ca', 'ca.id', '=', 'articulos.categoria_articulo_id')
			->join('plantels as p', 'p.id', '=', 'e.plantel_id')
			->join('ubicacion_arts as ua', 'ua.id', '=', 'e.ubicacion_art_id')
			->where('e.plantel_id', $datos['plantel_f'])
			->whereIn('e.ubicacion_art_id', $datos['ubicacion_art_id'])
			->whereIn('e.articulo_id', $datos['articulo_t'])
			->get();
		//						   dd($registros);
		return view('articulos.reportes.existenciasActualesR', compact('registros'));
	}

	public function getUnidad(Request $request)
	{
		if ($request->ajax()) {
			$datos = $request->all();
			return Articulo::find($datos['articulo'])->value('unidad_uso');
		}
	}
}
