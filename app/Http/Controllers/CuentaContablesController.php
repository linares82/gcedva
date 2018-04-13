<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentaContable;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuentaContable;
use App\Http\Requests\createCuentaContable;

class CuentaContablesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentaContables = CuentaContable::getAllData($request);

		return view('cuentaContables.index', compact('cuentaContables'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuentaContables.create')
			->with( 'list', CuentaContable::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentaContable $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                if(!isset($input['activo'])){
			$input['activo']=0;
		}else{
			$input['activo']=1;
		}
                
		//create data
		CuentaContable::create( $input );

		return redirect()->route('cuentaContables.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentaContable $cuentaContable)
	{
		$cuentaContable=$cuentaContable->find($id);
		return view('cuentaContables.show', compact('cuentaContable'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentaContable $cuentaContable)
	{
		$cuentaContable=$cuentaContable->find($id);
		return view('cuentaContables.edit', compact('cuentaContable'))
			->with( 'list', CuentaContable::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentaContable $cuentaContable)
	{
		$cuentaContable=$cuentaContable->find($id);
		return view('cuentaContables.duplicate', compact('cuentaContable'))
			->with( 'list', CuentaContable::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentaContable $cuentaContable, updateCuentaContable $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		if(!isset($input['activo'])){
			$input['activo']=0;
		}else{
			$input['activo']=1;
		}
                //update data
		$cuentaContable=$cuentaContable->find($id);
		$cuentaContable->update( $input );

		return redirect()->route('cuentaContables.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuentaContable $cuentaContable)
	{
		$cuentaContable=$cuentaContable->find($id);
		$cuentaContable->delete();

		return redirect()->route('cuentaContables.index')->with('message', 'Registro Borrado.');
	}

}
