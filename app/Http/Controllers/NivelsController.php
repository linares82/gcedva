<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Nivel;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateNivel;
use App\Http\Requests\createNivel;

class NivelsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$nivels = Nivel::getAllData($request);

		return view('nivels.index', compact('nivels'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('nivels.create')
			->with( 'list', Nivel::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createNivel $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Nivel::create( $input );

		return redirect()->route('nivels.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Nivel $nivel)
	{
		$nivel=$nivel->find($id);
		return view('nivels.show', compact('nivel'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Nivel $nivel)
	{
		$nivel=$nivel->find($id);
		return view('nivels.edit', compact('nivel'))
			->with( 'list', Nivel::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Nivel $nivel)
	{
		$nivel=$nivel->find($id);
		return view('nivels.duplicate', compact('nivel'))
			->with( 'list', Nivel::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Nivel $nivel, updateNivel $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$nivel=$nivel->find($id);
		$nivel->update( $input );

		return redirect()->route('nivels.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Nivel $nivel)
	{
		$nivel=$nivel->find($id);
		$nivel->delete();

		return redirect()->route('nivels.index')->with('message', 'Registro Borrado.');
	}

	public function getCmbGrados($id=0){
		//dd($_REQUEST['estado']);
		$e = $_REQUEST['nivel'];
        $grados = Nivel::find($e)->grados;
        //dd($municipios);
        return $grados->pluck('name', 'id');

	}

}