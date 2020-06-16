<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FailMultipago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFailMultipago;
use App\Http\Requests\createFailMultipago;

class FailMultipagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$failMultipagos = FailMultipago::getAllData($request);

		return view('failMultipagos.index', compact('failMultipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('failMultipagos.create')
			->with( 'list', FailMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFailMultipago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		FailMultipago::create( $input );

		return redirect()->route('failMultipagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FailMultipago $failMultipago)
	{
		$failMultipago=$failMultipago->find($id);
		return view('failMultipagos.show', compact('failMultipago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FailMultipago $failMultipago)
	{
		$failMultipago=$failMultipago->find($id);
		return view('failMultipagos.edit', compact('failMultipago'))
			->with( 'list', FailMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FailMultipago $failMultipago)
	{
		$failMultipago=$failMultipago->find($id);
		return view('failMultipagos.duplicate', compact('failMultipago'))
			->with( 'list', FailMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FailMultipago $failMultipago, updateFailMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$failMultipago=$failMultipago->find($id);
		$failMultipago->update( $input );

		return redirect()->route('failMultipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FailMultipago $failMultipago)
	{
		$failMultipago=$failMultipago->find($id);
		$failMultipago->delete();

		return redirect()->route('failMultipagos.index')->with('message', 'Registro Borrado.');
	}

}
