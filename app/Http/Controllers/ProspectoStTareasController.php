<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoStTarea;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoStTarea;
use App\Http\Requests\createProspectoStTarea;

class ProspectoStTareasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoStTareas = ProspectoStTarea::getAllData($request);

		return view('prospectoStTareas.index', compact('prospectoStTareas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoStTareas.create')
			->with( 'list', ProspectoStTarea::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoStTarea $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoStTarea::create( $input );

		return redirect()->route('prospectoStTareas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoStTarea $prospectoStTarea)
	{
		$prospectoStTarea=$prospectoStTarea->find($id);
		return view('prospectoStTareas.show', compact('prospectoStTarea'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoStTarea $prospectoStTarea)
	{
		$prospectoStTarea=$prospectoStTarea->find($id);
		return view('prospectoStTareas.edit', compact('prospectoStTarea'))
			->with( 'list', ProspectoStTarea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoStTarea $prospectoStTarea)
	{
		$prospectoStTarea=$prospectoStTarea->find($id);
		return view('prospectoStTareas.duplicate', compact('prospectoStTarea'))
			->with( 'list', ProspectoStTarea::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoStTarea $prospectoStTarea, updateProspectoStTarea $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoStTarea=$prospectoStTarea->find($id);
		$prospectoStTarea->update( $input );

		return redirect()->route('prospectoStTareas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoStTarea $prospectoStTarea)
	{
		$prospectoStTarea=$prospectoStTarea->find($id);
		$prospectoStTarea->delete();

		return redirect()->route('prospectoStTareas.index')->with('message', 'Registro Borrado.');
	}

}
