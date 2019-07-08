<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentasEfectivoPlantel;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuentasEfectivoPlantel;
use App\Http\Requests\createCuentasEfectivoPlantel;

class CuentasEfectivoPlantelsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentasEfectivoPlantels = CuentasEfectivoPlantel::getAllData($request);
                //dd($cuentasEfectivoPlantels);
		return view('cuentasEfectivoPlantels.index', compact('cuentasEfectivoPlantels'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuentasEfectivoPlantels.create')
			->with( 'list', CuentasEfectivoPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentasEfectivoPlantel $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                if($input['saldo_inicial']>0 and $input['fecha_saldo_inicial']<>""){
                    $input['saldo_actualizado']=$input['saldo_inicial'];
                }

		//create data
		CuentasEfectivoPlantel::create( $input );

		return redirect()->route('cuentasEfectivoPlantels.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentasEfectivoPlantel $cuentasEfectivoPlantel)
	{
		$cuentasEfectivoPlantel=$cuentasEfectivoPlantel->find($id);
		return view('cuentasEfectivoPlantels.show', compact('cuentasEfectivoPlantel'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentasEfectivoPlantel $cuentasEfectivoPlantel)
	{
		$cuentasEfectivoPlantel=$cuentasEfectivoPlantel->find($id);
		return view('cuentasEfectivoPlantels.edit', compact('cuentasEfectivoPlantel'))
			->with( 'list', CuentasEfectivoPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentasEfectivoPlantel $cuentasEfectivoPlantel)
	{
		$cuentasEfectivoPlantel=$cuentasEfectivoPlantel->find($id);
		return view('cuentasEfectivoPlantels.duplicate', compact('cuentasEfectivoPlantel'))
			->with( 'list', CuentasEfectivoPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentasEfectivoPlantel $cuentasEfectivoPlantel, updateCuentasEfectivoPlantel $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
                if($input['saldo_inicial']>0 and $input['fecha_saldo_inicial']<>""){
                    $input['saldo_actualizado']=$input['saldo_inicial'];
                }
		//update data
		$cuentasEfectivoPlantel=$cuentasEfectivoPlantel->find($id);
		$cuentasEfectivoPlantel->update( $input );

		return redirect()->route('cuentasEfectivoPlantels.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuentasEfectivoPlantel $cuentasEfectivoPlantel)
	{
		$cuentasEfectivoPlantel=$cuentasEfectivoPlantel->find($id);
		$cuentasEfectivoPlantel->delete();

		return redirect()->route('cuentasEfectivoPlantels.index')->with('message', 'Registro Borrado.');
	}

        
}
