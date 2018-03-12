<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PagosLectivosLn;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePagosLectivosLn;
use App\Http\Requests\createPagosLectivosLn;

class PagosLectivosLnsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$pagosLectivosLns = PagosLectivosLn::getAllData($request);

		return view('pagosLectivosLns.index', compact('pagosLectivosLns'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pagosLectivosLns.create')
			->with( 'list', PagosLectivosLn::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPagosLectivosLn $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PagosLectivosLn::create( $input );

		return redirect()->route('pagosLectivosLns.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PagosLectivosLn $pagosLectivosLn)
	{
		$pagosLectivosLn=$pagosLectivosLn->find($id);
		return view('pagosLectivosLns.show', compact('pagosLectivosLn'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PagosLectivosLn $pagosLectivosLn)
	{
		$pagosLectivosLn=$pagosLectivosLn->find($id);
		return view('pagosLectivosLns.edit', compact('pagosLectivosLn'))
			->with( 'list', PagosLectivosLn::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PagosLectivosLn $pagosLectivosLn)
	{
		$pagosLectivosLn=$pagosLectivosLn->find($id);
		return view('pagosLectivosLns.duplicate', compact('pagosLectivosLn'))
			->with( 'list', PagosLectivosLn::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PagosLectivosLn $pagosLectivosLn, updatePagosLectivosLn $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$pagosLectivosLn=$pagosLectivosLn->find($id);
		$pagosLectivosLn->update( $input );

		return redirect()->route('pagosLectivosLns.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PagosLectivosLn $pagosLectivosLn)
	{
		$pagosLectivosLn=$pagosLectivosLn->find($id);
		$pagosLectivosLn->delete();

		return redirect()->route('pagosLectivosLns.index')->with('message', 'Registro Borrado.');
	}

}
