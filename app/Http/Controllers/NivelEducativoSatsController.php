<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\NivelEducativoSat;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateNivelEducativoSat;
use App\Http\Requests\createNivelEducativoSat;

class NivelEducativoSatsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$nivelEducativoSats = NivelEducativoSat::getAllData($request);

		return view('nivelEducativoSats.index', compact('nivelEducativoSats'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('nivelEducativoSats.create')
			->with( 'list', NivelEducativoSat::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createNivelEducativoSat $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		NivelEducativoSat::create( $input );

		return redirect()->route('nivelEducativoSats.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, NivelEducativoSat $nivelEducativoSat)
	{
		$nivelEducativoSat=$nivelEducativoSat->find($id);
		return view('nivelEducativoSats.show', compact('nivelEducativoSat'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, NivelEducativoSat $nivelEducativoSat)
	{
		$nivelEducativoSat=$nivelEducativoSat->find($id);
		return view('nivelEducativoSats.edit', compact('nivelEducativoSat'))
			->with( 'list', NivelEducativoSat::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, NivelEducativoSat $nivelEducativoSat)
	{
		$nivelEducativoSat=$nivelEducativoSat->find($id);
		return view('nivelEducativoSats.duplicate', compact('nivelEducativoSat'))
			->with( 'list', NivelEducativoSat::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, NivelEducativoSat $nivelEducativoSat, updateNivelEducativoSat $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$nivelEducativoSat=$nivelEducativoSat->find($id);
		$nivelEducativoSat->update( $input );

		return redirect()->route('nivelEducativoSats.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,NivelEducativoSat $nivelEducativoSat)
	{
		$nivelEducativoSat=$nivelEducativoSat->find($id);
		$nivelEducativoSat->delete();

		return redirect()->route('nivelEducativoSats.index')->with('message', 'Registro Borrado.');
	}

}
