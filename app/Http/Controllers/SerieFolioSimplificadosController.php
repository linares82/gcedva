<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentaP;
use App\SerieFolioSimplificado;
use App\Mese;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSerieFolioSimplificado;
use App\Http\Requests\createSerieFolioSimplificado;

class SerieFolioSimplificadosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$serieFolioSimplificados = SerieFolioSimplificado::getAllData($request);
		$cuentap = $request->input('cuentap');
		//dd($request->all());
		$descCuentap = CuentaP::find($cuentap);

		return view('serieFolioSimplificados.index', compact('serieFolioSimplificados', 'cuentap', 'descCuentap'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$meses = Mese::pluck('name', 'id');
		$cuentap = $request->input('cuentap');
		return view('serieFolioSimplificados.create', compact('meses', 'cuentap'))
			->with('list', SerieFolioSimplificado::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSerieFolioSimplificado $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		if (!isset($input['bnd_fiscal'])) {
			$input['bnd_fiscal'] = 0;
		}
		if (!isset($input['bnd_activo'])) {
			$input['bnd_fiscal'] = 0;
		}
		$cuentap = $input['cuenta_p_id'];

		//create data
		SerieFolioSimplificado::create($input);

		//return redirect()->route('serieFolioSimplificados.index')->with('message', 'Registro Creado.');
		return redirect('serieFolioSimplificados/index' . "?q%5Bs%5D=&q%5Bcuenta_ps.id_cont%5D=" . $cuentap . "&q%5Bserie_cont%5D=&q%5Bfolio_inicial_cont%5D=&q%5Bfolio_actual_cont%5D=&q%5Banio_cont%5D=&q%5Bmes_id_cont%5D=&q%5Bbnd_activo_cont%5D=&q%5Busu_alta_id_cont%5D=&q%5Busu_mod_id_cont%5D=&commit=Buscar&cuentap=" . $cuentap)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SerieFolioSimplificado $serieFolioSimplificado)
	{
		$serieFolioSimplificado = $serieFolioSimplificado->find($id);
		return view('serieFolioSimplificados.show', compact('serieFolioSimplificado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SerieFolioSimplificado $serieFolioSimplificado)
	{
		$serieFolioSimplificado = $serieFolioSimplificado->find($id);
		$meses = Mese::pluck('name', 'id');
		return view('serieFolioSimplificados.edit', compact('serieFolioSimplificado', 'meses'))
			->with('list', SerieFolioSimplificado::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SerieFolioSimplificado $serieFolioSimplificado)
	{
		$serieFolioSimplificado = $serieFolioSimplificado->find($id);
		return view('serieFolioSimplificados.duplicate', compact('serieFolioSimplificado'))
			->with('list', SerieFolioSimplificado::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SerieFolioSimplificado $serieFolioSimplificado, updateSerieFolioSimplificado $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		if (!isset($input['bnd_fiscal'])) {
			$input['bnd_fiscal'] = 0;
		}
		if (!isset($input['bnd_activo'])) {
			$input['bnd_fiscal'] = 0;
		}
		//update data
		$serieFolioSimplificado = $serieFolioSimplificado->find($id);
		$serieFolioSimplificado->update($input);
		$cuentap = $serieFolioSimplificado->cuenta_p_id;
		//return redirect()->route('serieFolioSimplificados.index')->with('message', 'Registro Actualizado.');
		return redirect('serieFolioSimplificados/index' . "?q%5Bs%5D=&q%5Bcuenta_ps.id_cont%5D=" . $cuentap . "&q%5Bserie_cont%5D=&q%5Bfolio_inicial_cont%5D=&q%5Bfolio_actual_cont%5D=&q%5Banio_cont%5D=&q%5Bmes_id_cont%5D=&q%5Bbnd_activo_cont%5D=&q%5Busu_alta_id_cont%5D=&q%5Busu_mod_id_cont%5D=&commit=Buscar&cuentap=" . $cuentap)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, SerieFolioSimplificado $serieFolioSimplificado)
	{
		$serieFolioSimplificado = $serieFolioSimplificado->find($id);
		$serieFolioSimplificado->delete();

		return redirect()->route('serieFolioSimplificados.index')->with('message', 'Registro Borrado.');
	}
}
