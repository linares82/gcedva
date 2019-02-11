<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Mese;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMese;
use App\Http\Requests\createMese;

class MeseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$mese = Mese::getAllData($request);

		return view('mese.index', compact('mese'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('mese.create')
			->with( 'list', Mese::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMese $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Mese::create( $input );

		return redirect()->route('mese.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Mese $mese)
	{
		$mese=$mese->find($id);
		return view('mese.show', compact('mese'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Mese $mese)
	{
		$mese=$mese->find($id);
		return view('mese.edit', compact('mese'))
			->with( 'list', Mese::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Mese $mese)
	{
		$mese=$mese->find($id);
		return view('mese.duplicate', compact('mese'))
			->with( 'list', Mese::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Mese $mese, updateMese $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$mese=$mese->find($id);
		$mese->update( $input );

		return redirect()->route('mese.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Mese $mese)
	{
		$mese=$mese->find($id);
		$mese->delete();

		return redirect()->route('mese.index')->with('message', 'Registro Borrado.');
	}

}
