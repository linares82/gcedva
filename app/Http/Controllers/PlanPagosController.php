<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlanPago;
use App\PlanPagoLn;
use App\ReglaRecargo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlanPago;
use App\Http\Requests\createPlanPago;

class PlanPagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$planPagos = PlanPago::getAllData($request);

		return view('planPagos.index', compact('planPagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('planPagos.create')
			->with( 'list', PlanPago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlanPago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlanPago::create( $input );

		return redirect()->route('planPagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlanPago $planPago)
	{
		$planPago=$planPago->find($id);
                //dd($planPago->lineas->toArray());
                $reglaRecargo=ReglaRecargo::pluck('name','id');
                //$reglaRecargosRelacionados= $planPago->planPagoLn->reglaRecargos();
                //dd($reglaRecargo);
		return view('planPagos.show', compact('planPago', 'reglaRecargo'))->with( 'list', PlanPagoLn::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlanPago $planPago)
	{
		$planPago=$planPago->find($id);
		return view('planPagos.edit', compact('planPago'))
			->with( 'list', PlanPago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlanPago $planPago)
	{
		$planPago=$planPago->find($id);
		return view('planPagos.duplicate', compact('planPago'))
			->with( 'list', PlanPago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlanPago $planPago, updatePlanPago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$planPago=$planPago->find($id);
		$planPago->update( $input );

		return redirect()->route('planPagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlanPago $planPago)
	{
		$planPago=$planPago->find($id);
		$planPago->delete();

		return redirect()->route('planPagos.index')->with('message', 'Registro Borrado.');
	}

}
