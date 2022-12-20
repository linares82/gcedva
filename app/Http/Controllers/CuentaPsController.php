<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentaP;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuentaP;
use App\Http\Requests\createCuentaP;
use App\Mese;
use App\SerieFolioSimplificado;

class CuentaPsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentaPs = CuentaP::getAllData($request);

		return view('cuentaPs.index', compact('cuentaPs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuentaPs.create')
			->with('list', CuentaP::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentaP $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		CuentaP::create($input);

		return redirect()->route('cuentaPs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentaP $cuentaP)
	{
		$cuentaP = $cuentaP->find($id);
		return view('cuentaPs.show', compact('cuentaP'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentaP $cuentaP)
	{
		$cuentaP = $cuentaP->find($id);
		return view('cuentaPs.edit', compact('cuentaP'))
			->with('list', CuentaP::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentaP $cuentaP)
	{
		$cuentaP = $cuentaP->find($id);
		return view('cuentaPs.duplicate', compact('cuentaP'))
			->with('list', CuentaP::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentaP $cuentaP, updateCuentaP $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$cuentaP = $cuentaP->find($id);
		$cuentaP->update($input);

		return redirect()->route('cuentaPs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, CuentaP $cuentaP)
	{
		$cuentaP = $cuentaP->find($id);
		$cuentaP->delete();

		return redirect()->route('cuentaPs.index')->with('message', 'Registro Borrado.');
	}

	public function createSeriesFolios()
	{
		$cuentas = CuentaP::all();
		$meses = Mese::where('id', '<', 13)->get();

		

		foreach ($cuentas as $cuenta) {
			
			$anio_siguiente=0;
			if($cuenta->anio<>""){
				$anio_siguiente=$cuenta->anio;
			}else{
				$anio_siguiente=Date('Y')+1;
			}
			
			$anio_generado = SerieFolioSimplificado::where('anio', $anio_siguiente)->where('cuenta_p_id', $cuenta->id)->get();
			if ($anio_generado->count() == 0) {
				$datos['cuenta_p_id'] = $cuenta->id;
				$datos['serie'] = ($cuenta->serie=="" ? 'AB' : $cuenta->serie);
				$datos['folio_inicial'] = '0';
				$datos['folio_actual'] = '0';
				$datos['anio'] = $anio_siguiente;
				$datos['mese_id'] = 13;
				$datos['bnd_activo'] = '1';
				$datos['bnd_fiscal'] = '1';
				$datos['usu_alta_id'] = '1';
				$datos['usu_mod_id'] = '1';
				SerieFolioSimplificado::create($datos);
				foreach ($meses as $mes) {
					$datos['cuenta_p_id'] = $cuenta->id;
					$datos['serie'] = ($cuenta->serie=="" ? 'AB' : $cuenta->serie);
					$datos['folio_inicial'] = '0';
					$datos['folio_actual'] = '0';
					$datos['anio'] = $anio_siguiente;
					$datos['mese_id'] = $mes->id;
					$datos['bnd_activo'] = '1';
					$datos['bnd_fiscal'] = '0';
					$datos['usu_alta_id'] = '1';
					$datos['usu_mod_id'] = '1';
					SerieFolioSimplificado::create($datos);
				}
			}
		}

		return redirect()->route('cuentaPs.index')->with('message', 'Series y folios generados.');
	}
}
