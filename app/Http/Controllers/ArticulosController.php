<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Articulo;
use App\Existencium;
use App\Plantel;
use App\UnidadUso;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateArticulo;
use App\Http\Requests\createArticulo;

class ArticulosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$articulos = Articulo::getAllData($request);

		return view('articulos.index', compact('articulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $unidades=UnidadUso::pluck('name','name');
		return view('articulos.create', compact('unidades'))
			->with( 'list', Articulo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createArticulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                
		//create data
		$a=Articulo::create( $input );
                
                $plantels=Plantel::get();
                foreach($plantels as $plantel){
                    $existencia['plantel_id']=$plantel->id;
                    $existencia['articulo_id']=$a->id;
                    $existencia['existencia']=0;
                    $existencia['usu_alta_id']=Auth::user()->id;
                    $existencia['usu_mod_id']=Auth::user()->id;
                    Existencium::create($existencia);
                }

		return redirect()->route('articulos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Articulo $articulo)
	{
		$articulo=$articulo->find($id);
		return view('articulos.show', compact('articulo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Articulo $articulo)
	{
                $unidades=UnidadUso::pluck('name','name');
		$articulo=$articulo->find($id);
		return view('articulos.edit', compact('articulo','unidades'))
			->with( 'list', Articulo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Articulo $articulo)
	{
		$articulo=$articulo->find($id);
		return view('articulos.duplicate', compact('articulo'))
			->with( 'list', Articulo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Articulo $articulo, updateArticulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$articulo=$articulo->find($id);
		$articulo->update( $input );

		return redirect()->route('articulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Articulo $articulo)
	{
		$articulo=$articulo->find($id);
		$articulo->delete();

		return redirect()->route('articulos.index')->with('message', 'Registro Borrado.');
	}

}
