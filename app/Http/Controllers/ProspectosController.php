<?php namespace App\Http\Controllers;

use Log;
use Auth;

use App\Medio;
use App\Cliente;
use App\Plantel;
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
use App\ProspectoHactividad;
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
		
		return view('prospectos.index', compact('prospectos','estatus'))
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
		$planteles = Empleado::where('user_id',Auth::user()->id)->first()->plantels()->pluck('razon','id');

		return view('prospectos.create', compact('medios','estatus', 'planteles'))
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
		$planteles = Empleado::where('user_id',Auth::user()->id)->first()->plantels()->pluck('razon','id');
		return view('prospectos.edit', compact('prospecto', 'medios','estatus', 'planteles'))
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
		$planteles = Empleado::where('user_id',Auth::user()->id)->first()->plantels()->pluck('razon','id');
		
		return view('prospectos.reportes.reporteGeneral', compact('planteles'))
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

	public function creadosAyerHoy(){
		
		$hoy=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		//dd($hoy);
		$ayer=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->subDay();
		
		$empleado = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id','<>',3)->first();
        
		$resumen=array();
		$registro=array();
		if(Auth::user()->can('prospectos.resumen')){
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
		}
		return view('prospectos.reportes.creadosAyerHoy', compact('resumen'))
		->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	public function resumenProspectosTareasAvisos(){
		$empleado=Empleado::where('user_id',Auth::user()->id)->first();
		$empleados_seleccionados=array(13,23,28,84,525,527,564,821,879,964,973,1096,1101,1102,1133,1069,1134,1140,1147, 1174,1179);
		$planteles_validos=$empleado->plantels->pluck('id');
		$planteles_seleccionados=Plantel::whereIn('id', array(5,6,10,12,13,15,17,18,21,22,23,24,25,29,30,32,36,37,38,39,40,41,42,43,45,46,47,49,50))
		->pluck('id');
		$planteles=Plantel::whereIn('id', $planteles_validos)->pluck('razon','id');
		$empleados=Empleado::select('id',DB::raw('concat(nombre, " ",ape_paterno, " ",ape_materno) as nombre'))->pluck('nombre','id');
		$st_prospectos=StProspecto::pluck('name','id');
		return view('prospectos.reportes.resumenProspectosTareasAvisos', 
		compact('planteles', 'empleados', 'planteles_seleccionados', 'empleados_seleccionados','st_prospectos'));
	}

	public function resumenProspectosTareasAvisosR(Request $request){
		$datos=$request->all();
		//dd($datos);
		$resumen=array();
		$hoy=Carbon::createFromFormat('Y-m-d',$datos['fecha_f'])->toDateString();
		$ayer=Carbon::createFromFormat('Y-m-d',$datos['fecha_f'])/*->subDay()*/->toDateString();
		
		$plantel_usuarios1=ProspectoHactividad::select('p.plantel_id','plantels.razon','prospecto_hactividads.usu_alta_id',
		'u.name as user', 'e.id as empleado_id')
		->join('prospectos as p','p.id','prospecto_hactividads.prospecto_id')
		->join('plantels','plantels.id','p.plantel_id')
		->join('users as u','u.id','prospecto_hactividads.usu_alta_id')
		->join('empleados as e','e.user_id','u.id')
		->whereIn('p.plantel_id', $datos['plantel_f'])
		->whereIn('e.id', $datos['empleado_f'])
		->whereDate('prospecto_hactividads.created_at','>=', $ayer)
		->whereDate('prospecto_hactividads.created_at', '<=',$hoy)
		->distinct();
		//->get();

		$plantel_usuarios=Empleado::select('plantels.id as plantel_id','plantels.razon','empleados.user_id as usu_alta_id',
		'u.name as user', 'empleados.id as empleado_id')
		->join('empleado_plantel as ep','ep.empleado_id','empleados.id')
		->join('plantels','plantels.id','ep.plantel_id')
		->join('users as u','u.id','empleados.user_id')
		->whereIn('plantels.id', $datos['plantel_f'])
		->whereIn('empleados.id', $datos['empleado_f'])
		->orderBy('plantels.razon')
		->union($plantel_usuarios1)
		->distinct()
		//->orderBy('plantels.razon')
		->get();
		
		/*
		$plantel_usuarios=Empleado::select('plantels.id as plantel_id','plantels.razon','empleados.user_id as usu_alta_id',
		'u.name as user', 'empleados.id as empleado_id')
		->join('empleado_plantel as ep','ep.empleado_id','empleados.id')
		->join('plantels','plantels.id','ep.plantel_id')
		->join('users as u','u.id','empleados.user_id')
		->whereIn('plantels.id', $datos['plantel_f'])
		->whereIn('empleados.id', $datos['empleado_f'])
		->orderBy('plantels.razon')
		->distinct()
		//->orderBy('plantels.razon')
		->get();
		*/
		//dd($plantel_usuarios->toArray());
		//$sorted=$plantel_usuarios->sortBy('plantels.id');

		//dd($sorted->values()->all());

		foreach($plantel_usuarios as $plantel_usuario){
			$linea=array();
			$linea['plantel']=$plantel_usuario->razon;
			$linea['usuario']=$plantel_usuario->user;
			$linea['plantel_id']=$plantel_usuario->plantel_id;
			$linea['user_id']=$plantel_usuario->usu_alta_id;
			$linea['empleado_id']=$plantel_usuario->empleado_id;
			$linea['inicio_matricula']=$datos['inicio_matricula'];
			$linea['hoy']=$hoy;
			$linea['ayer']=$ayer;
			
			$linea['callToAsesorAyer']=HStProspecto::where('h_st_prospectos.st_prospecto_id',2)
				->where('h_st_prospectos.st_anterior_id',1)
				->join('prospectos as pro', 'pro.id','h_st_prospectos.prospecto_id')
				->join('plantels as p','p.id','pro.plantel_id')
				->whereDate('h_st_prospectos.created_at',$ayer)
				->where('p.id',$plantel_usuario->plantel_id)
				//->where('h_st_prospectos.usu_alta_id',$plantel_usuario->usu_alta_id)
				->count();

			/*	
			$linea['clientes_concretados']=Cliente::select(DB::raw('count(distinct(clientes.id)) as total'))
			->join('seguimientos as s','s.cliente_id','clientes.id')
			->join('hactividades as h', 'h.seguimiento_id','s.id')
			->join('users as u','u.id','h.usu_alta_id')
			->where('h.asunto','Cambio estatus ')
			->where('h.detalle','Concretado 100%')
			->where('clientes.plantel_id',$plantel_usuario->plantel_id)
			->where('h.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereDate('h.fecha',$ayer)
			->value('total');
			*/
			$clientes=Cliente::select(DB::raw('p.razon, clientes.id, h.fecha, h.detalle as estatus, 
			concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as empleado, e.id as empleado_id,
			hc.reactivado, hc.fec_reactivado'))
			->join('seguimientos as s','s.cliente_id','clientes.id')
			//->join('h_estatuses as h', 'h.seguimiento_id','s.id')
			->leftJoin('historia_clientes as hc','hc.cliente_id','clientes.id')
			->join('hactividades as h', 'h.seguimiento_id','s.id')
			->join('plantels as p','p.id','clientes.plantel_id')
			//->join('users as u','u.id','h.usu_alta_id')
			->join('empleados as e','e.id','clientes.empleado_id')
			->where('h.asunto','Cambio estatus ')
			->where('h.detalle','Concretado 100%')
			//->where('clientes.matricula','like', $datos['inicio_matricula'].'%')
			->when($datos['inicio_matricula'], function($query, $datos){
				$inicios=explode(",",$datos);
				$cadena="(";
				$cantidad=count($inicios);
				$i=1;
				foreach($inicios as $inicio){
					if($i==$cantidad){
						$cadena=$cadena."clientes.matricula like '".$inicio."%'";
					}elseif($i==1){
						$cadena=$cadena."clientes.matricula like '".$inicio."%' or ";
					}else{
						$cadena=$cadena."clientes.matricula like '".$inicio."%' or ";
					}
					$i++;
				}
				$cadena=$cadena.")";
				//dd($cadena);
				return $query->whereRaw($cadena);
			})
			->where('clientes.plantel_id',$plantel_usuario->plantel_id)
			//->where('h.usu_alta_id',$plantel_usuario->usu_alta_id)
			->where('e.id',$plantel_usuario->empleado_id)
			->whereDate('h.fecha',$ayer)
			->get();

			//dd($clientes);
			
			$linea['clientes_concretados']=0;
			foreach($clientes as $cliente){
				if(is_null($cliente->reactivado)){
					$linea['clientes_concretados']=$linea['clientes_concretados']+1;
				}
			}

			$linea['prospectos_convertidos']=Prospecto::select(DB::raw('count(distinct(prospectos.id)) as total'))
			->join('clientes as c', 'c.id','prospectos.cliente_id')
			//->join('prospecto_seguimientos as s','s.prospecto_id','prospectos.id')
			//->join('prospecto_h_estatuses as h', 'h.prospecto_id','prospectos.id')
			//->where('h.tabla','seguimientos')
			//->where('h.estatus_id',5) 
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			->where('c.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereDate('c.created_at',$ayer)
			->whereNull('prospectos.deleted_at')
			->value('total');
			
			

			$linea['prospectos_creados']=Prospecto::whereDate('created_at',$ayer)
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			->where('prospectos.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('prospectos.deleted_at')
			->count();

			

			$linea['prospectos_tocados']=Prospecto::select(DB::raw('count(distinct(prospectos.id)) as total'))
			->join('prospecto_seguimientos as s','s.prospecto_id','prospectos.id')
			->join('prospecto_hactividads as h', 'h.prospecto_seguimiento_id','s.id')
			->whereDate('h.fecha',$ayer)
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			->where('h.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('prospectos.deleted_at')
			->value('total');

			$linea['avisos_creados']=ProspectoSeguimiento::join('prospecto_avisos as pa','pa.prospecto_seguimiento_id','prospecto_seguimientos.id')
			->join('prospectos as p','p.id','prospecto_seguimientos.prospecto_id')
			->whereDate('pa.created_at',$ayer)
			->where('p.plantel_id',$plantel_usuario->plantel_id)
			->where('pa.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('p.deleted_at')
			->count();

			$linea['avisos_cerrados']=ProspectoSeguimiento::join('prospecto_avisos as pa','pa.prospecto_seguimiento_id','prospecto_seguimientos.id')
			->join('prospectos as p','p.id','prospecto_seguimientos.prospecto_id')
			->whereDate('pa.updated_at',$ayer)
			->where('pa.activo',0)
			->where('p.plantel_id',$plantel_usuario->plantel_id)
			->where('pa.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('p.deleted_at')
			->count();

			$linea['tarea_informe_presencial']=Prospecto::join('prospecto_asignacion_tareas as pat','pat.prospecto_id','prospectos.id')
			->whereDate('pat.created_at',$ayer)
			->where('pat.prospecto_tarea_id',4)
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			->where('pat.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('prospectos.deleted_at')
			->count();

			$linea['tarea_informe_telefonico']=Prospecto::join('prospecto_asignacion_tareas as pat','pat.prospecto_id','prospectos.id')
			->whereDate('pat.created_at',$ayer)
			->where('pat.prospecto_tarea_id',8)
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			->where('pat.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('prospectos.deleted_at')
			->count();

			$linea['tarea_cita_plantel']=Prospecto::join('prospecto_asignacion_tareas as pat','pat.prospecto_id','prospectos.id')
			->whereDate('pat.created_at',$ayer)
			->where('pat.prospecto_tarea_id',3)
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			->where('pat.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('prospectos.deleted_at')
			->count();

			$linea['base_total']=Prospecto::join('prospecto_seguimientos as s','s.prospecto_id','prospectos.id')
			//->join('prospecto_h_estatuses as h', 'h.prospecto_seguimiento_id','s.id')
			//->where('h.tabla','seguimientos')
			->whereIn('s.prospecto_st_seg_id',array(2,3,4))
			->where('prospectos.st_prospecto_id', 2)
			//->whereDate('h.fecha',$hoy)
			->where('prospectos.plantel_id',$plantel_usuario->plantel_id)
			//->where('h.usu_alta_id',$plantel_usuario->usu_alta_id)
			->whereNull('prospectos.deleted_at')
			->count();
			//dd($linea);
			if($linea['callToAsesorAyer']>0 or 
				$linea['clientes_concretados']>0 or
				$linea['prospectos_convertidos']>0 or
				$linea['prospectos_creados']>0 or
				$linea['prospectos_tocados']>0 or
				$linea['avisos_creados']>0 or
				$linea['avisos_cerrados']>0 or
				$linea['tarea_informe_presencial']>0 or
				$linea['tarea_informe_telefonico']>0 or
				$linea['tarea_cita_plantel']>0 or
				$linea['base_total']>0){
				array_push($resumen, $linea);
			}

		}
		
		return view('prospectos.reportes.resumenProspectosTareasAvisosR', compact('resumen','datos','hoy'));
	}

	public function detalleProspectosTareasAvisosR(Request $request){
		$datos=$request->all();
		//dd($datos);
		$callToAsesorAyer=HStProspecto::select('p.razon','pro.id','sta.name as estatus_aterior',
			'std.name as estatus_despues', 'u.name as usu_alta', 'h_st_prospectos.created_at')
			->where('h_st_prospectos.st_prospecto_id',2)
			->join('st_prospectos as std','std.id','h_st_prospectos.st_prospecto_id')
			->where('h_st_prospectos.st_anterior_id',1)
			->join('st_prospectos as sta','sta.id','h_st_prospectos.st_anterior_id')
			->join('prospectos as pro', 'pro.id','h_st_prospectos.prospecto_id')
			->join('plantels as p','p.id','pro.plantel_id')
			->join('users as u','u.id','h_st_prospectos.usu_alta_id')
			->whereDate('h_st_prospectos.created_at',$datos['ayer'])
			->where('p.id',$datos['plantel'])
			//->where('h_st_prospectos.usu_alta_id',$datos['user'])
			->get();

		/*$clientes=Cliente::select(DB::raw('p.razon, clientes.id, h.fecha, h.detalle as estatus, u.name as usu_alta,
			hc.reactivado, hc.fec_reactivado'))
			->join('seguimientos as s','s.cliente_id','clientes.id')
			//->join('h_estatuses as h', 'h.seguimiento_id','s.id')
			->leftJoin('historia_clientes as hc','hc.cliente_id','clientes.id')
			->join('hactividades as h', 'h.seguimiento_id','s.id')
			->join('plantels as p','p.id','clientes.plantel_id')
			->join('users as u','u.id','h.usu_alta_id')
			->where('h.asunto','Cambio estatus ')
			->where('h.detalle','Concretado 100%')
			->where('clientes.plantel_id',$datos['plantel'])
			->where('h.usu_alta_id',$datos['user'])
			->whereDate('h.fecha',$datos['ayer'])
			->get();*/
			$clientes=Cliente::select(DB::raw('p.razon, clientes.id, h.fecha, h.detalle as estatus, 
			concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as empleado,
			hc.reactivado, hc.fec_reactivado'))
			->join('seguimientos as s','s.cliente_id','clientes.id')
			//->join('h_estatuses as h', 'h.seguimiento_id','s.id')
			->leftJoin('historia_clientes as hc','hc.cliente_id','clientes.id')
			->join('hactividades as h', 'h.seguimiento_id','s.id')
			->join('plantels as p','p.id','clientes.plantel_id')
			//->join('users as u','u.id','h.usu_alta_id')
			->join('empleados as e','e.id','clientes.empleado_id')
			->where('h.asunto','Cambio estatus ')
			->where('h.detalle','Concretado 100%')
			->where('clientes.plantel_id',$datos['plantel'])
			//->where('clientes.matricula','like', $datos['inicio_matricula'].'%')
			->when($datos['inicio_matricula'], function($query, $datos){
				$inicios=explode(",",$datos);
				$cadena="(";
				$cantidad=count($inicios);
				$i=1;
				foreach($inicios as $inicio){
					if($i==$cantidad){
						$cadena=$cadena."clientes.matricula like '".$inicio."%'";
					}elseif($i==1){
						$cadena=$cadena."clientes.matricula like '".$inicio."%' or ";
					}else{
						$cadena=$cadena."clientes.matricula like '".$inicio."%' or ";
					}
					$i++;
				}
				$cadena=$cadena.")";
				//dd($cadena);
				return $query->whereRaw($cadena);
			})
			//->where('h.usu_alta_id',$plantel_usuario->usu_alta_id)
			->where('e.id',$datos['empleado'])
			->whereDate('h.fecha',$datos['ayer'])
			->get();
			//dd($clientes);

			$prospectos_convertidos=Prospecto::select('p.razon', 'prospectos.id','c.id as cliente_id', 'u.name')
			//->join('prospecto_seguimientos as s','s.prospecto_id','prospectos.id')
			//->join('prospecto_h_estatuses as h', 'h.prospecto_id','prospectos.id')
			->join('clientes as c', 'c.id','prospectos.cliente_id')
			->join('plantels as p','p.id','prospectos.plantel_id')
			->join('users as u','u.id','c.usu_alta_id')
			//->where('h.tabla','seguimientos')
			//->where('h.estatus_id',5)
			->where('prospectos.plantel_id',$datos['plantel'])
			->where('c.usu_alta_id',$datos['user'])
			->whereDate('c.created_at',$datos['ayer'])
			->whereNull('prospectos.deleted_at')
			->get();

			$prospectos_creados=Prospecto::select('pla.razon','prospectos.id','prospectos.created_at','u.name as usu_alta')
			->join('plantels as pla','pla.id','prospectos.plantel_id')
			->join('users as u','u.id','prospectos.usu_alta_id')
			->whereDate('prospectos.created_at',$datos['ayer'])
			->where('prospectos.plantel_id',$datos['plantel'])
			->where('prospectos.usu_alta_id',$datos['user'])
			->whereNull('prospectos.deleted_at')
			->get();

			$prospectos_tocados=Prospecto::select('pla.razon','prospectos.id','h.tarea','h.asunto','h.detalle','h.created_at','u.name as usu_alta')
			->join('prospecto_seguimientos as s','s.prospecto_id','prospectos.id')
			->join('prospecto_hactividads as h', 'h.prospecto_seguimiento_id','s.id')
			->join('plantels as pla','pla.id','prospectos.plantel_id')
			->join('users as u','u.id','h.usu_alta_id')
			->whereDate('h.fecha',$datos['ayer'])
			->where('prospectos.plantel_id',$datos['plantel'])
			->where('h.usu_alta_id',$datos['user'])
			->whereNull('prospectos.deleted_at')
			->get();

			$avisos_creados=ProspectoSeguimiento::select('pla.razon','p.id','pa.detalle as detalle','pa.created_at','u.name','pa.activo')
			->join('prospecto_avisos as pa','pa.prospecto_seguimiento_id','prospecto_seguimientos.id')
			->join('prospectos as p','p.id','prospecto_seguimientos.prospecto_id')
			->join('plantels as pla','pla.id','p.plantel_id')
			->join('prospecto_asuntos as proa','proa.id','pa.prospecto_asunto_id')
			->join('users as u','u.id','pa.usu_alta_id')
			->where('p.plantel_id',$datos['plantel'])
			->where('pa.usu_alta_id',$datos['user'])
			->whereDate('pa.created_at',$datos['ayer'])
			->whereNull('p.deleted_at')
			->get();

			$avisos_cerrados=ProspectoSeguimiento::select('pla.razon','p.id','pa.detalle as detalle','pa.created_at','u.name','pa.activo')
			->join('prospecto_avisos as pa','pa.prospecto_seguimiento_id','prospecto_seguimientos.id')
			->join('prospectos as p','p.id','prospecto_seguimientos.prospecto_id')
			->join('plantels as pla','pla.id','p.plantel_id')
			->join('prospecto_asuntos as proa','proa.id','pa.prospecto_asunto_id')
			->join('users as u','u.id','pa.usu_alta_id')
			->whereDate('pa.updated_at',$datos['ayer'])
			->where('pa.activo',0)
			->where('p.plantel_id',$datos['plantel'])
			->where('pa.usu_alta_id',$datos['user'])
			->whereNull('p.deleted_at')
			->get();

			$tareas=Prospecto::select('pla.razon','prospectos.id', 'pt.name as prospecto_tarea',
			'pat.created_at','u.name as usu_alta')
			->join('prospecto_asignacion_tareas as pat','pat.prospecto_id','prospectos.id')
			->join('plantels as pla','pla.id','prospectos.plantel_id')
			->join('prospecto_tareas as pt','pt.id','pat.prospecto_tarea_id')
			->join('users as u','u.id','pat.usu_alta_id')
			->whereDate('pat.created_at',$datos['ayer'])
			->whereIn('pat.prospecto_tarea_id',array(3,4,8))
			->where('prospectos.plantel_id',$datos['plantel'])
			->where('pat.usu_alta_id',$datos['user'])
			->whereNull('prospectos.deleted_at')
			->orderBy('pat.prospecto_tarea_id')
			->get();

			$base_total=Prospecto::select('pla.razon','prospectos.id','psts.name as estatus')
			->join('prospecto_seguimientos as s','s.prospecto_id','prospectos.id')
			//->join('prospecto_h_estatuses as h', 'h.prospecto_seguimiento_id','s.id')
			->join('plantels as pla','pla.id','prospectos.plantel_id')
			//->join('users as u','u.id','h.usu_alta_id')
			->join('prospecto_st_segs as psts','psts.id','s.prospecto_st_seg_id')
			//->where('h.tabla','seguimientos')
			->whereIn('s.prospecto_st_seg_id',array(2,3,4))
			->where('prospectos.st_prospecto_id', 2)
			//->whereDate('h.fecha',$datos['hoy'])
			->where('prospectos.plantel_id',$datos['plantel'])
			//->where('h.usu_alta_id',$datos['user'])
			->whereNull('prospectos.deleted_at')
			->orderBy('s.prospecto_st_seg_id')
			->get();

			//dd($prospectos_convertidos);
		return view('prospectos.reportes.detalleProspectosTareasAvisosR', 
		compact('clientes','prospectos_convertidos','avisos_creados', 'prospectos_creados',
		'prospectos_tocados','avisos_cerrados','tareas','base_total','callToAsesorAyer'));
	}

	public function prospectosL(Request $request){
		$empleados=Empleado::select('id',DB::raw('concat(nombre, " ",ape_paterno, " ",ape_materno) as nombre'))->pluck('nombre','id');
		$empleados_seleccionados=array(4,5,7,8,10,11,219,312,313,314,563,883);
		$empleado=Empleado::where('user_id', Auth::user()->id)->first();
		$planteles=$empleado->plantels->pluck('razon','id');
		//$estatus=StProspecto::pluck('name','id');
		return view('prospectos.reportes.prospectosL', compact('planteles','empleados','empleados_seleccionados','empleado'));
	}

	public function prospectosLR(Request $request){
		$datos=$request->all();
		
		$resumen=Prospecto::select(DB::raw('prospectos.fecha, p.razon, ua.name as usuario_alta, stp.name as estatus, count(ua.name) as total'))
		->join('users as ua','ua.id','=','prospectos.usu_alta_id')
		->join('empleados as e','e.user_id','ua.id')
		->join('plantels as p','p.id','=','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','=','prospectos.st_prospecto_id')
		//->join('plantels as p','p.id','=','prospectos.plantel_id')
		->whereDate('prospectos.fecha','>=', $datos['fecha_f'])
		->whereDate('prospectos.fecha','<=', $datos['fecha_t'])
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereIn('e.id', $datos['empleado_f'])
		//->groupBy('p.razon')
		->groupBy('prospectos.fecha')
		->groupBy('p.razon')
		->groupBy('stp.name')
		->groupBy('ua.name')
		->get();
		//dd($resumen->toArray());
		$registros=Prospecto::join('users as ua','ua.id','=','prospectos.usu_alta_id')
		->join('empleados as e','e.user_id','ua.id')
		->whereDate('prospectos.created_at','>=', $datos['fecha_f'])
		->whereDate('prospectos.created_at','<=', $datos['fecha_t'])
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		->whereIn('e.id', $datos['empleado_f'])
		->get();
		return view('prospectos.reportes.prospectosLR', compact('registros', 'resumen'));
	}
}

	
