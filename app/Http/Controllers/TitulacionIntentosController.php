<?php namespace App\Http\Controllers;

use Auth;
use App\Titulacion;

use App\Http\Requests;
use App\TitulacionIntento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createTitulacionIntento;
use App\Http\Requests\updateTitulacionIntento;

class TitulacionIntentosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionIntentos = TitulacionIntento::getAllData($request);

		return view('titulacionIntentos.index', compact('titulacionIntentos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('titulacionIntentos.create')
			->with( 'list', TitulacionIntento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionIntento $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$intento=TitulacionIntento::create( $input );
		$titulacion=Titulacion::find($intento->titulacion_id);
		$titulacion->bnd_titulado=$input['bnd_titulado'];
		$titulacion->save();

		return $intento;
		//return redirect()->route('titulacionIntentos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionIntento $titulacionIntento)
	{
		$titulacionIntento=$titulacionIntento->find($id);
		return view('titulacionIntentos.show', compact('titulacionIntento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionIntento $titulacionIntento)
	{
		$titulacionIntento=$titulacionIntento->find($id);
		return view('titulacionIntentos.edit', compact('titulacionIntento'))
			->with( 'list', TitulacionIntento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionIntento $titulacionIntento)
	{
		$titulacionIntento=$titulacionIntento->find($id);
		return view('titulacionIntentos.duplicate', compact('titulacionIntento'))
			->with( 'list', TitulacionIntento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//dd($input);
		//update data
		$titulacionIntento=TitulacionIntento::find($id);
		$titulacionIntento->update( $input );

		$titulacion=$titulacionIntento->titulacion;
		$titulacion->bnd_titulado=$titulacionIntento->bnd_titulado;
		$titulacion->save();

		if($titulacion->bnd_titulado==1){
			$seguimiento=$titulacion->cliente->seguimiento;
			$seguimiento->st_seguimiento_id=10;
			$seguimiento->save();
		}
		

		return $titulacionIntento;
		//return redirect()->route('titulacionIntentos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TitulacionIntento $titulacionIntento)
	{
		$titulacionIntento=$titulacionIntento->find($id);
		$titulacion=$titulacionIntento->id;
		$titulacionIntento->delete();

		return redirect()->route('titulacions.edit', $titulacion)->with('message', 'Registro Borrado.');
	}

}
