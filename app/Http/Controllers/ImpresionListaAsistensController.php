<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ImpresionListaAsisten;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateImpresionListaAsisten;
use App\Http\Requests\createImpresionListaAsisten;

class ImpresionListaAsistensController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$impresionListaAsistens = ImpresionListaAsisten::getAllData($request);

		return view('impresionListaAsistens.index', compact('impresionListaAsistens'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('impresionListaAsistens.create')
			->with( 'list', ImpresionListaAsisten::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createImpresionListaAsisten $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ImpresionListaAsisten::create( $input );

		return redirect()->route('impresionListaAsistens.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ImpresionListaAsisten $impresionListaAsisten)
	{
		$impresionListaAsisten=$impresionListaAsisten->find($id);
		return view('impresionListaAsistens.show', compact('impresionListaAsisten'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ImpresionListaAsisten $impresionListaAsisten)
	{
		$impresionListaAsisten=$impresionListaAsisten->find($id);
		return view('impresionListaAsistens.edit', compact('impresionListaAsisten'))
			->with( 'list', ImpresionListaAsisten::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ImpresionListaAsisten $impresionListaAsisten)
	{
		$impresionListaAsisten=$impresionListaAsisten->find($id);
		return view('impresionListaAsistens.duplicate', compact('impresionListaAsisten'))
			->with( 'list', ImpresionListaAsisten::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ImpresionListaAsisten $impresionListaAsisten, updateImpresionListaAsisten $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$impresionListaAsisten=$impresionListaAsisten->find($id);
		$impresionListaAsisten->update( $input );

		return redirect()->route('impresionListaAsistens.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ImpresionListaAsisten $impresionListaAsisten)
	{
		$impresionListaAsisten=$impresionListaAsisten->find($id);
		$impresionListaAsisten->delete();

		return redirect()->route('impresionListaAsistens.index')->with('message', 'Registro Borrado.');
	}

}
