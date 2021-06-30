<?php namespace App\Http\Controllers;

use Auth;
use App\Medio;

use App\Cliente;
use App\Empleado;
use App\Prospecto;
use App\Seguimiento;
use App\HStProspecto;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspecto;
use App\Http\Requests\updateProspecto;
use Log;
class ProspectosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectos = Prospecto::getAllData($request);

		return view('prospectos.index', compact('prospectos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$medios=Medio::whereIn('id', array(8,10,15,18,19,20,23))->pluck('name','id');
		return view('prospectos.create', compact('medios'))
			->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspecto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['st_prospecto_id']=1;
		$input['fecha']=date('Y-m-d');
		if(!isset($input['bnd_liga_enviada'])){
			$input['bnd_liga_enviada']=0;
		}

		//create data
		$registro=Prospecto::create( $input );

		$historico['prospecto_id']=$registro->id;
		$historico['st_prospecto_id']=$registro->st_prospecto_id;
		$historico['st_anterior_id']=$registro->st_prospecto_id;
		$historico['usu_alta_id']=Auth::user()->id;
		$historico['usu_mod_id']=Auth::user()->id;

		HStProspecto::create($historico);

		return redirect()->route('prospectos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		return view('prospectos.show', compact('prospecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		$medios=Medio::whereIn('id', array(8,10,15,18,19,20,23))->pluck('name','id');
		return view('prospectos.edit', compact('prospecto', 'medios'))
			->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		return view('prospectos.duplicate', compact('prospecto'))
			->with( 'list', Prospecto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Prospecto $prospecto, updateProspecto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospecto=$prospecto->find($id);
		$prospecto->update( $input );

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Prospecto $prospecto)
	{
		$prospecto=$prospecto->find($id);
		$prospecto->delete();

		return redirect()->route('prospectos.index')->with('message', 'Registro Borrado.');
	}

	public function Aceptar(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=3;
		$prospecto->save();

		$empleado=Empleado::where('user_id', Auth::user()->id)->first();

		$input=$prospecto->toArray();
		$input['municipio_id']=0;
		$input['estado_id']=0;
		$input['st_cliente_id']=0;
		$input['ofertum_id']=0;
		$input['empleado_id']=$empleado->id;
		$input['grado_id']=0;
		$input['diplomado_id']=0;
		$input['subdiplomado_id']=0;
		$input['curso_id']=0;
		$input['subcurso_id']=0;
		$input['otro_id']=0;
		$input['subotro_id']=0;
		$input['pagador_id']=0;
		$input['promociones'] = 0;
		$input['promo_cel'] = 0;
        $input['promo_correo'] = 0;
		$input['uso_factura_id']=21;
		//dd($input);
		$cliente=Cliente::create($input);
		$seguimiento=Seguimiento::create(array(
			'cliente_id'=>$cliente->id,
			'st_seguimiento_id'=>1,
			'mes'=> date('m'),
			'usu_alta_id'=>Auth::user()->id,
			'usu_mod_id'=>Auth::user()->id
		));
		$prospecto->cliente_id=$cliente->id;
		$prospecto->save();
		//dd($cliente);
		return redirect()->route('clientes.edit', $cliente->id);
	}

	public function Rechazar(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=4;
		$prospecto->save();

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	public function regresarAsesores(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=2;
		$prospecto->save();

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	public function regresarCallCenter(Request $request){
		$datos=$request->all();
		$prospecto=Prospecto::find($datos['prospecto']);
		$prospecto->st_prospecto_id=1;
		$prospecto->save();

		return redirect()->route('prospectos.index')->with('message', 'Registro Actualizado.');
	}

	public function prospectos(Request $request){
		$empleado=Empleado::where('user_id', Auth::user()->id)->first();
		$planteles=$empleado->plantels->pluck('razon','id');
		return view('prospectos.reportes.prospectos', compact('planteles'));
	}

	public function prospectosR(Request $request){
		$datos=$request->all();
		$resumen=Prospecto::select(DB::raw('prospectos.fecha, p.razon, ua.name as usuario_alta, stp.name as estatus, count(ua.name) as total'))
		->join('users as ua','ua.id','=','prospectos.usu_alta_id')
		->join('plantels as p','p.id','=','prospectos.plantel_id')
		->join('st_prospectos as stp','stp.id','=','prospectos.st_prospecto_id')
		//->join('plantels as p','p.id','=','prospectos.plantel_id')
		->whereDate('prospectos.fecha','>=', $datos['fecha_f'])
		->whereDate('prospectos.fecha','<=', $datos['fecha_t'])
		->whereIn('prospectos.plantel_id', $datos['plantel_f'])
		//->groupBy('p.razon')
		->groupBy('prospectos.fecha')
		->groupBy('p.razon')
		->groupBy('stp.name')
		->groupBy('ua.name')
		->get();
		//dd($resumen->toArray());
		$registros=Prospecto::whereDate('created_at','>=', $datos['fecha_f'])
		->whereDate('created_at','<=', $datos['fecha_t'])
		->whereIn('plantel_id', $datos['plantel_f'])
		->get();
		return view('prospectos.reportes.prospectosR', compact('registros', 'resumen'));
	}

	public function whCrearProspecto(Request $request){
        Log::info("Adwords");
		Log::info($request);
    }
}
