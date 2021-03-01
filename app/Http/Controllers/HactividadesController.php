<?php namespace App\Http\Controllers;

use App\AsignacionTarea;
use Auth;
use App\Plantel;

use App\Empleado;
use App\Hactividade;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createHactividade;
use App\Http\Requests\updateHactividade;
use DB;

class HactividadesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hactividades = Hactividade::getAllData($request);

		return view('hactividades.index', compact('hactividades'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hactividades.create')
			->with( 'list', Hactividade::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHactividade $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Hactividade::create( $input );

		return redirect()->route('hactividades.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Hactividade $hactividade)
	{
		$hactividade=$hactividade->find($id);
		return view('hactividades.show', compact('hactividade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Hactividade $hactividade)
	{
		$hactividade=$hactividade->find($id);
		return view('hactividades.edit', compact('hactividade'))
			->with( 'list', Hactividade::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Hactividade $hactividade)
	{
		$hactividade=$hactividade->find($id);
		return view('hactividades.duplicate', compact('hactividade'))
			->with( 'list', Hactividade::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Hactividade $hactividade, updateHactividade $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hactividade=$hactividade->find($id);
		$hactividade->update( $input );

		return redirect()->route('hactividades.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Hactividade $hactividade)
	{
		$hactividade=$hactividade->find($id);
		$hactividade->delete();

		return redirect()->route('hactividades.index')->with('message', 'Registro Borrado.');
	}

	public function llamadasColaboradores(){
		//$tareas=Tarea::pluc('name','name');
		
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = $empleado->plantels->pluck('razon', 'id');
		return view('hactividades.reportes.llamadasColaborador', compact('planteles'));
	}

	public function llamadasColaboradoresR(Request $request){
		$datos=$request->all();
		/*
		$registros=Hactividade::select('p.razon','c.id as cliente_id','c.nombre', 'c.nombre2','c.ape_paterno','c.ape_materno',
		'hactividades.asunto','hactividades.tarea','hactividades.detalle', 'hactividades.fecha', 'hactividades.hora','u.name as usuario_alta',
		'c.tel_fijo', 'c.tel_cel')
		->join('clientes as c','c.id','=','hactividades.cliente_id')
		->join('plantels as p','p.id','=','c.plantel_id')
		->join('users as u','u.id','=','hactividades.usu_alta_id')
		//->where('hactividades.tarea','LLAMADA TELEFONICA')
		->whereIn('p.id',$datos['plantel_f'])
		->where('hactividades.fecha','>=',$datos['fecha_f'])
		->where('hactividades.fecha','<=',$datos['fecha_t'])
		->orderBy('hactividades.usu_alta_id')
		->orderBy('hactividades.fecha')
		->orderBy('hactividades.hora')
		->get();
		*/
		$registros=AsignacionTarea::select('p.razon','c.id as cliente_id','c.nombre', 'c.nombre2','c.ape_paterno','c.ape_materno',
		't.name as tarea','asignacion_tareas.detalle', 'asignacion_tareas.created_at',DB::raw('concat(e.nombre," ", e.ape_paterno," ",e.ape_materno) as empleado'),
		'c.tel_fijo', 'c.tel_cel','u.name as usuario_alta')
		->join('clientes as c','c.id','=','asignacion_tareas.cliente_id')
		->join('plantels as p','p.id','=','c.plantel_id')
		->join('empleados as e','e.id','=','c.empleado_id')
		->join('tareas as t','t.id','=','asignacion_tareas.tarea_id')
		->join('st_tareas as sta','sta.id','=','asignacion_tareas.st_tarea_id')
		->join('users as u','u.id','=','asignacion_tareas.usu_alta_id')
		//->where('hactividades.tarea','LLAMADA TELEFONICA')
		->whereIn('p.id',$datos['plantel_f'])
		->whereDate('asignacion_tareas.created_at','>=',$datos['fecha_f'])
		->whereDate('asignacion_tareas.created_at','<=',$datos['fecha_t'])
		->orderBy('asignacion_tareas.empleado_id')
		->orderBy('asignacion_tareas.created_at')
		//->orderBy('hactividades.hora')
		->get();
		//dd($registros->toArray());
		return view('hactividades.reportes.llamadasColaboradorR', compact('registros'));
	}

}
