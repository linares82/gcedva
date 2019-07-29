<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DocPlantel;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDocPlantel;
use App\Http\Requests\createDocPlantel;

class DocPlantelsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$docPlantels = DocPlantel::getAllData($request);

		return view('docPlantels.index', compact('docPlantels'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('docPlantels.create')
			->with( 'list', DocPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDocPlantel $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

                if(!isset($input['bnd_obligatorio'])){
                    $input['bnd_obligatorio']=0;
                }
                
		//create data
		DocPlantel::create( $input );

		return redirect()->route('docPlantels.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, DocPlantel $docPlantel)
	{
		$docPlantel=$docPlantel->find($id);
		return view('docPlantels.show', compact('docPlantel'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, DocPlantel $docPlantel)
	{
		$docPlantel=$docPlantel->find($id);
		return view('docPlantels.edit', compact('docPlantel'))
			->with( 'list', DocPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, DocPlantel $docPlantel)
	{
		$docPlantel=$docPlantel->find($id);
		return view('docPlantels.duplicate', compact('docPlantel'))
			->with( 'list', DocPlantel::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, DocPlantel $docPlantel, updateDocPlantel $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
                if(!isset($input['bnd_obligatorio'])){
                    $input['bnd_obligatorio']=0;
                }
		//update data
		$docPlantel=$docPlantel->find($id);
		$docPlantel->update( $input );

		return redirect()->route('docPlantels.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,DocPlantel $docPlantel)
	{
		$docPlantel=$docPlantel->find($id);
		$docPlantel->delete();

		return redirect()->route('docPlantels.index')->with('message', 'Registro Borrado.');
	}

}
