<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RegimenFiscal;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateRegimenFiscal;
use App\Http\Requests\createRegimenFiscal;

class RegimenFiscalsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$regimenFiscals = RegimenFiscal::getAllData($request);

		return view('regimenFiscals.index', compact('regimenFiscals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('regimenFiscals.create')
			->with( 'list', RegimenFiscal::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createRegimenFiscal $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		RegimenFiscal::create( $input );

		return redirect()->route('regimenFiscals.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, RegimenFiscal $regimenFiscal)
	{
		$regimenFiscal=$regimenFiscal->find($id);
		return view('regimenFiscals.show', compact('regimenFiscal'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, RegimenFiscal $regimenFiscal)
	{
		$regimenFiscal=$regimenFiscal->find($id);
		return view('regimenFiscals.edit', compact('regimenFiscal'))
			->with( 'list', RegimenFiscal::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, RegimenFiscal $regimenFiscal)
	{
		$regimenFiscal=$regimenFiscal->find($id);
		return view('regimenFiscals.duplicate', compact('regimenFiscal'))
			->with( 'list', RegimenFiscal::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, RegimenFiscal $regimenFiscal, updateRegimenFiscal $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$regimenFiscal=$regimenFiscal->find($id);
		$regimenFiscal->update( $input );

		return redirect()->route('regimenFiscals.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,RegimenFiscal $regimenFiscal)
	{
		$regimenFiscal=$regimenFiscal->find($id);
		$regimenFiscal->delete();

		return redirect()->route('regimenFiscals.index')->with('message', 'Registro Borrado.');
	}

}
