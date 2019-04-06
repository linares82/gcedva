<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CursosEmpresa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCursosEmpresa;
use App\Http\Requests\createCursosEmpresa;

class CursosEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cursosEmpresas = CursosEmpresa::getAllData($request);

		return view('cursosEmpresas.index', compact('cursosEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cursosEmpresas.create')
			->with( 'list', CursosEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCursosEmpresa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CursosEmpresa::create( $input );

		return redirect()->route('cursosEmpresas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CursosEmpresa $cursosEmpresa)
	{
		$cursosEmpresa=$cursosEmpresa->find($id);
		return view('cursosEmpresas.show', compact('cursosEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CursosEmpresa $cursosEmpresa)
	{
		$cursosEmpresa=$cursosEmpresa->find($id);
		return view('cursosEmpresas.edit', compact('cursosEmpresa'))
			->with( 'list', CursosEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CursosEmpresa $cursosEmpresa)
	{
		$cursosEmpresa=$cursosEmpresa->find($id);
		return view('cursosEmpresas.duplicate', compact('cursosEmpresa'))
			->with( 'list', CursosEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CursosEmpresa $cursosEmpresa, updateCursosEmpresa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cursosEmpresa=$cursosEmpresa->find($id);
		$cursosEmpresa->update( $input );

		return redirect()->route('cursosEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CursosEmpresa $cursosEmpresa)
	{
		$cursosEmpresa=$cursosEmpresa->find($id);
		$cursosEmpresa->delete();

		return redirect()->route('cursosEmpresas.index')->with('message', 'Registro Borrado.');
	}

        public function getDescuentoMax($id){
            $descuento= CursosEmpresa::find($id);
            
            echo json_encode($descuento->descuento_max);
        }
}
