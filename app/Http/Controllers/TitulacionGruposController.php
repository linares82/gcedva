<?php namespace App\Http\Controllers;

use Auth;
use App\Plantel;

use App\Empleado;
use App\Titulacion;
use App\Http\Requests;
use App\TitulacionGrupo;
use App\TitulacionEgreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\createTitulacionGrupo;
use App\Http\Requests\updateTitulacionGrupo;

class TitulacionGruposController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionGrupos = TitulacionGrupo::getAllData($request);
		$empleado = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id','<>',3)->first();
        $plantels=array();
		foreach ($empleado->plantels as $p) {
            array_push($plantels, $p->id);
        }
        $planteles = Plantel::whereIn('id',$plantels)->pluck('razon','id');
        

		return view('titulacionGrupos.index', compact('titulacionGrupos','planteles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('titulacionGrupos.create')
			->with( 'list', TitulacionGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionGrupo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TitulacionGrupo::create( $input );

		return redirect()->route('titulacionGrupos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionGrupo $titulacionGrupo)
	{
		$titulacionGrupo=$titulacionGrupo->find($id);
		return view('titulacionGrupos.show', compact('titulacionGrupo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionGrupo $titulacionGrupo)
	{
		$titulacionGrupo=$titulacionGrupo->find($id);
		return view('titulacionGrupos.edit', compact('titulacionGrupo'))
			->with( 'list', TitulacionGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionGrupo $titulacionGrupo)
	{
		$titulacionGrupo=$titulacionGrupo->find($id);
		return view('titulacionGrupos.duplicate', compact('titulacionGrupo'))
			->with( 'list', TitulacionGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TitulacionGrupo $titulacionGrupo, updateTitulacionGrupo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacionGrupo=$titulacionGrupo->find($id);
		$titulacionGrupo->update( $input );

		return redirect()->route('titulacionGrupos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TitulacionGrupo $titulacionGrupo)
	{
		$titulacionGrupo=$titulacionGrupo->find($id);
		$titulacionGrupo->delete();

		return redirect()->route('titulacionGrupos.index')->with('message', 'Registro Borrado.');
	}

	public function reporte(Request $request){
		//dd($request->all());
		$datos=$request->all();
		$plantel=Plantel::find($datos['plantel_id']);
		//dd($plantel->toArray());
		$grupo=TitulacionGrupo::find($datos['id']);
		$ingresos=array();
		$titulaciones_conceptos=Titulacion::select('ot.id as opcion_titulacion_id','ot.name as opcion_titulacion')
		->join('opcion_titulacions as ot','ot.id','titulacions.opcion_titulacion_id')
		->join('titulacion_pagos as tp','tp.titulacion_id','titulacions.id')
		->join('clientes as c','c.id','titulacions.cliente_id')
		->where('c.plantel_id',$plantel->id)
		->where('titulacion_grupo_id',$grupo->id)
		->orderBy('opcion_titulacion_id', 'asc') 
		->distinct()
		->get();
		//dd($titulaciones_conceptos);

		foreach($titulaciones_conceptos as $concepto){
			$titulaciones_total_alumnos=Titulacion::select('titulacions.cliente_id')
			->join('opcion_titulacions as ot','ot.id','titulacions.opcion_titulacion_id')
			->join('titulacion_pagos as tp','tp.titulacion_id','titulacions.id')
			->join('clientes as c','c.id','titulacions.cliente_id')
			->where('c.plantel_id',$plantel->id)
			->where('titulacion_grupo_id',$grupo->id)
			->where('titulacions.opcion_titulacion_id',$concepto->opcion_titulacion_id)
			->orderBy('titulacions.cliente_id', 'asc')
			->groupBy('titulacions.cliente_id','ot.id','ot.name')
			->distinct()
			->get()->count();
			//dd($titulaciones_total_alumnos);

			$titulaciones_suma=Titulacion::select(DB::raw('sum(tp.monto) as suma_monto'))
			->join('opcion_titulacions as ot','ot.id','titulacions.opcion_titulacion_id')
			->join('titulacion_pagos as tp','tp.titulacion_id','titulacions.id')
			->join('clientes as c','c.id','titulacions.cliente_id')
			->where('c.plantel_id',$plantel->id)
			->where('titulacion_grupo_id',$grupo->id)
			->where('titulacions.opcion_titulacion_id',$concepto->opcion_titulacion_id)
			->whereNull('tp.deleted_at')
			->orderBy('opcion_titulacion_id', 'asc') 
			->orderBy('titulacions.cliente_id', 'asc')
			->first();
			//dd($titulaciones_suma->toArray());
			array_push($ingresos, array('concepto'=>$concepto->opcion_titulacion, 
									'total_alumnos'=>$titulaciones_total_alumnos,
									'total_ingreso'=>$titulaciones_suma->suma_monto));
		}
		//dd($ingresos);
		$egresos=TitulacionEgreso::where('titulacion_grupo_id', $datos['id'])->get();
		//dd($egresos);
		return view('titulacionGrupos.reporte', compact('ingresos', 'egresos','plantel','grupo'));
	}

}
