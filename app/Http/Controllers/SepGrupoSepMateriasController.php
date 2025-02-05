<?php namespace App\Http\Controllers;

use Auth;
use App\Plantel;

use App\SepGrupo;
use App\SepMaterium;
use App\Http\Requests;
use App\SepGrupoSepMateria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createSepGrupo;
use App\Http\Requests\updateSepGrupo;

class SepGrupoSepMateriasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepGrupos = SepGrupo::getAllData($request);

		return view('sepGrupos.index', compact('sepGrupos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$plantels=Plantel::pluck('razon','id');
		return view('sepGrupos.create',compact('plantels'))
			->with( 'list', SepGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepGrupo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepGrupo::create( $input );

		return redirect()->route('sepGrupos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->find($id);
		return view('sepGrupos.show', compact('sepGrupo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->with('materias')->find($id);
		//dd($sepGrupo);
		$sepMaterias=SepMaterium::where('plantel_id',$sepGrupo->plantel_id)->pluck('name','id');
		$plantels=Plantel::pluck('razon','id');
		return view('sepGrupos.edit', compact('sepGrupo','plantels','sepMaterias'))
			->with( 'list', SepGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->find($id);
		return view('sepGrupos.duplicate', compact('sepGrupo'))
			->with( 'list', SepGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepGrupo $sepGrupo, updateSepGrupo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepGrupo=$sepGrupo->find($id);
		$sepGrupo->update( $input );

		if(!is_null($input['sep_materia_id']) and !is_null($input['grado']) and !is_null($input['duracion_horas'])){
			$inputGM['sep_grupo_id']=$id;
			$inputGM['sep_materia_id']=$input['sep_materia_id'];
			$inputGM['grado']=$input['grado'];
			$inputGM['duracion_horas']=$input['duracion_horas'];
			$inputGM['usu_alta_id']=Auth::user()->id;
			$inputGM['usu_mod_id']=Auth::user()->id;
			SepGrupoSepMateria::create($inputGM);
		}

		return redirect()->route('sepGrupos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepGrupoSepMateria $sepGrupoSepMateria)
	{
		$sepGrupoSepMateria=$sepGrupoSepMateria->find($id);
		$grupo=$sepGrupoSepMateria->sep_grupo_id;
		$sepGrupoSepMateria->delete();

		return redirect()->route('sepGrupos.edit', $grupo)->with('message', 'Registro Borrado.');
	}

}
