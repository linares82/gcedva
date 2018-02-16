<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CcuestionarioRespuestum;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCcuestionarioRespuestum;
use App\Http\Requests\createCcuestionarioRespuestum;

class CcuestionarioRespuestasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ccuestionarioRespuestas = CcuestionarioRespuestum::getAllData($request);

		return view('ccuestionarioRespuestas.index', compact('ccuestionarioRespuestas'));
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
		return view('ccuestionarioRespuestas.create', compact('cuestionario', 'pregunta'))
			->with( 'list', CcuestionarioRespuestum::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCcuestionarioRespuestum $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CcuestionarioRespuestum::create( $input );

		return redirect()->route('ccuestionarios.show', $input['ccuestionario_id'])->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CcuestionarioRespuestum $ccuestionarioRespuestum)
	{
		$ccuestionarioRespuestum=$ccuestionarioRespuestum->find($id);
		return view('ccuestionarioRespuestas.show', compact('ccuestionarioRespuestum'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CcuestionarioRespuestum $ccuestionarioRespuestum)
	{
		$ccuestionarioRespuestum=$ccuestionarioRespuestum->find($id);
                $cuestionario=$ccuestionarioRespuestum->cuestionario_id;
                $pregunta=$ccuestionarioRespuestum->pregunta_id;
		return view('ccuestionarioRespuestas.edit', compact('ccuestionarioRespuestum','cuestionario', 'pregunta'))
			->with( 'list', CcuestionarioRespuestum::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CcuestionarioRespuestum $ccuestionarioRespuestum)
	{
		$ccuestionarioRespuestum=$ccuestionarioRespuestum->find($id);
		return view('ccuestionarioRespuestas.duplicate', compact('ccuestionarioRespuestum'))
			->with( 'list', CcuestionarioRespuestum::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CcuestionarioRespuestum $ccuestionarioRespuestum, updateCcuestionarioRespuestum $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ccuestionarioRespuestum=$ccuestionarioRespuestum->find($id);
		$ccuestionarioRespuestum->update( $input );

		return redirect()->route('ccuestionarios.show', $input['ccuestionario_id'])->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CcuestionarioRespuestum $ccuestionarioRespuestum)
	{
		$ccuestionarioRespuestum=$ccuestionarioRespuestum->find($id);
                $cuestionario=$ccuestionarioRespuestum->ccuestionario_id;
		$ccuestionarioRespuestum->delete();

		return redirect()->route('ccuestionarios.show', $cuestionario)->with('message', 'Registro Borrado.');
	}

}
