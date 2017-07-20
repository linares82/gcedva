<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seguimiento;
use App\Empleado;
use App\Cliente;
use App\StSeguimiento;
use App\AsignacionTarea;
use App\Aviso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSeguimiento;
use App\Http\Requests\createSeguimiento;
use App\Http\Requests\updateAsignacionTarea;
use DB;
use PDF;

class SeguimientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$seguimientos = Seguimiento::getAllData($request);

		return view('seguimientos.index', compact('seguimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('seguimientos.create')
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Seguimiento::create( $input );

		return redirect()->route('seguimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Seguimiento $seguimiento, updateAsignaciontarea $request)
	{
		$seguimiento=$seguimiento->where('cliente_id', '=', $id)->first();
		//dd($seguimiento);
		if(!isset($seguimiento->id)){
			$input_seguimiento['cliente_id']=$id;
			$input_seguimiento['estatus_id']=1;
			$input_seguimiento['usu_alta_id']=Auth::user()->id;
			$input_seguimiento['usu_mod_id']=Auth::user()->id;
			$seguimiento=Seguimiento::create($input_seguimiento);
		}
		//$seguimiento->getAllData();
		$sts=StSeguimiento::pluck('name', 'id');
		$asignacionTareas = AsignacionTarea::where('cliente_id', '=', $seguimiento->cliente_id)->get();
		$avisos=Aviso::select('avisos.id','a.name','avisos.detalle', 'avisos.fecha',
							Db::Raw('DATEDIFF(avisos.fecha,CURDATE()) as dias_restantes'))
					->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
					->where('seguimiento_id', '=', $seguimiento->id)
					->where('avisos.activo', '=', '1')
					->get();
		//$dias=round((strtotime($a->fecha)-strtotime(date('Y-m-d')))/86400);
		//dd($avisos);
		return view('seguimientos.show', compact('seguimiento', 'sts', 'asignacionTareas', 'avisos'))
					->with( 'list', AsignacionTarea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		return view('seguimientos.edit', compact('seguimiento'))
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		return view('seguimientos.duplicate', compact('seguimiento'))
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Seguimiento $seguimiento, updateSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$seguimiento=$seguimiento->find($id);
		$seguimiento->update( $input );

		return redirect()->route('seguimientos.show', $seguimiento->cliente_id)->with('message', 'Registro Actualizado.');
	}

	public function updateEstatus($id, Seguimiento $seguimiento, updateSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$seguimiento=$seguimiento->find($id);
		$seguimiento->update( $input );

		return redirect()->route('seguimientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		$seguimiento->delete();

		return redirect()->route('seguimientos.index')->with('message', 'Registro Borrado.');
	}

	public function reporteSeguimientosXEmpleado(){
		$estatus=$_REQUEST['estatus'];
		$e=Empleado::where('user_id', '=', Auth::user()->id)->first();
		$mes=date('m');
		$fecha=date('d-m-Y');
		
		$seguimientos=Seguimiento::select('c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno',
			'c.calle', 'c.no_interior', 'c.no_exterior', 'm.name as municipio', 'e.name as estado', 
			'c.tel_fijo', 'tel_cel', 'mail', 'sts.name as st_seguimiento', 
			'stc.name as st_cliente')
			->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.estatus_id')
			->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
			->join('municipios as m', 'm.id', '=', 'c.municipio_id')
			->join('estados as e', 'e.id', '=', 'c.estado_id')
			->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
			->join('asignacion_tareas as at', 'at.cliente_id', '=','seguimientos.cliente_id')
			->where(Db::raw('MONTH(seguimientos.created_at)'), '=', $mes)
			->where('c.empleado_id', '=', $e->id)
			->where('seguimientos.estatus_id', '=', $estatus)
			->get();
		//dd($seguimientos);
			PDF::setOptions(['defaultFont' => 'arial']);
			$pdf = PDF::loadView('seguimientos.reportes.seguimientosXempleado', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'e'=>$e))
						->setPaper('letter', 'landscape');
			return $pdf->download('reporte.pdf');
			
		//return view('seguimientos.reportes.seguimientosXempleado', compact('seguimientos', 'fecha', 'e'));			
	}

	public function seguimientosXempleadoG()
	{
		return view('seguimientos.reportes.seguimientosXempleadoG')
			->with( 'list', Cliente::getListFromAllRelationApps())
			->with( 'list1', Seguimiento::getListFromAllRelationApps());
	}

	public function seguimientosXempleadoGr(updateSeguimiento $request)
	{
		$input=$request->all();
		$fecha=date('d-m-Y');

		/*$clientes=Cliente::whereBetween('s.created_at', [$input['fecha_f'], $input['fecha_t']])
			->join('seguimientos as s', 's.cliente_id', 'clientes.id')
			->whereBetween('clientes.empleado_id', [$input['empleado_f'], $input['empleado_t']])
			->whereBetween('clientes.plantel_id', [$input['plantel_f'], $input['plantel_t']])
			->whereBetween('s.estatus_id', [$input['estatus_f'], $input['estatus_t']])
			->get();
		*/
		$seguimientos=Seguimiento::join('clientes as c', 'c.id', 'seguimientos.cliente_id')
				->whereBetween('c.empleado_id', [$input['empleado_f'], $input['empleado_t']])
				->whereBetween('c.plantel_id', [$input['plantel_f'], $input['plantel_t']])
				->whereBetween('seguimientos.estatus_id', [$input['estatus_f'], $input['estatus_t']])
				->orderBy('c.empleado_id', 'seguimientos.estatus_id')
				->get();
		//$s=Seguimiento::get();
		//dd($clientes);
			PDF::setOptions(['defaultFont' => 'arial']);
			$pdf = PDF::loadView('seguimientos.reportes.seguimientosXempleadoGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha))
						->setPaper('letter', 'landscape');
			return $pdf->download('reporte.pdf');
			//return view('seguimientos.reportes.seguimientosXempleadoGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha));	
	}
}
