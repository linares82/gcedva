<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuestionarioDato;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuestionarioDato;
use App\Http\Requests\createCuestionarioDato;

class CuestionarioDatosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuestionarioDatos = CuestionarioDato::getAllData($request);

		return view('cuestionarioDatos.index', compact('cuestionarioDatos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuestionarioDatos.create')
			->with( 'list', CuestionarioDato::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuestionarioDato $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CuestionarioDato::create( $input );

		return redirect()->route('cuestionarioDatos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuestionarioDato $cuestionarioDato)
	{
		$cuestionarioDato=$cuestionarioDato->find($id);
		return view('cuestionarioDatos.show', compact('cuestionarioDato'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuestionarioDato $cuestionarioDato)
	{
		$cuestionarioDato=$cuestionarioDato->find($id);
		return view('cuestionarioDatos.edit', compact('cuestionarioDato'))
			->with( 'list', CuestionarioDato::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuestionarioDato $cuestionarioDato)
	{
		$cuestionarioDato=$cuestionarioDato->find($id);
		return view('cuestionarioDatos.duplicate', compact('cuestionarioDato'))
			->with( 'list', CuestionarioDato::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuestionarioDato $cuestionarioDato, updateCuestionarioDato $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cuestionarioDato=$cuestionarioDato->find($id);
		$cuestionarioDato->update( $input );

		return redirect()->route('cuestionarioDatos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuestionarioDato $cuestionarioDato)
	{
		$cuestionarioDato=$cuestionarioDato->find($id);
		$cuestionarioDato->delete();

		return redirect()->route('cuestionarioDatos.index')->with('message', 'Registro Borrado.');
	}

        public function visible($empresa, $cuestionario, $pregunta, $respuesta){
            $existe=CuestionarioDato::where('empresa_id', '=', $empresa)
                                ->where('cuestionario_id','=', $cuestionario)
                                ->where('cuestionario_pregunta_id','=', $pregunta)
                                ->where('cuestionario_respuesta_id', '=', $respuesta)
                                ->first();
            if($existe==null){
                return false;
            }else{
                return true;
            }
        }
}
