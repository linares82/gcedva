<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoTarea;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoTarea;
use App\Http\Requests\createProspectoTarea;

class ProspectoTareasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoTareas = ProspectoTarea::getAllData($request);

		return view('prospectoTareas.index', compact('prospectoTareas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoTareas.create')
			->with( 'list', ProspectoTarea::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoTarea $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoTarea::create( $input );

		return redirect()->route('prospectoTareas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoTarea $prospectoTarea)
	{
		$prospectoTarea=$prospectoTarea->find($id);
		return view('prospectoTareas.show', compact('prospectoTarea'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoTarea $prospectoTarea)
	{
		$prospectoTarea=$prospectoTarea->find($id);
		return view('prospectoTareas.edit', compact('prospectoTarea'))
			->with( 'list', ProspectoTarea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoTarea $prospectoTarea)
	{
		$prospectoTarea=$prospectoTarea->find($id);
		return view('prospectoTareas.duplicate', compact('prospectoTarea'))
			->with( 'list', ProspectoTarea::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoTarea $prospectoTarea, updateProspectoTarea $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoTarea=$prospectoTarea->find($id);
		$prospectoTarea->update( $input );

		return redirect()->route('prospectoTareas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoTarea $prospectoTarea)
	{
		$prospectoTarea=$prospectoTarea->find($id);
		$prospectoTarea->delete();

		return redirect()->route('prospectoTareas.index')->with('message', 'Registro Borrado.');
	}

}
