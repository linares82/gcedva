<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TipoBeca;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTipoBeca;
use App\Http\Requests\createTipoBeca;

class TipoBecasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tipoBecas = TipoBeca::getAllData($request);

		return view('tipoBecas.index', compact('tipoBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipoBecas.create')
			->with( 'list', TipoBeca::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTipoBeca $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TipoBeca::create( $input );

		return redirect()->route('tipoBecas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TipoBeca $tipoBeca)
	{
		$tipoBeca=$tipoBeca->find($id);
		return view('tipoBecas.show', compact('tipoBeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TipoBeca $tipoBeca)
	{
		$tipoBeca=$tipoBeca->find($id);
		return view('tipoBecas.edit', compact('tipoBeca'))
			->with( 'list', TipoBeca::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TipoBeca $tipoBeca)
	{
		$tipoBeca=$tipoBeca->find($id);
		return view('tipoBecas.duplicate', compact('tipoBeca'))
			->with( 'list', TipoBeca::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TipoBeca $tipoBeca, updateTipoBeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tipoBeca=$tipoBeca->find($id);
		$tipoBeca->update( $input );

		return redirect()->route('tipoBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TipoBeca $tipoBeca)
	{
		$tipoBeca=$tipoBeca->find($id);
		$tipoBeca->delete();

		return redirect()->route('tipoBecas.index')->with('message', 'Registro Borrado.');
	}

}
