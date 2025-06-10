<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepInstitucionEducativa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepInstitucionEducativa;
use App\Http\Requests\createSepInstitucionEducativa;

class SepInstitucionEducativasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepInstitucionEducativas = SepInstitucionEducativa::getAllData($request);

		return view('sepInstitucionEducativas.index', compact('sepInstitucionEducativas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepInstitucionEducativas.create')
			->with( 'list', SepInstitucionEducativa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepInstitucionEducativa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepInstitucionEducativa::create( $input );

		return redirect()->route('sepInstitucionEducativas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepInstitucionEducativa $sepInstitucionEducativa)
	{
		$sepInstitucionEducativa=$sepInstitucionEducativa->find($id);
		return view('sepInstitucionEducativas.show', compact('sepInstitucionEducativa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepInstitucionEducativa $sepInstitucionEducativa)
	{
		$sepInstitucionEducativa=$sepInstitucionEducativa->find($id);
		return view('sepInstitucionEducativas.edit', compact('sepInstitucionEducativa'))
			->with( 'list', SepInstitucionEducativa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepInstitucionEducativa $sepInstitucionEducativa)
	{
		$sepInstitucionEducativa=$sepInstitucionEducativa->find($id);
		return view('sepInstitucionEducativas.duplicate', compact('sepInstitucionEducativa'))
			->with( 'list', SepInstitucionEducativa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepInstitucionEducativa $sepInstitucionEducativa, updateSepInstitucionEducativa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepInstitucionEducativa=$sepInstitucionEducativa->find($id);
		$sepInstitucionEducativa->update( $input );

		return redirect()->route('sepInstitucionEducativas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepInstitucionEducativa $sepInstitucionEducativa)
	{
		$sepInstitucionEducativa=$sepInstitucionEducativa->find($id);
		$sepInstitucionEducativa->delete();

		return redirect()->route('sepInstitucionEducativas.index')->with('message', 'Registro Borrado.');
	}

}
