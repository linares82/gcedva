<?php

namespace App\Http\Controllers;

use Auth;
use App\Cliente;

use Carbon\Carbon;
use App\FormatoDgcft;
use App\Http\Requests;
use App\FormatoDgcftDetalle;
use Illuminate\Http\Request;
use App\FormatoDgcftMatCalif;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\createFormatoDgcft;
use App\Http\Requests\updateFormatoDgcft;

class FormatoDgcftsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$formatoDgcfts = FormatoDgcft::getAllData($request);


		return view('formatoDgcfts.index', compact('formatoDgcfts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('formatoDgcfts.create')
			->with('list', FormatoDgcft::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFormatoDgcft $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		FormatoDgcft::create($input);

		return redirect()->route('formatoDgcfts.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->find($id);
		return view('formatoDgcfts.show', compact('formatoDgcft'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->with('formatoDgcftDetalles')->find($id);
		//dd($formatoDgcft);
		return view('formatoDgcfts.edit', compact('formatoDgcft'))
			->with('list', FormatoDgcft::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->find($id);
		return view('formatoDgcfts.duplicate', compact('formatoDgcft'))
			->with('list', FormatoDgcft::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FormatoDgcft $formatoDgcft, updateFormatoDgcft $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$formatoDgcft = $formatoDgcft->find($id);
		$formatoDgcft->update($input);

		return redirect()->route('formatoDgcfts.edit', $formatoDgcft->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, FormatoDgcft $formatoDgcft)
	{
		$formatoDgcft = $formatoDgcft->find($id);
		$formatoDgcft->delete();

		return redirect()->route('formatoDgcfts.index')->with('message', 'Registro Borrado.');
	}

	public function generarLineas(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$clientes_id = explode(",", $formatoDgcft->clientes);
		//$controls = explode(",", $formatoDgcft->control);
		//$escolaridads = explode(",", $formatoDgcft->escolaridad);
		//$becas = explode(",", $formatoDgcft->beca);
		//$resultados = explode(",", $formatoDgcft->resultados);
		//$finals = explode(",", $formatoDgcft->final);
		$contador = 1;
		$control_inicio=$datos['control_inicio'];
		//dd($clientes_id);
		foreach ($clientes_id as $llave => $cliente_id) {
			//dd($llave."-".$cliente_id);
			//Log::info($llave);
			$existe_cliente = FormatoDgcftDetalle::where('formato_dgcft_id', $formatoDgcft->id)
				->where('cliente_id', trim($cliente_id))
				->first();
			if (is_null($existe_cliente)) {

				$cliente = Cliente::find(trim($cliente_id));
				$inputFormatoDgcftdetalle['formato_dgcft_id'] = $formatoDgcft->id;
				$inputFormatoDgcftdetalle['num'] = $contador;
				//$inputFormatoDgcftdetalle['control'] = trim($controls[$llave]);
				$inputFormatoDgcftdetalle['control']=$datos['control_parte_fija'].str_pad($control_inicio,7,"0",STR_PAD_LEFT); 
				$inputFormatoDgcftdetalle['cliente_id'] = $cliente->id;
				$inputFormatoDgcftdetalle['nombre'] = $cliente->ape_paterno . " " . $cliente->ape_materno . " " . $cliente->nombre . " " . $cliente->nombre2;
				$inputFormatoDgcftdetalle['curp'] = $cliente->curp;
				$fecha_referencia = Carbon::createFromFormat("Y-m-d", $formatoDgcft->fec_edad);
				$edad = Carbon::createFromFormat("Y-m-d", $cliente->fec_nacimiento)->diffInYears($fecha_referencia);
				$inputFormatoDgcftdetalle['edad'] = $edad;
				$inputFormatoDgcftdetalle['fec_sexo'] = $cliente->genero == 1 ? "H" : "M";
				//$inputFormatoDgcftdetalle['escolaridad'] = trim($escolaridads[$llave]);
				$inputFormatoDgcftdetalle['escolaridad'] = $cliente->escolaridad_id;
				//$inputFormatoDgcftdetalle['beca'] = trim($becas[$llave]);
				$beca=$cliente->autorizacionBecas->where('st_beca_id',4)->last();
				$inputFormatoDgcftdetalle['beca'] = "-";
				if(!is_null($beca)){
					$inputFormatoDgcftdetalle['beca'] = ($beca->monto_inscripcion*100)."%";
				}
				
				//$inputFormatoDgcftdetalle['resultado'] = trim($resultados[$llave]);
				//$inputFormatoDgcftdetalle['final'] = trim($finals[$llave]);
				$inputFormatoDgcftdetalle['usu_alta_id'] = Auth::user()->id;
				$inputFormatoDgcftdetalle['usu_mod_id'] = Auth::user()->id;
				//dd($inputFormatoDgcftdetalle);
				FormatoDgcftDetalle::create($inputFormatoDgcftdetalle);
				$contador++;
				$control_inicio++;
			}
		}
		return redirect()->route('formatoDgcfts.edit', $datos['id']);
	}



	public function generarCalificaciones(Request $request)
	{
		$datos = $request->all();
		$formatoDgcft = FormatoDgcft::find($datos['id']);
		$materias = explode(',', $formatoDgcft->materias);
		$grados=explode(',',$formatoDgcft->grados);
		$ids = FormatoDgcftDetalle::where('formato_dgcft_id', $formatoDgcft->id)
			->pluck('id');
		//dd($ids->toArray());
		foreach ($materias as $llave_materia => $materia) {
			$series = explode('-', $formatoDgcft->calificaciones);
			//dd($series);
			foreach ($series as $llave_serie => $serie) {
				if ($llave_materia == $llave_serie) {
					$calificaciones = explode(',', $serie);
					foreach ($calificaciones as $llave => $calificacion) {
						$formatoDgcftMatCalif = FormatoDgcftMatCalif::where('formato_dgcft_detalle_id', $ids[$llave])
							->where('materia', trim($materia))
							->first();
						if (is_null($formatoDgcftMatCalif)) {
							$input['formato_dgcft_detalle_id'] = $ids[$llave];
							$input['grado'] = trim($grados[$llave_materia]);
							$input['materia'] = trim($materia);
							$input['calificacion'] = $calificacion;
							$input['usu_alta_id'] = Auth::user()->id;
							$input['usu_mod_id'] = Auth::user()->id;

							FormatoDgcftMatCalif::create($input);
						}
					}
				}
			}
		}

		/*
		$resultados = explode(",", $formatoDgcft->resultados);
		$finals = explode(",", $formatoDgcft->final);

		foreach ($formatoDgcft->formatoDgcftDetalles as $detalle) {
			$detalle->update(
				['resultado' => trim($resultados[$detalle->num - 1])]
			);
			$detalle->update(
				['final' => trim($finals[$detalle->num - 1])]
			);
		}*/
		


		return redirect()->route('formatoDgcfts.edit', $datos['id']);
	}

	public function destroyCalificacion(Request $request){
		$datos=$request->all();
		$calificacion=FormatoDgcftMatCalif::find($datos['id']);
		$calificacion->delete();
		return redirect()->route('formatoDgcfts.edit', $datos['formato_dgcft_id']);
	}

	public function limpiarLineas(Request $request){
		$datos=$request->all();
		$formatoDgcft=FormatoDgcft::find($datos['id']);
		foreach($formatoDgcft->formatoDgcftDetalles as $detalle){
			$detalle->delete();
		}
		return redirect()->route('formatoDgcfts.edit', $datos['id']);
	}

	public function ieap04(Request $request){
		$datos=$request->all();
		$formatoDgcft=FormatoDgcft::find($datos['id']);
		$materias=explode(',',$formatoDgcft->materias);
		return view('formatoDgcfts.reportes.ieap04', compact('formatoDgcft','materias'));
	}

	public function riap02(Request $request){
		$datos=$request->all();
		$formatoDgcft=FormatoDgcft::find($datos['id']);
		$materias=explode(',',$formatoDgcft->materias);
		return view('formatoDgcfts.reportes.riap02', compact('formatoDgcft','materias'));
	}

	public function icp08(Request $request){
		$datos=$request->all();
		$formatoDgcft=FormatoDgcft::find($datos['id']);
		$detalles=$formatoDgcft->formatoDgcftDetalles;

		$materias=explode(',',$formatoDgcft->materias);
		return view('formatoDgcfts.reportes.icp08', compact('formatoDgcft','materias','detalles'));
	}

	public function icp08XMateria(Request $request){
		$datos=$request->all();
		$formatoDgcft=FormatoDgcft::find($datos['id']);
		$detalles=FormatoDgcftDetalle::select()
		->join('formato_dgcft_mat_califs as mc','mc.formato_dgcft_detalle_id','formato_dgcft_detalles.id')
		->where('mc.materia', $datos['materia'])
		->where('formato_dgcft_detalles.formato_dgcft_id',$datos['id'])
		->get();

		$materias=explode(',',$formatoDgcft->materias);
		return view('formatoDgcfts.reportes.icp08XMateria', compact('formatoDgcft','detalles'));
	}
}
