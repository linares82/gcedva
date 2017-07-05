<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Plantilla;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantilla;
use App\Http\Requests\createPlantilla;

class PlantillasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantillas = Plantilla::getAllData($request);

		return view('plantillas.index', compact('plantillas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantillas.create')
			->with( 'list', Plantilla::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantilla $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['periodo_id']=2;
		if($input['inicio']=="" or $input['inicio']=="0000-00-00"){$input['inicio']=date('Y-m-d');}
		if($input['fin']=="" or $input['fin']=="0000-00-00"){$input['fin']=date('Y-m-d');}

		//create data
		$p=Plantilla::create( $input );
		$file = fopen(app_path('resources\views\emails\\'.$p->id.'.blade.html'), "w+");
		fwrite($file, $input['plantilla']);
		fclose($file);

		return redirect()->route('plantillas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		return view('plantillas.show', compact('plantilla'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		return view('plantillas.edit', compact('plantilla'))
			->with( 'list', Plantilla::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		return view('plantillas.duplicate', compact('plantilla'))
			->with( 'list', Plantilla::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Plantilla $plantilla, updatePlantilla $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		$input['periodo_id']=2;
		$st=$input['st_cliente'];	
		unset($input['st_cliente']);
		$input['st_cliente_id']=0;
		//dd($st);
		//update data
		$plantilla=$plantilla->find($id);
		$plantilla->update( $input );
		if($st<>0){
			$plantilla->estatus()->attach($st);	
		}
		if($input['inicio']=="" or $input['inicio']=="0000-00-00"){$input['inicio']=date('Y-m-d');}
		if($input['fin']=="" or $input['fin']=="0000-00-00"){$input['fin']=date('Y-m-d');}


		//dd($input['plantilla']);
		$file = fopen(base_path('resources\views\emails\\'.$id.'.blade.php'), "w+");
		$h=str_replace('http:/', 'http://', $input['plantilla']);
		//dd($h);
		$h=str_replace('&gt;', '>', $h);
		
		//dd($h);
		fwrite($file, $h);
		fclose($file);

		return redirect()->route('plantillas.edit', $id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		$plantilla->delete();

		return redirect()->route('plantillas.index')->with('message', 'Registro Borrado.');
	}


	public function eliminarEstatus(Request $request, Plantilla $p){
		$p=$p->find($_GET['plantilla']);
		//dd($p);
		$p->estatus()->detach($_GET['st']);
		return redirect()->route('plantillas.edit', $p->id)->with('message', 'Registro Actualizado.');
	}	

}
