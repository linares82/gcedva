<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\GrupoPeriodoEstudio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateGrupoPeriodoEstudio;
use App\Http\Requests\createGrupoPeriodoEstudio;

class GrupoPeriodoEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$grupoPeriodoEstudios = GrupoPeriodoEstudio::getAllData($request);

		return view('grupoPeriodoEstudios.index', compact('grupoPeriodoEstudios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('grupoPeriodoEstudios.create')
			->with( 'list', GrupoPeriodoEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createGrupoPeriodoEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		GrupoPeriodoEstudio::create( $input );

		return redirect()->route('grupoPeriodoEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, GrupoPeriodoEstudio $grupoPeriodoEstudio)
	{
		$grupoPeriodoEstudio=$grupoPeriodoEstudio->find($id);
		return view('grupoPeriodoEstudios.show', compact('grupoPeriodoEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, GrupoPeriodoEstudio $grupoPeriodoEstudio)
	{
		$grupoPeriodoEstudio=$grupoPeriodoEstudio->find($id);
		return view('grupoPeriodoEstudios.edit', compact('grupoPeriodoEstudio'))
			->with( 'list', GrupoPeriodoEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, GrupoPeriodoEstudio $grupoPeriodoEstudio)
	{
		$grupoPeriodoEstudio=$grupoPeriodoEstudio->find($id);
		return view('grupoPeriodoEstudios.duplicate', compact('grupoPeriodoEstudio'))
			->with( 'list', GrupoPeriodoEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, GrupoPeriodoEstudio $grupoPeriodoEstudio, updateGrupoPeriodoEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$grupoPeriodoEstudio=$grupoPeriodoEstudio->find($id);
		$grupoPeriodoEstudio->update( $input );

		return redirect()->route('grupoPeriodoEstudios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,GrupoPeriodoEstudio $grupoPeriodoEstudio)
	{
		$grupoPeriodoEstudio=$grupoPeriodoEstudio->find($id);
		$grupoPeriodoEstudio->delete();

		return redirect()->route('grupoPeriodoEstudios.index')->with('message', 'Registro Borrado.');
	}

}
