<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlanCampoFiltro;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlanCampoFiltro;
use App\Http\Requests\createPlanCampoFiltro;

class PlanCampoFiltrosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$planCampoFiltros = PlanCampoFiltro::getAllData($request);

		return view('planCampoFiltros.index', compact('planCampoFiltros'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('planCampoFiltros.create')
			->with( 'list', PlanCampoFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlanCampoFiltro $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlanCampoFiltro::create( $input );

		return redirect()->route('planCampoFiltros.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlanCampoFiltro $planCampoFiltro)
	{
		$planCampoFiltro=$planCampoFiltro->find($id);
		return view('planCampoFiltros.show', compact('planCampoFiltro'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlanCampoFiltro $planCampoFiltro)
	{
		$planCampoFiltro=$planCampoFiltro->find($id);
		return view('planCampoFiltros.edit', compact('planCampoFiltro'))
			->with( 'list', PlanCampoFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlanCampoFiltro $planCampoFiltro)
	{
		$planCampoFiltro=$planCampoFiltro->find($id);
		return view('planCampoFiltros.duplicate', compact('planCampoFiltro'))
			->with( 'list', PlanCampoFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlanCampoFiltro $planCampoFiltro, updatePlanCampoFiltro $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$planCampoFiltro=$planCampoFiltro->find($id);
		$planCampoFiltro->update( $input );

		return redirect()->route('planCampoFiltros.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlanCampoFiltro $planCampoFiltro)
	{
		$planCampoFiltro=$planCampoFiltro->find($id);
		$planCampoFiltro->delete();

		return redirect()->route('planCampoFiltros.index')->with('message', 'Registro Borrado.');
	}

}
