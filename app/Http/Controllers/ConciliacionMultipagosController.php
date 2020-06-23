<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ConciliacionMultipago;
use App\ConciliacionMultiDetalle;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateConciliacionMultipago;
use App\Http\Requests\createConciliacionMultipago;
use Storage;
use Log;
class ConciliacionMultipagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$conciliacionMultipagos = ConciliacionMultipago::getAllData($request);

		return view('conciliacionMultipagos.index', compact('conciliacionMultipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('conciliacionMultipagos.create')
			->with( 'list', ConciliacionMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createConciliacionMultipago $request)
	{

		$input = $request->all();

		$input['fecha_carga']=date('Y-m-d');
		$input['registros']=0;
		$input['contador_ejecucion']=0;
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		$r = $request->hasFile('archivo');
		//dd($r);
		if ($r) {
			$archivo = $request->file('archivo');
			$input['archivo'] = $archivo->getClientOriginalName();
		}

		//create data
		$e=ConciliacionMultipago::create( $input );

		if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $extension = $file->getClientOriginalExtension();
            $nombre = date('dmYhmi') . $file->getClientOriginalName();
            $r = Storage::disk('conciliaciones')->put($nombre, \File::get($file));
            
            $e->archivo = $nombre;
            $e->save();
		}
			
		//dd($file);
		$fp = fopen($file, "r");
		$i=0;
		
		while(!feof($fp)) {
			$registro=array();
			//$file=storage_path('conciliaciones\\'.$nombre);
			$linea = fgets($fp);
			Log::info("linea ".$i.": ".$linea);
			if(trim($linea)<>""){
				$posicion=0;
				$longitud=0;
				$registro['conciliacion_multipago_id']=$e->id;
				$longitud=26;
				$registro['fecha_pago']=substr($linea,$posicion,$longitud);
				$posicion=$posicion+$longitud;
				$longitud=50;
				$registro['razon_social']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=10;
				$registro['mp_node']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=10;
				$registro['mp_concept']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=10;
				$registro['mp_paymentmethod']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=40;
				$registro['mp_reference']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=40;
				$registro['mp_order']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=10;
				$registro['no_aprobacion']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=20;
				$registro['identificador_venta']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=20;
				$registro['ref_medio_pago']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=22;
				$registro['importe']=floatval(trim(substr($linea,$posicion,$longitud)));
				$posicion=$posicion+$longitud;
				$longitud=22;
				$registro['comision']=floatval(trim(substr($linea,$posicion,$longitud)));
				$posicion=$posicion+$longitud;
				$longitud=22;
				$registro['iva_comision']=floatval(trim(substr($linea,$posicion,$longitud)));
				$posicion=$posicion+$longitud;
				$longitud=10;
				$registro['fecha_dispersion']=substr($linea,$posicion,$longitud);
				$posicion=$posicion+$longitud;
				$longitud=2;
				$registro['periodo_financiamiento']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=1;
				$registro['moneda']=substr($linea,$posicion,$longitud);
				$posicion=$posicion+$longitud;
				$longitud=100;
				$registro['banco_emisor']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=100;
				$registro['mp_customername']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=50;
				$registro['mail']=trim(substr($linea,$posicion,$longitud));
				$posicion=$posicion+$longitud;
				$longitud=50;
				$registro['tel_customername']=trim(substr($linea,$posicion,$longitud));
				$registro['usu_alta_id']=Auth::user()->id;
				$registro['usu_mod_id']=Auth::user()->id;
				//dd($registro);
				ConciliacionMultiDetalle::create($registro);
				$i++;
				//dd($registro['archivo']);
			}
			
		}
		$e->registros=$i;
		$e->update();

		fclose($fp);

		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Registro Creado.');
	}

	public function ejecutarConciliacion(Request $request){
		$registros=ConciliacionMultiDetalle::where('conciliacion_multipagos_id',$request['id']);
		foreach($registros as $pago){
			$pagoBuscado=PeticionMultipago::where('mp_order',)
			->where('mp_reference',$pago->mp_reference)
			->where('mp_order',$pago->mp_order)
			->where('mp_amount',$pago->mp_monto)
			->first();
			if(!is_null($pagoBuscado) and optional($pagoBuscado->pago)->bnd_pagado<>1){
				$pagoBuscado->pago->bnd_pagado=1;
				$pagoBuscado->pago->bnd_pagado->save();
			}
		}
		$conciliacion=ConciliacionMultipago::find($request['id'])->increments('contador_ejecucion',1);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago=$conciliacionMultipago->find($id);
		return view('conciliacionMultipagos.show', compact('conciliacionMultipago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago=$conciliacionMultipago->find($id);
		return view('conciliacionMultipagos.edit', compact('conciliacionMultipago'))
			->with( 'list', ConciliacionMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago=$conciliacionMultipago->find($id);
		return view('conciliacionMultipagos.duplicate', compact('conciliacionMultipago'))
			->with( 'list', ConciliacionMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ConciliacionMultipago $conciliacionMultipago, updateConciliacionMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$conciliacionMultipago=$conciliacionMultipago->find($id);
		$conciliacionMultipago->update( $input );

		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago=$conciliacionMultipago->find($id);
		$conciliacionMultipago->delete();

		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Registro Borrado.');
	}

}
