<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CpSat;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCpSat;
use App\Http\Requests\createCpSat;

class CpSatsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cpSats = CpSat::getAllData($request);

		return view('cpSats.index', compact('cpSats'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cpSats.create')
			->with( 'list', CpSat::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCpSat $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CpSat::create( $input );

		return redirect()->route('cpSats.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CpSat $cpSat)
	{
		$cpSat=$cpSat->find($id);
		return view('cpSats.show', compact('cpSat'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CpSat $cpSat)
	{
		$cpSat=$cpSat->find($id);
		return view('cpSats.edit', compact('cpSat'))
			->with( 'list', CpSat::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CpSat $cpSat)
	{
		$cpSat=$cpSat->find($id);
		return view('cpSats.duplicate', compact('cpSat'))
			->with( 'list', CpSat::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CpSat $cpSat, updateCpSat $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cpSat=$cpSat->find($id);
		$cpSat->update( $input );

		return redirect()->route('cpSats.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CpSat $cpSat)
	{
		$cpSat=$cpSat->find($id);
		$cpSat->delete();

		return redirect()->route('cpSats.index')->with('message', 'Registro Borrado.');
	}

}
