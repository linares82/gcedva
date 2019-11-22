<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AutorizacionBeca;
use App\Cliente;
use App\Plantel;
use App\StBeca;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAutorizacionBeca;
use App\Http\Requests\createAutorizacionBeca;

class AutorizacionBecasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$autorizacionBecas = AutorizacionBeca::getAllData($request);
                $estatus= StBeca::pluck('name','id');
                $plantels=Plantel::pluck('razon','id');
		return view('autorizacionBecas.index', compact('autorizacionBecas','estatus','plantels'));
	}
        
        public function findByClienteId(Request $request)
	{
		$autorizacionBecas = AutorizacionBeca::where('cliente_id',$request->input('cliente_id'))->paginate(25);
				$cliente=$request->input('cliente_id');
		$stBecas=StBeca::where('id','>',1)->pluck('name','id');
                
		return view('autorizacionBecas.findByClienteId', compact('autorizacionBecas','cliente','stBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
            $datos=$request->all();
            $cliente=Cliente::find($datos['id']);
		return view('autorizacionBecas.create', compact('cliente'))
			->with( 'list', AutorizacionBeca::getListFromAllRelationApps() );
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
                $input['st_beca_id']=1;
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		AutorizacionBeca::create( $input );

		return redirect()->route('autorizacionBecas.findByClienteId',array('cliente_id'=>$input['cliente_id']))->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AutorizacionBeca $autorizacionBeca)
	{
		$autorizacionBeca=$autorizacionBeca->find($id);
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
		$autorizacionBeca=$autorizacionBeca->find($id);
                $cliente=Cliente::find($autorizacionBeca->cliente->id);
		return view('autorizacionBecas.edit', compact('autorizacionBeca','cliente'))
			->with( 'list', AutorizacionBeca::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AutorizacionBeca $autorizacionBeca)
	{
		$autorizacionBeca=$autorizacionBeca->find($id);
		return view('autorizacionBecas.duplicate', compact('autorizacionBeca'))
			->with( 'list', AutorizacionBeca::getListFromAllRelationApps() );
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
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$autorizacionBeca=$autorizacionBeca->find($id);
		$autorizacionBeca->update( $input );

		return redirect()->route('autorizacionBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,AutorizacionBeca $autorizacionBeca)
	{
		$autorizacionBeca=$autorizacionBeca->find($id);
		$autorizacionBeca->delete();

		return redirect()->route('autorizacionBecas.index')->with('message', 'Registro Borrado.');
	}

        public function findByCliente(Request $request){
            $datos=$request->all();
            //dd($datos);
            $registros=AutorizacionBeca::select('autorizacion_becas.id','autorizacion_becas.solicitud','autorizacion_becas.monto_inscripcion','autorizacion_becas.monto_mensualidad',
                                                'autorizacion_becas.created_at','autorizacion_becas.updated_at','st.name as estatus')
                    ->where('cliente_id',$datos['check'])
                    ->join('st_becas as st','st.id','=','autorizacion_becas.st_beca_id')
                    ->with('autorizacionBecaComentarios')
                    ->get();
            echo $registros->toJson();
        }
}
