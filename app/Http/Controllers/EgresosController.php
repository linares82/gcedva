<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Egreso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEgreso;
use App\Http\Requests\createEgreso;
use File as Archi;

class EgresosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$egresos = Egreso::getAllData($request);

		return view('egresos.index', compact('egresos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('egresos.create')
			->with( 'list', Egreso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEgreso $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		$r=$request->hasFile('comprobante_file');
		if($r){
			$comprobante_file = $request->file('comprobante_file');
			$input['archivo'] = $comprobante_file->getClientOriginalName();
		}
                
		//create data
		$e=Egreso::create( $input );
                if($e){
                    $ruta=public_path()."/imagenes/egresos/".$e->id."/";
			if(!file_exists($ruta)){
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if($request->file('comprobante_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('comprobante_file')->move($ruta, $input['archivo']);
			}
                }

		return redirect()->route('egresos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		return view('egresos.show', compact('egreso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		return view('egresos.edit', compact('egreso'))
			->with( 'list', Egreso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		return view('egresos.duplicate', compact('egreso'))
			->with( 'list', Egreso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Egreso $egreso, updateEgreso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
                
                $r=$request->hasFile('comprobante_file');
		if($r){
			$comprobante_file = $request->file('comprobante_file');
			$input['archivo'] = $comprobante_file->getClientOriginalName();
		}
                
		//update data
		$egreso=$egreso->find($id);
		$e=$egreso->update( $input );
                
                if($e){
                    $ruta=public_path()."/imagenes/egresos/".$egreso->id."/";
			if(!file_exists($ruta)){
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if($request->file('comprobante_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('comprobante_file')->move($ruta, $input['archivo']);
			}
                }

		return redirect()->route('egresos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		$egreso->delete();

		return redirect()->route('egresos.index')->with('message', 'Registro Borrado.');
	}

}
