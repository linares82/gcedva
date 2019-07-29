<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DocPlantelPlantel;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDocPlantelPlantel;
use App\Http\Requests\createDocPlantelPlantel;

class DocPlantelPlantelsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$docPlantelPlantels = DocPlantelPlantel::getAllData($request);

		return view('docPlantelPlantels.index', compact('docPlantelPlantels'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('docPlantelPlantels.create')
			->with( 'list', DocPlantelPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDocPlantelPlantel $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		DocPlantelPlantel::create( $input );

		return redirect()->route('docPlantelPlantels.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, DocPlantelPlantel $docPlantelPlantel)
	{
		$docPlantelPlantel=$docPlantelPlantel->find($id);
		return view('docPlantelPlantels.show', compact('docPlantelPlantel'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, DocPlantelPlantel $docPlantelPlantel)
	{
		$docPlantelPlantel=$docPlantelPlantel->find($id);
		return view('docPlantelPlantels.edit', compact('docPlantelPlantel'))
			->with( 'list', DocPlantelPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, DocPlantelPlantel $docPlantelPlantel)
	{
		$docPlantelPlantel=$docPlantelPlantel->find($id);
		return view('docPlantelPlantels.duplicate', compact('docPlantelPlantel'))
			->with( 'list', DocPlantelPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, DocPlantelPlantel $docPlantelPlantel, updateDocPlantelPlantel $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$docPlantelPlantel=$docPlantelPlantel->find($id);
		$docPlantelPlantel->update( $input );

		return redirect()->route('docPlantelPlantels.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,DocPlantelPlantel $docPlantelPlantel)
	{
		$docPlantelPlantel=$docPlantelPlantel->find($id);
		$docPlantelPlantel->delete();

		return redirect()->route('docPlantelPlantels.index')->with('message', 'Registro Borrado.');
	}

}
