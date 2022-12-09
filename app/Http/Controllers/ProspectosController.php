<?php namespace App\Http\Controllers;

use Log;
use Auth;

use App\Medio;
use App\Cliente;
use App\Empleado;
use App\Prospecto;
use Carbon\Carbon;
use App\Seguimiento;
use App\StProspecto;
use App\HStProspecto;
use App\Http\Requests;
use App\ProspectoAviso;
use App\ProspectoStSeg;
use App\ProspectoHEstatuse;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspecto;
use App\Http\Requests\updateProspecto;

class ProspectosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectos = Prospecto::getAllData($request);
		$estatus=ProspectoStSeg::pluck('name','id');
		
		$hoy=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		//dd($hoy);
		$ayer=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->subDay();
		
		$empleado = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id','<>',3)->first();
        
        
		$resumen=array();
		$registro=array();
		foreach($empleado->plantels as $plantel){
			$registro['plantel']=$plantel->razon;
			/*$asesoresHoy=ProspectoHEstatuse::where('tabla','prospectos')
			->join('prospectos as pro', 'pro.id','prospecto_h_estatuses.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->whereDate('prospecto_h_estatuses.fecha',$hoy->toDateString())
			->where('p.id',$plantel->id)
			->where('estatus','Asesores')
			->count();
			$registro['asesoresHoy']=$asesoresHoy;

			$asesoresAyer=ProspectoHEstatuse::where('tabla','prospectos')
			->join('prospectos as pro', 'pro.id','prospecto_h_estatuses.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->whereDate('prospecto_h_estatuses.fecha',$ayer->toDateString())
			->where('p.id',$plantel->id)
			->where('estatus','Asesores')
			->count();
			$registro['asesoresAyer']=$asesoresAyer;
			*/

			$asesoresHoy=HStProspecto::whereColumn('h_st_prospectos.st_prospecto_id','h_st_prospectos.st_anterior_id')
			->join('prospectos as pro', 'pro.id','h_st_prospectos.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->whereDate('h_st_prospectos.created_at',$hoy->toDateString())
			->where('p.id',$plantel->id)
			->where('h_st_prospectos.st_prospecto_id',2)
			->count();
			$registro['asesoresHoy']=$asesoresHoy;

			$asesoresAyer=HStProspecto::whereColumn('h_st_prospectos.st_prospecto_id','h_st_prospectos.st_anterior_id')
			->join('prospectos as pro', 'pro.id','h_st_prospectos.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->whereDate('h_st_prospectos.created_at',$ayer->toDateString())
			->where('p.id',$plantel->id)
			->where('h_st_prospectos.st_prospecto_id',2)
			->count();
			$registro['asesoresAyer']=$asesoresAyer;

			$callToAsesorHoy=HStProspecto::where('h_st_prospectos.st_prospecto_id',2)->where('h_st_prospectos.st_anterior_id',1)
			->join('prospectos as pro', 'pro.id','h_st_prospectos.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->whereDate('h_st_prospectos.created_at',$hoy->toDateString())
			->where('p.id',$plantel->id)
			->count();
			$registro['callToAsesorHoy']=$callToAsesorHoy;

			$callToAsesorAyer=HStProspecto::where('h_st_prospectos.st_prospecto_id',2)->where('h_st_prospectos.st_anterior_id',1)
			->join('prospectos as pro', 'pro.id','h_st_prospectos.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->whereDate('h_st_prospectos.created_at',$ayer->toDateString())
			->where('p.id',$plantel->id)
			->count();
			$registro['callToAsesorAyer']=$callToAsesorAyer;
			if($callToAsesorHoy>0 or
				$callToAsesorAyer>0 or
				$registro['asesoresHoy']>0 or
				$registro['asesoresAyer']>0
			){
				array_push($resumen, $registro);
			}
			
		}
		

		return view('prospectos.index', compact('prospectos','estatus', 'resumen'))
		->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$medios=Medio::where('bnd_prospectos', 1)->pluck('name','id');
		$estatus=StProspecto::whereIn('id',array(1,2))->pluck('name','id');
		return view('prospectos.create', compact('medios','estatus'))
			->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspecto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		//$input['st_prospecto_id']=1;
		$input['fecha']=date('Y-m-d');
		if(!isset($input['bnd_liga_enviada'])){
			$input['bnd_liga_enviada']=0;
		}
		if(!isset($input['bnd_inscripcion'])){
			$input['bnd_inscripcion']=0;
		}
		

		//create data
		$registro=Prospecto::create( $input );

		$input['prospecto_id']=$registro->id;
		$input['mes']=$registro->created_at->month;
		$input['contador_sms']=0;
		$input['prospecto_st_seg_id']=1;
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$prospectoSeguimiento=ProspectoSeguimiento::create($input);

		$historico['prospecto_id']=$registro->id;
		$historico['st_prospecto_id']=$registro->st_prospecto_id;
		$historico['st_anterior_id']=$registro->st_prospecto_id;
		$historico['usu_alta_id']=Auth::user()->id;
		$historico['usu_mod_id']=Auth::user()->id;

		HStProspecto::create($historico);

		return redirect()->route('prospectoSeguimientos.show', $registro->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		return view('prospectos.show', compact('prospecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		$medios=Medio::where('bnd_prospectos', 1)->pluck('name','id');
		$estatus=StProspecto::whereIn('id',array(1,2))->pluck('name','id');
		return view('prospectos.edit', compact('prospecto', 'medios','estatus'))
			->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		return view('prospectos.duplicate', compact('prospecto'))
			->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Prospecto $prospecto, updateProspecto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospecto=$prospecto->find($id);
		if(!isset($input['bnd_inscripcion'])){
			$input['bnd_inscripcion']=0;
		}
		$prospecto->update( $input );

		return redirect()->route('prospectoSeguimientos.show', $prospecto->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		$prospecto->delete();

		return redirect()->route('prospectos.index')->with('message', 'Registro Borrado.');
	}

	public function Aceptar(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=3;
		$prospecto->save();

		$empleado=Empleado::where('user_id', Auth::user()->id)->first();

		$input=$prospecto->toArray();
		$input['municipio_id']=0;
		$input['estado_id']=0;
		$input['st_cliente_id']=1;
		$input['ofertum_id']=0;
		$input['empleado_id']=$empleado->id;
		$input['grado_id']=0;
		$input['diplomado_id']=0;
		$input['subdiplomado_id']=0;
		$input['curso_id']=0;
		$input['subcurso_id']=0;
		$input['otro_id']=0;
		$input['subotro_id']=0;
		$input['pagador_id']=0;
		$input['promociones'] = 0;
		$input['promo_cel'] = 0;
        $input['promo_correo'] = 0;
		$input['uso_factura_id']=21;
		//dd($input);
		$cliente=Cliente::create($input);
		$seguimiento=Seguimiento::create(array(
			'cliente_id'=>$cliente->id,
			'st_seguimiento_id'=>1,
			'mes'=> date('m'),
			'usu_alta_id'=>Auth::user()->id,
			'usu_mod_id'=>Auth::user()->id
		));
		$prospecto->cliente_id=$cliente->id;
		$prospecto->save();
		//dd($cliente);
		return redirect()->route('clientes.edit', $cliente->id);
	}

	public function Rechazar(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=4;
		$prospecto->save();

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	public function regresarAsesores(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=2;
		$prospecto->save();

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	public function regresarCallCenter(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=1;
		$prospecto->save();

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	public function prospectos(Request $request){
		$empleado=Empleado::where('user_id', Auth::user()->id)->first();
		$planteles=$empleado->plantels->pluck('razon','id');
		$estatus=StProspecto::pluck('name','id');
		return view('prospectos.reportes.prospectos', compact('planteles','estatus'));
	}

	public function prospectosR(Request $request){
		$datos=$request->all();
		
		$resumen=Prospecto::select(DB::raw('prospectos.fecha, p.razon, ua.name as usuario_alta, stp.name as estatus, count(ua.name) as total'))
		->join('users as ua','ua.id','=','prospectos.usu_alta_id')
		->join('plantels as p','p.id','=','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','=','prospectos.st_prospecto_id')
		//->join('plantels as p','p.id','=','prospectos.plantel_id')
		->whereDate('prospectos.fecha','>=', $datos['fecha_f'])
		->whereDate('prospectos.fecha','<=', $datos['fecha_t'])
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereIn('prospectos.st_prospecto_id', $datos['estatus_f'])
		//->groupBy('p.razon')
		->groupBy('prospectos.fecha')
		->groupBy('p.razon')
		->groupBy('stp.name')
		->groupBy('ua.name')
		->get();
		//dd($resumen->toArray());
		$registros=Prospecto::whereDate('created_at','>=', $datos['fecha_f'])
		->whereDate('created_at','<=', $datos['fecha_t'])
		->whereIn('plantel_id', $datos['plantel_f'])
		->whereIn('prospectos.st_prospecto_id', $datos['estatus_f'])
		->get();
		return view('prospectos.reportes.prospectosR', compact('registros', 'resumen'));
	}

	public function whCrearProspecto(Request $request){
        Log::info("Adwords");
		Log::info($request);
    }

	public function reporteGeneral(){
		return view('prospectos.reportes.reporteGeneral')
		->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	public function reporteGeneralR(Request $request){

		$datos=$request->all();
		//Resumen de actividades por empleado
		$tareas=Prospecto::select(DB::raw('1 as bnd_tarea'),'prospectos.nombre', 'prospectos.nombre2', 'prospectos.ape_paterno', 
		'prospectos.ape_materno','prospectos.tel_cel','prospectos.mail', 'p.razon', 'stp.name as st_prospecto',
		'psts.name as st_seguimiento', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as empleado'), 
		'pt.name as tarea','pstt.name as st_tarea',
		'pa.name as asunto','pat.detalle', DB::raw('0 as fecha'), 'pat.created_at')
		->join('plantels as p','p.id','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','prospectos.st_prospecto_id')
		->leftJoin('prospecto_seguimientos as ps', 'ps.prospecto_id','prospectos.id')
		->leftJoin('prospecto_st_segs as psts', 'psts.id','ps.prospecto_st_seg_id')
		->join('prospecto_asignacion_tareas as pat','pat.prospecto_id','prospectos.id')
		->join('empleados as e','e.id','pat.empleado_id')
		->join('prospecto_tareas as pt','pt.id','pat.prospecto_tarea_id')
		->join('prospecto_st_tareas as pstt','pstt.id','pat.prospecto_st_tarea_id')
		->join('prospecto_asuntos as pa','pa.id', 'pat.prospecto_asunto_id')
		->whereIn('prospectos.st_prospecto_id',[1,2])
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereNull('pat.deleted_at')
		->whereDate('pat.created_at','>',$datos['fecha_f'])
		->whereDate('pat.created_at','<',$datos['fecha_t'])
		->orderBy('prospectos.id')
		->orderBy('pat.prospecto_tarea_id');
		
		//->get();
		//dd($tareas->toArray());

		$avisos=Prospecto::select(DB::raw('0 as bnd_tarea'),'prospectos.nombre', 'prospectos.nombre2', 'prospectos.ape_paterno', 
		'prospectos.ape_materno','prospectos.tel_cel','prospectos.mail', 'p.razon', 'stp.name as st_prospecto',
		'psts.name as st_seguimiento', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as empleado'), DB::raw('"Aviso" as tarea'),
		DB::raw('if(pa.activo=0, "INACTIVO", "ACTIVO") as st_tarea'),
		'pas.name as asunto','pa.detalle', 'pa.fecha','pa.created_at')
		->join('plantels as p','p.id','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','prospectos.st_prospecto_id')
		->join('prospecto_seguimientos as ps', 'ps.prospecto_id','prospectos.id')
		->join('prospecto_st_segs as psts', 'psts.id','ps.prospecto_st_seg_id')
		->join('prospecto_avisos as pa','pa.prospecto_seguimiento_id','ps.id')
		->join('users as u','u.id','pa.usu_alta_id')
		->join('empleados as e','e.user_id','u.id')
		//->join('prospecto_tareas as pt','pt.id','pat.prospecto_tarea_id')
		//->join('prospecto_st_tareas as pstt','pstt.id','pat.prospecto_st_tarea_id')
		->join('prospecto_asuntos as pas','pas.id', 'pa.prospecto_asunto_id')
		->whereIn('prospectos.st_prospecto_id',[1,2])
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereNull('pa.deleted_at')
		->whereDate('pa.created_at','>=',$datos['fecha_f'])
		->whereDate('pa.created_at','<=',$datos['fecha_t'])
		->orderBy('prospectos.id')
		->union($tareas)
		->get();
		//dd($avisos->toArray());

		$regs_empleado=$avisos->sortBy('empleado')->groupBy('empleado');
		//dd($regs_empleado);
		$resumen_totales=array();
		foreach($regs_empleado as $llave=>$regs){
			//dd($regs);
			$resumen=array();
			$resumen['empleado']=$llave;
			$resumen_actividades=$regs->groupBy('tarea');
			//dd($resumen_actividades);
			foreach($resumen_actividades as $llave=>$regs){
			//dd($llave);
			$resumen['actividad']=$llave;
			
			$resumen['cantidad']=count($regs);
			//dd($resumen);
			array_push($resumen_totales, $resumen);
			}
		}
		//Fin Resumen de actividades por empleado
		//dd($resumen_totales);

		$prospectos_nuevos=Prospecto::select('prospectos.id','prospectos.nombre', 'prospectos.nombre2', 'prospectos.ape_paterno', 
		'prospectos.ape_materno','prospectos.tel_cel','prospectos.mail', 'p.razon', 'stp.name as st_prospecto',
		'psts.name as st_seguimiento', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as empleado'), 
		'prospectos.created_at')
		->join('plantels as p','p.id','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','prospectos.st_prospecto_id')
		->join('prospecto_seguimientos as ps', 'ps.prospecto_id','prospectos.id')
		->join('prospecto_st_segs as psts', 'psts.id','ps.prospecto_st_seg_id')
		->join('users as u','u.id','prospectos.usu_alta_id')
		->join('empleados as e','e.user_id','u.id')
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereNull('prospectos.deleted_at')
		->whereDate('prospectos.created_at','>=',$datos['fecha_f'])
		->whereDate('prospectos.created_at','<=',$datos['fecha_t'])
		->orderBy('prospectos.id')
		->get();
		//dd($prospectos_nuevos->toArray());

		$regs_empleado=$prospectos_nuevos->sortBy('empleado')->groupBy('empleado');
		//dd($regs_empleado);
		$resumen_nuevos=array();
		foreach($regs_empleado as $llave=>$regs){
			$resumen=array();
			$resumen['empleado']=$llave;
			$resumen['actividad']='Creacion';
			$resumen['cantidad']=count($regs);
			array_push($resumen_nuevos, $resumen);
		}
		//dd($resumen_nuevos);
		$prospectos_clientes=Prospecto::select('prospectos.id','prospectos.nombre', 'prospectos.nombre2', 'prospectos.ape_paterno', 
		'prospectos.ape_materno','prospectos.tel_cel','prospectos.mail', 'p.razon', 'stp.name as st_prospecto',
		'psts.name as st_seguimiento', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as empleado'), 
		'hst.created_at')
		->join('plantels as p','p.id','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','prospectos.st_prospecto_id')
		->join('h_st_prospectos as hst','hst.prospecto_id','prospectos.id')
		->leftJoin('prospecto_seguimientos as ps', 'ps.prospecto_id','prospectos.id')
		->leftJoin('prospecto_st_segs as psts', 'psts.id','ps.prospecto_st_seg_id')
		->join('users as u','u.id','hst.usu_alta_id')
		->join('empleados as e','e.user_id','u.id')
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereNull('prospectos.deleted_at')
		->whereDate('hst.created_at','>=',$datos['fecha_f'])
		->whereDate('hst.created_at','<=',$datos['fecha_t'])
		->where('prospectos.st_prospecto_id', 3)
		->where('hst.st_prospecto_id', 3)
		->whereNotNull('prospectos.cliente_id')
		->orderBy('prospectos.id')
		->get();

		$regs_empleado=$prospectos_clientes->sortBy('empleado')->groupBy('empleado');
		//dd($regs_empleado);
		$resumen_aceptados=array();
		foreach($regs_empleado as $llave=>$regs){
			$resumen=array();
			$resumen['empleado']=$llave;
			$resumen['actividad']='Aceptado Cliente';
			$resumen['cantidad']=count($regs);
			array_push($resumen_aceptados, $resumen);
		}

		//dd($resumen_aceptados);
		return view('prospectos.reportes.reporteGeneralR', compact('avisos', 'resumen_totales', 
		'prospectos_nuevos','resumen_nuevos', 
		'prospectos_clientes','resumen_aceptados'));
	}

	public function widgetAvisosProspectos(){
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$avisos = ProspectoAviso::select('prospecto_avisos.id', 'a.name', 'prospecto_avisos.detalle', 
				'prospecto_avisos.fecha', 's.prospecto_id')
                ->join('prospecto_asuntos as a', 'a.id', '=', 'prospecto_avisos.prospecto_asunto_id')
                ->join('prospecto_seguimientos as s', 's.id', '=', 'prospecto_avisos.prospecto_seguimiento_id')
                ->join('prospectos as c', 'c.id', '=', 's.prospecto_id')
                ->where('prospecto_avisos.activo', '=', '1')
                //->where('avisos.fecha', '>=', Db::Raw('CURDATE()'))
                //->where('c.empleado_id', '=', $empleado->id)
                ->where('prospecto_avisos.usu_alta_id', '=', $empleado->user_id)
                ->orderBy('prospecto_avisos.fecha')
                ->get();
		//dd($avisos);
		return view('prospectos.reportes.widgetAvisosProspectos', compact('avisos'));
	}


	//No esta concluida
	public function apiStore(createProspecto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=1;
		$input['usu_mod_id']=1;
		//$input['st_prospecto_id']=1;
		$input['fecha']=date('Y-m-d');
		if(!isset($input['bnd_liga_enviada'])){
			$input['bnd_liga_enviada']=0;
		}
		if(!isset($input['bnd_inscripcion'])){
			$input['bnd_inscripcion']=0;
		}
		

		//create data
		$registro=Prospecto::create( $input );

		$historico['prospecto_id']=$registro->id;
		$historico['st_prospecto_id']=$registro->st_prospecto_id;
		$historico['st_anterior_id']=$registro->st_prospecto_id;
		$historico['usu_alta_id']=1;
		$historico['usu_mod_id']=1;

		HStProspecto::create($historico);

		return redirect()->route('prospectos.index')->with('message', 'Registro Creado.');
	}

}

	
