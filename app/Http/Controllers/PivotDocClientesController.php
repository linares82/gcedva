<?php namespace App\Http\Controllers;

use Auth;
use App\Cliente;

use App\DocAlumno;
use App\Http\Requests;
use App\PivotDocCliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createPivotDocCliente;
use App\Http\Requests\updatePivotDocCliente;

class PivotDocClientesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$pivotDocEmpleados = PivotDocEmpleado::getAllData($request);

		return view('pivotDocEmpleados.index', compact('pivotDocEmpleados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pivotDocEmpleados.create')
			->with( 'list', PivotDocEmpleado::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPivotDocEmpleado $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PivotDocEmpleado::create( $input );

		return redirect()->route('pivotDocEmpleados.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PivotDocEmpleado $pivotDocEmpleado)
	{
		$pivotDocEmpleado=$pivotDocEmpleado->find($id);
		return view('pivotDocEmpleados.show', compact('pivotDocEmpleado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PivotDocEmpleado $pivotDocEmpleado)
	{
		$pivotDocEmpleado=$pivotDocEmpleado->find($id);
		return view('pivotDocEmpleados.edit', compact('pivotDocEmpleado'))
			->with( 'list', PivotDocEmpleado::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PivotDocEmpleado $pivotDocEmpleado)
	{
		$pivotDocEmpleado=$pivotDocEmpleado->find($id);
		return view('pivotDocEmpleados.duplicate', compact('pivotDocEmpleado'))
			->with( 'list', PivotDocEmpleado::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PivotDocEmpleado $pivotDocEmpleado, updatePivotDocEmpleado $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$pivotDocEmpleado=$pivotDocEmpleado->find($id);
		$pivotDocEmpleado->update( $input );

		return redirect()->route('pivotDocEmpleados.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PivotDocCliente $pivotDocCliente)
	{
		$pivotDocCliente=$pivotDocCliente->find($id);
		$cliente=$pivotDocCliente->cliente_id;
		$pivotDocCliente->delete();
		$this->docObligatoriosEntregados($cliente);


		return redirect()->route('clientes.edit', $cliente)->with('message', 'Registro Borrado.');
	}

	public function crearListaCheck(Request $request){
		$datos=$request->all();
		$documentos=DocAlumno::get();
		foreach($documentos as $doc){
			$buscarRegistro=PivotDocCliente::where('cliente_id', $datos['cliente_id'])->where('doc_alumno_id', $doc->id)->first();
			if(is_null($buscarRegistro)){
				$input['doc_alumno_id']=$doc->id;
				$input['cliente_id']=$datos['cliente_id'];
				$input['usu_alta_id']=Auth::user()->id;
				$input['usu_mod_id']=Auth::user()->id;
				PivotDocCliente::create($input);
			}
		}
		return redirect()->route('clientes.edit', $datos['cliente_id'])->with('message', 'Registro Borrado.');
	}

	public function recibirDocumento(Request $request){
		$data=$request->all();

		$documento=PivotDocCliente::find($data['documento']);
		$documento->doc_entregado=1;
		$documento->save();
		$this->docObligatoriosEntregados($documento->cliente_id);

		return $documento->toJson();
	}

	public function docObligatoriosEntregados($cliente_id){
		$cliente=Cliente::find($cliente_id);
		$documentos=PivotDocCliente::join('doc_alumnos as da','da.id','pivot_doc_clientes.doc_alumno_id')
		->where('cliente_id',$cliente_id)->where('doc_obligatorio', 1)->get();
		$documentos_obligatorios_total=DocAlumno::where('doc_obligatorio',1)->count();
		//dd($documentos->toArray());
		$documentos_total=0;
		$documentos_entregados=0;
		foreach($documentos as $documento){
			if($documento->doc_obligatorio==1){
				$documentos_total++;
			}
			if(!is_null($documento->archivo)){
				$documentos_entregados++;
			}
		}
		//dd("doc obligatorios ".$documentos_obligatorios_total."-- doc recibidos ".$documentos_entregados);
		if($documentos_entregados >= $documentos_obligatorios_total){
			$cliente->bnd_doc_oblig_entregados=1;
			$cliente->save();
		}else{
			$cliente->bnd_doc_oblig_entregados=0;
			$cliente->save();
		}
}

}
