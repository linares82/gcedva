<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Correo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCorreo;
use App\Http\Requests\createCorreo;

class CorreosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$correos = Correo::getAllData($request);

		return view('correos.index', compact('correos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('correos.create')
			->with( 'list', Correo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCorreo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Correo::create( $input );

		return redirect()->route('correos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Correo $correo)
	{
		$correo=$correo->find($id);
		return view('correos.show', compact('correo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Correo $correo)
	{
		$correo=$correo->find($id);
		return view('correos.edit', compact('correo'))
			->with( 'list', Correo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Correo $correo)
	{
		$correo=$correo->find($id);
		return view('correos.duplicate', compact('correo'))
			->with( 'list', Correo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Correo $correo, updateCorreo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$correo=$correo->find($id);
		$correo->update( $input );

		return redirect()->route('correos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Correo $correo)
	{
		$correo=$correo->find($id);
		$correo->delete();

		return redirect()->route('correos.index')->with('message', 'Registro Borrado.');
	}
        
        public function redactar($mail, Request $request)
	{
		$mail=$mail;
		return view('correos.version2.frm_envio', compact('mail'));
	}
}
