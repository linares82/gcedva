<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FacturaGLinea;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFacturaGLinea;
use App\Http\Requests\createFacturaGLinea;

class FacturaGLineasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$facturaGLineas = FacturaGLinea::getAllData($request);

		return view('facturaGLineas.index', compact('facturaGLineas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('facturaGLineas.create')
			->with( 'list', FacturaGLinea::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFacturaGLinea $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		FacturaGLinea::create( $input );

		return redirect()->route('facturaGLineas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FacturaGLinea $facturaGLinea)
	{
		$facturaGLinea=$facturaGLinea->find($id);
		return view('facturaGLineas.show', compact('facturaGLinea'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FacturaGLinea $facturaGLinea)
	{
		$facturaGLinea=$facturaGLinea->find($id);
		return view('facturaGLineas.edit', compact('facturaGLinea'))
			->with( 'list', FacturaGLinea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaGLinea $facturaGLinea)
	{
		$facturaGLinea=$facturaGLinea->find($id);
		return view('facturaGLineas.duplicate', compact('facturaGLinea'))
			->with( 'list', FacturaGLinea::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FacturaGLinea $facturaGLinea, updateFacturaGLinea $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$facturaGLinea=$facturaGLinea->find($id);
		$facturaGLinea->update( $input );

		return redirect()->route('facturaGLineas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FacturaGLinea $facturaGLinea)
	{
		$facturaGLinea=$facturaGLinea->find($id);
		$facturaGLinea->delete();

		return redirect()->route('facturaGLineas.index')->with('message', 'Registro Borrado.');
	}

	public function bndIncluir(Request $request){
		$datos=$request->all();

		$linea=FacturaGLinea::find($datos['id']);
		$linea->bnd_incluido=$datos['valor'];
		$linea->save();

		return $linea;
	}

}
