<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SegmentoMercado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSegmentoMercado;
use App\Http\Requests\createSegmentoMercado;

class SegmentoMercadosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$segmentoMercados = SegmentoMercado::getAllData($request);

		return view('segmentoMercados.index', compact('segmentoMercados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('segmentoMercados.create')
			->with( 'list', SegmentoMercado::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSegmentoMercado $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SegmentoMercado::create( $input );

		return redirect()->route('segmentoMercados.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SegmentoMercado $segmentoMercado)
	{
		$segmentoMercado=$segmentoMercado->find($id);
		return view('segmentoMercados.show', compact('segmentoMercado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SegmentoMercado $segmentoMercado)
	{
		$segmentoMercado=$segmentoMercado->find($id);
		return view('segmentoMercados.edit', compact('segmentoMercado'))
			->with( 'list', SegmentoMercado::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SegmentoMercado $segmentoMercado)
	{
		$segmentoMercado=$segmentoMercado->find($id);
		return view('segmentoMercados.duplicate', compact('segmentoMercado'))
			->with( 'list', SegmentoMercado::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SegmentoMercado $segmentoMercado, updateSegmentoMercado $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$segmentoMercado=$segmentoMercado->find($id);
		$segmentoMercado->update( $input );

		return redirect()->route('segmentoMercados.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SegmentoMercado $segmentoMercado)
	{
		$segmentoMercado=$segmentoMercado->find($id);
		$segmentoMercado->delete();

		return redirect()->route('segmentoMercados.index')->with('message', 'Registro Borrado.');
	}

        public function getCmbSegmento(){
        $r=SegmentoMercado::select('name', 'id')->get();
        $final=array();
        foreach ($r as $r1) {
            array_push($final, array('id' => $r1->id,
                'name' => $r1->name,
                'selectec' => ''));
        }
        return $final;
    }
}
