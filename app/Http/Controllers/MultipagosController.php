<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Multipago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMultipago;
use App\Http\Requests\createMultipago;

class MultipagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$multipagos = Multipago::getAllData($request);

		return view('multipagos.index', compact('multipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('multipagos.create')
			->with( 'list', Multipago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMultipago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Multipago::create( $input );

		return redirect()->route('multipagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Multipago $multipago)
	{
		$multipago=$multipago->find($id);
		return view('multipagos.show', compact('multipago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Multipago $multipago)
	{
		$multipago=$multipago->find($id);
		return view('multipagos.edit', compact('multipago'))
			->with( 'list', Multipago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Multipago $multipago)
	{
		$multipago=$multipago->find($id);
		return view('multipagos.duplicate', compact('multipago'))
			->with( 'list', Multipago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Multipago $multipago, updateMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$multipago=$multipago->find($id);
		$multipago->update( $input );

		return redirect()->route('multipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Multipago $multipago)
	{
		$multipago=$multipago->find($id);
		$multipago->delete();

		return redirect()->route('multipagos.index')->with('message', 'Registro Borrado.');
	}

}
