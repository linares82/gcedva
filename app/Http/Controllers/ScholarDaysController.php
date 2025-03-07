<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ScholarDay;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateScholarDay;
use App\Http\Requests\createScholarDay;

class ScholarDaysController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$scholarDays = ScholarDay::getAllData($request);

		return view('scholarDays.index', compact('scholarDays'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('scholarDays.create')
			->with( 'list', ScholarDay::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createScholarDay $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ScholarDay::create( $input );

		return redirect()->route('scholarDays.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ScholarDay $scholarDay)
	{
		$scholarDay=$scholarDay->find($id);
		return view('scholarDays.show', compact('scholarDay'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ScholarDay $scholarDay)
	{
		$scholarDay=$scholarDay->find($id);
		return view('scholarDays.edit', compact('scholarDay'))
			->with( 'list', ScholarDay::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ScholarDay $scholarDay)
	{
		$scholarDay=$scholarDay->find($id);
		return view('scholarDays.duplicate', compact('scholarDay'))
			->with( 'list', ScholarDay::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ScholarDay $scholarDay, updateScholarDay $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$scholarDay=$scholarDay->find($id);
		$scholarDay->update( $input );

		return redirect()->route('scholarDays.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ScholarDay $scholarDay)
	{
		$scholarDay=$scholarDay->find($id);
		$scholarDay->delete();

		return redirect()->route('scholarDays.index')->with('message', 'Registro Borrado.');
	}

}
