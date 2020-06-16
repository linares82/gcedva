<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SuccessMultipago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSuccessMultipago;
use App\Http\Requests\createSuccessMultipago;

class SuccessMultipagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$successMultipagos = SuccessMultipago::getAllData($request);

		return view('successMultipagos.index', compact('successMultipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('successMultipagos.create')
			->with( 'list', SuccessMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSuccessMultipago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SuccessMultipago::create( $input );

		return redirect()->route('successMultipagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SuccessMultipago $successMultipago)
	{
		$successMultipago=$successMultipago->find($id);
		return view('successMultipagos.show', compact('successMultipago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SuccessMultipago $successMultipago)
	{
		$successMultipago=$successMultipago->find($id);
		return view('successMultipagos.edit', compact('successMultipago'))
			->with( 'list', SuccessMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SuccessMultipago $successMultipago)
	{
		$successMultipago=$successMultipago->find($id);
		return view('successMultipagos.duplicate', compact('successMultipago'))
			->with( 'list', SuccessMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SuccessMultipago $successMultipago, updateSuccessMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$successMultipago=$successMultipago->find($id);
		$successMultipago->update( $input );

		return redirect()->route('successMultipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SuccessMultipago $successMultipago)
	{
		$successMultipago=$successMultipago->find($id);
		$successMultipago->delete();

		return redirect()->route('successMultipagos.index')->with('message', 'Registro Borrado.');
	}

}
