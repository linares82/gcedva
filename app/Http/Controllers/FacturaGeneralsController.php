<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Caja;
use App\FacturaGeneral;
use App\FacturaGeneralLinea;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFacturaGeneral;
use App\Http\Requests\createFacturaGeneral;

class FacturaGeneralsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$facturaGenerals = FacturaGeneral::getAllData($request);

		return view('facturaGenerals.index', compact('facturaGenerals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('facturaGenerals.create')
			->with( 'list', FacturaGeneral::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFacturaGeneral $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		FacturaGeneral::create( $input );

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		return view('facturaGenerals.show', compact('facturaGeneral'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		return view('facturaGenerals.edit', compact('facturaGeneral'))
			->with( 'list', FacturaGeneral::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		return view('facturaGenerals.duplicate', compact('facturaGeneral'))
			->with( 'list', FacturaGeneral::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FacturaGeneral $facturaGeneral, updateFacturaGeneral $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$facturaGeneral=$facturaGeneral->find($id);
		$facturaGeneral->update( $input );

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		$facturaGeneral->usu_eliminar_id=Auth::user()->id;
		$facturaGeneral->save();
		$facturaGeneral->delete();

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Borrado.');
	}

	public function recargarLineas($id){
		$facturaGeneral=FacturaGeneral::find($id);
		$lineas=FacturaGeneralLinea::where('factura_general_id',$facturaGeneral->id)->get();
		if($lineas->count()>0){
			foreach($lineas as $ln){
				$ln->delete();
			}
		}
		$registrosSinFactura=Caja::select('pla.razon','c.id as cliente_id','c.nombre','c.nombre2','c.ape_paterno',
			'c.ape_materno','cajas.fecha as fecha_caja','p.fecha as fecha_pago','cc.name as concepto','p.uuid',
			'cajas.id as caja_id','p.id as pago_id','p.monto','a.id as adeudo_id')
			->join('caja_lns as ln','ln.caja_id','=','cajas.id')
			->join('clientes as c','c.id','=','cajas.cliente_id')
			->join('adeudos as a','a.id','=','ln.adeudo_id')
			->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
			->join('pagos as p','p.caja_id','=','cajas.id')
			->join('plantels as pla','pla.id','=','cajas.plantel_id')
			->where('a.pagado_bnd',1)
			->where('p.fecha','<=',$facturaGeneral->fec_fin)
			->where('p.fecha','>=',$facturaGeneral->fec_inicio)
			->where('cajas.fecha','<=',$facturaGeneral->fec_fin)
			->where('cajas.fecha','>=',$facturaGeneral->fec_inicio)
			->where('pla.id',$facturaGeneral->plantel_id)
			->where('a.pagado_bnd',1)
			->where('cc.bnd_mensualidad',1)
			->whereNull('p.uuid')
			->whereNull('a.deleted_at')
			->whereNull('cajas.deleted_at')
			->whereNull('ln.deleted_at')
			->whereNull('p.deleted_at')
			->orderBy('cajas.cliente_id')
			->orderBy('p.fecha')
			->get();
		//dd($registrosSinFactura->toArray());
		foreach($registrosSinFactura as $registro){
			$input['factura_general_id']=$facturaGeneral->id;
			$input['cliente_id']=$registro->cliente_id;
			$input['caja_id']=$registro->caja_id;
			$input['pago_id']=$registro->pago_id;
			$input['bnd_incluido']=1;
			$input['monto']=$registro->monto;
			$input['usu_mod_id']=Auth::user()->id;
			$input['usu_alta_id']=Auth::user()->id;
			FacturaGeneralLinea::create($input);
			$suma=$suma+$registro->monto;
		}
		$facturaGeneral->total=$suma;
		$facturaGeneral->save();

		//$this->detalle($facturaGeneral->id);
		return redirect()->route('facturaGenerals.detalle', $facturaGeneral->id);
	}

	public function detalle($id){
		$facturaGeneral=FacturaGeneral::find($id);
		$lineas=FacturaGeneralLinea::where('factura_general_id',$facturaGeneral->id)
		->with('caja')
		->with('pago')
		->with('cliente')
		->with('facturaGeneral')
		->get();
		
		//dd($facturaGeneral);
		
		//dd($registrosSinFactura->toArray());

		return view('facturaGenerals.detalle', compact('lineas','facturaGeneral'));
	}

	public function total(Request $request){
		$datos=$request->all();
		$facturaGeneral=FacturaGeneral::find($datos['id']);
		$suma=FacturaGeneralLinea::where('factura_general_id',$datos['id'])->where('bnd_incluido',1)->sum('monto');

		$facturaGeneral->total=$suma;
		$facturaGeneral->save();

		$lineas=FacturaGeneralLinea::where('factura_general_id',$facturaGeneral->id)
		->with('caja')
		->with('pago')
		->with('cliente')
		->with('facturaGeneral')
		->get();
		return view('facturaGenerals.detalle', compact('lineas','facturaGeneral'));
	}

}
