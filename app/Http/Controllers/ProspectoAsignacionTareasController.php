<?php namespace App\Http\Controllers;

use Auth;
use App\Empleado;

use App\Prospecto;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
use App\ProspectoAsignacionTarea;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspectoAsignacionTarea;
use App\Http\Requests\updateProspectoAsignacionTarea;

class ProspectoAsignacionTareasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoAsignacionTareas = ProspectoAsignacionTarea::getAllData($request);

		return view('prospectoAsignacionTareas.index', compact('prospectoAsignacionTareas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoAsignacionTareas.create')
			->with( 'list', ProspectoAsignacionTarea::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		/*
		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoAsignacionTarea::create( $input );

		return redirect()->route('prospectoAsignacionTareas.index')->with('message', 'Registro Creado.');
		*/
		
		$input = $request->all();

		//dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$empleado=Empleado::where('user_id',Auth::user()->id)->first();
		$input['empleado_id']=$empleado->id;
		//dd($input);
		//create data
		$a=ProspectoAsignacionTarea::create( $input );
		$prospecto=Prospecto::find($a->prospecto_id);
		$prospectoSeguimiento=ProspectoSeguimiento::where('prospecto_id', $prospecto->id)->first();
		/*if($seguimiento->st_seguimiento_id<>2 and 
		   $seguimiento->st_seguimiento_id<>7 and
		   $seguimiento->st_seguimiento_id<>9 and
		   $seguimiento->st_seguimiento_id<>10){
			$prospecto->empleado_id=$empleado->id;
			$prospecto->save();
		}revisar si se asigna un empleado en particular y cuando
		*/
		return redirect()->route('prospectoSeguimientos.show', $prospecto->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoAsignacionTarea $prospectoAsignacionTarea)
	{
		$prospectoAsignacionTarea=$prospectoAsignacionTarea->find($id);
		return view('prospectoAsignacionTareas.show', compact('prospectoAsignacionTarea'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoAsignacionTarea $prospectoAsignacionTarea)
	{
		$prospectoAsignacionTarea=$prospectoAsignacionTarea->find($id);
		return view('prospectoAsignacionTareas.edit', compact('prospectoAsignacionTarea'))
			->with( 'list', ProspectoAsignacionTarea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoAsignacionTarea $prospectoAsignacionTarea)
	{
		$prospectoAsignacionTarea=$prospectoAsignacionTarea->find($id);
		return view('prospectoAsignacionTareas.duplicate', compact('prospectoAsignacionTarea'))
			->with( 'list', ProspectoAsignacionTarea::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoAsignacionTarea $prospectoAsignacionTarea, updateProspectoAsignacionTarea $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoAsignacionTarea=$prospectoAsignacionTarea->find($id);
		$prospectoAsignacionTarea->update( $input );

		return redirect()->route('prospectoAsignacionTareas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoAsignacionTarea $prospectoAsignacionTarea)
	{
		
		$prospectoAsignacionTarea=$prospectoAsignacionTarea->find($id);
		//dd($prospectoAsignacionTarea);
		$prospectoSeguimiento=ProspectoSeguimiento::where('prospecto_id',$prospectoAsignacionTarea->prospecto_id)->first();
		//dd($prospectoSeguimiento->toArray());
		$prospectoAsignacionTarea->delete();

		return redirect()->route('prospectoSeguimientos.show', $prospectoSeguimiento->prospecto_id)->with('message', 'Registro Borrado.');
	}

}
