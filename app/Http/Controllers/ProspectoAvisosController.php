<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;

use App\ProspectoAviso;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspectoAviso;
use App\Http\Requests\updateProspectoAviso;

class ProspectoAvisosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoAvisos = ProspectoAviso::getAllData($request);

		return view('prospectoAvisos.index', compact('prospectoAvisos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoAvisos.create')
			->with( 'list', ProspectoAviso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoAviso $request)
	{
		
		$input = $request->all();
		//dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['activo']=1;
		

		//create data
		ProspectoAviso::create( $input );

		return redirect()->route('prospectoSeguimientos.show', $input['prospecto_id'])->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoAviso $prospectoAviso)
	{
		$prospectoAviso=$prospectoAviso->find($id);
		return view('prospectoAvisos.show', compact('prospectoAviso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoAviso $prospectoAviso)
	{
		$prospectoAviso=$prospectoAviso->find($id);
		return view('prospectoAvisos.edit', compact('prospectoAviso'))
			->with( 'list', ProspectoAviso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoAviso $prospectoAviso)
	{
		$prospectoAviso=$prospectoAviso->find($id);
		return view('prospectoAvisos.duplicate', compact('prospectoAviso'))
			->with( 'list', ProspectoAviso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoAviso $prospectoAviso, updateProspectoAviso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoAviso=$prospectoAviso->find($id);
		$prospectoAviso->update( $input );

		return redirect()->route('prospectoAvisos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoAviso $prospectoAviso)
	{
		$prospectoAviso=$prospectoAviso->find($id);
		$prospectoAviso->delete();

		return redirect()->route('prospectoAvisos.index')->with('message', 'Registro Borrado.');
	}

	public function inactivo()
	{
		
		$aviso=ProspectoAviso::find($_REQUEST['id']);
		$aviso->activo=0;
		$aviso->save();

		return redirect()->route('prospectoSeguimientos.show', $_REQUEST['prospecto'])->with('message', 'Registro Actualizado.');
	}

}
