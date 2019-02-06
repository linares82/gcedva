<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AvisosEmpresa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAvisosEmpresa;
use App\Http\Requests\createAvisosEmpresa;

class AvisosEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$avisosEmpresas = AvisosEmpresa::getAllData($request);

		return view('avisosEmpresas.index', compact('avisosEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('avisosEmpresas.create')
			->with( 'list', AvisosEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAvisosEmpresa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                if(isset($input['activo'])){
                    $input['activo']=1;
                }else{
                    $input['activo']=0;
                }
                
		//create data
		$a=AvisosEmpresa::create( $input );

		return redirect()->route('empresas.seguimiento', $a->empresa_id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AvisosEmpresa $avisosEmpresa)
	{
		$avisosEmpresa=$avisosEmpresa->find($id);
		return view('avisosEmpresas.show', compact('avisosEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AvisosEmpresa $avisosEmpresa)
	{
		$avisosEmpresa=$avisosEmpresa->find($id);
		return view('avisosEmpresas.edit', compact('avisosEmpresa'))
			->with( 'list', AvisosEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AvisosEmpresa $avisosEmpresa)
	{
		$avisosEmpresa=$avisosEmpresa->find($id);
		return view('avisosEmpresas.duplicate', compact('avisosEmpresa'))
			->with( 'list', AvisosEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, AvisosEmpresa $avisosEmpresa, updateAvisosEmpresa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		if(isset($input['activo'])){
                    $input['activo']=1;
                }else{
                    $input['activo']=0;
                }
                $avisosEmpresa=$avisosEmpresa->find($id);
		$avisosEmpresa->update( $input );

		return redirect()->route('avisosEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,AvisosEmpresa $avisosEmpresa)
	{
		$avisosEmpresa=$avisosEmpresa->find($id);
		$avisosEmpresa->delete();

		return redirect()->route('avisosEmpresas.index')->with('message', 'Registro Borrado.');
	}

}
