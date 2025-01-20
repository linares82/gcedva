<?php namespace App\Http\Controllers;

use Auth;
use App\Plantel;

use App\Http\Requests;
use App\PlantelAgrupamiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createPlantelAgrupamiento;
use App\Http\Requests\updatePlantelAgrupamiento;

class PlantelAgrupamientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantelAgrupamientos = PlantelAgrupamiento::getAllData($request);

		return view('plantelAgrupamientos.index', compact('plantelAgrupamientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$planteles=Plantel::pluck('razon','id');
		return view('plantelAgrupamientos.create', compact('planteles'))
			->with( 'list', PlantelAgrupamiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantelAgrupamiento $request)
	{

		$input = $request->except('´plantel_id');
		$planteles = $request->only('plantel_id');
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$e=PlantelAgrupamiento::create( $input );

		if (!is_null($planteles['plantel_id'])) {
			$e->plantels()->sync($planteles['plantel_id']);
		}

		return redirect()->route('plantelAgrupamientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlantelAgrupamiento $plantelAgrupamiento)
	{
		$plantelAgrupamiento=$plantelAgrupamiento->find($id);
		return view('plantelAgrupamientos.show', compact('plantelAgrupamiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlantelAgrupamiento $plantelAgrupamiento)
	{
		$plantelAgrupamiento=$plantelAgrupamiento->find($id);
		$planteles=Plantel::pluck('razon','id');
		return view('plantelAgrupamientos.edit', compact('plantelAgrupamiento','planteles'))
			->with( 'list', PlantelAgrupamiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlantelAgrupamiento $plantelAgrupamiento)
	{
		$plantelAgrupamiento=$plantelAgrupamiento->find($id);
		return view('plantelAgrupamientos.duplicate', compact('plantelAgrupamiento'))
			->with( 'list', PlantelAgrupamiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlantelAgrupamiento $plantelAgrupamiento, updatePlantelAgrupamiento $request)
	{
		//dd($request->all());
		$input = $request->except('´plantel_id');
		$planteles = $request->only('plantel_id');
		//dd($planteles);
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$plantelAgrupamiento=$plantelAgrupamiento->find($id);
		$plantelAgrupamiento->update( $input );

		if (!is_null($planteles['plantel_id'])) {
			$plantelAgrupamiento->plantels()->sync($planteles['plantel_id']);
		}

		return redirect()->route('plantelAgrupamientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlantelAgrupamiento $plantelAgrupamiento)
	{
		$plantelAgrupamiento=$plantelAgrupamiento->find($id);
		$plantelAgrupamiento->delete();

		return redirect()->route('plantelAgrupamientos.index')->with('message', 'Registro Borrado.');
	}

}
