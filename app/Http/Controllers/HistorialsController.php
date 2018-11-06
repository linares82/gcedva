<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File as Archi;

use App\Historial;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHistorial;
use App\Http\Requests\createHistorial;

class HistorialsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$historials = Historial::getAllData($request);

		return view('historials.index', compact('historials'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
            $datos=$request->all();
            $empleado=$datos['empleado'];
		return view('historials.create', compact('empleado'))
			->with( 'list', Historial::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHistorial $request)
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
		$e=Historial::create( $input );

                if ( $e ){
                    $ruta=public_path()."/imagenes/historial_eventos/".$e->id."/";
                    if(!file_exists($ruta)){
                            Archi::makedirectory($ruta, 0777, true, true);
                    }
                    
                    if($request->file('archivo_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['archivo']);
			}
                }
                
		return redirect()->route('empleados.index', $input['empleado_id'])->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Historial $historial)
	{
		$historial=$historial->find($id);
		return view('historials.show', compact('historial'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Historial $historial)
	{
		$historial=$historial->find($id);
                $empleado=$historial->empleado_id;
		return view('historials.edit', compact('historial', 'empleado'))
			->with( 'list', Historial::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Historial $historial)
	{
		$historial=$historial->find($id);
                $empleado=$historial->empleado_id;
		return view('historials.duplicate', compact('historial','empleado'))
			->with( 'list', Historial::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Historial $historial, updateHistorial $request)
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
		$historial=$historial->find($id);
		$historial->update( $input );
                $e=$historial;
                if ( $e ){
                    $ruta=public_path()."/imagenes/historial_eventos/".$e->id."/";
                    
                    if(!file_exists($ruta)){
                            Archi::makedirectory($ruta, 0777, true, true);
                    }
                    
                    if($request->file('archivo_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['archivo']);
			}
                }

		return redirect()->route('historials.index',array('q[empleado_id_lt]'=>$historial->empleado_id))->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Historial $historial)
	{
		$historial=$historial->find($id);
                $empleado=$historial->empleado_id;
		$historial->delete();

		return redirect()->route('historials.index',array('q[empleado_id_lt]'=>$empleado))->with('message', 'Registro Borrado.');
	}

}
