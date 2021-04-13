<?php namespace App\Http\Controllers;

use Auth;
use App\ActaFinal;

use Carbon\Carbon;
use App\Calificacion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createActaFinal;
use App\Http\Requests\updateActaFinal;


class ActaFinalsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$actaFinals = ActaFinal::getAllData($request);

		return view('actaFinals.index', compact('actaFinals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('actaFinals.create')
			->with( 'list', ActaFinal::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createActaFinal $request)
	{

		$input1 = $request->all();
		$idCalificaciones=explode(",",$input1['calificaciones']);
		//dd($idCalificaciones);
		$fecha=Date('Y-m-d');
		
		$actaFinal=ActaFinal::orderBy("id",'desc')->first();
		if(is_null($actaFinal)){
			$input['fecha']=$fecha;
			$input['consecutivo']=1;
		}elseif(!is_null($actaFinal) and $actaFinal->consecutivo==999){
			$input['fecha']=$fecha;
			$input['consecutivo']=1;
		}elseif(!is_null($actaFinal) and $actaFinal->consecutivo<999){
			$input['fecha']=$fecha;
			$input['consecutivo']=$actaFinal->consecutivo+1;
		}
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$actaFinal=ActaFinal::create( $input );

		Calificacion::whereIn('id',$idCalificaciones)->update(['acta_final_id' => $actaFinal->id]);;

		//return true;
		//return redirect()->route('actaFinals.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ActaFinal $actaFinal)
	{
		$actaFinal=$actaFinal->find($id);
		return view('actaFinals.show', compact('actaFinal'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ActaFinal $actaFinal)
	{
		$actaFinal=$actaFinal->find($id);
		return view('actaFinals.edit', compact('actaFinal'))
			->with( 'list', ActaFinal::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ActaFinal $actaFinal)
	{
		$actaFinal=$actaFinal->find($id);
		return view('actaFinals.duplicate', compact('actaFinal'))
			->with( 'list', ActaFinal::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ActaFinal $actaFinal, updateActaFinal $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$actaFinal=$actaFinal->find($id);
		$actaFinal->update( $input );

		return redirect()->route('actaFinals.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ActaFinal $actaFinal)
	{
		$actaFinal=$actaFinal->find($id);
		$actaFinal->delete();

		return redirect()->route('actaFinals.index')->with('message', 'Registro Borrado.');
	}

}
