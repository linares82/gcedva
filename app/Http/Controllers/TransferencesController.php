<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Empleado;
use App\Transference;
use App\CuentasEfectivo;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests\updateTransference;
use App\Http\Requests\createTransference;

class TransferencesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$transferences = Transference::getAllData($request);

		return view('transferences.index', compact('transferences'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $cuentasEfectivo= CuentasEfectivo::pluck('name','id');
            $empleados=Empleado::select('id', DB::raw('concat(nombre, " ",ape_paterno," ",ape_materno) as name'))->pluck('name','id');
		return view('transferences.create',compact('cuentasEfectivo','empleados'))
			->with( 'list', Transference::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTransference $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Transference::create( $input );

		return redirect()->route('transferences.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Transference $transference)
	{
		$transference=$transference->find($id);
		return view('transferences.show', compact('transference'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Transference $transference)
	{
		$transference=$transference->find($id);
                $cuentasEfectivo= CuentasEfectivo::pluck('name','id');
				$empleados=Empleado::select('id', DB::raw('concat(nombre, " ",ape_paterno," ",ape_materno) as name'))->pluck('name','id');
				//$plantels=Plantel::where('')
		return view('transferences.edit', compact('transference','cuentasEfectivo','empleados'))
			->with( 'list', Transference::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Transference $transference)
	{
		$transference=$transference->find($id);
		return view('transferences.duplicate', compact('transference'))
			->with( 'list', Transference::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Transference $transference, updateTransference $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$transference=$transference->find($id);
		$transference->update( $input );

		return redirect()->route('transferences.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Transference $transference)
	{
		$transference=$transference->find($id);
		$transference->delete();

		return redirect()->route('transferences.index')->with('message', 'Registro Borrado.');
	}

}
