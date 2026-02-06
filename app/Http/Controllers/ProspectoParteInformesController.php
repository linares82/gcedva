<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoParteInforme;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoParteInforme;
use App\Http\Requests\createProspectoParteInforme;

class ProspectoParteInformesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoParteInformes = ProspectoParteInforme::getAllData($request);

		return view('prospectoParteInformes.index', compact('prospectoParteInformes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoParteInformes.create')
			->with( 'list', ProspectoParteInforme::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoParteInforme $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoParteInforme::create( $input );

		return redirect()->route('prospectoParteInformes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoParteInforme $prospectoParteInforme)
	{
		$prospectoParteInforme=$prospectoParteInforme->find($id);
		return view('prospectoParteInformes.show', compact('prospectoParteInforme'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoParteInforme $prospectoParteInforme)
	{
		$prospectoParteInforme=$prospectoParteInforme->find($id);
		return view('prospectoParteInformes.edit', compact('prospectoParteInforme'))
			->with( 'list', ProspectoParteInforme::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoParteInforme $prospectoParteInforme)
	{
		$prospectoParteInforme=$prospectoParteInforme->find($id);
		return view('prospectoParteInformes.duplicate', compact('prospectoParteInforme'))
			->with( 'list', ProspectoParteInforme::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoParteInforme $prospectoParteInforme, updateProspectoParteInforme $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoParteInforme=$prospectoParteInforme->find($id);
		$prospectoParteInforme->update( $input );

		return redirect()->route('prospectoParteInformes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoParteInforme $prospectoParteInforme)
	{
		$prospectoParteInforme=$prospectoParteInforme->find($id);
		$prospectoParteInforme->delete();

		return redirect()->route('prospectoParteInformes.index')->with('message', 'Registro Borrado.');
	}

}
