<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MateriumPeriodo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMateriumPeriodo;
use App\Http\Requests\createMateriumPeriodo;

class MateriumPeriodosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$materiumPeriodos = MateriumPeriodo::getAllData($request);

		return view('materiumPeriodos.index', compact('materiumPeriodos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('materiumPeriodos.create')
			->with( 'list', MateriumPeriodo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMateriumPeriodo $request)
	{

		$input = $request->all();
		//dd($input['registro']);
		$periodo_estudios=0;
		foreach($input['registro'] as $registro){
			//dd($registro);
			if($periodo_estudios==0){
				$periodo_estudios=$registro['periodo_estudio_id'];
			}
			$inputR['periodo_estudio_id']=$periodo_estudios;
			$inputR['materium_id']=$registro['materia_id'];
			$inputR['horas_jornada']=$registro['horas_jornada'];
			$inputR['duracion_clase']=$registro['duracion_clase'];
			$inputR['usu_alta_id']=Auth::user()->id;
			$inputR['usu_mod_id']=Auth::user()->id;
			MateriumPeriodo::create( $inputR );
		}
		

		//create data
		

		return redirect()->route('periodoEstudios.edit',$periodo_estudios)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, MateriumPeriodo $materiumPeriodo)
	{
		$materiumPeriodo=$materiumPeriodo->find($id);
		return view('materiumPeriodos.show', compact('materiumPeriodo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, MateriumPeriodo $materiumPeriodo)
	{
		$materiumPeriodo=$materiumPeriodo->find($id);
		return view('materiumPeriodos.edit', compact('materiumPeriodo'))
			->with( 'list', MateriumPeriodo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, MateriumPeriodo $materiumPeriodo)
	{
		$materiumPeriodo=$materiumPeriodo->find($id);
		return view('materiumPeriodos.duplicate', compact('materiumPeriodo'))
			->with( 'list', MateriumPeriodo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, MateriumPeriodo $materiumPeriodo, updateMateriumPeriodo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$materiumPeriodo=$materiumPeriodo->find($id);
		$materiumPeriodo->update( $input );
		//return json_encode(array('msj'=>'listo'));

		return redirect()->route('materiumPeriodos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,MateriumPeriodo $materiumPeriodo)
	{
		$materiumPeriodo=$materiumPeriodo->find($id);
		$materiumPeriodo->delete();

		return redirect()->route('materiumPeriodos.index')->with('message', 'Registro Borrado.');
	}

}
