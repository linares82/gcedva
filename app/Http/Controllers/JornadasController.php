<?php namespace App\Http\Controllers;

use Auth;
use App\Dium;

use App\Jornada;
use App\ScholarDay;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createJornada;
use App\Http\Requests\updateJornada;

class JornadasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$jornadas = Jornada::getAllData($request);

		return view('jornadas.index', compact('jornadas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('jornadas.create')
			->with( 'list', Jornada::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createJornada $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Jornada::create( $input );

		return redirect()->route('jornadas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Jornada $jornada)
	{
		$jornada=$jornada->find($id);
		return view('jornadas.show', compact('jornada'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Jornada $jornada)
	{
		$jornada=$jornada->with('scholarDays')->find($id);
		//dd($jornada);
		$dias=Dium::pluck('name','id');
		return view('jornadas.edit', compact('jornada','dias'))
			->with( 'list', Jornada::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Jornada $jornada)
	{
		$jornada=$jornada->find($id);
		return view('jornadas.duplicate', compact('jornada'))
			->with( 'list', Jornada::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Jornada $jornada, updateJornada $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$jornada=$jornada->find($id);
		$jornada->update( $input );

		if($input['dia_id']>0 and !is_null($input['h_inicio']) and !is_null($input['h_fin'])){
			ScholarDay::create(array('jornada_id'=>$jornada->id,
				'dia_id'=>$input['dia_id'],
				'h_inicio'=>$input['h_inicio'],
				'h_fin'=>$input['h_fin'],
				'usu_alta_id'=>Auth::user()->id,
				'usu_mod_id'=>Auth::user()->id));
		}

		return redirect()->route('jornadas.edit', $jornada->id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Jornada $jornada)
	{
		$jornada=$jornada->find($id);
		$jornada->delete();

		return redirect()->route('jornadas.index')->with('message', 'Registro Borrado.');
	}

}
