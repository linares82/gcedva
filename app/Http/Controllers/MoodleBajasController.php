<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MoodleBaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMoodleBaja;
use App\Http\Requests\createMoodleBaja;

class MoodleBajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$moodleBajas = MoodleBaja::getAllData($request);

		return view('moodleBajas.index', compact('moodleBajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('moodleBajas.create')
			->with( 'list', MoodleBaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMoodleBaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		MoodleBaja::create( $input );

		return redirect()->route('moodleBajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja=$moodleBaja->find($id);
		return view('moodleBajas.show', compact('moodleBaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja=$moodleBaja->find($id);
		return view('moodleBajas.edit', compact('moodleBaja'))
			->with( 'list', MoodleBaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja=$moodleBaja->find($id);
		return view('moodleBajas.duplicate', compact('moodleBaja'))
			->with( 'list', MoodleBaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, MoodleBaja $moodleBaja, updateMoodleBaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$moodleBaja=$moodleBaja->find($id);
		$moodleBaja->update( $input );

		return redirect()->route('moodleBajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,MoodleBaja $moodleBaja)
	{
		$moodleBaja=$moodleBaja->find($id);
		$moodleBaja->delete();

		return redirect()->route('moodleBajas.index')->with('message', 'Registro Borrado.');
	}

}
