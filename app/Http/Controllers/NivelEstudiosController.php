<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\NivelEstudio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateNivelEstudio;
use App\Http\Requests\createNivelEstudio;

class NivelEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$nivelEstudios = NivelEstudio::getAllData($request);

		return view('nivelEstudios.index', compact('nivelEstudios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('nivelEstudios.create')
			->with( 'list', NivelEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createNivelEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		NivelEstudio::create( $input );

		return redirect()->route('nivelEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, NivelEstudio $nivelEstudio)
	{
		$nivelEstudio=$nivelEstudio->find($id);
		return view('nivelEstudios.show', compact('nivelEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, NivelEstudio $nivelEstudio)
	{
		$nivelEstudio=$nivelEstudio->find($id);
		return view('nivelEstudios.edit', compact('nivelEstudio'))
			->with( 'list', NivelEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, NivelEstudio $nivelEstudio)
	{
		$nivelEstudio=$nivelEstudio->find($id);
		return view('nivelEstudios.duplicate', compact('nivelEstudio'))
			->with( 'list', NivelEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, NivelEstudio $nivelEstudio, updateNivelEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$nivelEstudio=$nivelEstudio->find($id);
		$nivelEstudio->update( $input );

		return redirect()->route('nivelEstudios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,NivelEstudio $nivelEstudio)
	{
		$nivelEstudio=$nivelEstudio->find($id);
		$nivelEstudio->delete();

		return redirect()->route('nivelEstudios.index')->with('message', 'Registro Borrado.');
	}

}
