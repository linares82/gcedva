<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PeriodoEstudio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePeriodoEstudio;
use App\Http\Requests\createPeriodoEstudio;

class PeriodoEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$periodoEstudios = PeriodoEstudio::getAllData($request);

		return view('periodoEstudios.index', compact('periodoEstudios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('periodoEstudios.create')
			->with( 'list', PeriodoEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPeriodoEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PeriodoEstudio::create( $input );

		return redirect()->route('periodoEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PeriodoEstudio $periodoEstudio)
	{
		$periodoEstudio=$periodoEstudio->find($id);
		return view('periodoEstudios.show', compact('periodoEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PeriodoEstudio $periodoEstudio)
	{
		$periodoEstudio=$periodoEstudio->find($id);
		return view('periodoEstudios.edit', compact('periodoEstudio'))
			->with( 'list', PeriodoEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PeriodoEstudio $periodoEstudio)
	{
		$periodoEstudio=$periodoEstudio->find($id);
		return view('periodoEstudios.duplicate', compact('periodoEstudio'))
			->with( 'list', PeriodoEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PeriodoEstudio $periodoEstudio, updatePeriodoEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$periodoEstudio=$periodoEstudio->find($id);
		$periodoEstudio->update( $input );

		return redirect()->route('periodoEstudios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PeriodoEstudio $periodoEstudio)
	{
		$periodoEstudio=$periodoEstudio->find($id);
		$periodoEstudio->delete();

		return redirect()->route('periodoEstudios.index')->with('message', 'Registro Borrado.');
	}

}
