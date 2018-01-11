<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuestionarioRespuesta;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuestionarioRespuesta;
use App\Http\Requests\createCuestionarioRespuesta;

class CuestionarioRespuestasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuestionarioRespuestas = CuestionarioRespuesta::getAllData($request);

		return view('cuestionarioRespuestas.index', compact('cuestionarioRespuestas'));
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
                $pregunta=$input['pregunta'];
		return view('cuestionarioRespuestas.create', compact('cuestionario', 'pregunta'))
			->with( 'list', CuestionarioRespuesta::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuestionarioRespuesta $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CuestionarioRespuesta::create( $input );

		return redirect()->route('cuestionarios.show', $input['cuestionario_id'])->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuestionarioRespuesta $cuestionarioRespuesta)
	{
		$cuestionarioRespuesta=$cuestionarioRespuesta->find($id);
		return view('cuestionarioRespuestas.show', compact('cuestionarioRespuesta'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuestionarioRespuesta $cuestionarioRespuesta)
	{
		$cuestionarioRespuesta=$cuestionarioRespuesta->find($id);
                $cuestionario=$cuestionarioRespuesta->cuestionario_id;
                $pregunta=$cuestionarioRespuesta->pregunta_id;
		return view('cuestionarioRespuestas.edit', compact('cuestionarioRespuesta', 'cuestionario', 'pregunta'))
			->with( 'list', CuestionarioRespuesta::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuestionarioRespuesta $cuestionarioRespuesta)
	{
		$cuestionarioRespuesta=$cuestionarioRespuesta->find($id);
		return view('cuestionarioRespuestas.duplicate', compact('cuestionarioRespuesta'))
			->with( 'list', CuestionarioRespuesta::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuestionarioRespuesta $cuestionarioRespuesta, updateCuestionarioRespuesta $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cuestionarioRespuesta=$cuestionarioRespuesta->find($id);
		$cuestionarioRespuesta->update( $input );

		return redirect()->route('cuestionarios.show', $input['cuestionario_id'])->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuestionarioRespuesta $cuestionarioRespuesta)
	{
		$cuestionarioRespuesta=$cuestionarioRespuesta->find($id);
                $cuestionario=$cuestionarioRespuesta->cuestionario_id;
		$cuestionarioRespuesta->delete();

		return redirect()->route('cuestionarios.show',$cuestionario)->with('message', 'Registro Borrado.');
	}

}
