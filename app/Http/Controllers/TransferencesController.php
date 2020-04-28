<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Empleado;
use App\Transference;
use App\CuentasEfectivo;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests\updateTransference;
use App\Http\Requests\createTransference;
use App\Plantel;
use File as Archi;

class TransferencesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$transferences = Transference::getAllData($request);

		return view('transferences.index', compact('transferences'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cuentasEfectivo = CuentasEfectivo::pluck('name', 'id');
		$empleados = Empleado::select('id', DB::raw('concat(nombre, " ",ape_paterno," ",ape_materno) as name'))->pluck('name', 'id');
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = array();
		foreach ($empleado->plantels as $p) {
			//dd($p->id);
			array_push($planteles, $p->id);
		}
		if (Auth::user()->can('transferencia.filtroPlantel')) {
			//$plantels = Plantel::where('id', $empleado->plantel_id)->pluck('razon', 'id');
			$plantels = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
		} else {
			$plantels = Plantel::pluck('razon', 'id');
		}
		return view('transferences.create', compact('cuentasEfectivo', 'empleados', 'plantels'))
			->with('list', Transference::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTransference $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		Transference::create($input);

		return redirect()->route('transferences.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Transference $transference)
	{
		$transference = $transference->find($id);
		return view('transferences.show', compact('transference'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Transference $transference)
	{
		$transference = $transference->find($id);
		$cuentasEfectivo = CuentasEfectivo::pluck('name', 'id');
		$empleados = Empleado::select('id', DB::raw('concat(nombre, " ",ape_paterno," ",ape_materno) as name'))->pluck('name', 'id');
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = array();
		foreach ($empleado->plantels as $p) {
			//dd($p->id);
			array_push($planteles, $p->id);
		}
		if (Entrust::can('transferencia.filtroPlantel')) {
			//$plantels = Plantel::where('id', $empleado->plantel_id)->pluck('razon', 'id');
			$plantels = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
		} else {
			$plantels = Plantel::pluck('razon', 'id');
		}

		return view('transferences.edit', compact('transference', 'cuentasEfectivo', 'empleados', 'plantels'))
			->with('list', Transference::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Transference $transference)
	{
		$transference = $transference->find($id);
		return view('transferences.duplicate', compact('transference'))
			->with('list', Transference::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Transference $transference, updateTransference $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;

		$r = $request->hasFile('comprobante_file');
		if ($r) {
			$comprobante_file = $request->file('comprobante_file');
			$input['archivo'] = $comprobante_file->getClientOriginalName();
		}
		//dd($input);
		//update data
		$transference = $transference->find($id);
		$e = $transference->update($input);

		if ($e) {
			$ruta = public_path() . "/imagenes/transferencias/" . $transference->id . "/";
			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if ($request->file('comprobante_file')) {
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('comprobante_file')->move($ruta, $input['archivo']);
			}
		}

		return redirect()->route('transferences.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Transference $transference)
	{
		$transference = $transference->find($id);
		$transference->delete();

		return redirect()->route('transferences.index')->with('message', 'Registro Borrado.');
	}

	public function recibo($id, Request $request)
	{
		$transferencia = Transference::find($id);
		return view('transferences.reportes.recibo', array('transferencia' => $transferencia));
	}
}
