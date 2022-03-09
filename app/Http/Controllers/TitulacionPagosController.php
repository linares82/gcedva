<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TitulacionPago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTitulacionPago;
use App\Http\Requests\createTitulacionPago;

class TitulacionPagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionPagos = TitulacionPago::getAllData($request);

		return view('titulacionPagos.index', compact('titulacionPagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('titulacionPagos.create')
			->with( 'list', TitulacionPago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionPago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$pago=TitulacionPago::create( $input );
		return $pago;
		//return redirect()->route('titulacionPagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionPago $titulacionPago)
	{
		$titulacionPago=$titulacionPago->find($id);
		return view('titulacionPagos.show', compact('titulacionPago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionPago $titulacionPago)
	{
		$titulacionPago=$titulacionPago->find($id);
		return view('titulacionPagos.edit', compact('titulacionPago'))
			->with( 'list', TitulacionPago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionPago $titulacionPago)
	{
		$titulacionPago=$titulacionPago->find($id);
		return view('titulacionPagos.duplicate', compact('titulacionPago'))
			->with( 'list', TitulacionPago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TitulacionPago $titulacionPago, updateTitulacionPago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacionPago=$titulacionPago->find($id);
		$titulacionPago->update( $input );
		return $titulacionPago;
		//return redirect()->route('titulacionPagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TitulacionPago $titulacionPago)
	{
		$titulacionPago=$titulacionPago->find($id);
		$titulacion=$titulacionPago->titulacion_id;
		$titulacionPago->delete();

		return redirect()->route('titulacions.edit',$titulacion)->with('message', 'Registro Borrado.');
	}

}
