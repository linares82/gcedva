<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Vinculacion;
use App\DocVinculacionVinculacion;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use App\Http\Requests\updateVinculacion;
use App\Http\Requests\createVinculacion;

class VinculacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$vinculacions = Vinculacion::getAllData($request);
                $datos=$request->all();
                
		return view('vinculacions.index', compact('vinculacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
            $cliente=$request->input('cliente');
		return view('vinculacions.create', compact('cliente'))
			->with( 'list', Vinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createVinculacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                if(!isset($input['bnd_constacia_entregada'])){
                    $input['bnd_constacia_entregada']=0;
                }
                
		//create data
		Vinculacion::create( $input );

		return redirect()->route('clientes.indexEventos')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Vinculacion $vinculacion)
	{
		$vinculacion=$vinculacion->find($id);
		return view('vinculacions.show', compact('vinculacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Vinculacion $vinculacion)
	{
		$vinculacion=$vinculacion->find($id);
                $cliente=$vinculacion->cliente_id;
                
                $doc_existentes = DB::table('doc_vinculacion_vinculacions as dpp')->select('doc_vinculacion_id')
                        ->join('vinculacions as p', 'p.id', '=', 'dpp.vinculacion_id')
                        ->where('p.id', '=', $id)
                        ->whereNull('p.deleted_at')
                        ->get();

                $de_array = array();
                if ($doc_existentes->isNotEmpty()) {
                    foreach ($doc_existentes as $de) {
                        array_push($de_array, $de->doc_vinculacion_id);
                    }
                    //dd($de_array);
                }

                $documentos_faltantes = DB::table('doc_plantels')
                        ->select()
                        ->whereNotIn('id', $de_array)
                        ->get();
                
		return view('vinculacions.edit', compact('vinculacion', 'cliente','documentos_faltantes'))
			->with( 'list', Vinculacion::getListFromAllRelationApps() )
                        ->with( 'list1', DocVinculacionVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Vinculacion $vinculacion)
	{
		$vinculacion=$vinculacion->find($id);
		return view('vinculacions.duplicate', compact('vinculacion'))
			->with( 'list', Vinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Vinculacion $vinculacion, updateVinculacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
                if(!isset($input['bnd_constacia_entregada'])){
                    $input['bnd_constacia_entregada']=0;
                }
		//update data
		$vinculacion=$vinculacion->find($id);
		$vinculacion->update( $input );
                $cliente=$vinculacion->cliente_id;

		return redirect()->route('vinculacions.index', array('q[cliente_id_lt]'=>$vinculacion->cliente_id))
                        ->with('message', 'Registro Actualizado.');
                
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Vinculacion $vinculacion)
	{
		$vinculacion=$vinculacion->find($id);
                $cliente=$vinculacion->cliente_id;
		$vinculacion->delete();

                return redirect()->route('vinculacions.index', array('q[cliente_id_lt]'=>$cliente))->with('message', 'Registro Actualizado.');
		//return redirect()->route('vinculacions.index')->with('message', 'Registro Borrado.');
	}

    public function cargarImg(Request $request){
        
        $r=$request->hasFile('file');
        $datos=$request->all();
        //dd($request->all());
        if ($r) {
            $logo_file = $request->file('file');
            $input['file'] = $logo_file->getClientOriginalName();
            $ruta_web=asset("/imagenes/vinculacions/".$datos['vinculacion']);
            //dd($ruta_web);
            $ruta= public_path()."/imagenes/vinculacions/".$datos['vinculacion']."/";
            if(!file_exists($ruta)){
                File::makedirectory($ruta, 0777, true, true);
            }
            if($request->file('file')->move($ruta, $input['file'])){
                $documento= new DocVinculacionVinculacion();
                $documento->vinculacion_id=$datos['vinculacion'];
                $documento->doc_vinculacion_id=$datos['doc_vinculacion_id'];
                $documento->archivo=$input['file'];
                $documento->usu_alta_id=Auth::user()->id;
                $documento->usu_mod_id=Auth::user()->id;
                $documento->save();
                echo json_encode($ruta_web."/".$input['file']);
            }else{
                echo json_encode(0);
            }
         }
        //echo json_encode(0);
    }
}
