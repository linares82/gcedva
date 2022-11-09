<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlantelInventario;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantelInventario;
use App\Http\Requests\createPlantelInventario;

class PlantelInventariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantelInventarios = PlantelInventario::getAllData($request);

		return view('plantelInventarios.index', compact('plantelInventarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantelInventarios.create')
			->with( 'list', PlantelInventario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantelInventario $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlantelInventario::create( $input );

		return redirect()->route('plantelInventarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlantelInventario $plantelInventario)
	{
		$plantelInventario=$plantelInventario->find($id);
		return view('plantelInventarios.show', compact('plantelInventario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlantelInventario $plantelInventario)
	{
		$plantelInventario=$plantelInventario->find($id);
		return view('plantelInventarios.edit', compact('plantelInventario'))
			->with( 'list', PlantelInventario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlantelInventario $plantelInventario)
	{
		$plantelInventario=$plantelInventario->find($id);
		return view('plantelInventarios.duplicate', compact('plantelInventario'))
			->with( 'list', PlantelInventario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlantelInventario $plantelInventario, updatePlantelInventario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$plantelInventario=$plantelInventario->find($id);
		$plantelInventario->update( $input );

		return redirect()->route('plantelInventarios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlantelInventario $plantelInventario)
	{
		$plantelInventario=$plantelInventario->find($id);
		$plantelInventario->delete();

		return redirect()->route('plantelInventarios.index')->with('message', 'Registro Borrado.');
	}

}
