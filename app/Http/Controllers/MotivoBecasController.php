<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MotivoBeca;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMotivoBeca;
use App\Http\Requests\createMotivoBeca;

class MotivoBecasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$motivoBecas = MotivoBeca::getAllData($request);

		return view('motivoBecas.index', compact('motivoBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('motivoBecas.create')
			->with( 'list', MotivoBeca::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMotivoBeca $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		MotivoBeca::create( $input );

		return redirect()->route('motivoBecas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, MotivoBeca $motivoBeca)
	{
		$motivoBeca=$motivoBeca->find($id);
		return view('motivoBecas.show', compact('motivoBeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, MotivoBeca $motivoBeca)
	{
		$motivoBeca=$motivoBeca->find($id);
		return view('motivoBecas.edit', compact('motivoBeca'))
			->with( 'list', MotivoBeca::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, MotivoBeca $motivoBeca)
	{
		$motivoBeca=$motivoBeca->find($id);
		return view('motivoBecas.duplicate', compact('motivoBeca'))
			->with( 'list', MotivoBeca::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, MotivoBeca $motivoBeca, updateMotivoBeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$motivoBeca=$motivoBeca->find($id);
		$motivoBeca->update( $input );

		return redirect()->route('motivoBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,MotivoBeca $motivoBeca)
	{
		$motivoBeca=$motivoBeca->find($id);
		$motivoBeca->delete();

		return redirect()->route('motivoBecas.index')->with('message', 'Registro Borrado.');
	}

}
