<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TareasEmpresa;
use App\Empleado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTareasEmpresa;
use App\Http\Requests\createTareasEmpresa;

class TareasEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tareasEmpresas = TareasEmpresa::getAllData($request);

		return view('tareasEmpresas.index', compact('tareasEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tareasEmpresas.create')
			->with( 'list', TareasEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTareasEmpresa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TareasEmpresa::create( $input );

		return redirect()->route('tareasEmpresas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TareasEmpresa $tareasEmpresa)
	{
		$tareasEmpresa=$tareasEmpresa->find($id);
		return view('tareasEmpresas.show', compact('tareasEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TareasEmpresa $tareasEmpresa)
	{
		$tareasEmpresa=$tareasEmpresa->find($id);
		return view('tareasEmpresas.edit', compact('tareasEmpresa'))
			->with( 'list', TareasEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TareasEmpresa $tareasEmpresa)
	{
		$tareasEmpresa=$tareasEmpresa->find($id);
		return view('tareasEmpresas.duplicate', compact('tareasEmpresa'))
			->with( 'list', TareasEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TareasEmpresa $tareasEmpresa, updateTareasEmpresa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tareasEmpresa=$tareasEmpresa->find($id);
		$tareasEmpresa->update( $input );

		return redirect()->route('tareasEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TareasEmpresa $tareasEmpresa)
	{
		$tareasEmpresa=$tareasEmpresa->find($id);
		$tareasEmpresa->delete();

		return redirect()->route('tareasEmpresas.index')->with('message', 'Registro Borrado.');
	}

        public function storeModal(Request $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                $input['empleado_id']=Empleado::where('user_id',Auth::user()->id)->value('id') ;
		//dd($input);
		//create data
		$a= TareasEmpresa::create( $input );
		
		return redirect()->route('empresas.seguimiento', $a->empresa_id)->with('message', 'Registro Creado.');
	}
}
