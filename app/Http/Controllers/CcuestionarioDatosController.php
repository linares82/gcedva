<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CcuestionarioDato;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCcuestionarioDato;
use App\Http\Requests\createCcuestionarioDato;

class CcuestionarioDatosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ccuestionarioDatos = CcuestionarioDato::getAllData($request);

		return view('ccuestionarioDatos.index', compact('ccuestionarioDatos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ccuestionarioDatos.create')
			->with( 'list', CcuestionarioDato::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCcuestionarioDato $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CcuestionarioDato::create( $input );

		return redirect()->route('ccuestionarioDatos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CcuestionarioDato $ccuestionarioDato)
	{
		$ccuestionarioDato=$ccuestionarioDato->find($id);
		return view('ccuestionarioDatos.show', compact('ccuestionarioDato'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CcuestionarioDato $ccuestionarioDato)
	{
		$ccuestionarioDato=$ccuestionarioDato->find($id);
		return view('ccuestionarioDatos.edit', compact('ccuestionarioDato'))
			->with( 'list', CcuestionarioDato::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CcuestionarioDato $ccuestionarioDato)
	{
		$ccuestionarioDato=$ccuestionarioDato->find($id);
		return view('ccuestionarioDatos.duplicate', compact('ccuestionarioDato'))
			->with( 'list', CcuestionarioDato::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CcuestionarioDato $ccuestionarioDato, updateCcuestionarioDato $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ccuestionarioDato=$ccuestionarioDato->find($id);
		$ccuestionarioDato->update( $input );

		return redirect()->route('ccuestionarioDatos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CcuestionarioDato $ccuestionarioDato)
	{
		$ccuestionarioDato=$ccuestionarioDato->find($id);
		$ccuestionarioDato->delete();

		return redirect()->route('ccuestionarioDatos.index')->with('message', 'Registro Borrado.');
	}

        
        public function visible($cliente, $cuestionario, $pregunta, $respuesta){
            $existe=CcuestionarioDato::where('cliente_id', '=', $cliente)
                                ->where('ccuestionario_id','=', $cuestionario)
                                ->where('ccuestionario_pregunta_id','=', $pregunta)
                                ->where('ccuestionario_respuesta_id', '=', $respuesta)
                                ->first();
            if($existe==null){
                return false;
            }else{
                return true;
            }
        }
}
