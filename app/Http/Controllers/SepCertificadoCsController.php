<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCertificadoC;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCertificadoC;
use App\Http\Requests\createSepCertificadoC;

class SepCertificadoCsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCertificadoCs = SepCertificadoC::getAllData($request);

		return view('sepCertificadoCs.index', compact('sepCertificadoCs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCertificadoCs.create')
			->with( 'list', SepCertificadoC::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCertificadoC $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCertificadoC::create( $input );

		return redirect()->route('sepCertificadoCs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCertificadoC $sepCertificadoC)
	{
		$sepCertificadoC=$sepCertificadoC->find($id);
		return view('sepCertificadoCs.show', compact('sepCertificadoC'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCertificadoC $sepCertificadoC)
	{
		$sepCertificadoC=$sepCertificadoC->find($id);
		return view('sepCertificadoCs.edit', compact('sepCertificadoC'))
			->with( 'list', SepCertificadoC::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCertificadoC $sepCertificadoC)
	{
		$sepCertificadoC=$sepCertificadoC->find($id);
		return view('sepCertificadoCs.duplicate', compact('sepCertificadoC'))
			->with( 'list', SepCertificadoC::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCertificadoC $sepCertificadoC, updateSepCertificadoC $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCertificadoC=$sepCertificadoC->find($id);
		$sepCertificadoC->update( $input );

		return redirect()->route('sepCertificadoCs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCertificadoC $sepCertificadoC)
	{
		$sepCertificadoC=$sepCertificadoC->find($id);
		$sepCertificadoC->delete();

		return redirect()->route('sepCertificadoCs.index')->with('message', 'Registro Borrado.');
	}

}
