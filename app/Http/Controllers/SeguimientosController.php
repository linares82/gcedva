<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seguimiento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSeguimiento;
use App\Http\Requests\createSeguimiento;

class SeguimientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$seguimientos = Seguimiento::getAllData($request);

		return view('seguimientos.index', compact('seguimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('seguimientos.create')
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Seguimiento::create( $input );

		return redirect()->route('seguimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->where('cliente_id', '=', $id)->first();
		//dd($seguimiento);
		if(!isset($seguimiento->id)){
			$input_seguimiento['cliente_id']=$id;
			$input_seguimiento['estatus_id']=1;
			$input_seguimiento['usu_alta_id']=Auth::user()->id;
			$input_seguimiento['usu_mod_id']=Auth::user()->id;
			$seguimiento=Seguimiento::create($input_seguimiento);
		}
		return view('seguimientos.show', compact('seguimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		return view('seguimientos.edit', compact('seguimiento'))
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		return view('seguimientos.duplicate', compact('seguimiento'))
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Seguimiento $seguimiento, updateSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$seguimiento=$seguimiento->find($id);
		$seguimiento->update( $input );

		return redirect()->route('seguimientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		$seguimiento->delete();

		return redirect()->route('seguimientos.index')->with('message', 'Registro Borrado.');
	}

}
