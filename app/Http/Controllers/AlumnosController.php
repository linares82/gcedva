<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Alumno;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAlumno;
use App\Http\Requests\createAlumno;

class AlumnosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$alumnos = Alumno::getAllData($request);

		return view('alumnos.index', compact('alumnos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('alumnos.create')
			->with( 'list', Alumno::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAlumno $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Alumno::create( $input );

		return redirect()->route('alumnos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Alumno $alumno)
	{
		$alumno=$alumno->find($id);
		return view('alumnos.show', compact('alumno'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Alumno $alumno)
	{
		$alumno=$alumno->find($id);
		return view('alumnos.edit', compact('alumno'))
			->with( 'list', Alumno::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Alumno $alumno)
	{
		$alumno=$alumno->find($id);
		return view('alumnos.duplicate', compact('alumno'))
			->with( 'list', Alumno::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Alumno $alumno, updateAlumno $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$alumno=$alumno->find($id);
		$alumno->update( $input );

		return redirect()->route('alumnos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Alumno $alumno)
	{
		$alumno=$alumno->find($id);
		$alumno->delete();

		return redirect()->route('alumnos.index')->with('message', 'Registro Borrado.');
	}

}
