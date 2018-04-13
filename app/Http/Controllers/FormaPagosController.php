<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FormaPago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFormaPago;
use App\Http\Requests\createFormaPago;

class FormaPagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$formaPagos = FormaPago::getAllData($request);

		return view('formaPagos.index', compact('formaPagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('formaPagos.create')
			->with( 'list', FormaPago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFormaPago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		FormaPago::create( $input );

		return redirect()->route('formaPagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FormaPago $formaPago)
	{
		$formaPago=$formaPago->find($id);
		return view('formaPagos.show', compact('formaPago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FormaPago $formaPago)
	{
		$formaPago=$formaPago->find($id);
		return view('formaPagos.edit', compact('formaPago'))
			->with( 'list', FormaPago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FormaPago $formaPago)
	{
		$formaPago=$formaPago->find($id);
		return view('formaPagos.duplicate', compact('formaPago'))
			->with( 'list', FormaPago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FormaPago $formaPago, updateFormaPago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$formaPago=$formaPago->find($id);
		$formaPago->update( $input );

		return redirect()->route('formaPagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FormaPago $formaPago)
	{
		$formaPago=$formaPago->find($id);
		$formaPago->delete();

		return redirect()->route('formaPagos.index')->with('message', 'Registro Borrado.');
	}

}
