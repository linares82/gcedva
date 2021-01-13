<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UsoFactura;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateUsoFactura;
use App\Http\Requests\createUsoFactura;

class UsoFacturasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$usoFacturas = UsoFactura::getAllData($request);

		return view('usoFacturas.index', compact('usoFacturas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('usoFacturas.create')
			->with( 'list', UsoFactura::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createUsoFactura $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		UsoFactura::create( $input );

		return redirect()->route('usoFacturas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, UsoFactura $usoFactura)
	{
		$usoFactura=$usoFactura->find($id);
		return view('usoFacturas.show', compact('usoFactura'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, UsoFactura $usoFactura)
	{
		$usoFactura=$usoFactura->find($id);
		return view('usoFacturas.edit', compact('usoFactura'))
			->with( 'list', UsoFactura::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, UsoFactura $usoFactura)
	{
		$usoFactura=$usoFactura->find($id);
		return view('usoFacturas.duplicate', compact('usoFactura'))
			->with( 'list', UsoFactura::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, UsoFactura $usoFactura, updateUsoFactura $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$usoFactura=$usoFactura->find($id);
		$usoFactura->update( $input );

		return redirect()->route('usoFacturas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,UsoFactura $usoFactura)
	{
		$usoFactura=$usoFactura->find($id);
		$usoFactura->delete();

		return redirect()->route('usoFacturas.index')->with('message', 'Registro Borrado.');
	}

}
