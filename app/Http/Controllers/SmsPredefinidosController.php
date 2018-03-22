<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SmsPredefinido;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSmsPredefinido;
use App\Http\Requests\createSmsPredefinido;

class SmsPredefinidosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$smsPredefinidos = SmsPredefinido::getAllData($request);

		return view('smsPredefinidos.index', compact('smsPredefinidos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('smsPredefinidos.create')
			->with( 'list', SmsPredefinido::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSmsPredefinido $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SmsPredefinido::create( $input );

		return redirect()->route('smsPredefinidos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SmsPredefinido $smsPredefinido)
	{
		$smsPredefinido=$smsPredefinido->find($id);
		return view('smsPredefinidos.show', compact('smsPredefinido'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SmsPredefinido $smsPredefinido)
	{
		$smsPredefinido=$smsPredefinido->find($id);
		return view('smsPredefinidos.edit', compact('smsPredefinido'))
			->with( 'list', SmsPredefinido::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SmsPredefinido $smsPredefinido)
	{
		$smsPredefinido=$smsPredefinido->find($id);
		return view('smsPredefinidos.duplicate', compact('smsPredefinido'))
			->with( 'list', SmsPredefinido::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SmsPredefinido $smsPredefinido, updateSmsPredefinido $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$smsPredefinido=$smsPredefinido->find($id);
		$smsPredefinido->update( $input );

		return redirect()->route('smsPredefinidos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SmsPredefinido $smsPredefinido)
	{
		$smsPredefinido=$smsPredefinido->find($id);
		$smsPredefinido->delete();

		return redirect()->route('smsPredefinidos.index')->with('message', 'Registro Borrado.');
	}

    public function getDetalleSms(Request $request){
        if ($request->ajax()) {
            //dd($request->all());
            $smsPredefinido=SmsPredefinido::find($request->input('sms'));
            echo json_encode($smsPredefinido->detalle);
            //return $smsPredefinido->detalle;
        }
    }
}
