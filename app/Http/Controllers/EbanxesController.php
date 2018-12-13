<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ebanx;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEbanx;
use App\Http\Requests\createEbanx;

class EbanxesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ebanxes = Ebanx::getAllData($request);

		return view('ebanxes.index', compact('ebanxes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ebanxes.create')
			->with( 'list', Ebanx::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEbanx $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Ebanx::create( $input );

		return redirect()->route('ebanxes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		return view('ebanxes.show', compact('ebanx'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		return view('ebanxes.edit', compact('ebanx'))
			->with( 'list', Ebanx::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		return view('ebanxes.duplicate', compact('ebanx'))
			->with( 'list', Ebanx::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Ebanx $ebanx, updateEbanx $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ebanx=$ebanx->find($id);
		$ebanx->update( $input );

		return redirect()->route('ebanxes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		$ebanx->delete();

		return redirect()->route('ebanxes.index')->with('message', 'Registro Borrado.');
	}

}
