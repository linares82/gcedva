<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProcedenciaAlumno;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProcedenciaAlumno;
use App\Http\Requests\createProcedenciaAlumno;

class ProcedenciaAlumnosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$procedenciaAlumnos = ProcedenciaAlumno::getAllData($request);

		return view('procedenciaAlumnos.index', compact('procedenciaAlumnos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('procedenciaAlumnos.create')
			->with( 'list', ProcedenciaAlumno::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProcedenciaAlumno $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProcedenciaAlumno::create( $input );

		return redirect()->route('procedenciaAlumnos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProcedenciaAlumno $procedenciaAlumno)
	{
		$procedenciaAlumno=$procedenciaAlumno->find($id);
		return view('procedenciaAlumnos.show', compact('procedenciaAlumno'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProcedenciaAlumno $procedenciaAlumno)
	{
		$procedenciaAlumno=$procedenciaAlumno->find($id);
		return view('procedenciaAlumnos.edit', compact('procedenciaAlumno'))
			->with( 'list', ProcedenciaAlumno::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProcedenciaAlumno $procedenciaAlumno)
	{
		$procedenciaAlumno=$procedenciaAlumno->find($id);
		return view('procedenciaAlumnos.duplicate', compact('procedenciaAlumno'))
			->with( 'list', ProcedenciaAlumno::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProcedenciaAlumno $procedenciaAlumno, updateProcedenciaAlumno $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$procedenciaAlumno=$procedenciaAlumno->find($id);
		$procedenciaAlumno->update( $input );

		return redirect()->route('procedenciaAlumnos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProcedenciaAlumno $procedenciaAlumno)
	{
		$procedenciaAlumno=$procedenciaAlumno->find($id);
		$procedenciaAlumno->delete();

		return redirect()->route('procedenciaAlumnos.index')->with('message', 'Registro Borrado.');
	}

}
