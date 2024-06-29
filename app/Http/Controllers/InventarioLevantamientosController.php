<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Plantel;
use Carbon\Carbon;
use App\Inventario;
use App\Http\Requests;
use App\PlantelInventario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\InventarioObservacion;
use App\InventarioLevantamiento;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\createInventarioLevantamiento;
use App\Http\Requests\updateInventarioLevantamiento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class InventarioLevantamientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	/*
	 public function index(Request $request)
	{
		$inventarioLevantamientos = InventarioLevantamiento::getAllData($request);
		$planteles=PlantelInventario::pluck('name','id');

		return view('inventarioLevantamientos.index', compact('inventarioLevantamientos','planteles'));
	}*/

	public function index(Request $request)
	{
		$datos=$request->all();
		//dd($datos["q"]["fecha_f"]);
		$inventarioLevantamientos=InventarioLevantamiento::getAllData($request);
		//dd($inventarioLevantamientos);
		/*$inventarioLevantamientos_aux=InventarioLevantamiento::select('inventario_levantamientos.id',
		'pi.name as plantel','st_il.name as st_il',
		'inventario_levantamientos.fecha')
		->join('inventarios as i','i.inventario_levantamiento_id','inventario_levantamientos.id')
		->join('plantel_inventarios as pi','pi.id','i.plantel_inventario_id')
		->join('inventario_levantamiento_sts as st_il','st_il.id','inventario_levantamientos.inventario_levantamiento_st_id')
		->distinct();

		if(isset($datos["q"]["fecha_f"]) and isset($datos["q"]["fecha_f"])){
			$inventarioLevantamientos=$inventarioLevantamientos_aux->whereDate('inventario_levantamientos.fecha','>=',$datos["q"]["fecha_f"])
			->whereDate('inventario_levantamientos.fecha','<=',$datos["q"]["fecha_t"]);
		}else{
			$fecha=Carbon::createFromFormat('Y-m-d',date('Y-m-d'))->subYear()->toDateString();
			$inventarioLevantamientos=$inventarioLevantamientos_aux->whereDate('inventario_levantamientos.fecha', '>=', $fecha);
		}
		$inventarioLevantamientos=$inventarioLevantamientos_aux->get();
		*/
		//dd($inventarioLevantamientos);
		
		
		$planteles=PlantelInventario::pluck('name','id');

		return view('inventarioLevantamientos.index', compact('inventarioLevantamientos','planteles'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$planteles=PlantelInventario::pluck('name','id');
		return view('inventarioLevantamientos.create', compact('planteles'))
			->with( 'list', InventarioLevantamiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInventarioLevantamiento $request)
	{

		$input = $request->all();
		
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['inventario_levantamiento_st_id']=1;

		//create data
		InventarioLevantamiento::create( $input );

		return redirect()->route('inventarioLevantamientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request)
	{
		//dd($request);
		
		
		$datos=$request->all();
		//dd($datos['q']["inventario_levantamiento_id_lt"]);
		$inventarioLevantamiento=InventarioLevantamiento::find($datos['q']["inventario_levantamiento_id_lt"]);
		//dd($request);
		$inventarios = Inventario::getAllData($request);
		//$inventarios = Inventario::where('inventario_levantamiento_id',$datos['q']["inventario_levantamiento_id_lt"])->get();
		//dd($datos);
		$planteles=PlantelInventario::pluck('name','id');
		$planteles->prepend('Seleccionar opcion', 0);
		$catEstado=array('0'=>'SELECCIONAR', 'BUENO'=>'BUENO', 'MALO'=>'MALO');
		$catExiste=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		
		
		return view('inventarioLevantamientos.show', compact('inventarioLevantamiento', 'inventarios','planteles','catEstado','catExiste'))
		->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, InventarioLevantamiento $inventarioLevantamiento)
	{
		$inventarioLevantamiento=$inventarioLevantamiento->find($id);
		$planteles=PlantelInventario::pluck('name','id');
		return view('inventarioLevantamientos.edit', compact('inventarioLevantamiento','planteles'))
			->with( 'list', InventarioLevantamiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, InventarioLevantamiento $inventarioLevantamiento)
	{
		$inventarioLevantamiento=$inventarioLevantamiento->find($id);
		return view('inventarioLevantamientos.duplicate', compact('inventarioLevantamiento'))
			->with( 'list', InventarioLevantamiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, InventarioLevantamiento $inventarioLevantamiento, updateInventarioLevantamiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inventarioLevantamiento=$inventarioLevantamiento->find($id);
		$inventarioLevantamiento->update( $input );

		return redirect()->route('inventarioLevantamientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,InventarioLevantamiento $inventarioLevantamiento)
	{
		$inventarioLevantamiento=$inventarioLevantamiento->find($id);
		$inventarioLevantamiento->delete();

		return redirect()->route('inventarioLevantamientos.index')->with('message', 'Registro Borrado.');
	}

	public function cargarCsv(Request $request){
		$datos=$request->all();
		$inventario_levantamiento_id=$datos['inventario_levantamiento_id'];
		$cabecera=InventarioLevantamiento::find($datos['inventario_levantamiento_id']);
		$plantels=PlantelInventario::pluck('name','id');
		return view('inventarioLevantamientos.cargarCsv', compact('inventario_levantamiento_id','plantels','cabecera'));
	}

	public function cargarLineas(Request $request){
		$datos=$request->all();
		//dd($datos);
		$r = $request->hasFile('archivo');
		//dd($r);
		if ($r) {
			$archivo = $request->file('archivo');
			$input['archivo'] = $archivo->getClientOriginalName();
		}

		//create data
		//$e = FacturaG::create($input);
		//dd($request->hasFile('archivo'));
		if ($request->hasFile('archivo')) {
			$file = $request->file('archivo');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			
			try{
				$r = Storage::disk('inventario')->put($nombre, \File::get($file));
			}catch(Exception $e){
				dd($e);
			}
			

			//$e->archivo = $nombre;
			//$e->save();
		}

		//dd($file);
		$fp = fopen($file, "r");
		$i = 0;
		$total_lineas=0;
		while (!feof($fp)) {
			$registro = array();
			//$file=storage_path('conciliaciones\\'.$nombre);


			$linea_aux = fgets($fp);
			$linea = utf8_encode($linea_aux);
			//dd(utf8_encode($linea));
			//Log::info("linea " . $i . ": " . $linea);
			if ($i >= 1) {
				//dd($linea);
				if (trim($linea) <> "") {
					//dd($linea);
					$resultado = explode(',', $linea);
					//dd($resultado);
					$input = array();
					$input['inventario_levantamiento_id'] = $datos['inventario_levantamiento_id'];
					$input['plantel_inventario_id'] = $datos['plantel_id'];
					$input['area'] = trim(str_replace('"','',$resultado[1]));
					//$input['escuela'] = trim(str_replace('"','',$resultado[2]));
					//$input['tipo_inventario'] = trim(str_replace('"','',$resultado[3]));
					$input['ubicacion'] = trim(str_replace('"','',$resultado[2]));
					$input['cantidad'] = trim(str_replace('"','',$resultado[3]));
					$input['nombre'] = trim(str_replace('"','',$resultado[4]));
					$input['medida'] = trim(str_replace('"','',$resultado[5]));
					$input['marca'] = trim(str_replace('"','',$resultado[6]));
					$input['observaciones'] = trim(str_replace('"','',$resultado[7]));
					$input['existe_si'] = trim(str_replace('"','',$resultado[8]));
					//$input['existe_no'] = trim(str_replace('"','',$resultado[9]));
					$input['estado_bueno'] = trim(str_replace('"','',$resultado[9]));
					//$input['estado_malo'] = trim(str_replace('"','',$resultado[11]));
					$input['usu_alta_id'] = Auth::user()->id;
					$input['usu_mod_id'] = Auth::user()->id;
					$input['origen']=$nombre;
					$input['no_inventario']=$this->generarNoInventarioPlantel($datos['plantel_id'])+1;
					//dd($input);
					$total_lineas++;
					Inventario::create($input);
				}
			}
			$i++;
		}
		$inventario_levantamiento_id=$datos['inventario_levantamiento_id'];
		$plantels=PlantelInventario::pluck('name','id');
		//return redirect()->route('inventarioLevantamientos.index');
		return view('inventarioLevantamientos.cargarCsv', compact('inventario_levantamiento_id','plantels', 'nombre', 'total_lineas'));
	}

	public function actualizarCsv(Request $request){
		$datos=$request->all();
		$inventario_levantamiento_id=$datos['inventario_levantamiento_id'];
		return view('inventarioLevantamientos.actualizarCsv', compact('inventario_levantamiento_id'));
	}

	public function actualizarLineas(Request $request){
		$datos=$request->all();
		//dd($datos);
		$r = $request->hasFile('archivo');
		//dd($r);
		if ($r) {
			$archivo = $request->file('archivo');
			$input['archivo'] = $archivo->getClientOriginalName();
		}

		//create data
		//$e = FacturaG::create($input);
		//dd($request->hasFile('archivo'));
		if ($request->hasFile('archivo')) {
			$file = $request->file('archivo');
			$extension = $file->getClientOriginalExtension();
			$nombre = "actualizar".date('dmYhmi') . $file->getClientOriginalName();
			
			try{
				$r = Storage::disk('inventario')->put($nombre, \File::get($file));
			}catch(Exception $e){
				dd($e);
			}
			

			//$e->archivo = $nombre;
			//$e->save();
		}

		//dd($file);
		$fp = fopen($file, "r");
		$i = 0;
		$total_lineas=0;
		$total_campos=0;
		while (!feof($fp)) {
			$registro = array();
			//$file=storage_path('conciliaciones\\'.$nombre);


			$linea_aux = fgets($fp);
			$linea = utf8_encode($linea_aux);
			//dd(utf8_encode($linea));
			//Log::info("linea " . $i . ": " . $linea);
			if ($i >= 1) {
				//dd($linea);
				if (trim($linea) <> "") {
					//dd($linea);
					
					$resultado = explode(',', $linea);
					//dd($resultado);
					try{
						$registroExistente=Inventario::findOrFail(trim(str_replace('"','',$resultado[0])));
						$inventario_levantamiento_id=$registroExistente->inventario_levantamiento_id;
					}catch(ModelNotFoundException $e){
						dd('Registro con id '.$resultado[0].' no encontrado, recuerde que el valor de la columna id no debe ser modificado en el archivo .csv');
					}
					
					//dd($registroExistente);
					if($registroExistente->area!=trim(str_replace('"','',$resultado[2]))){
						$registroExistente->area=trim(str_replace('"','',$resultado[2]));
						$total_campos++;
					}
					if($registroExistente->escuela!=trim(str_replace('"','',$resultado[3]))){
						$registroExistente->escuela=trim(str_replace('"','',$resultado[3]));
						$total_campos++;
					}
					if($registroExistente->tipo_inventario!=trim(str_replace('"','',$resultado[4]))){
						$registroExistente->tipo_inventario=trim(str_replace('"','',$resultado[4]));
						$total_campos++;
					}
					if($registroExistente->ubicacion!=trim(str_replace('"','',$resultado[5]))){
						$registroExistente->ubicacion=trim(str_replace('"','',$resultado[5]));
						$total_campos++;
					}
					if($registroExistente->cantidad!=trim(str_replace('"','',$resultado[6]))){
						$registroExistente->cantidad=trim(str_replace('"','',$resultado[6]));
						$total_campos++;
					}
					if($registroExistente->nombre!=trim(str_replace('"','',$resultado[7]))){
						$registroExistente->nombre=trim(str_replace('"','',$resultado[7]));
						$total_campos++;
					}
					if($registroExistente->medida!=trim(str_replace('"','',$resultado[8]))){
						$registroExistente->medida=trim(str_replace('"','',$resultado[8]));
						$total_campos++;
					}
					if($registroExistente->marca!=trim(str_replace('"','',$resultado[9]))){
						$registroExistente->marca=trim(str_replace('"','',$resultado[9]));
						$total_campos++;
					}
					if($registroExistente->observaciones!=trim(str_replace('"','',$resultado[10]))){
						$registroExistente->observaciones=trim(str_replace('"','',$resultado[10]));
						$total_campos++;
					}
					if($registroExistente->existe_si!=trim(str_replace('"','',$resultado[11]))){
						$registroExistente->existe_si=trim(str_replace('"','',$resultado[11]));
						$total_campos++;
					}
					if($registroExistente->existe_no!=trim(str_replace('"','',$resultado[12]))){
						$registroExistente->existe_no=trim(str_replace('"','',$resultado[12]));
						$total_campos++;
					}
					if($registroExistente->estado_bueno!=trim(str_replace('"','',$resultado[13]))){
						$registroExistente->estado_bueno=trim(str_replace('"','',$resultado[13]));
						$total_campos++;
					}
					if($registroExistente->estado_malo!=trim(str_replace('"','',$resultado[14]))){
						$registroExistente->estado_malo=trim(str_replace('"','',$resultado[14]));
						$total_campos++;
					}
					$registroExistente->origen=$nombre;
					$registroExistente->save();
					
					$total_lineas++;
				}
			}
			$i++;
		}
		
		//return redirect()->route('inventarioLevantamientos.index');
		return view('inventarioLevantamientos.actualizarCsv', compact('inventario_levantamiento_id', 'nombre', 'total_lineas','total_campos'));
	}

	public function descargarCsv(Request $request){
		$datos=$request->all();
		//dd($datos);
		$table = Inventario::where('inventario_levantamiento_id', $datos['id'])
			->where('plantel_inventario_id', $datos['plantel_id'])
			->get();	
		//dd($table);
		if(isset($datos['csv'])){
			$filename = storage_path('app') . "/public/Inventario".$datos['plantel_id'].".csv";
			$handle = fopen($filename, 'w+');
			fputcsv($handle, array("NO_ID","PLANTEL_ID","AREA","ESCUELA","TIPO INVENTARIO","UBICACION","CANTIDAD","NOMBRE","MEDIDA","MARCA","OBSERVACIONES","EXISTE-SI","EXISTE-NO","ESTADO-BUENO","ESTADO-MALO"));

			foreach($table as $row) {
				fputcsv($handle, array($row->no_inventario,$row->plantel_inventario_id, $row->area, $row->escuela, $row->tipo_inventario,$row->ubicacion,
									$row->cantidad,$row->nombre,$row->medida,$row->marca,
									$row->observaciones,$row->existe_si,$row->existe_no,$row->estado_bueno,
									$row->estado_malo));
			}

			fclose($handle);

			$headers = array(
				'Content-Type' => 'text/csv',
			);
			return response()->download($filename, 'Inventario'.$datos['plantel_id'].'.csv', $headers);
		}else{
			return view('inventarioLevantamientos.reportes.formato', compact('table'));	
		}
		

		
	}

	public function copiarAnterior(Request $request){
		$inventarioLevantamiento=InventarioLevantamiento::join('plantel_inventarios as pi','pi.id','inventario_levantamientos.plantel_inventario_id')
		->select('inventario_levantamientos.id', DB::raw('concat(pi.name,"-",inventario_levantamientos.fecha) as fecha'))
		->pluck('fecha','inventario_levantamientos.id');
		$destino=$request->input('destino');
		return view('inventarioLevantamientos.copiarAnterior', compact('inventarioLevantamiento','destino'));	
	}

	public function copiaLineas(Request $request){
		$datos=$request->all();
		$origen=InventarioLevantamiento::find($datos['origen']);
		foreach($origen->inventarios as $inventario){
			$input['plantel_inventario_id']=$inventario->plantel_inventario_id;
			$input['area']=$inventario->area;
			$input['escuela']=$inventario->escuela;
			$input['tipo_inventario']=$inventario->tipo_inventario;
			$input['ubicacion']=$inventario->ubicacion;
			$input['cantidad']=$inventario->cantidad;
			$input['nombre']=$inventario->nombre;
			$input['medida']=$inventario->medida;
			$input['marca']=$inventario->marca;
			$input['observaciones']=$inventario->observaciones;
			$input['existe_si']=$inventario->existe_si;
			$input['existe_no']=$inventario->existe_no;
			$input['estado_bueno']=$inventario->estado_bueno;
			$input['estado_malo']=$inventario->estado_malo;
			$input['inventario_levantamiento_id']=$datos['destino'];
			$input['origen']='copia';
			$input['usu_alta_id']=Auth::user()->id;
			$input['usu_mod_id']=Auth::user()->id;
			$input['no_inventario']=$inventario->no_inventario;
			Inventario::create($input);
		}
		return redirect()->route('inventarioLevantamientos.index');
	}

	public function dictamen(Request $request){
		$datos=$request->all();
		$plantel=PlantelInventario::find($datos['plantel_id']);
		$inventarioLevantamiento=InventarioLevantamiento::find($datos['id']);

		//dd($datos);
		$inventarioObservaciones=InventarioObservacion::where('inventario_levantamiento_id', $datos['id'])
		->where('plantel_inventario_id', $datos['plantel_id'])->get();
		return view('inventarioLevantamientos.reportes.dictamen', compact('plantel', 'inventarioObservaciones','inventarioLevantamiento'));
	}

	public function inicioLevantamiento(){
		$planteles=PlantelInventario::pluck('name','id');
		$catEstado=array('0'=>'SELECCIONAR', 'BUENO'=>'BUENO', 'MALO'=>'MALO');
		$catExiste=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		
		return view('inventarioLevantamientos.reportes.inicioLevantamiento', compact('planteles','catExiste','catEstado'));
	}

	public function inicioLevantamientoLista(Request $request){
		$datos=$request->all();
		//dd($datos);
		$areas=explode(',', $datos['area']);
		$cadena_areas="";
		foreach($areas as $llave=>$valor){
			$areas[$llave]="%".trim($valor)."%";
		}
		//dd($areas);
		$resultado_aux=Inventario::select('pi.id as plantel_id','pi.name as plantel','il.fecha','inventarios.area',
		'estado_bueno', 'existe_si')
		->join('inventario_levantamientos as il','il.id','inventarios.inventario_levantamiento_id')
		->join('plantel_inventarios as pi','pi.id','inventarios.plantel_inventario_id')
		->whereIn('inventarios.plantel_inventario_id',$datos['plantel_f']);
		//->whereIn('inventarios.area', 'like', $areas)
		foreach($areas as $area){	
			$resultado_aux->where('area','like', $area);
		}

		$resultado= $resultado_aux->whereIn('inventarios.estado_bueno', $datos['estado_bueno'])
		->whereIn('inventarios.existe_si', $datos['existe_si'])
		->whereDate('il.fecha','>=', $datos['fecha_f'])
		->whereDate('il.fecha','<=', $datos['fecha_t'])
		->distinct()
		->orderBy('il.fecha','desc')
		->get();
		$planteles=PlantelInventario::pluck('name','id');
		$catEstado=array('0'=>'SELECCIONAR', 'BUENO'=>'BUENO', 'MALO'=>'MALO');
		$catExiste=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		//dd($resultado);
		return view('inventarioLevantamientos.reportes.inicioLevantamiento', compact('resultado','planteles','catExiste','catEstado'));
	}

	public function inicioLevantamientoC(){
		$planteles=PlantelInventario::pluck('name','id');
		$catEstado=array('0'=>'SELECCIONAR', 'BUENO'=>'BUENO', 'MALO'=>'MALO','ESPECIAL'=>'SEGMENTACION ESPECIAL');
		$catExiste=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		$sinSegmentos=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		
		return view('inventarioLevantamientos.reportes.inicioLevantamientoC', compact('planteles','catExiste','catEstado','sinSegmentos'));
	}

	public function inicioLevantamientoListaC(Request $request){
		$datos=$request->all();
		//dd($datos);
		
		//dd($areas);
		$resultado_aux=Inventario::join('inventario_levantamientos as il','il.id','inventarios.inventario_levantamiento_id')
		->join('plantel_inventarios as pi','pi.id','inventarios.plantel_inventario_id')
		->whereIn('inventarios.plantel_inventario_id',$datos['plantel_f']);
		//->whereIn('inventarios.area', 'like', $areas)
		if($datos['incluir_segmentos_existe_estado']=='SI' and !in_array("ESPECIAL",$datos['estado_bueno'])){
			$resultado_aux->whereIn('inventarios.estado_bueno', $datos['estado_bueno'])
				->whereIn('inventarios.existe_si', $datos['existe_si'])
				->select('pi.id as plantel_id','pi.name as plantel','il.fecha',
				'estado_bueno', 'existe_si');		
		}elseif($datos['incluir_segmentos_existe_estado']=='SI' and in_array("ESPECIAL",$datos['estado_bueno'])){
			$resultado_aux->whereIn('inventarios.existe_si', $datos['existe_si'])
				->select('pi.id as plantel_id','pi.name as plantel','il.fecha',
				'existe_si');	
		}else{
			$resultado_aux->select('pi.id as plantel_id','pi.name as plantel','il.fecha');		
		}
		//dd(in_array("ESPECIAL",$datos['estado_bueno']));
		
		
		$resultado= $resultado_aux->whereDate('il.fecha','>=', $datos['fecha_f'])
		->whereDate('il.fecha','<=', $datos['fecha_t'])
		->distinct()
		->orderBy('il.fecha','desc')
		->get();
		$planteles=PlantelInventario::pluck('name','id');
		$catEstado=array('0'=>'SELECCIONAR', 'BUENO'=>'BUENO', 'MALO'=>'MALO','ESPECIAL'=>'SEGMENTACION ESPECIAL');
		$catExiste=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		$sinSegmentos=array('0'=>'SELECCIONAR','SI'=>'SI', 'NO'=>'NO');
		
		return view('inventarioLevantamientos.reportes.inicioLevantamientoC', compact('resultado','planteles','catExiste','catEstado','sinSegmentos'));
	}

	public function inicioLevantamientoCsv(Request $request){
		$datos=$request->all();
		//dd($datos);
		$resultado_aux=Inventario::select('il.fecha','pi.name as plantel', 'inventarios.*')
		->join('inventario_levantamientos as il','il.id','inventarios.inventario_levantamiento_id')
		->join('plantel_inventarios as pi','pi.id','inventarios.plantel_inventario_id')
		->where('inventarios.plantel_inventario_id',$datos['plantel']);
		if(isset($datos['area'])){
			$resultado_aux->where('inventarios.area',$datos['area']);
		}
		if(isset($datos['estado_bueno'])){
			$resultado_aux->where('inventarios.estado_bueno',$datos['estado_bueno']);
		}
		if(isset($datos['existe_si']) and isset($datos['estado_bueno'])){
			$resultado_aux->where('inventarios.existe_si',$datos['existe_si']);
		}elseif(isset($datos['existe_si']) and !isset($datos['estado_bueno'])){
			if($datos['existe_si']=='SI'){
				$resultado_aux->where('inventarios.estado_bueno',['MALO']);
			}else{
			$resultado_aux->where('inventarios.estado_bueno',['MALO','BUENO']);
			}
		}

		$resultado=$resultado_aux->where('il.fecha',$datos['fecha'])
		//->where('inventarios.estado_bueno',$datos['estado_bueno'])
		//->where('inventarios.existe_si',$datos['existe_si'])
		->get();

/*		$table = Inventario::where('inventario_levantamiento_id', $datos['id'])
			->where('plantel_inventario_id', $datos['plantel'])
			->get();
*/
		$filename = storage_path('app') . "/public/Inventario".$datos['plantel'].".csv";
			$handle = fopen($filename, 'w+');
			fputcsv($handle, array("ID","PLANTEL_ID","AREA","ESCUELA","TIPO INVENTARIO","UBICACION","CANTIDAD","NOMBRE","MEDIDA","MARCA","OBSERVACIONES","EXISTE-SI/NO","ESTADO-BUENO/MALO"));

			foreach($resultado as $row) {
				fputcsv($handle, array($row->id,$row->plantel_inventario_id, $row->area, $row->escuela, $row->tipo_inventario,$row->ubicacion,
									$row->cantidad,$row->nombre,$row->medida,$row->marca,
									$row->observaciones,$row->existe_si,$row->estado_bueno));
			}

			fclose($handle);

			$headers = array(
				'Content-Type' => 'text/csv',
			);
			return response()->download($filename, 'Inventario'.$datos['plantel'].'.csv', $headers);

		//dd($resultado);
		//return view('inventarioLevantamientos.reportes.inicioLevantamiento', compact('planteles'));
	}

	public function inicioLevantamientoFormato(Request $request){
		$datos=$request->all();
		//dd($datos);
		$resultado_aux=Inventario::select('il.fecha','pi.name as plantel', 'inventarios.*')
		->join('inventario_levantamientos as il','il.id','inventarios.inventario_levantamiento_id')
		->join('plantel_inventarios as pi','pi.id','inventarios.plantel_inventario_id')
		->where('inventarios.plantel_inventario_id',$datos['plantel'])
		->where('il.fecha',$datos['fecha']);
		if(isset($datos['area'])){
			$resultado_aux->where('inventarios.area',$datos['area']);
		}
		if(isset($datos['estado_bueno'])){
			$resultado_aux->where('inventarios.estado_bueno',$datos['estado_bueno']);
		}
		if(isset($datos['existe_si'])){
			$resultado_aux->where('inventarios.existe_si',$datos['existe_si']);
		}
		/*
		->where('inventarios.estado_bueno',$datos['estado_bueno'])
		->where('inventarios.existe_si',$datos['existe_si'])
		*/
		$resultado=$resultado_aux->get();
		//dd($resultado);
		//return view('inventarioLevantamientos.reportes.inicioLevantamiento', compact('planteles'));
		return view('inventarioLevantamientos.reportes.formato', array('table'=>$resultado));	
	}

	public function generarNoInventarioPlantel($plantel_id){
		$no_inventario=Inventario::where('plantel_inventario_id',$plantel_id)->max('no_inventario');
		return intVal($no_inventario);
	}
}
