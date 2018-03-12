<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TpoInforme;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTpoInforme;
use App\Http\Requests\createTpoInforme;

class TpoInformesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tpoInformes = TpoInforme::getAllData($request);

		return view('tpoInformes.index', compact('tpoInformes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tpoInformes.create')
			->with( 'list', TpoInforme::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTpoInforme $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TpoInforme::create( $input );

		return redirect()->route('tpoInformes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TpoInforme $tpoInforme)
	{
		$tpoInforme=$tpoInforme->find($id);
		return view('tpoInformes.show', compact('tpoInforme'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TpoInforme $tpoInforme)
	{
		$tpoInforme=$tpoInforme->find($id);
		return view('tpoInformes.edit', compact('tpoInforme'))
			->with( 'list', TpoInforme::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TpoInforme $tpoInforme)
	{
		$tpoInforme=$tpoInforme->find($id);
		return view('tpoInformes.duplicate', compact('tpoInforme'))
			->with( 'list', TpoInforme::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TpoInforme $tpoInforme, updateTpoInforme $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tpoInforme=$tpoInforme->find($id);
		$tpoInforme->update( $input );

		return redirect()->route('tpoInformes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TpoInforme $tpoInforme)
	{
		$tpoInforme=$tpoInforme->find($id);
		$tpoInforme->delete();

		return redirect()->route('tpoInformes.index')->with('message', 'Registro Borrado.');
	}

}
