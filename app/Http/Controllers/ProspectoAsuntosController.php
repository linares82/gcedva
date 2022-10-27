<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoAsunto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoAsunto;
use App\Http\Requests\createProspectoAsunto;

class ProspectoAsuntosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoAsuntos = ProspectoAsunto::getAllData($request);

		return view('prospectoAsuntos.index', compact('prospectoAsuntos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoAsuntos.create')
			->with( 'list', ProspectoAsunto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoAsunto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoAsunto::create( $input );

		return redirect()->route('prospectoAsuntos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoAsunto $prospectoAsunto)
	{
		$prospectoAsunto=$prospectoAsunto->find($id);
		return view('prospectoAsuntos.show', compact('prospectoAsunto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoAsunto $prospectoAsunto)
	{
		$prospectoAsunto=$prospectoAsunto->find($id);
		return view('prospectoAsuntos.edit', compact('prospectoAsunto'))
			->with( 'list', ProspectoAsunto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoAsunto $prospectoAsunto)
	{
		$prospectoAsunto=$prospectoAsunto->find($id);
		return view('prospectoAsuntos.duplicate', compact('prospectoAsunto'))
			->with( 'list', ProspectoAsunto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoAsunto $prospectoAsunto, updateProspectoAsunto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoAsunto=$prospectoAsunto->find($id);
		$prospectoAsunto->update( $input );

		return redirect()->route('prospectoAsuntos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoAsunto $prospectoAsunto)
	{
		$prospectoAsunto=$prospectoAsunto->find($id);
		$prospectoAsunto->delete();

		return redirect()->route('prospectoAsuntos.index')->with('message', 'Registro Borrado.');
	}

}
