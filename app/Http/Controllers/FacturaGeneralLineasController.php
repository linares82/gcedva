<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FacturaGeneralLinea;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFacturaGeneralLinea;
use App\Http\Requests\createFacturaGeneralLinea;

class FacturaGeneralLineasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$facturaGeneralLineas = FacturaGeneralLinea::getAllData($request);

		return view('facturaGeneralLineas.index', compact('facturaGeneralLineas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$datos=$request->all();
		
		$facturaGeneral=$datos['facturaGeneral'];
		return view('facturaGeneralLineas.create', compact('facturaGeneral'))
			->with( 'list', FacturaGeneralLinea::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFacturaGeneralLinea $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['bnd_incluido']=1;
		$input['bnd_manual']=1;

		//create data
		$facturaGeneralLinea=FacturaGeneralLinea::create( $input );

		return redirect()->route('facturaGenerals.detalle',$facturaGeneralLinea->factura_general_id)
		->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FacturaGeneralLinea $facturaGeneralLinea)
	{
		$facturaGeneralLinea=$facturaGeneralLinea->find($id);
		return view('facturaGeneralLineas.show', compact('facturaGeneralLinea'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FacturaGeneralLinea $facturaGeneralLinea)
	{
		$facturaGeneralLinea=$facturaGeneralLinea->find($id);
		return view('facturaGeneralLineas.edit', compact('facturaGeneralLinea'))
			->with( 'list', FacturaGeneralLinea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaGeneralLinea $facturaGeneralLinea)
	{
		$facturaGeneralLinea=$facturaGeneralLinea->find($id);
		return view('facturaGeneralLineas.duplicate', compact('facturaGeneralLinea'))
			->with( 'list', FacturaGeneralLinea::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FacturaGeneralLinea $facturaGeneralLinea, updateFacturaGeneralLinea $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$facturaGeneralLinea=$facturaGeneralLinea->find($id);
		$facturaGeneralLinea->update( $input );

		return redirect()->route('facturaGeneralLineas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FacturaGeneralLinea $facturaGeneralLinea)
	{
		$facturaGeneralLinea=$facturaGeneralLinea->find($id);
		$facturaGeneral=$facturaGeneralLinea->factura_general_id;
		$facturaGeneralLinea->delete();

		return redirect()->route('facturaGenerals.detalle', $facturaGeneral)->with('message', 'Registro Borrado.');
	}

	public function bndIncluir(Request $request){
		$datos=$request->all();

		$linea=FacturaGeneralLinea::find($datos['id']);
		$linea->bnd_incluido=$datos['valor'];
		$linea->save();

		return $linea;
	}
}
