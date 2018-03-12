<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlanCondicionFiltro;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlanCondicionFiltro;
use App\Http\Requests\createPlanCondicionFiltro;

class PlanCondicionFiltrosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$planCondicionFiltros = PlanCondicionFiltro::getAllData($request);

		return view('planCondicionFiltros.index', compact('planCondicionFiltros'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('planCondicionFiltros.create')
			->with( 'list', PlanCondicionFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlanCondicionFiltro $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlanCondicionFiltro::create( $input );

		return redirect()->route('planCondicionFiltros.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlanCondicionFiltro $planCondicionFiltro)
	{
		$planCondicionFiltro=$planCondicionFiltro->find($id);
		return view('planCondicionFiltros.show', compact('planCondicionFiltro'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlanCondicionFiltro $planCondicionFiltro)
	{
		$planCondicionFiltro=$planCondicionFiltro->find($id);
		return view('planCondicionFiltros.edit', compact('planCondicionFiltro'))
			->with( 'list', PlanCondicionFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlanCondicionFiltro $planCondicionFiltro)
	{
		$planCondicionFiltro=$planCondicionFiltro->find($id);
		return view('planCondicionFiltros.duplicate', compact('planCondicionFiltro'))
			->with( 'list', PlanCondicionFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlanCondicionFiltro $planCondicionFiltro, updatePlanCondicionFiltro $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$planCondicionFiltro=$planCondicionFiltro->find($id);
		$planCondicionFiltro->update( $input );

		return redirect()->route('planCondicionFiltros.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlanCondicionFiltro $planCondicionFiltro)
	{
		$planCondicionFiltro=$planCondicionFiltro->find($id);
                $id=$planCondicionFiltro->plantilla_id;
		$planCondicionFiltro->delete();

		return redirect()->route('plantillas.edit', $id)->with('message', 'Registro Borrado.');
	}

}
