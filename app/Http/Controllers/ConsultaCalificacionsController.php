<?php namespace App\Http\Controllers;

use Auth;
use App\Cliente;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\ConsultaCalificacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\createConsultaCalificacion;
use App\Http\Requests\updateConsultaCalificacion;

class ConsultaCalificacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$consultaCalificacions = ConsultaCalificacion::getAllData($request);

		return view('consultaCalificacions.index', compact('consultaCalificacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$cliente=Cliente::find($request->input('cliente'));
		return view('consultaCalificacions.create', compact('cliente'))
			->with( 'list', ConsultaCalificacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createConsultaCalificacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		$cliente=Cliente::where('matricula',$input['matricula'])->first();
		//create data
		ConsultaCalificacion::create( $input );

		return redirect()->route('clientes.edit', $cliente->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ConsultaCalificacion $consultaCalificacion)
	{
		$consultaCalificacion=$consultaCalificacion->find($id);
		return view('consultaCalificacions.show', compact('consultaCalificacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request, ConsultaCalificacion $consultaCalificacion)
	{
		$datos=$request->all();
		$consultaCalificacion=ConsultaCalificacion::find($datos['id']);
		$cliente=Cliente::find($datos['cliente']);
		//dd($cliente->matricula<>"");
		if(!is_null($cliente->matricula) and $cliente->matricula<>""){
			$consultaCalificacion->matricula=$cliente->matricula;
			$consultaCalificacion->save();
		}
		
		return view('consultaCalificacions.edit', compact('consultaCalificacion', 'cliente'))
			->with( 'list', ConsultaCalificacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ConsultaCalificacion $consultaCalificacion)
	{
		$consultaCalificacion=$consultaCalificacion->find($id);
		return view('consultaCalificacions.duplicate', compact('consultaCalificacion'))
			->with( 'list', ConsultaCalificacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ConsultaCalificacion $consultaCalificacion, updateConsultaCalificacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$consultaCalificacion=$consultaCalificacion->find($id);
		$consultaCalificacion->update( $input );
		$cliente=Cliente::where('matricula',$consultaCalificacion->matricula)->first();

		return redirect()->route('clientes.edit', $cliente->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ConsultaCalificacion $consultaCalificacion)
	{
		
		$consultaCalificacion=$consultaCalificacion->find($id);
		$cliente=Cliente::where('matricula', $consultaCalificacion->matricula)->first();
		$consultaCalificacion->delete();

		return redirect()->route('clientes.edit', $cliente->id)->with('message', 'Registro Borrado.');
	}

}
