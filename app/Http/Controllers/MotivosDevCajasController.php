<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MotivosDevCaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMotivosDevCaja;
use App\Http\Requests\createMotivosDevCaja;

class MotivosDevCajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$motivosDevCajas = MotivosDevCaja::getAllData($request);

		return view('motivosDevCajas.index', compact('motivosDevCajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('motivosDevCajas.create')
			->with( 'list', MotivosDevCaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMotivosDevCaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		MotivosDevCaja::create( $input );

		return redirect()->route('motivosDevCajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, MotivosDevCaja $motivosDevCaja)
	{
		$motivosDevCaja=$motivosDevCaja->find($id);
		return view('motivosDevCajas.show', compact('motivosDevCaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, MotivosDevCaja $motivosDevCaja)
	{
		$motivosDevCaja=$motivosDevCaja->find($id);
		return view('motivosDevCajas.edit', compact('motivosDevCaja'))
			->with( 'list', MotivosDevCaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, MotivosDevCaja $motivosDevCaja)
	{
		$motivosDevCaja=$motivosDevCaja->find($id);
		return view('motivosDevCajas.duplicate', compact('motivosDevCaja'))
			->with( 'list', MotivosDevCaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, MotivosDevCaja $motivosDevCaja, updateMotivosDevCaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$motivosDevCaja=$motivosDevCaja->find($id);
		$motivosDevCaja->update( $input );

		return redirect()->route('motivosDevCajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,MotivosDevCaja $motivosDevCaja)
	{
		$motivosDevCaja=$motivosDevCaja->find($id);
		$motivosDevCaja->delete();

		return redirect()->route('motivosDevCajas.index')->with('message', 'Registro Borrado.');
	}

}
