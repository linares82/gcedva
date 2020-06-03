<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Descuento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDescuento;
use App\Http\Requests\createDescuento;

class DescuentosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$descuentos = Descuento::getAllData($request);

		return view('descuentos.index', compact('descuentos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('descuentos.create')
			->with( 'list', Descuento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDescuento $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Descuento::create( $input );

		return redirect()->route('descuentos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Descuento $descuento)
	{
		$descuento=$descuento->find($id);
		return view('descuentos.show', compact('descuento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Descuento $descuento)
	{
		$descuento=$descuento->find($id);
		return view('descuentos.edit', compact('descuento'))
			->with( 'list', Descuento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Descuento $descuento)
	{
		$descuento=$descuento->find($id);
		return view('descuentos.duplicate', compact('descuento'))
			->with( 'list', Descuento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Descuento $descuento, updateDescuento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$descuento=$descuento->find($id);
		$descuento->update( $input );

		return redirect()->route('descuentos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Descuento $descuento)
	{
		$descuento=$descuento->find($id);
		$descuento->delete();

		return redirect()->route('descuentos.index')->with('message', 'Registro Borrado.');
	}

}
