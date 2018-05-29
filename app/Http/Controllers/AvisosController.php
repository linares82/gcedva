<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Aviso;
use App\Cliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAviso;
use App\Http\Requests\createAviso;
use DB;

class AvisosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$avisos = Aviso::getAllData($request);

		return view('avisos.index', compact('avisos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('avisos.create')
			->with( 'list', Aviso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAviso $request)
	{
		$input = $request->all();
		$input['activo']=1;
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$cli=$request->input('cliente_id');
		unset($input['cliente_id']);
		//create data
		//dd($input);
		Aviso::create( $input );
		//dd($cli);
		return redirect()->route('seguimientos.show', $cli)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Aviso $aviso)
	{
		$aviso=$aviso->find($id);
		return view('avisos.show', compact('aviso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Aviso $aviso)
	{
		$aviso=$aviso->find($id);
		return view('avisos.edit', compact('aviso'))
			->with( 'list', Aviso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Aviso $aviso)
	{
		$aviso=$aviso->find($id);
		return view('avisos.duplicate', compact('aviso'))
			->with( 'list', Aviso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Aviso $aviso, updateAviso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$aviso=$aviso->find($id);
		$aviso->update( $input );

		return redirect()->route('avisos.index')->with('message', 'Registro Actualizado.');
	}

	public function inactivo()
	{
		
		$aviso=Aviso::find($_REQUEST['id']);
		$aviso->activo=0;
		$aviso->save();

		return redirect()->route('seguimientos.show', $_REQUEST['cliente'])->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Aviso $aviso)
	{
		$aviso=$aviso->find($id);
		$aviso->delete();

		return redirect()->route('avisos.index')->with('message', 'Registro Borrado.');
	}

        
        public function avisosPlantelEmpleadoFecha(){
            
            return view('avisos.consultas.avisosPlantelEmpleadoFecha')
			->with( 'list', Cliente::getListFromAllRelationApps() );
        }
        
        public function avisosPlantelEmpleadoFechaR(Request $request){
            $data=$request->all();
            //dd($data);
            $avisos=Aviso::select('avisos.id','a.name','avisos.detalle', 'avisos.fecha', 's.cliente_id','avisos.activo',
                                DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado'),'p.razon')
       		         ->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
                         ->join('seguimientos as s', 's.id', '=', 'avisos.seguimiento_id')
                         ->join('clientes as c', 'c.id', '=', 's.cliente_id')
                         ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                         ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
		         //->where('avisos.activo', '=', '1')
                         ->where('avisos.fecha', '>=', $data['fecha_f'])
                         ->where('avisos.fecha', '<=', $data['fecha_t'])
                         ->where('c.empleado_id', '>=', $data['empleado_f'])
                         ->where('c.empleado_id', '<=', $data['empleado_t'])
                         ->where('c.plantel_id', '>=', $data['plantel_f'])
                         ->where('c.plantel_id', '<=', $data['plantel_t'])
			 ->get();
            return view('avisos.consultas.avisosPlantelEmpleadoFechaR', compact('avisos'));                    
        }
}
