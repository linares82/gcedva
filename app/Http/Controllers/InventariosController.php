<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Inventario;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\InventarioLevantamiento;
use App\Http\Controllers\Controller;
use App\Http\Requests\createInventario;
use App\Http\Requests\updateInventario;
use Illuminate\Support\Facades\Storage;

class InventariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inventarios = Inventario::getAllData($request);
		

		return view('inventarios.index', compact('inventarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inventarios.create')
			->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInventario $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Inventario::create( $input );

		return redirect()->route('inventarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		
		return view('inventarios.show', compact('inventario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		$catExiste=array('SI'=>'SI', 'NO'=>'NO');
		$catEstado=array('BUENO'=>'BUENO', 'MALO'=>'MALO');
		return view('inventarios.edit', compact('inventario','catExiste', 'catEstado'))
			->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		return view('inventarios.duplicate', compact('inventario'))
			->with( 'list', Inventario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Inventario $inventario, updateInventario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inventario=$inventario->find($id);
		//dd($input);

		/*
		if ($request->hasFile('video')) {
			$archivo = $request->file('video');
			$file = $request->file('video');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$ruta = "inventarios_multimedia/".$id."/";
			$input['video'] = $ruta.$nombre;
			//dd($input);
			try {
				
				
				//$path=$request->file('archivo')->storePubliclyAs($ruta, $nombre,"do");
				$r = Storage::disk('do')->put($ruta.$nombre, \File::get($file));
				Storage::disk('do')->setVisibility($ruta.$nombre,'public');
				//dd('do realizado');

			} catch (Exception $e) {
				dd($e);
			}
		}*/

		if(is_null($inventario->video1)){
			$input['video1'] = $this->cargaArchivo($request, 'video1', $id);	
		}
		if(is_null($inventario->video2)){
			$input['video2'] = $this->cargaArchivo($request, 'video2', $id);	
		}
		if(is_null($inventario->img1)){
			$input['img1'] = $this->cargaArchivo($request, 'img1', $id);	
		}
		if(is_null($inventario->img2)){
			$input['img1'] = $this->cargaArchivo($request, 'img2', $id);	
		}
		if(is_null($inventario->img3)){
			$input['img1'] = $this->cargaArchivo($request, 'img3', $id);	
		}
		if(is_null($inventario->img4)){
			$input['img1'] = $this->cargaArchivo($request, 'img4', $id);	
		}
		if(is_null($inventario->img5)){
			$input['img1'] = $this->cargaArchivo($request, 'img5', $id);	
		}
		if(is_null($inventario->img6)){
			$input['img1'] = $this->cargaArchivo($request, 'img6', $id);	
		}
		
		/*if ($request->hasFile('pdf')) {
			$archivo = $request->file('pdf');
			$file = $request->file('pdf');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$ruta = "inventarios_multimedia/".$id."/";
			$input['pdf'] = $ruta.$nombre;
			
			try {
				$r = Storage::disk('do')->put($ruta.$nombre, \File::get($file));
				Storage::disk('do')->setVisibility($ruta.$nombre,'public');
				//dd('do realizado');

			} catch (Exception $e) {
				dd($e);
			}
		}*/
		
		$inventario->update( $input );
		//dd('Registro guardado');
		return redirect()->route('inventarioLevantamientos.show', array('q[inventario_levantamiento_id_lt]'=>$inventario->inventario_levantamiento_id))->with('message', 'Registro Actualizado.');
	}

	public function cargaArchivo(Request $request, $campo, $inventario_id){
		if ($request->hasFile($campo)) {
			$archivo = $request->file($campo);
			$file = $request->file($campo);
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$ruta = "inventarios_multimedia/".$inventario_id."/";
			
			//dd($input);
			try {
				
				
				//$path=$request->file('archivo')->storePubliclyAs($ruta, $nombre,"do");
				$r = Storage::disk('do')->put($ruta.$nombre, \File::get($file));
				Storage::disk('do')->setVisibility($ruta.$nombre,'public');
				//dd('do realizado');

			} catch (Exception $e) {
				dd($e);
			}
			return $ruta.$nombre;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Inventario $inventario)
	{
		$inventario=$inventario->find($id);
		$inventarioLevantamiento=$inventario->levantamiento_inventario_id;
		$inventario->delete();
		dd('Registro borrado');
		//return redirect()->route('inventarioLevantamientos.show', array('q[inventario_levantamiento_id_lt]'=>$inventarioLevantamiento) )->with('message', 'Registro Borrado.');
	}

	public function editEstado(Request $request){
		$inventario=Inventario::find($request['id']);
		$inventario->estado_bueno=$request['estado_bueno'];
		$inventario->save();
		return $inventario;
	}

	public function editExiste(Request $request){
		$inventario=Inventario::find($request['id']);
		$inventario->existe_si=$request['existe_si'];
		$inventario->save();
		return $inventario;
	}

}
