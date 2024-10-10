<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SeccionesCat;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSeccion;
use App\Http\Requests\createSeccion;

class SeccionesCatsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$seccionesCats = SeccionesCat::getAllData($request);

		return view('seccionesCat.index', compact('seccionesCats'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('seccionesCat.create')
			->with( 'list', SeccionesCat::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSeccion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SeccionesCat::create( $input );

		return redirect()->route('seccionesCats.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$seccionCat=SeccionesCat::find($id);
		return view('seccionesCat.show', compact('seccionCat'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$seccionCat=SeccionesCat::find($id);
		return view('seccionesCat.edit', compact('seccionCat'))
			->with( 'list', SeccionesCat::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SeccionesCat $seccionCat)
	{
		$seccionCat=$seccionCat->find($id);
		return view('seccionesCat.duplicate', compact('seccionCat'))
			->with( 'list', SeccionesCat::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SeccionesCat $seccionCat, updateSeccion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		if(isset($input['bnd_tramite'])){
			$input['bnd_tramite']=1;
		}else{
			$input['bnd_tramite']=0;
		}
		//update data
		$seccionCat=$seccionCat->find($id);
		$seccionCat->update( $input );

		return redirect()->route('seccionesCats.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SeccionesCat $seccionCat)
	{
		$seccionCat=$seccionCat->find($id);
		$seccionCat->delete();

		return redirect()->route('seccionesCats.index')->with('message', 'Registro Borrado.');
	}

}
