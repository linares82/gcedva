<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Bandeja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateBandeja;
use App\Http\Requests\createBandeja;

class BandejasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bandejas = Bandeja::getAllData($request);

		return view('bandejas.index', compact('bandejas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('bandejas.create')
			->with( 'list', Bandeja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createBandeja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Bandeja::create( $input );

		return redirect()->route('bandejas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Bandeja $bandeja)
	{
		$bandeja=$bandeja->find($id);
		return view('bandejas.show', compact('bandeja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Bandeja $bandeja)
	{
		$bandeja=$bandeja->find($id);
		return view('bandejas.edit', compact('bandeja'))
			->with( 'list', Bandeja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Bandeja $bandeja)
	{
		$bandeja=$bandeja->find($id);
		return view('bandejas.duplicate', compact('bandeja'))
			->with( 'list', Bandeja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Bandeja $bandeja, updateBandeja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$bandeja=$bandeja->find($id);
		$bandeja->update( $input );

		return redirect()->route('bandejas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Bandeja $bandeja)
	{
		$bandeja=$bandeja->find($id);
		$bandeja->delete();

		return redirect()->route('bandejas.index')->with('message', 'Registro Borrado.');
	}

}
