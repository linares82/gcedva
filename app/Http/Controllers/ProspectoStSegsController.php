<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoStSeg;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoStSeg;
use App\Http\Requests\createProspectoStSeg;

class ProspectoStSegsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoStSegs = ProspectoStSeg::getAllData($request);

		return view('prospectoStSegs.index', compact('prospectoStSegs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoStSegs.create')
			->with( 'list', ProspectoStSeg::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoStSeg $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoStSeg::create( $input );

		return redirect()->route('prospectoStSegs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoStSeg $prospectoStSeg)
	{
		$prospectoStSeg=$prospectoStSeg->find($id);
		return view('prospectoStSegs.show', compact('prospectoStSeg'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoStSeg $prospectoStSeg)
	{
		$prospectoStSeg=$prospectoStSeg->find($id);
		return view('prospectoStSegs.edit', compact('prospectoStSeg'))
			->with( 'list', ProspectoStSeg::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoStSeg $prospectoStSeg)
	{
		$prospectoStSeg=$prospectoStSeg->find($id);
		return view('prospectoStSegs.duplicate', compact('prospectoStSeg'))
			->with( 'list', ProspectoStSeg::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoStSeg $prospectoStSeg, updateProspectoStSeg $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoStSeg=$prospectoStSeg->find($id);
		$prospectoStSeg->update( $input );

		return redirect()->route('prospectoStSegs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoStSeg $prospectoStSeg)
	{
		$prospectoStSeg=$prospectoStSeg->find($id);
		$prospectoStSeg->delete();

		return redirect()->route('prospectoStSegs.index')->with('message', 'Registro Borrado.');
	}

}
