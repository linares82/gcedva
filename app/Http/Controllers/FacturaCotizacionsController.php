<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CotizacionCurso;
use App\FacturaCotizacion;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFacturaCotizacion;
use App\Http\Requests\createFacturaCotizacion;

class FacturaCotizacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$facturaCotizacions = FacturaCotizacion::getAllData($request);

		return view('facturaCotizacions.index', compact('facturaCotizacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('facturaCotizacions.create')
			->with( 'list', FacturaCotizacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFacturaCotizacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                $this->pagarCotizacion($input['cotizacion_curso_id']);
		//create data
		FacturaCotizacion::create( $input );

		//return redirect()->route('facturaCotizacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FacturaCotizacion $facturaCotizacion)
	{
		$facturaCotizacion=$facturaCotizacion->find($id);
		return view('facturaCotizacions.show', compact('facturaCotizacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FacturaCotizacion $facturaCotizacion)
	{
		$facturaCotizacion=$facturaCotizacion->find($id);
		return view('facturaCotizacions.edit', compact('facturaCotizacion'))
			->with( 'list', FacturaCotizacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaCotizacion $facturaCotizacion)
	{
		$facturaCotizacion=$facturaCotizacion->find($id);
		return view('facturaCotizacions.duplicate', compact('facturaCotizacion'))
			->with( 'list', FacturaCotizacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FacturaCotizacion $facturaCotizacion, updateFacturaCotizacion $request)
	{
                
		$input = $request->all();
                //dd($input);
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$facturaCotizacion=$facturaCotizacion->find($id);
		$facturaCotizacion->update( $input );
                $this->pagarCotizacion($facturaCotizacion->cotizacion_curso_id);
		//return redirect()->route('facturaCotizacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FacturaCotizacion $facturaCotizacion)
	{
		$facturaCotizacion=$facturaCotizacion->find($id);
		$facturaCotizacion->delete();
                $this->pagarCotizacion($facturaCotizacion->cotizacion_curso_id);
		//return redirect()->route('facturaCotizacions.index')->with('message', 'Registro Borrado.');
                return redirect()->route('cotizacionCursos.cotizacionesEmpresa',array('empresa'=>$facturaCotizacion->cotizacionCurso->empresa_id))->with('message', 'Registro Borrado.');
	}
        
        public function getByCotizacionCursoId(Request $request){
            $datos=$request->all();
            $lineas= FacturaCotizacion::select('factura_cotizacions.id','factura_cotizacions.cotizacion_curso_id','factura_cotizacions.no_factura',
                                               'factura_cotizacions.fecha','factura_cotizacions.monto','factura_cotizacions.forma_pago_id',
                                               'fp.name as forma_pago')
                                        ->join('forma_pagos as fp','fp.id','=','factura_cotizacions.forma_pago_id')
                                        ->where('cotizacion_curso_id', $datos['cotizacion_curso'])->get();
                    
            //dd($lineas->toArray());
            echo $lineas->toJson();
        }
        
        public function pagarCotizacion($cotizacion){
            $cotizacion= CotizacionCurso::find($cotizacion);
            $suma_facturas=0;
            foreach($cotizacion->facturaCotizacions as $linea){
                $suma_facturas=$suma_facturas+$linea->monto;
            }
            if($suma_facturas >= $cotizacion->total){
                $cotizacion->st_curso_empresa_id=5;
                $cotizacion->save();
            }
            
        }
}
