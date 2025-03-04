<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AutorizacionBeca;
use App\Cliente;
use App\Empleado;
use App\Lectivo;
use App\Plantel;
use App\StBeca;
use App\TipoBeca;
use App\Param;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAutorizacionBeca;
use App\Http\Requests\createAutorizacionBeca;
use File as Archi;

class AutorizacionBecasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$autorizacionBecas = AutorizacionBeca::getAllData($request);
		$estatus = StBeca::pluck('name', 'id');
		$plantels = Plantel::pluck('razon', 'id');
		return view('autorizacionBecas.index', compact('autorizacionBecas', 'estatus', 'plantels'));
	}

	public function findByClienteId(Request $request)
	{
		$autorizacionBecas = AutorizacionBeca::where('cliente_id', $request->input('cliente_id'))->paginate(25);
		$cliente = $request->input('cliente_id');
		$stBecas = StBeca::where('id', '>', 1)->pluck('name', 'id');

		return view('autorizacionBecas.findByClienteId', compact('autorizacionBecas', 'cliente', 'stBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$datos = $request->all();
		$cliente = Cliente::find($datos['id']);
		$tipo_becas = TipoBeca::pluck('name', 'id');
		$lectivos = Lectivo::join('hacademicas as i', 'i.lectivo_id', '=', 'lectivos.id')
			->where('i.cliente_id', $cliente->id)
			->whereNull('i.deleted_at')
			->distinct()
			->pluck('lectivos.name', 'lectivos.id');
		$parametro = Param::where('llave', 'mensualidad_sep')->first();
		$monto_sep = $parametro->valor;
		return view('autorizacionBecas.create', compact('cliente', 'lectivos', 'tipo_becas', 'monto_sep'))
			->with('list', AutorizacionBeca::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAutorizacionBeca $request)
	{

		$input = $request->all();
		$input['st_beca_id'] = 1;
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		if(!isset($input['bnd_tiene_vigencia'])){
			$input['bnd_tiene_vigencia']=0;
		}

		$r = $request->hasFile('archivo_file');
		//dd($r);
		if ($r) {
			$archivo_file = $request->file('archivo_file');
			$input['file'] = $archivo_file->getClientOriginalName();
		}

		//create data
		$e = AutorizacionBeca::create($input);

		if ($e) {
			$ruta = public_path() . "/imagenes/autorizacion_becas/" . $e->id . "/";
			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}

			if ($request->file('archivo_file')) {
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['file']);
			}
		}

		return redirect()->route('autorizacionBecas.findByClienteId', array('cliente_id' => $input['cliente_id']))->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AutorizacionBeca $autorizacionBeca)
	{
		$autorizacionBeca = $autorizacionBeca->find($id);
		return view('autorizacionBecas.show', compact('autorizacionBeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AutorizacionBeca $autorizacionBeca)
	{
		$tipo_becas = TipoBeca::pluck('name', 'id');
		$autorizacionBeca = $autorizacionBeca->find($id);
		$cliente = Cliente::find($autorizacionBeca->cliente->id);
		$lectivos = Lectivo::join('hacademicas as i', 'i.lectivo_id', '=', 'lectivos.id')
			->where('i.cliente_id', $cliente->id)
			->whereNull('i.deleted_at')
			->distinct()
			->pluck('lectivos.name', 'lectivos.id');

		return view('autorizacionBecas.edit', compact('autorizacionBeca', 'cliente', 'tipo_becas', 'lectivos'))
			->with('list', AutorizacionBeca::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AutorizacionBeca $autorizacionBeca)
	{
		$autorizacionBeca = $autorizacionBeca->find($id);
		return view('autorizacionBecas.duplicate', compact('autorizacionBeca'))
			->with('list', AutorizacionBeca::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, AutorizacionBeca $autorizacionBeca, updateAutorizacionBeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		if(!isset($input['bnd_tiene_vigencia'])){
			$input['bnd_tiene_vigencia']=0;
		}

		$r = $request->hasFile('archivo_file');
		//dd($r);
		if ($r) {
			$archivo_file = $request->file('archivo_file');
			$input['file'] = $archivo_file->getClientOriginalName();
		}

		//update data
		$autorizacionBeca = $autorizacionBeca->find($id);
		$autorizacionBeca->update($input);

		$e = $autorizacionBeca;

		if ($e) {
			$ruta = public_path() . "/imagenes/autorizacion_becas/" . $e->id . "/";
			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}

			if ($request->file('archivo_file')) {
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['file']);
			}
		}

		return redirect()->route('autorizacionBecas.findByClienteId', array('cliente_id' => $autorizacionBeca->cliente_id))->with('message', 'Registro Actualizado.');
		//return redirect()->route('autorizacionBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, AutorizacionBeca $autorizacionBeca)
	{
		$autorizacionBeca = $autorizacionBeca->find($id);
		$cliente = $autorizacionBeca->cliente_id;
		$autorizacionBeca->delete();


		return redirect()->route('autorizacionBecas.findByClienteId', array('id' => $cliente))->with('message', 'Registro Borrado.');
	}

	public function findByCliente(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$registros = AutorizacionBeca::select(
			'autorizacion_becas.id',
			'autorizacion_becas.solicitud',
			'autorizacion_becas.monto_inscripcion',
			'autorizacion_becas.monto_mensualidad',
			'autorizacion_becas.created_at',
			'autorizacion_becas.updated_at',
			'st.name as estatus'
		)
			->where('cliente_id', $datos['check'])
			->join('st_becas as st', 'st.id', '=', 'autorizacion_becas.st_beca_id')
			->with('autorizacionBecaComentarios')
			->get();
		echo $registros->toJson();
	}

	public function becasAutorizadas()
	{
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = $empleado->plantels->pluck('razon', 'id');
		//dd($planteles);
		$planteles->prepend('Seleccionar opción');

		//dd($planteles);
		return view('autorizacionBecas.reportes.becasAutorizadas', compact('planteles'));
	}

	public function becasAutorizadasR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$registros_aux = AutorizacionBeca::select(
			'p.razon as plantel',
			'e.name as especialidad',
			'n.name as nivel',
			'g.name as grado',
			'l.name as lectivo',
			'c.matricula',
			'c.id',
			'c.nombre',
			'c.nombre2',
			'c.ape_paterno',
			'c.ape_materno',
			'autorizacion_becas.solicitud',
			'autorizacion_becas.monto_mensualidad as porcentaje'
		)
			->join('clientes as c', 'c.id', '=', 'autorizacion_becas.cliente_id')
			->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
			->join('plantels as p', 'p.id', '=', 'c.plantel_id')
			->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'i.nivel_id')
			->join('grados as g', 'g.id', '=', 'i.grado_id')
			->join('lectivos as l', 'l.id', '=', 'i.lectivo_id')
			//->whereColumn('autorizacion_becas.lectivo_id', 'i.lectivo_id')
			->where('p.id', $datos['plantel_f'])
			//->where('n.id', $datos['nivel_f'])
			//->where('e.id', $datos['especialidad_f'])
			//->where('g.id', $datos['grado_f'])
			->where('autorizacion_becas.lectivo_id', $datos['lectivo_f'])
			->where('autorizacion_becas.st_beca_id', 4)
			->whereNull('i.deleted_at')
			->whereNull('autorizacion_becas.deleted_at');
			if(!is_null($datos['fecha_f']) and !is_null($datos['fecha_t'])){
				$registros_aux->whereDate('vigencia','>=', $datos['fecha_f'])
							->whereDate('vigencia','<=', $datos['fecha_t']);
			}else{
				$registros_aux->where('i.lectivo_id', $datos['lectivo_f']);
			}
			$registros=$registros_aux->get();
		//dd($registros->toArray());
		return view('autorizacionBecas.reportes.becasAutorizadasR', compact('registros'));
	}
}
