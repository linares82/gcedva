<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TitulacionEgreso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTitulacionEgreso;
use App\Http\Requests\createTitulacionEgreso;

class TitulacionEgresosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionEgresos = TitulacionEgreso::getAllData($request);

		return view('titulacionEgresos.index', compact('titulacionEgresos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$titulacionGrupo=$request->input('titulacionGrupo');
		//dd($titulacionGrupo);
		return view('titulacionEgresos.create', compact('titulacionGrupo'))
			->with( 'list', TitulacionEgreso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionEgreso $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TitulacionEgreso::create( $input );

		return redirect()->route('titulacionGrupos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionEgreso $titulacionEgreso)
	{
		$titulacionEgreso=$titulacionEgreso->find($id);
		return view('titulacionEgresos.show', compact('titulacionEgreso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionEgreso $titulacionEgreso)
	{
		$titulacionEgreso=$titulacionEgreso->find($id);
		return view('titulacionEgresos.edit', compact('titulacionEgreso'))
			->with( 'list', TitulacionEgreso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionEgreso $titulacionEgreso)
	{
		$titulacionEgreso=$titulacionEgreso->find($id);
		return view('titulacionEgresos.duplicate', compact('titulacionEgreso'))
			->with( 'list', TitulacionEgreso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TitulacionEgreso $titulacionEgreso, updateTitulacionEgreso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacionEgreso=$titulacionEgreso->find($id);
		$titulacionEgreso->update( $input );

		//return redirect()->route('titulacionEgresos.index')->with('message', 'Registro Actualizado.');
		return redirect()->route('titulacionEgresos.index',array('q[titulacion_grupo_id_lt]'=>$titulacionEgreso->titulacion_grupo_id))->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TitulacionEgreso $titulacionEgreso)
	{
		$titulacionEgreso=$titulacionEgreso->find($id);
		$titulacionEgreso->delete();

		return redirect()->route('titulacionEgresos.index')->with('message', 'Registro Borrado.');
	}

}
