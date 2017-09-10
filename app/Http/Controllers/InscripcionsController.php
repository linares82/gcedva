<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Inscripcion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateInscripcion;
use App\Http\Requests\createInscripcion;

class InscripcionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inscripcions = Inscripcion::getAllData($request);

		return view('inscripcions.index', compact('inscripcions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inscripcions.create')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInscripcion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Inscripcion::create( $input );

		return redirect()->route('inscripcions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		return view('inscripcions.show', compact('inscripcion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		return view('inscripcions.edit', compact('inscripcion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		return view('inscripcions.duplicate', compact('inscripcion'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Inscripcion $inscripcion, updateInscripcion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inscripcion=$inscripcion->find($id);
		$inscripcion->update( $input );

		return redirect()->route('inscripcions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		$inscripcion->delete();

		return redirect()->route('inscripcions.index')->with('message', 'Registro Borrado.');
	}

	public function destroyCli($id,Inscripcion $inscripcion)
	{
		$inscripcion=$inscripcion->find($id);
		$cli=$inscripcion->cliente_id;
		$inscripcion->delete();

		return redirect()->route('clientes.edit', $cli)->with('message', 'Registro Borrado.');
	}

}
