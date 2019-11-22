<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AutorizacionBeca;
use App\AutorizacionBecaComentario;
use App\Cliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAutorizacionBecaComentario;
use App\Http\Requests\createAutorizacionBecaComentario;

class AutorizacionBecaComentariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$autorizacionBecaComentarios = AutorizacionBecaComentario::getAllData($request);

		return view('autorizacionBecaComentarios.index', compact('autorizacionBecaComentarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('autorizacionBecaComentarios.create')
			->with( 'list', AutorizacionBecaComentario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{

		$input = $request->except('autorizacion');
		$autorizacion=$request->only('autorizacion');
		//dd($autorizacion);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		AutorizacionBecaComentario::create( $input );
                
    	$autorizacionBeca=AutorizacionBeca::find($input['autorizacion_beca_id']);
                
		if($autorizacion['autorizacion']=='aut_caja_plantel'){
			$autorizacionBeca->st_beca_id = 3;
			$autorizacionBeca->aut_caja_plantel = $input['st_beca_id'];
		}elseif ($autorizacion['autorizacion']=='aut_dir_plantel') {
			$autorizacionBeca->st_beca_id = 3;
			$autorizacionBeca->aut_dir_plantel = $input['st_beca_id'];
		} elseif ($autorizacion['autorizacion'] == 'aut_caja_corp') {
			$autorizacionBeca->st_beca_id = 3;
			$autorizacionBeca->aut_caja_corp = $input['st_beca_id'];
		} elseif ($autorizacion['autorizacion'] == 'aut_ser_esc') {
			$autorizacionBeca->st_beca_id = 3;
			$autorizacionBeca->aut_ser_esc = $input['st_beca_id'];
		} elseif ($autorizacion['autorizacion'] == 'aut_dueno') {
			$autorizacionBeca->st_beca_id = $input['st_beca_id'];
			$autorizacionBeca->aut_dueno = $input['st_beca_id'];
		}

		$autorizacionBeca->monto_inscripcion = $input['monto_inscripcion'];
		$autorizacionBeca->monto_mensualidad = $input['monto_mensualidad'];
		$autorizacionBeca->save();

		if($autorizacion['autorizacion']=='aut_dueno' and $autorizacionBeca->st_beca_id==4){
			$cliente = Cliente::find($autorizacionBeca->cliente_id);
			$cliente->monto_mensualidad = $input['monto_mensualidad'];
			$cliente->beca_porcentaje = $input['monto_inscripcion'];
			$cliente->beca_bnd = 1;
			$cliente->save();
		}

               /* 
                if($input['st_beca_id']==4){
                    $cliente=Cliente::find($autorizacionBeca->cliente_id);
                    $cliente->monto_mensualidad=$input['monto_mensualidad'];
                    $cliente->beca_porcentaje=$input['monto_inscripcion'];
                    $cliente->beca_bnd=1;
                    $cliente->save();
                }
                
                if($input['st_beca_id']==5){
                    $cliente=Cliente::find($autorizacionBeca->cliente_id);
                    $cliente->monto_mensualidad=$input['monto_mensualidad'];
                    $cliente->beca_porcentaje=$input['monto_inscripcion'];
                    $cliente->beca_bnd=0;
                    $cliente->save();
                }
                */

		//return redirect()->route('autorizacionBecaComentarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AutorizacionBecaComentario $autorizacionBecaComentario)
	{
		$autorizacionBecaComentario=$autorizacionBecaComentario->find($id);
		return view('autorizacionBecaComentarios.show', compact('autorizacionBecaComentario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AutorizacionBecaComentario $autorizacionBecaComentario)
	{
		$autorizacionBecaComentario=$autorizacionBecaComentario->find($id);
		return view('autorizacionBecaComentarios.edit', compact('autorizacionBecaComentario'))
			->with( 'list', AutorizacionBecaComentario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AutorizacionBecaComentario $autorizacionBecaComentario)
	{
		$autorizacionBecaComentario=$autorizacionBecaComentario->find($id);
		return view('autorizacionBecaComentarios.duplicate', compact('autorizacionBecaComentario'))
			->with( 'list', AutorizacionBecaComentario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, AutorizacionBecaComentario $autorizacionBecaComentario, updateAutorizacionBecaComentario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$autorizacionBecaComentario=$autorizacionBecaComentario->find($id);
		$autorizacionBecaComentario->update( $input );

		return redirect()->route('autorizacionBecaComentarios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,AutorizacionBecaComentario $autorizacionBecaComentario)
	{
		$autorizacionBecaComentario=$autorizacionBecaComentario->find($id);
		$autorizacionBecaComentario->delete();

		return redirect()->route('autorizacionBecaComentarios.index')->with('message', 'Registro Borrado.');
	}

    public function findByAutorizacionBecaId(Request $request){
            $datos=$request->all();
            //dd($datos);
            $vistos = AutorizacionBecaComentario::where('autorizacion_beca_id',$datos['check'])->get();
            foreach($vistos as $v){
                $v->bnd_visto=1;
                $v->save();
            }
            $registros= AutorizacionBecaComentario::select('autorizacion_beca_comentarios.id','autorizacion_beca_comentarios.comentario',
                                                           'autorizacion_beca_comentarios.monto_inscripcion','autorizacion_beca_comentarios.monto_mensualidad',
                                                           'autorizacion_beca_comentarios.created_at','u.name as user',
                                                           'st.name as estatus')
                    ->where('autorizacion_beca_id',$datos['check'])
                    ->join('st_becas as st','st.id','=','autorizacion_beca_comentarios.st_beca_id')
                    ->join('users as u','u.id','=','autorizacion_beca_comentarios.usu_alta_id')
                    ->get();
            echo $registros->toJson();
    }
}
