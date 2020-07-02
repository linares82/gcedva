<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ConceptoMultipago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateConceptoMultipago;
use App\Http\Requests\createConceptoMultipago;

class ConceptoMultipagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$conceptoMultipagos = ConceptoMultipago::getAllData($request);

		return view('conceptoMultipagos.index', compact('conceptoMultipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('conceptoMultipagos.create')
			->with( 'list', ConceptoMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createConceptoMultipago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ConceptoMultipago::create( $input );

		return redirect()->route('conceptoMultipagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ConceptoMultipago $conceptoMultipago)
	{
		$conceptoMultipago=$conceptoMultipago->find($id);
		return view('conceptoMultipagos.show', compact('conceptoMultipago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ConceptoMultipago $conceptoMultipago)
	{
		$conceptoMultipago=$conceptoMultipago->find($id);
		return view('conceptoMultipagos.edit', compact('conceptoMultipago'))
			->with( 'list', ConceptoMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ConceptoMultipago $conceptoMultipago)
	{
		$conceptoMultipago=$conceptoMultipago->find($id);
		return view('conceptoMultipagos.duplicate', compact('conceptoMultipago'))
			->with( 'list', ConceptoMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ConceptoMultipago $conceptoMultipago, updateConceptoMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$conceptoMultipago=$conceptoMultipago->find($id);
		$conceptoMultipago->update( $input );

		return redirect()->route('conceptoMultipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ConceptoMultipago $conceptoMultipago)
	{
		$conceptoMultipago=$conceptoMultipago->find($id);
		$conceptoMultipago->delete();

		return redirect()->route('conceptoMultipagos.index')->with('message', 'Registro Borrado.');
	}

}
