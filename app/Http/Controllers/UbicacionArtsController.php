<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UbicacionArt;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateUbicacionArt;
use App\Http\Requests\createUbicacionArt;
use DB;

class UbicacionArtsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ubicacionArts = UbicacionArt::getAllData($request);

		return view('ubicacionArts.index', compact('ubicacionArts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ubicacionArts.create')
			->with( 'list', UbicacionArt::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createUbicacionArt $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		UbicacionArt::create( $input );

		return redirect()->route('ubicacionArts.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, UbicacionArt $ubicacionArt)
	{
		$ubicacionArt=$ubicacionArt->find($id);
		return view('ubicacionArts.show', compact('ubicacionArt'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, UbicacionArt $ubicacionArt)
	{
		$ubicacionArt=$ubicacionArt->find($id);
		return view('ubicacionArts.edit', compact('ubicacionArt'))
			->with( 'list', UbicacionArt::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, UbicacionArt $ubicacionArt)
	{
		$ubicacionArt=$ubicacionArt->find($id);
		return view('ubicacionArts.duplicate', compact('ubicacionArt'))
			->with( 'list', UbicacionArt::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, UbicacionArt $ubicacionArt, updateUbicacionArt $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ubicacionArt=$ubicacionArt->find($id);
		$ubicacionArt->update( $input );

		return redirect()->route('ubicacionArts.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,UbicacionArt $ubicacionArt)
	{
		$ubicacionArt=$ubicacionArt->find($id);
		$ubicacionArt->delete();

		return redirect()->route('ubicacionArts.index')->with('message', 'Registro Borrado.');
	}

	public function getUbicacionesXPlantel(Request $request){
		if($request->ajax()){
			$datos=$request->all();
			$final = array();
			$r = DB::table('ubicacion_arts as u')
				->select('u.id', 'u.ubicacion as name')
				->where('u.plantel_id', '=', $datos['plantel'])
				->where('u.id', '>', '0')
				->get();
			//dd($r);
			if (isset($datos['ubicacion']) and $datos['ubicacion'] <> 0) {
				foreach ($r as $r1) {
					if ($r1->id == $datos['ubicacion']) {
						array_push($final, array(
							'id' => $r1->id,
							'name' => $r1->name,
							'selectec' => 'Selected'
						));
					} else {
						array_push($final, array(
							'id' => $r1->id,
							'name' => $r1->name,
							'selectec' => ''
						));
					}
				}
				return $final;
			} else {
				return $r;
			}
		}
	}
}
