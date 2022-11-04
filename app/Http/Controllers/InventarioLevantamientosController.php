<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Plantel;
use App\Inventario;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\InventarioObservacion;
use App\InventarioLevantamiento;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\createInventarioLevantamiento;
use App\Http\Requests\updateInventarioLevantamiento;

class InventarioLevantamientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inventarioLevantamientos = InventarioLevantamiento::getAllData($request);
		$planteles=Plantel::pluck('razon','id');

		return view('inventarioLevantamientos.index', compact('inventarioLevantamientos','planteles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inventarioLevantamientos.create')
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
		//dd($datos['q']["inventario_levantamiento_id_lt"]);
		$inventarios = Inventario::getAllData($request);
		$datos=$request->all();
		$inventarioLevantamiento=InventarioLevantamiento::find($datos['q']["inventario_levantamiento_id_lt"]);
		
		
		
		return view('inventarioLevantamientos.show', compact('inventarioLevantamiento', 'inventarios'))
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
		return view('inventarioLevantamientos.edit', compact('inventarioLevantamiento'))
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
		$plantels=Plantel::pluck('razon','id');
		return view('inventarioLevantamientos.cargarCsv', compact('inventario_levantamiento_id','plantels'));
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
					$input['plantel_id'] = $datos['plantel_id'];
					$input['area'] = trim(str_replace('"','',$resultado[1]));
					$input['escuela'] = trim(str_replace('"','',$resultado[2]));
					$input['tipo_inventario'] = trim(str_replace('"','',$resultado[3]));
					$input['ubicacion'] = trim(str_replace('"','',$resultado[4]));
					$input['cantidad'] = trim(str_replace('"','',$resultado[5]));
					$input['nombre'] = trim(str_replace('"','',$resultado[6]));
					$input['medida'] = trim(str_replace('"','',$resultado[7]));
					$input['marca'] = trim(str_replace('"','',$resultado[8]));
					$input['observaciones'] = trim(str_replace('"','',$resultado[9]));
					$input['existe_si'] = trim(str_replace('"','',$resultado[10]));
					$input['existe_no'] = trim(str_replace('"','',$resultado[11]));
					$input['estado_bueno'] = trim(str_replace('"','',$resultado[12]));
					$input['estado_malo'] = trim(str_replace('"','',$resultado[13]));
					$input['usu_alta_id'] = Auth::user()->id;
					$input['usu_mod_id'] = Auth::user()->id;
					$input['origen']=$nombre;
					//dd($input);
					$total_lineas++;
					Inventario::create($input);
				}
			}
			$i++;
		}
		$inventario_levantamiento_id=$datos['inventario_levantamiento_id'];
		$plantels=Plantel::pluck('razon','id');
		//return redirect()->route('inventarioLevantamientos.index');
		return view('inventarioLevantamientos.cargarCsv', compact('inventario_levantamiento_id','plantels', 'nombre', 'total_lineas'));
	}

	public function descargarCsv(Request $request){
		$datos=$request->all();
		//dd($datos);
		$table = Inventario::where('inventario_levantamiento_id', $datos['id'])
			->where('plantel_id', $datos['plantel_id'])
			->get();	
		if(isset($datos['csv'])){
			$filename = storage_path('app') . "/public/Inventario".$datos['plantel_id'].".csv";
			$handle = fopen($filename, 'w+');
			fputcsv($handle, array("ID","PLANTEL_ID","AREA","ESCUELA","TIPO INVENTARIO","UBICACION","CANTIDAD","NOMBRE","MEDIDA","MARCA","OBSERVACIONES","EXISTE-SI","EXISTE-NO","ESTADO-BUENO","ESTADO-MALO"));

			foreach($table as $row) {
				fputcsv($handle, array($row->id,$row->plantel_id, $row->area, $row->escuela, $row->tipo_inventario,$row->ubicacion,
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
		$inventarioLevantamiento=InventarioLevantamiento::pluck('fecha','id');
		$destino=$request->input('destino');
		return view('inventarioLevantamientos.copiarAnterior', compact('inventarioLevantamiento','destino'));	
	}

	public function copiaLineas(Request $request){
		$datos=$request->all();
		$origen=InventarioLevantamiento::find($datos['origen']);
		foreach($origen->inventarios as $inventario){
			$input['plantel_id']=$inventario->plantel_id;
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
			Inventario::create($input);
		}
		return redirect()->route('inventarioLevantamientos.index');
	}

	public function dictamen(Request $request){
		$datos=$request->all();
		$plantel=Plantel::find($datos['plantel_id']);
		$inventarioLevantamiento=InventarioLevantamiento::find($datos['id']);
		$inventarioObservaciones=InventarioObservacion::where('inventario_levantamiento_id', $datos['id'])
		->where('plantel_id', $datos['plantel_id'])->get();
		return view('inventarioLevantamientos.reportes.dictamen', compact('plantel', 'inventarioObservaciones','inventarioLevantamiento'));
	}
}
