<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CajaLn;
use App\Caja;
use App\Adeudo;
use App\Cliente;
use App\CombinacionCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCajaLn;
use App\Http\Requests\createCajaLn;

class CajaLnsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cajaLns = CajaLn::getAllData($request);

		return view('cajaLns.index', compact('cajaLns'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cajaLns.create')
			->with( 'list', CajaLn::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCajaLn $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CajaLn::create( $input );

		return redirect()->route('cajaLns.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CajaLn $cajaLn)
	{
		$cajaLn=$cajaLn->find($id);
		return view('cajaLns.show', compact('cajaLn'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CajaLn $cajaLn)
	{
		$cajaLn=$cajaLn->find($id);
		return view('cajaLns.edit', compact('cajaLn'))
			->with( 'list', CajaLn::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CajaLn $cajaLn)
	{
		$cajaLn=$cajaLn->find($id);
		return view('cajaLns.duplicate', compact('cajaLn'))
			->with( 'list', CajaLn::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CajaLn $cajaLn, updateCajaLn $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cajaLn=$cajaLn->find($id);
		$cajaLn->update( $input );

		return redirect()->route('cajaLns.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CajaLn $cajaLn)
	{
                
		$cajaLn=$cajaLn->find($id);
                if($cajaLn->adeudo_id<>0){
                    $adeudo=Adeudo::find($cajaLn->adeudo_id);
                    $adeudo->caja_id=0;
                    $adeudo->save();
                }
                $caja=Caja::find($cajaLn->caja_id);
                
                $caja->subtotal=$caja->subtotal-$cajaLn->subtotal;
                $caja->recargo=$caja->recargo-$cajaLn->recargo;
                $caja->descuento=$caja->descuento-$cajaLn->descuento;
                $caja->total=$caja->total-$cajaLn->total;
                $caja->save();
                $cliente=Cliente::find($caja->cliente_id);
		$cajaLn->delete();
                $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
                $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();

		return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );
	}

}
