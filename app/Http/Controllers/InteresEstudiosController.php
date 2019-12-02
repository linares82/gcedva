<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\InteresEstudio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateInteresEstudio;
use App\Http\Requests\createInteresEstudio;

class InteresEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$interesEstudios = InteresEstudio::getAllData($request);

		return view('interesEstudios.index', compact('interesEstudios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('interesEstudios.create')
			->with( 'list', InteresEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInteresEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		InteresEstudio::create( $input );

		return redirect()->route('interesEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, InteresEstudio $interesEstudio)
	{
		$interesEstudio=$interesEstudio->find($id);
		return view('interesEstudios.show', compact('interesEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, InteresEstudio $interesEstudio)
	{
		$interesEstudio=$interesEstudio->find($id);
		return view('interesEstudios.edit', compact('interesEstudio'))
			->with( 'list', InteresEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, InteresEstudio $interesEstudio)
	{
		$interesEstudio=$interesEstudio->find($id);
		return view('interesEstudios.duplicate', compact('interesEstudio'))
			->with( 'list', InteresEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, InteresEstudio $interesEstudio, updateInteresEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$interesEstudio=$interesEstudio->find($id);
		$interesEstudio->update( $input );

		return redirect()->route('interesEstudios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,InteresEstudio $interesEstudio)
	{
		$interesEstudio=$interesEstudio->find($id);
		$interesEstudio->delete();

		return redirect()->route('interesEstudios.index')->with('message', 'Registro Borrado.');
	}

}
