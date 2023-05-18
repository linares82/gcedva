<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Inventario;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateInventario;
use App\Http\Requests\createInventario;

class InventariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inventarios = Inventario::getAllData($request);
		

		return view('inventarios.index', compact('inventarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inventarios.create')
			->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInventario $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Inventario::create( $input );

		return redirect()->route('inventarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		return view('inventarios.show', compact('inventario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		$catExiste=array('SI'=>'SI', 'NO'=>'NO');
		$catEstado=array('BUENO'=>'BUENO', 'MALO'=>'MALO');
		return view('inventarios.edit', compact('inventario','catExiste', 'catEstado'))
			->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		return view('inventarios.duplicate', compact('inventario'))
			->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Inventario $inventario, updateInventario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inventario=$inventario->find($id);
		$inventario->update( $input );
		dd('Registro guardado');
		return redirect()->route('inventarioLevantamientos.show', array('q[inventario_levantamiento_id_lt]'=>$inventario->inventario_levantamiento_id))->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		$inventarioLevantamiento=$inventario->levantamiento_inventario_id;
		$inventario->delete();
		dd('Registro borrado');
		//return redirect()->route('inventarioLevantamientos.show', array('q[inventario_levantamiento_id_lt]'=>$inventarioLevantamiento) )->with('message', 'Registro Borrado.');
	}

	public function editEstado(Request $request){
		$inventario=Inventario::find($request['id']);
		$inventario->estado_bueno=$request['estado_bueno'];
		$inventario->save();
		return $inventario;
	}

	public function editExiste(Request $request){
		$inventario=Inventario::find($request['id']);
		$inventario->existe_si=$request['existe_si'];
		$inventario->save();
		return $inventario;
	}

}
