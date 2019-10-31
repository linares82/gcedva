<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PeriodoExamen;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePeriodoExaman;
use App\Http\Requests\createPeriodoExaman;

class PeriodoExamensController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$periodoExamens = PeriodoExamen::getAllData($request);

		return view('periodoExamens.index', compact('periodoExamens'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('periodoExamens.create')
			->with( 'list', PeriodoExamen::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPeriodoExaman $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PeriodoExaman::create( $input );

		return redirect()->route('periodoExamens.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PeriodoExamen $periodoExaman)
	{
		$periodoExaman=$periodoExaman->find($id);
		return view('periodoExamens.show', compact('periodoExaman'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PeriodoExamen $periodoExaman)
	{
		$periodoExaman=$periodoExaman->find($id);
		return view('periodoExamens.edit', compact('periodoExaman'))
			->with( 'list', PeriodoExaman::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PeriodoExamen $periodoExaman)
	{
		$periodoExaman=$periodoExaman->find($id);
		return view('periodoExamens.duplicate', compact('periodoExaman'))
			->with( 'list', PeriodoExaman::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PeriodoExaman $periodoExamen, updatePeriodoExaman $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$periodoExaman=$periodoExaman->find($id);
		$periodoExaman->update( $input );

		return redirect()->route('periodoExamens.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PeriodoExamen $periodoExaman)
	{
		//dd($id);
		$periodoExaman=$periodoExaman->find($id);
		$lectivo= $periodoExaman->lectivo_id;
		$periodoExaman->delete();

		return redirect()->route('lectivos.edit', $lectivo)->with('message', 'Registro Borrado.');
	}

}
