<?php namespace App\Http\Controllers;

use Auth;
use App\Plantel;

use App\SepMaterium;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createSepMaterium;
use App\Http\Requests\updateSepMaterium;

class SepMateriasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepMaterias = SepMaterium::getAllData($request);
		

		return view('sepMaterias.index', compact('sepMaterias'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$plantels=Plantel::pluck('razon','id');
		return view('sepMaterias.create', compact('plantels'))
			->with( 'list', SepMaterium::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepMaterium $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepMaterium::create( $input );

		return redirect()->route('sepMaterias.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepMaterium $sepMaterium)
	{
		$sepMaterium=$sepMaterium->find($id);
		return view('sepMaterias.show', compact('sepMaterium'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepMaterium $sepMaterium)
	{
		$plantels=Plantel::pluck('razon','id');
		$sepMaterium=$sepMaterium->find($id);
		return view('sepMaterias.edit', compact('sepMaterium','plantels'))
			->with( 'list', SepMaterium::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepMaterium $sepMaterium)
	{
		$sepMaterium=$sepMaterium->find($id);
		return view('sepMaterias.duplicate', compact('sepMaterium'))
			->with( 'list', SepMaterium::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepMaterium $sepMaterium, updateSepMaterium $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepMaterium=$sepMaterium->find($id);
		$sepMaterium->update( $input );

		return redirect()->route('sepMaterias.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepMaterium $sepMaterium)
	{
		$sepMaterium=$sepMaterium->find($id);
		$sepMaterium->delete();

		return redirect()->route('sepMaterias.index')->with('message', 'Registro Borrado.');
	}

}
