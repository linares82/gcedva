<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File as Archi;

use App\HistoriaCliente;
use App\Cliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHistoriaCliente;
use App\Http\Requests\createHistoriaCliente;

class HistoriaClientesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$historiaClientes = HistoriaCliente::getAllData($request);

		return view('historiaClientes.index', compact('historiaClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request )
	{
                $data=$request->all();
                $cliente=$data['cliente'];
		return view('historiaClientes.create', compact('cliente'))
			->with( 'list', HistoriaCliente::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHistoriaCliente $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

                $r=$request->hasFile('archivo_file');
                //dd($r);
		if($r){
			$archivo_file = $request->file('archivo_file');
			$input['archivo'] = $archivo_file->getClientOriginalName();
		}
                
		//create data
		$e=HistoriaCliente::create( $input );
                
                if($e->evento_cliente_id==4){
                    $cliente=Cliente::find($e->cliente_id);
                    $cliente->st_cliente_id=24;
                    $cliente->save();
                }elseif($e->evento_cliente_id==2){
                    $cliente=Cliente::find($e->cliente_id);
                    $cliente->st_cliente_id=3;
                    $cliente->save();
                }

                if ( $e ){
                    $ruta=public_path()."/imagenes/historia_clientes/".$e->id."/";
                    if(!file_exists($ruta)){
                            Archi::makedirectory($ruta, 0777, true, true);
                    }
                    
                    if($request->file('archivo_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['archivo']);
			}
                }
                
		return redirect()->route('clientes.indexEventos')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente=$historiaCliente->find($id);
		return view('historiaClientes.show', compact('historiaCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente=$historiaCliente->find($id);
                $cliente=$historiaCliente->cliente_id;
		return view('historiaClientes.edit', compact('historiaCliente','cliente'))
			->with( 'list', HistoriaCliente::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente=$historiaCliente->find($id);
		return view('historiaClientes.duplicate', compact('historiaCliente'))
			->with( 'list', HistoriaCliente::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HistoriaCliente $historiaCliente, updateHistoriaCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
                
                $r=$request->hasFile('archivo_file');
                //dd($r);
		if($r){
			$archivo_file = $request->file('archivo_file');
			$input['archivo'] = $archivo_file->getClientOriginalName();
		}
                
		//update data
		$historiaCliente=$historiaCliente->find($id);
		$historiaCliente->update( $input );
                
                $e=$historiaCliente;
                
                if($e->evento_cliente_id==4){
                    $cliente=Cliente::find($e->cliente_id);
                    $cliente->st_cliente_id=24;
                    $cliente->save();
                }elseif($e->evento_cliente_id==2){
                    $cliente=Cliente::find($e->cliente_id);
                    $cliente->st_cliente_id=3;
                    $cliente->save();
                }
                
                if ( $e ){
                    $ruta=public_path()."/imagenes/historia_clientes/".$e->id."/";
                    
                    if(!file_exists($ruta)){
                            Archi::makedirectory($ruta, 0777, true, true);
                    }
                    
                    if($request->file('archivo_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['archivo']);
			}
                }
                
		return redirect()->route('historiaClientes.index',array('q[cliente_id_lt]'=>$historiaCliente->cliente_id))->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HistoriaCliente $historiaCliente)
	{
		$historiaCliente=$historiaCliente->find($id);
                $cliente=$historiaCliente->cliente_id;
		$historiaCliente->delete();

		return redirect()->route('historiaClientes.index',array('q[cliente_id_lt]'=>$cliente))->with('message', 'Registro Borrado.');
	}

}
