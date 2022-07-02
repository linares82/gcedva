<?php namespace App\Http\Controllers;

use Auth;
use App\FacturaG;

use App\FacturaGLinea;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createFacturaGLinea;
use App\Http\Requests\updateFacturaGLinea;

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
	public function create(Request $request)
	{
		$datos=$request->all();
		$factura_g=$datos['factura_g'];
		$facturaCabecera=FacturaG::find($datos['factura_g']);
	
		return view('facturaGLineas.create', compact('factura_g', 'facturaCabecera'))
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
		$input['origen']='Manual';
		$input['bnd_incluido']=1;
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		FacturaGLinea::create( $input );

		return redirect()->route('facturaGs.show', $input['factura_g_id'])->with('message', 'Registro Creado.');
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
		$facturaCabecera=FacturaG::find($facturaGLinea->factura_g_id);
		return view('facturaGLineas.edit', compact('facturaGLinea', 'facturaCabecera'))
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
		$new_facturaGLinea=$facturaGLinea->replicate();
		$new_facturaGLinea->save();
		return redirect()->route('facturaGs.show',$facturaGLinea->factura_g_id)->with('message', 'Registro Actualizado.');
		/*return view('facturaGLineas.duplicate', compact('facturaGLinea'))
			->with( 'list', FacturaGLinea::getListFromAllRelationApps() );
			*/
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

		return redirect()->route('facturaGs.show',$facturaGLinea->factura_g_id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$facturaGLinea=FacturaGLinea::find($id);
		$factura_g_id=$facturaGLinea->factura_g_id;
		$facturaGLinea->delete();

		return redirect()->route('facturaGs.show',$factura_g_id)->with('message', 'Registro Borrado.');
	}

	public function bndIncluir(Request $request){
		$datos=$request->all();

		$linea=FacturaGLinea::find($datos['id']);
		$linea->bnd_incluido=$datos['valor'];
		$linea->save();

		return $linea;
	}

	public function editFolio(Request $request){
		$datos=$request->all();
		if($request->ajax()){
			$linea=FacturaGLinea::find($datos['id']);
			$linea->folio=$datos['noIdentificacion'];
			$linea->save();
			return $linea;
		}

	}
}
