<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuestionarioPregunta;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuestionarioPregunta;
use App\Http\Requests\createCuestionarioPregunta;

class CuestionarioPreguntasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuestionarioPreguntas = CuestionarioPregunta::getAllData($request);

		return view('cuestionarioPreguntas.index', compact('cuestionarioPreguntas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
                $input=$request->all();
                $cuestionario=$input['cuestionario'];
                //dd($input);
		return view('cuestionarioPreguntas.create', compact('cuestionario'))
			->with( 'list', CuestionarioPregunta::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuestionarioPregunta $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CuestionarioPregunta::create( $input );

		return redirect()->route('cuestionarios.show', $input['cuestionario_id'])->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuestionarioPregunta $cuestionarioPregunta)
	{
		$cuestionarioPregunta=$cuestionarioPregunta->find($id);
		return view('cuestionarioPreguntas.show', compact('cuestionarioPregunta'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuestionarioPregunta $cuestionarioPregunta)
	{
		$cuestionarioPregunta=$cuestionarioPregunta->find($id);
                $cuestionario=$cuestionarioPregunta->cuestionario_id;
		return view('cuestionarioPreguntas.edit', compact('cuestionarioPregunta', 'cuestionario'))
			->with( 'list', CuestionarioPregunta::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuestionarioPregunta $cuestionarioPregunta)
	{
		$cuestionarioPregunta=$cuestionarioPregunta->find($id);
		return view('cuestionarioPreguntas.duplicate', compact('cuestionarioPregunta'))
			->with( 'list', CuestionarioPregunta::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuestionarioPregunta $cuestionarioPregunta, updateCuestionarioPregunta $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cuestionarioPregunta=$cuestionarioPregunta->find($id);
		$cuestionarioPregunta->update( $input );

		return redirect()->route('cuestionarios.show', $input['cuestionario_id'])->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuestionarioPregunta $cuestionarioPregunta)
	{
		$cuestionarioPregunta=$cuestionarioPregunta->find($id);
		$cuestionario=$cuestionarioPregunta->cuestionario_id;
                $cuestionarioPregunta->delete();

		return redirect()->route('cuestionarios.show', $cuestionario)->with('message', 'Registro Borrado.');
	}

}
