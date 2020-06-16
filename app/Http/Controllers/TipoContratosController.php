<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TipoContrato;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTipoContrato;
use App\Http\Requests\createTipoContrato;

class TipoContratosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tipoContratos = TipoContrato::getAllData($request);

		return view('tipoContratos.index', compact('tipoContratos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipoContratos.create')
			->with( 'list', TipoContrato::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTipoContrato $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TipoContrato::create( $input );

		return redirect()->route('tipoContratos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TipoContrato $tipoContrato)
	{
		$tipoContrato=$tipoContrato->find($id);
		return view('tipoContratos.show', compact('tipoContrato'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TipoContrato $tipoContrato)
	{
		$tipoContrato=$tipoContrato->find($id);
		return view('tipoContratos.edit', compact('tipoContrato'))
			->with( 'list', TipoContrato::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TipoContrato $tipoContrato)
	{
		$tipoContrato=$tipoContrato->find($id);
		return view('tipoContratos.duplicate', compact('tipoContrato'))
			->with( 'list', TipoContrato::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TipoContrato $tipoContrato, updateTipoContrato $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tipoContrato=$tipoContrato->find($id);
		$tipoContrato->update( $input );

		return redirect()->route('tipoContratos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TipoContrato $tipoContrato)
	{
		$tipoContrato=$tipoContrato->find($id);
		$tipoContrato->delete();

		return redirect()->route('tipoContratos.index')->with('message', 'Registro Borrado.');
	}

}
