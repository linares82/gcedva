<?php namespace App\Http\Controllers;

use Auth;
use App\Titulacion;

use App\Http\Requests;
use App\OpcionTitulacion;
use App\TitulacionDocumento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createTitulacion;
use App\Http\Requests\updateTitulacion;
use App\TitulacionDocumentacion;

class TitulacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacions = Titulacion::getAllData($request);

		return view('titulacions.index', compact('titulacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$cliente = $request->input('cliente');
		$opciones_titulacion=OpcionTitulacion::pluck('name','id');
		$documentos=TitulacionDocumento::pluck('name','id');
		return view('titulacions.create', compact('cliente','opciones_titulacion','documentos'))
			->with( 'list', Titulacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacion $request)
	{

		$input = $request->all();
		
		
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['bnd_titulado']=0;

		//create data
		$titulacion=Titulacion::create( $input );

		if($titulacion->opcion_titulacion_id<>0){
			$titulacion->costo=$titulacion->opcionTitulacion->costo;
			$titulacion->save();
		}

		$seguimiento=$titulacion->cliente->seguimiento;
		$seguimiento->st_seguimiento_id=9;
		$seguimiento->save();
		//return $titulacion;

		return redirect()->route('titulacions.edit', $titulacion->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$titulacion=Titulacion::find($id);
		return view('titulacions.show', compact('titulacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$titulacion=Titulacion::find($id);
		$opciones_titulacion=OpcionTitulacion::pluck('name','id');
		$documentos=TitulacionDocumento::pluck('name','id');
		$documentos_existentes=TitulacionDocumentacion::select('titulacion_documento_id')
		->where('titulacion_id',$id)
		->whereNull('deleted_at')
		->get();
		$documentos_existentes_array=array();
		foreach($documentos_existentes as $doc){
			array_push($documentos_existentes_array, $doc->titulacion_documento_id);
		}

		$documentos_faltantes=TitulacionDocumento::whereNotIn('id',$documentos_existentes_array)
		->get();
		//dd($documentos_existentes_array);
		return view('titulacions.edit', compact('titulacion','opciones_titulacion','documentos','documentos_faltantes'))
			->with( 'list', Titulacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Titulacion $titulacion)
	{
		$titulacion=$titulacion->find($id);
		return view('titulacions.duplicate', compact('titulacion'))
			->with( 'list', Titulacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Titulacion $titulacion, updateTitulacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacion=$titulacion->find($id);
		if(!isset($input['bnd_doc_vinc_revisados'])){
			$input['bnd_doc_vinc_revisados']=0;
		}
		if(!isset($input['bnd_revision_director'])){
			$input['bnd_revision_director']=0;
		}
		$titulacion->update( $input );

		return redirect()->route('titulacions.index',array('q[cliente_id_lt]'=>$titulacion->cliente_id))->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Titulacion $titulacion)
	{
		$titulacion=$titulacion->find($id);
		$titulacion->delete();

		return redirect()->route('titulacions.index')->with('message', 'Registro Borrado.');
	}

	public function actualizarCosto(Request $request){
		$datos=$request->all();
		$titulacion=Titulacion::find($datos['id']);
		$opcion_titulacion=OpcionTitulacion::find($titulacion->opcion_titulacion_id);
		$titulacion->costo=$opcion_titulacion->costo;
		$titulacion->save();
		return redirect()->route('titulacions.index',array('q[cliente_id_lt]'=>$titulacion->cliente_id));
	}

}
