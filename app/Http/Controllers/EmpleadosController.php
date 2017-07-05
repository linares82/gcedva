<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use App\Empleado;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEmpleado;
use App\Http\Requests\createEmpleado;


class EmpleadosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$empleados = Empleado::getAllData($request);

		return view('empleados.index', compact('empleados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('empleados.create')
			->with( 'list', Empleado::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEmpleado $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		$r=$request->hasFile('foto_file');
		if($r){
			$foto_file = $request->file('foto_file');
			$input['foto'] = $foto_file->getClientOriginalName();
		}
		$r=$request->hasFile('identificacion_file');
		if($r){
			$identificacion_file = $request->file('identificacion_file');
			$input['identificacion'] = $identificacion_file->getClientOriginalName();
		}
		$r=$request->hasFile('contrato_file');
		if($r){
			$membrete_file = $request->file('contrato_file');
			$input['contrato'] = $contrato_file->getClientOriginalName();	
		}
		$r=$request->hasFile('evaluacion_psico_file');
		if($r){
			$evaluacion_psico_file = $request->file('evaluacion_psico_file');
			$input['evaluacion_psico'] = $evaluacion_psico_file->getClientOriginalName();	
		}

		//create data

		//dd($input);
		$e=Empleado::create( $input );
		if ( $e ){
			$ruta=public_path()."/imagenes/empleados/".$e->id."/";
			//dd($ruta);
			if(!file_exists($ruta)){
				File::makeDirectory($ruta, 0777, true, true);
			}
			if($request->file('foto_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('foto_file')->move($ruta, $input['foto']);
			}
			if($request->file('identificacion_file')){
				//\Storage::disk('local')->put($input['slogan'],  \File::get($slogan_file));
				$request->file('identificacion_file')->move($ruta, $input['identificacion']);
			}
			if($request->file('contrato_file')){
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('contrato_file')->move($ruta, $input['contrato']);
			}
			if($request->file('evaluacion_psico_file')){
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('evaluacion_psico_file')->move($ruta, $input['evaluacion_psico_file']);
			}
		}

		return redirect()->route('empleados.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Empleado $empleado)
	{
		$empleado=$empleado->find($id);
		return view('empleados.show', compact('empleado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Empleado $empleado)
	{
		$empleado=$empleado->find($id);
		return view('empleados.edit', compact('empleado'))
			->with( 'list', Empleado::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Empleado $empleado)
	{
		$empleado=$empleado->find($id);
		return view('empleados.duplicate', compact('empleado'))
			->with( 'list', Empleado::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Empleado $empleado, updateEmpleado $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		//dd($request->all());
		$r=$request->hasFile('foto_file');
		//dd($r);
		if($r){
			$foto_file = $request->file('foto_file');
			$input['foto'] = $foto_file->getClientOriginalName();

		}
		$r=$request->hasFile('identificacion_file');
		if($r){
			$identificacion_file = $request->file('identificacion_file');
			$input['identificacion'] = $identificacion_file->getClientOriginalName();
		}
		$r=$request->hasFile('contrato_file');
		if($r){
			$contrato_file = $request->file('contrato_file');
			$input['contrato'] = $contrato_file->getClientOriginalName();	
		}
		$r=$request->hasFile('evaluacion_psico_file');
		if($r){
			$evaluacion_psico_file = $request->file('evaluacion_psico_file');
			$input['evaluacion_psico'] = $evaluacion_psico_file->getClientOriginalName();	
		}

		//dd($input);
		//dd($request->all());
		$empleado=$empleado->find($id);
		
		$e=$empleado->update( $input );
		//dd($e);

		if ( $e ){
			$ruta=public_path()."/imagenes/empleados/".$id."/";
			if(!file_exists($ruta)){
				File::makeDirectory($ruta, 0777, true, true);
			}
			if($request->file('foto_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('foto_file')->move($ruta, $input['foto']);
			}
			if($request->file('identificacion_file')){
				//\Storage::disk('local')->put($input['slogan'],  \File::get($slogan_file));
				$request->file('identificacion_file')->move($ruta, $input['identificacion']);
			}
			if($request->file('contrato_file')){
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('contrato_file')->move($ruta, $input['contrato']);
			}
			if($request->file('evaluacion_psico_file')){
				//\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
				$request->file('evaluacion_psico_file')->move($ruta, $input['evaluacion_psico']);
			}
		}

		return redirect()->route('empleados.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Empleado $empleado)
	{
		$empleado=$empleado->find($id);
		$empleado->delete();

		return redirect()->route('empleados.index')->with('message', 'Registro Borrado.');
	}

	public function usuarios(Request $request)
    {
    	//dd($_REQUEST);
        $data = User::select('id as d', "name as n")
        		->where("name","LIKE","%".$request->input('term')."%")
        		->get();
        //dd($data);
        $results=array();
        foreach ($data as $value){
        	//dd($value);
        	$results[]=['id'=>$value->d, 'text'=>$value->n];
        }
        return response()->json($results);
    }

    

}
