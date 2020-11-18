<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BsBaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateBsBaja;
use App\Http\Requests\createBsBaja;
use App\Adeudo;
use App\Plantel;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

use App\valenceSdk\samples\BasicSample\UsoApi;
class BsBajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bsBajas = BsBaja::getAllData($request);

		return view('bsBajas.index', compact('bsBajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('bsBajas.create')
			->with( 'list', BsBaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createBsBaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		BsBaja::create( $input );

		return redirect()->route('bsBajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, BsBaja $bsBaja)
	{
		$bsBaja=$bsBaja->find($id);
		return view('bsBajas.show', compact('bsBaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, BsBaja $bsBaja)
	{
		$bsBaja=$bsBaja->find($id);
		return view('bsBajas.edit', compact('bsBaja'))
			->with( 'list', BsBaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, BsBaja $bsBaja)
	{
		$bsBaja=$bsBaja->find($id);
		return view('bsBajas.duplicate', compact('bsBaja'))
			->with( 'list', BsBaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, BsBaja $bsBaja, updateBsBaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$bsBaja=$bsBaja->find($id);
		$bsBaja->update( $input );

		return redirect()->route('bsBajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,BsBaja $bsBaja)
	{
		$bsBaja=$bsBaja->find($id);
		$bsBaja->delete();

		return redirect()->route('bsBajas.index')->with('message', 'Registro Borrado.');
	}

	public function prospectosBajas(){
		$planteles=Plantel::pluck('razon','id');
		return view('bsBajas.prospectosBajas', compact('planteles'));
	}

	public function prospectosBajasR(Request $request){
		$datos=$request->all();
		$fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		$registros = Adeudo::select(DB::raw('adeudos.cliente_id, count(adeudos.cliente_id) as adeudos_cantidad'))
                ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                ->where('cc.plantel_id', '>', 0)
                ->where('cc.especialidad_id', '>', 0)
                ->where('cc.nivel_id', '>', 0)
                ->where('cc.grado_id', '>', 0)
                ->where('cc.turno_id', '>', 0)
                ->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
                ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
				->where('caj_con.bnd_mensualidad', 1)
				->where('c.plantel_id', $datos['plantel_f'])
                ->where('fecha_pago', '<', $fechaActual)
                ->where('pagado_bnd', 0)
                ->whereNull('cc.deleted_at')
                ->whereNull('c.deleted_at')
                ->where('c.st_cliente_id', '<>', 25)
				->where('c.st_cliente_id', '<>', 3)
				->orderBy('c.ape_paterno')
				->orderBy('c.ape_materno')
				->orderBy('c.nombre')
				->orderBy('c.nombre2')
				->groupBy('adeudos.cliente_id')
                ->having('adeudos_cantidad', '>=', 2)
				->get();
		//dd($registros->toArray());	
		return view('bsBajas.prospectosBajasR', compact('registros'));
	}

	public function apiAutenticar(Request $request){
		if (isset($_GET['x_a']) && isset($_GET['x_b'])) {
			session_start();
			$_SESSION['userId'] = $_GET['x_a'];
			$_SESSION['userKey']= $_GET['x_b'];
			$authenticated = isset($_SESSION['userId']) && isset($_SESSION['userKey']);
			session_write_close();
			dd($_SESSION);
			//header("Location: index.php");
		} else {
			$apiBs=new UsoApi();
			//dd($apiBs->config);
			$url=$apiBs->authenticate();
			dd($url);	
		}
	}


	public function bajasBs(Request $request){
		$datos=$request->all();
		//dd($datos);
		
	}

	public function bajsBsAutenticado(){
		
	}
}
