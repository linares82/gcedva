<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlanEstudio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlanEstudio;
use App\Http\Requests\createPlanEstudio;

class PlanEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$planEstudios = PlanEstudio::getAllData($request);

		return view('planEstudios.index', compact('planEstudios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('planEstudios.create')
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlanEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlanEstudio::create( $input );

		return redirect()->route('planEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.show', compact('planEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.edit', compact('planEstudio'))
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.duplicate', compact('planEstudio'))
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlanEstudio $planEstudio, updatePlanEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$planEstudio=$planEstudio->find($id);
		$planEstudio->update( $input );

		return redirect()->route('planEstudios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		$planEstudio->delete();

		return redirect()->route('planEstudios.index')->with('message', 'Registro Borrado.');
	}

}
