<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DocVinculacionVinculacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDocVinculacionVinculacion;
use App\Http\Requests\createDocVinculacionVinculacion;

class DocVinculacionVinculacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$docVinculacionVinculacions = DocVinculacionVinculacion::getAllData($request);

		return view('docVinculacionVinculacions.index', compact('docVinculacionVinculacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('docVinculacionVinculacions.create')
			->with( 'list', DocVinculacionVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDocVinculacionVinculacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		DocVinculacionVinculacion::create( $input );

		return redirect()->route('docVinculacionVinculacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, DocVinculacionVinculacion $docVinculacionVinculacion)
	{
		$docVinculacionVinculacion=$docVinculacionVinculacion->find($id);
		return view('docVinculacionVinculacions.show', compact('docVinculacionVinculacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, DocVinculacionVinculacion $docVinculacionVinculacion)
	{
		$docVinculacionVinculacion=$docVinculacionVinculacion->find($id);
		return view('docVinculacionVinculacions.edit', compact('docVinculacionVinculacion'))
			->with( 'list', DocVinculacionVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, DocVinculacionVinculacion $docVinculacionVinculacion)
	{
		$docVinculacionVinculacion=$docVinculacionVinculacion->find($id);
		return view('docVinculacionVinculacions.duplicate', compact('docVinculacionVinculacion'))
			->with( 'list', DocVinculacionVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, DocVinculacionVinculacion $docVinculacionVinculacion, updateDocVinculacionVinculacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$docVinculacionVinculacion=$docVinculacionVinculacion->find($id);
		$docVinculacionVinculacion->update( $input );

		return redirect()->route('docVinculacionVinculacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,DocVinculacionVinculacion $docVinculacionVinculacion)
	{
		$docVinculacionVinculacion=$docVinculacionVinculacion->find($id);
                $vinculacion=$docVinculacionVinculacion->vinculacion_id;
		$docVinculacionVinculacion->delete();

		return redirect()->route('vinculacions.edit',$vinculacion)->with('message', 'Registro Borrado.');
	}

}
