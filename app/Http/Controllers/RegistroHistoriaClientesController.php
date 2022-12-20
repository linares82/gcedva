<?php

namespace App\Http\Controllers;

use App\Adeudo;
use App\HistoriaCliente;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RegistroHistoriaCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateRegistroHistoriaCliente;
use App\Http\Requests\createRegistroHistoriaCliente;
use App\Inscripcion;
use App\Cliente;
use App\Seguimiento;

class RegistroHistoriaClientesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$registroHistoriaClientes = RegistroHistoriaCliente::getAllData($request);

		return view('registroHistoriaClientes.index', compact('registroHistoriaClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('registroHistoriaClientes.create')
			->with('list', RegistroHistoriaCliente::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createRegistroHistoriaCliente $request)
	{

		$input = $request->except('autorizacion');
		//dd($input) ;
		$campo_autorizacion = $request->only('autorizacion');
		//dd($campo_autorizacion['autorizacion']);
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		$input['campo_etapa']= $campo_autorizacion['autorizacion'];
		//dd($input);
		//create data
		$r = RegistroHistoriaCliente::create($input);
		
		$historiaCliente = HistoriaCliente::find($r->historia_cliente_id);
		if ($campo_autorizacion['autorizacion'] == 'aut_caja') {
			$historiaCliente->aut_caja = $r->st_historia_cliente_id;
			$historiaCliente->st_historia_cliente_id = 6;
		} elseif ($campo_autorizacion['autorizacion'] == 'aut_director') {
			$historiaCliente->aut_director = $r->st_historia_cliente_id;
			//$historiaCliente->st_historia_cliente_id = 6;
			$historiaCliente->st_historia_cliente_id = $r->st_historia_cliente_id;
		}elseif ($campo_autorizacion['autorizacion'] == 'aut_caja_corp') {
			$historiaCliente->aut_caja_corp = $r->st_historia_cliente_id;
			$historiaCliente->st_historia_cliente_id = $r->st_historia_cliente_id;
		}
		if($historiaCliente->st_historia_cliente_id==2){
			$historiaCliente->fec_autorizacion=date('Y-m-d');
		}
		$historiaCliente->save();
		$e = $historiaCliente;
		if (
			$historiaCliente->aut_caja == 2 and
			$historiaCliente->aut_director == 2 and
			//$historiaCliente->aut_caja_corp == 2 and
			$historiaCliente->st_historia_cliente_id == 2
		) {
			if ($e->evento_cliente_id == 4) {
				$cliente = Cliente::find($e->cliente_id);
				$cliente->st_cliente_id = 24;
				$cliente->save();
			} elseif ($e->evento_cliente_id == 2) {
			
				/*if(!is_null($e->inscripcion_id)){
					$inscripcion = Inscripcion::find($e->inscripcion_id);
					if (!is_null($inscripcion)) {
						$inscripcion->st_inscripcion_id = 3;
						$inscripcion->save();
					}
				}*/
				$inscripciones = Inscripcion::where('cliente_id',$e->cliente_id)->whereNull('deleted_at')->count();
				if ($inscripciones>0) {
					$inscripcionesR = Inscripcion::where('cliente_id',$e->cliente_id)->whereNull('deleted_at')->get();
					foreach($inscripcionesR as $inscripcion){
						$inscripcion->st_inscripcion_id = 3;
						$inscripcion->save();
					}
				}
					
				$adeudos = Adeudo::where('cliente_id', $e->cliente_id)
					->where('caja_id', 0)
					->where('pagado_bnd', 0)
					->whereDate('adeudos.fecha_pago','>',Date('Y-m-d'))
					->get();
				//dd($adeudos->toArray());
				foreach ($adeudos as $adeudo) {
					$adeudo->delete();
				}

				$inscripcions = Inscripcion::where('cliente_id', $e->cliente_id)->where('st_inscripcion_id', '<>', 3)->whereNull('deleted_at')->count();

				if ($inscripcions == 0) {
					$cliente = Cliente::find($e->cliente_id);
					$cliente->st_cliente_id = 3;
					$cliente->save();

					$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
					$seguimiento->st_seguimiento_id = 6;
					$seguimiento->save();
				}


				//dd("echo");     
			} elseif ($e->evento_cliente_id == 6) {
				$cliente = Cliente::find($e->cliente_id);
				$cliente->st_cliente_id = 4;
				$cliente->save();

				$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
				$seguimiento->st_seguimiento_id = 2;
				$seguimiento->save();
			}
		}
		return $e;
		//return redirect()->route('registroHistoriaClientes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, RegistroHistoriaCliente $registroHistoriaCliente)
	{
		$registroHistoriaCliente = $registroHistoriaCliente->find($id);
		return view('registroHistoriaClientes.show', compact('registroHistoriaCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, RegistroHistoriaCliente $registroHistoriaCliente)
	{
		$registroHistoriaCliente = $registroHistoriaCliente->find($id);
		return view('registroHistoriaClientes.edit', compact('registroHistoriaCliente'))
			->with('list', RegistroHistoriaCliente::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, RegistroHistoriaCliente $registroHistoriaCliente)
	{
		$registroHistoriaCliente = $registroHistoriaCliente->find($id);
		return view('registroHistoriaClientes.duplicate', compact('registroHistoriaCliente'))
			->with('list', RegistroHistoriaCliente::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, RegistroHistoriaCliente $registroHistoriaCliente, updateRegistroHistoriaCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$registroHistoriaCliente = $registroHistoriaCliente->find($id);
		$registroHistoriaCliente->update($input);

		return redirect()->route('registroHistoriaClientes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, RegistroHistoriaCliente $registroHistoriaCliente)
	{
		$registroHistoriaCliente = $registroHistoriaCliente->find($id);
		$registroHistoriaCliente->delete();

		return redirect()->route('registroHistoriaClientes.index')->with('message', 'Registro Borrado.');
	}

	public function findByHistoriaClienteId(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		/*$vistos = RegistroHistoriaCliente::where('historia_cliente_id', $datos['check'])->get();
		foreach ($vistos as $v) {
			$v->bnd_visto = 1;
			$v->save();
		}*/

		$registros = RegistroHistoriaCliente::select(
			'registro_historia_clientes.id',
			'registro_historia_clientes.comentario',
			'registro_historia_clientes.created_at',
			'u.name as user',
			'st.name as estatus'
		)
			->where('historia_cliente_id', $datos['check'])
			->join('st_historia_clientes as st', 'st.id', '=', 'registro_historia_clientes.st_historia_cliente_id')
			->join('users as u', 'u.id', '=', 'registro_historia_clientes.usu_alta_id')
			->orderBy('registro_historia_clientes.id', 'desc')
			->get();

		echo $registros->toJson();
	}
}
