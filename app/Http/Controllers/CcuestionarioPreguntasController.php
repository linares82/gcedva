<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CcuestionarioPreguntum;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCcuestionarioPreguntum;
use App\Http\Requests\createCcuestionarioPreguntum;

class CcuestionarioPreguntasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ccuestionarioPreguntas = CcuestionarioPreguntum::getAllData($request);

		return view('ccuestionarioPreguntas.index', compact('ccuestionarioPreguntas'));
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
                
		return view('ccuestionarioPreguntas.create', compact('cuestionario'))
			->with( 'list', CcuestionarioPreguntum::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCcuestionarioPreguntum $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CcuestionarioPreguntum::create( $input );

		return redirect()->route('ccuestionarios.show', $input['ccuestionario_id'])->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CcuestionarioPreguntum $ccuestionarioPreguntum)
	{
		$ccuestionarioPreguntum=$ccuestionarioPreguntum->find($id);
		return view('ccuestionarioPreguntas.show', compact('ccuestionarioPreguntum'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CcuestionarioPreguntum $ccuestionarioPreguntum)
	{
		$ccuestionarioPreguntum=$ccuestionarioPreguntum->find($id);
                $cuestionario=$ccuestionarioPreguntum->ccuestionario_id;
		return view('ccuestionarioPreguntas.edit', compact('ccuestionarioPreguntum','cuestionario'))
			->with( 'list', CcuestionarioPreguntum::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CcuestionarioPreguntum $ccuestionarioPreguntum)
	{
		$ccuestionarioPreguntum=$ccuestionarioPreguntum->find($id);
		return view('ccuestionarioPreguntas.duplicate', compact('ccuestionarioPreguntum'))
			->with( 'list', CcuestionarioPreguntum::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CcuestionarioPreguntum $ccuestionarioPreguntum, updateCcuestionarioPreguntum $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ccuestionarioPreguntum=$ccuestionarioPreguntum->find($id);
		$ccuestionarioPreguntum->update( $input );

		return redirect()->route('ccuestionarios.show', $input['ccuestionario_id'])->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CcuestionarioPreguntum $ccuestionarioPreguntum)
	{
		$ccuestionarioPreguntum=$ccuestionarioPreguntum->find($id);
                //dd($ccuestionarioPreguntum);
		$cuestionario=$ccuestionarioPreguntum->ccuestionario_id;
                $ccuestionarioPreguntum->delete();

		return redirect()->route('ccuestionarios.show', $cuestionario)->with('message', 'Registro Borrado.');
	}

}
