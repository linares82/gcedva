<?php namespace App\Http\Controllers;

use Auth;
use App\Cliente;

use App\Lectivo;
use App\Plantel;
use App\Inscripcion;
use App\Calificacion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createCalificacion;
use App\Http\Requests\updateCalificacion;

class CalificacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$calificacions = Calificacion::getAllData($request);

		return view('calificacions.index', compact('calificacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('calificacions.create')
			->with( 'list', Calificacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCalificacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Calificacion::create( $input );

		return redirect()->route('calificacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Calificacion $calificacion)
	{
		$calificacion=$calificacion->find($id);
		return view('calificacions.show', compact('calificacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Calificacion $calificacion)
	{
		$calificacion=$calificacion->find($id);
		return view('calificacions.edit', compact('calificacion'))
			->with( 'list', Calificacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Calificacion $calificacion)
	{
		$calificacion=$calificacion->find($id);
		return view('calificacions.duplicate', compact('calificacion'))
			->with( 'list', Calificacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Calificacion $calificacion, updateCalificacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$calificacion=$calificacion->find($id);
		$calificacion->update( $input );

		return redirect()->route('calificacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$calificacion=Calificacion::find($id);
		$hacademica=$calificacion->hacademica;
		$calificacion->delete();

		return redirect()->route('clientes.edit', $hacademica->cliente_id)->with('message', 'Registro Borrado.');
	}

	public function promedios(){
		$plantels=Plantel::pluck('razon','id');
		$lectivos=Lectivo::pluck('name','id');
		return view('calificacions.reportes.promedios', compact('plantels','lectivos'));
	}

	public function promediosR(Request $request)
	{
		$datos=$request->all();
		//dd($datos);
		$registros=Cliente::select('p.razon','g.name as grado','l.name as lectivo','clientes.id','m.name as materia','car_po.name as ponderacion',
								'calif.calificacion','cp.calificacion_parcial', 'cp.ponderacion', 'cp.calificacion_parcial_calculada')
								->join('st_clientes as stc','stc.id','=','clientes.st_cliente_id')
								->join('plantels as p','p.id','=','clientes.plantel_id')
								->join('hacademicas as h','h.cliente_id','=','clientes.id')
								->join('grados as g','g.id','=','h.grado_id')
								->join('materia as m','m.id','=','h.materium_id')
								->join('lectivos as l', 'l.id', '=', 'h.lectivo_id')
								->join('calificacions as calif','calif.hacademica_id','=','h.id')
								->join('calificacion_ponderacions as cp','cp.calificacion_id','=','calif.id')
								->join('carga_ponderacions as car_po','car_po.id','=','cp.carga_ponderacion_id')
								->whereIn('p.id', $datos['plantel_f'])
								->whereIn('h.lectivo_id', $datos['lectivo_f'])
								->where('clientes.st_cliente_id','4')
								->whereNull('h.deleted_at')
								->whereNull('calif.deleted_at')
								->whereNull('cp.deleted_at')
								->get();
			//dd($registros->toArray());					 

		return view('calificacions.reportes.promediosR', compact('plantels'));
		
		
	}

	public function contarExtras(Request $request){
		$datos=$request->all();
		if($request->ajax()){
			$h = Inscripcion::select('h.id')
                ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                ->join('hacademicas as h', 'h.inscripcion_id', '=', 'inscripcions.id')
                ->where('c.id', '=', $datos['cliente_id'])
                ->where('inscripcions.grado_id', '=', $datos['grado_id'])
                ->where('h.materium_id', '=', $datos['materium_id'])
                ->where('h.deleted_at', '=', null)
                ->first();
			$totalExtras = Calificacion::where('hacademica_id', $h->id)
			->where('tpo_examen_id', 2)
			->where('lectivo_id',$datos['lectivo_id'])->count();
			return json_encode(array('totalExtras'=>$totalExtras));
		}
		
	}
}
