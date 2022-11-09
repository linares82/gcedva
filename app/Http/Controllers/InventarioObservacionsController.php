<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;

use App\PlantelInventario;
use Illuminate\Http\Request;
use App\InventarioObservacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\createInventarioObservacion;
use App\Http\Requests\updateInventarioObservacion;

class InventarioObservacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inventarioObservacions = InventarioObservacion::getAllData($request);

		return view('inventarioObservacions.index', compact('inventarioObservacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$inventarioLevantamiento=$request->input('inventarioLevantamiento');
		
		$planteles=PlantelInventario::pluck('name','id');
		return view('inventarioObservacions.create', compact('inventarioLevantamiento','planteles'))
			->with( 'list', InventarioObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInventarioObservacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$inventarioObservacion=InventarioObservacion::create( $input );

		return redirect()->route('inventarioLevantamientos.index', $inventarioObservacion->inventarioLevantamiento_id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, InventarioObservacion $inventarioObservacion)
	{
		$inventarioObservacion=$inventarioObservacion->find($id);
		return view('inventarioObservacions.show', compact('inventarioObservacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, InventarioObservacion $inventarioObservacion)
	{
		$inventarioObservacion=$inventarioObservacion->find($id);
		return view('inventarioObservacions.edit', compact('inventarioObservacion'))
			->with( 'list', InventarioObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, InventarioObservacion $inventarioObservacion)
	{
		$inventarioObservacion=$inventarioObservacion->find($id);
		return view('inventarioObservacions.duplicate', compact('inventarioObservacion'))
			->with( 'list', InventarioObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, InventarioObservacion $inventarioObservacion, updateInventarioObservacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inventarioObservacion=$inventarioObservacion->find($id);
		$inventarioObservacion->update( $input );

		return redirect()->route('inventarioObservacions.index', array('q[inventario_levantamiento_id_lt]'=>$inventarioObservacion->inventario_levantamiento_id))->with('message', 'Registro Actualizado.');
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,InventarioObservacion $inventarioObservacion)
	{
		$inventarioObservacion=$inventarioObservacion->find($id);
		$inventarioObservacion->delete();

		return redirect()->route('inventarioObservacions.index')->with('message', 'Registro Borrado.');
	}

}
