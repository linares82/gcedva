<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\VinculacionHora;
use Illuminate\Http\Request;
use Auth;
use File;
use App\Http\Requests\updateVinculacionHora;
use App\Http\Requests\createVinculacionHora;

class VinculacionHorasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$vinculacionHoras = VinculacionHora::getAllData($request);

		return view('vinculacionHoras.index', compact('vinculacionHoras'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('vinculacionHoras.create')
			->with( 'list', VinculacionHora::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createVinculacionHora $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                
                $r=$request->hasFile('file');
                if ($r) {
                    $logo_file = $request->file('file');
                    $input['fv6'] = $logo_file->getClientOriginalName();
                    $ruta_web=asset("/imagenes/fv6/");
                    //dd($ruta_web);
                    $ruta= public_path()."/imagenes/fv6/";
                    if(!file_exists($ruta)){
                        File::makedirectory($ruta, 0777, true, true);
                    }
                }                
		//create data
		$v=VinculacionHora::create( $input );
                $request->file('file')->move($ruta, $input['fv6']);
                $vinculacion=$v->vinculacion_id;
		return redirect()->route('vinculacions.edit',$vinculacion)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, VinculacionHora $vinculacionHora)
	{
		$vinculacionHora=$vinculacionHora->find($id);
		return view('vinculacionHoras.show', compact('vinculacionHora'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, VinculacionHora $vinculacionHora)
	{
		$vinculacionHora=$vinculacionHora->find($id);
		return view('vinculacionHoras.edit', compact('vinculacionHora'))
			->with( 'list', VinculacionHora::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, VinculacionHora $vinculacionHora)
	{
		$vinculacionHora=$vinculacionHora->find($id);
		return view('vinculacionHoras.duplicate', compact('vinculacionHora'))
			->with( 'list', VinculacionHora::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, VinculacionHora $vinculacionHora, updateVinculacionHora $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$vinculacionHora=$vinculacionHora->find($id);
		$vinculacionHora->update( $input );

		return redirect()->route('vinculacionHoras.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,VinculacionHora $vinculacionHora)
	{
		$vinculacionHora=$vinculacionHora->find($id);
                $vinculacion=$vinculacionHora->vinculacion_id;
		$vinculacionHora->delete();

		return redirect()->route('vinculacions.edit',$vinculacion)->with('message', 'Registro Borrado.');
	}

}
