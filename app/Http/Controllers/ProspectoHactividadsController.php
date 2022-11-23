<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoHactividad;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoHactividad;
use App\Http\Requests\createProspectoHactividad;

class ProspectoHactividadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoHactividads = ProspectoHactividad::getAllData($request);

		return view('prospectoHactividads.index', compact('prospectoHactividads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoHactividads.create')
			->with( 'list', ProspectoHactividad::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoHactividad $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoHactividad::create( $input );

		return redirect()->route('prospectoHactividads.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoHactividad $prospectoHactividad)
	{
		$prospectoHactividad=$prospectoHactividad->find($id);
		return view('prospectoHactividads.show', compact('prospectoHactividad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoHactividad $prospectoHactividad)
	{
		$prospectoHactividad=$prospectoHactividad->find($id);
		return view('prospectoHactividads.edit', compact('prospectoHactividad'))
			->with( 'list', ProspectoHactividad::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoHactividad $prospectoHactividad)
	{
		$prospectoHactividad=$prospectoHactividad->find($id);
		return view('prospectoHactividads.duplicate', compact('prospectoHactividad'))
			->with( 'list', ProspectoHactividad::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoHactividad $prospectoHactividad, updateProspectoHactividad $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoHactividad=$prospectoHactividad->find($id);
		$prospectoHactividad->update( $input );

		return redirect()->route('prospectoHactividads.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoHactividad $prospectoHactividad)
	{
		$prospectoHactividad=$prospectoHactividad->find($id);
		$prospectoHactividad->delete();

		return redirect()->route('prospectoHactividads.index')->with('message', 'Registro Borrado.');
	}

}
