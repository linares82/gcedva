<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HEstatus;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHEstatus;
use App\Http\Requests\createHEstatus;

class HEstatusesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hEstatuses = HEstatus::getAllData($request);

		return view('hEstatuses.index', compact('hEstatuses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hEstatuses.create')
			->with( 'list', HEstatus::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHEstatus $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HEstatus::create( $input );

		return redirect()->route('hEstatuses.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HEstatus $hEstatus)
	{
		$hEstatus=$hEstatus->find($id);
		return view('hEstatuses.show', compact('hEstatus'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HEstatus $hEstatus)
	{
		$hEstatus=$hEstatus->find($id);
		return view('hEstatuses.edit', compact('hEstatus'))
			->with( 'list', HEstatus::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HEstatus $hEstatus)
	{
		$hEstatus=$hEstatus->find($id);
		return view('hEstatuses.duplicate', compact('hEstatus'))
			->with( 'list', HEstatus::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HEstatus $hEstatus, updateHEstatus $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hEstatus=$hEstatus->find($id);
		$hEstatus->update( $input );

		return redirect()->route('hEstatuses.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HEstatus $hEstatus)
	{
		$hEstatus=$hEstatus->find($id);
		$hEstatus->delete();

		return redirect()->route('hEstatuses.index')->with('message', 'Registro Borrado.');
	}

}
