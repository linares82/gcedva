<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PeridoExaman;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePeridoExaman;
use App\Http\Requests\createPeridoExaman;

class PeridoExamensController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$peridoExamens = PeridoExaman::getAllData($request);

		return view('peridoExamens.index', compact('peridoExamens'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('peridoExamens.create')
			->with( 'list', PeridoExaman::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPeridoExaman $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PeridoExaman::create( $input );

		return redirect()->route('peridoExamens.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PeridoExaman $peridoExaman)
	{
		$peridoExaman=$peridoExaman->find($id);
		return view('peridoExamens.show', compact('peridoExaman'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PeridoExaman $peridoExaman)
	{
		$peridoExaman=$peridoExaman->find($id);
		return view('peridoExamens.edit', compact('peridoExaman'))
			->with( 'list', PeridoExaman::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PeridoExaman $peridoExaman)
	{
		$peridoExaman=$peridoExaman->find($id);
		return view('peridoExamens.duplicate', compact('peridoExaman'))
			->with( 'list', PeridoExaman::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PeridoExaman $peridoExaman, updatePeridoExaman $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$peridoExaman=$peridoExaman->find($id);
		$peridoExaman->update( $input );

		return redirect()->route('peridoExamens.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PeridoExaman $peridoExaman)
	{
		$peridoExaman=$peridoExaman->find($id);
		$peridoExaman->delete();

		return redirect()->route('peridoExamens.index')->with('message', 'Registro Borrado.');
	}

}
