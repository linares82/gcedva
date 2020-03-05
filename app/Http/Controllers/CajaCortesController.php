<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CajaCorte;
use App\Egreso;
use App\Empleado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCajaCorte;
use App\Http\Requests\createCajaCorte;
use App\Pago;

class CajaCortesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cajaCortes = CajaCorte::getAllData($request);

		return view('cajaCortes.index', compact('cajaCortes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();

		$ultimoCorte = CajaCorte::where('plantel_id', $empleado->plantel_id)->latest()->first();
		$vUltimoCorte = array();
		if (!is_object($ultimoCorte)) {
			$vUltimoCorte['id'] = 0;
			$vUltimoCorte['monto_calculado'] = 0;
			$vUltimoCorte['monto_real'] = 0;
			$vUltimoCorte['faltante'] = 0;
			$vUltimoCorte['sobrante'] = 0;
			$vUltimoCorte['usu_alta'] = "";
			$vUltimoCorte['created_at'] = "";
		} else {
			$vUltimoCorte['id'] = $ultimoCorte->id;
			$vUltimoCorte['monto_calculado'] = $ultimoCorte->monto_calculado;
			$vUltimoCorte['monto_real'] = $ultimoCorte->monto_real;
			$vUltimoCorte['faltante'] = $ultimoCorte->faltante;
			$vUltimoCorte['sobrante'] = $ultimoCorte->sobrante;
			$vUltimoCorte['usu_alta'] = $ultimoCorte->usu_alta->name;
			$vUltimoCorte['created_at'] = $ultimoCorte->created_at;
		}
		//dd($vUltimoCorte);

		$pagos = Pago::select(
			'p.razon as plantel',
			'caj.consecutivo',
			'pagos.monto',
			'fp.name as forma_pago',
			'u.name as user',
			'pagos.created_at'
		)
			->where('pagos.created_at', '>=', $vUltimoCorte['created_at'])
			//->whereDate('pagos.fecha', date('2020-01-31'))
			->join('cajas as caj', 'caj.id', '=', 'pagos.caja_id')
			->join('clientes as c', 'c.id', '=', 'caj.cliente_id')
			->join('forma_pagos as fp', 'fp.id', '=', 'pagos.forma_pago_id')
			->join('users as u', 'u.id', 'pagos.usu_alta_id')
			->join('plantels as p', 'p.id', 'caj.plantel_id')
			->where('c.plantel_id', $empleado->plantel_id)
			->where('pagos.forma_pago_id', 1)
			->get();

		$egresos = Egreso::select(
			'p.razon as plantel',
			'egresos.id',
			'egresos.monto',
			'fp.name as forma_pago',
			'u.name as user',
			'egresos.created_at'
		)
			->join('plantels as p', 'p.id', 'egresos.plantel_id')
			->join('forma_pagos as fp', 'fp.id', '=', 'egresos.forma_pago_id')
			->join('users as u', 'u.id', 'egresos.usu_alta_id')
			->whereDate('egresos.created_at', '>=', $vUltimoCorte['created_at'])
			//->whereDate('fecha', Date('2020-01-31'))
			->where('plantel_id', $empleado->plantel_id)
			->where('forma_pago_id', 1)
			->get();


		return view('cajaCortes.create', compact('pagos', 'egresos', 'vUltimoCorte'))
			->with('list', CajaCorte::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCajaCorte $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$input['plantel_id'] = $empleado->plantel_id;
		$input['fecha'] = Date('Y-m-d');
		//dd($input);
		//create data
		CajaCorte::create($input);

		return redirect()->route('cajas.caja')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CajaCorte $cajaCorte)
	{
		$cajaCorte = $cajaCorte->find($id);
		return view('cajaCortes.show', compact('cajaCorte'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CajaCorte $cajaCorte)
	{
		$cajaCorte = $cajaCorte->find($id);
		return view('cajaCortes.edit', compact('cajaCorte'))
			->with('list', CajaCorte::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CajaCorte $cajaCorte)
	{
		$cajaCorte = $cajaCorte->find($id);
		return view('cajaCortes.duplicate', compact('cajaCorte'))
			->with('list', CajaCorte::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CajaCorte $cajaCorte, updateCajaCorte $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$cajaCorte = $cajaCorte->find($id);
		$cajaCorte->update($input);

		return redirect()->route('cajaCortes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, CajaCorte $cajaCorte)
	{
		$cajaCorte = $cajaCorte->find($id);
		$cajaCorte->delete();

		return redirect()->route('cajaCortes.index')->with('message', 'Registro Borrado.');
	}
}
