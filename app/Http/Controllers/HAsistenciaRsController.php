<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HAsistenciaR;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHAsistenciaR;
use App\Http\Requests\createHAsistenciaR;

class HAsistenciaRsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hAsistenciaRs = HAsistenciaR::getAllData($request);

		return view('hAsistenciaRs.index', compact('hAsistenciaRs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hAsistenciaRs.create')
			->with( 'list', HAsistenciaR::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHAsistenciaR $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HAsistenciaR::create( $input );

		return redirect()->route('hAsistenciaRs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HAsistenciaR $hAsistenciaR)
	{
		$hAsistenciaR=$hAsistenciaR->find($id);
		return view('hAsistenciaRs.show', compact('hAsistenciaR'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HAsistenciaR $hAsistenciaR)
	{
		$hAsistenciaR=$hAsistenciaR->find($id);
		return view('hAsistenciaRs.edit', compact('hAsistenciaR'))
			->with( 'list', HAsistenciaR::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HAsistenciaR $hAsistenciaR)
	{
		$hAsistenciaR=$hAsistenciaR->find($id);
		return view('hAsistenciaRs.duplicate', compact('hAsistenciaR'))
			->with( 'list', HAsistenciaR::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HAsistenciaR $hAsistenciaR, updateHAsistenciaR $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hAsistenciaR=$hAsistenciaR->find($id);
		$hAsistenciaR->update( $input );

		return redirect()->route('hAsistenciaRs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HAsistenciaR $hAsistenciaR)
	{
		$hAsistenciaR=$hAsistenciaR->find($id);
		$hAsistenciaR->delete();

		return redirect()->route('hAsistenciaRs.index')->with('message', 'Registro Borrado.');
	}

}
