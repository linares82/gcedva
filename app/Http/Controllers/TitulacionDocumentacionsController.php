<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TitulacionDocumentacion;
use Illuminate\Http\Request;
use Auth;
use File;
use App\Http\Requests\updateTitulacionDocumentacion;
use App\Http\Requests\createTitulacionDocumentacion;

class TitulacionDocumentacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionDocumentacions = TitulacionDocumentacion::getAllData($request);

		return view('titulacionDocumentacions.index', compact('titulacionDocumentacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('titulacionDocumentacions.create')
			->with( 'list', TitulacionDocumentacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionDocumentacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TitulacionDocumentacion::create( $input );

		return redirect()->route('titulacionDocumentacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionDocumentacion $titulacionDocumentacion)
	{
		$titulacionDocumentacion=$titulacionDocumentacion->find($id);
		return view('titulacionDocumentacions.show', compact('titulacionDocumentacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionDocumentacion $titulacionDocumentacion)
	{
		$titulacionDocumentacion=$titulacionDocumentacion->find($id);
		return view('titulacionDocumentacions.edit', compact('titulacionDocumentacion'))
			->with( 'list', TitulacionDocumentacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionDocumentacion $titulacionDocumentacion)
	{
		$titulacionDocumentacion=$titulacionDocumentacion->find($id);
		return view('titulacionDocumentacions.duplicate', compact('titulacionDocumentacion'))
			->with( 'list', TitulacionDocumentacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TitulacionDocumentacion $titulacionDocumentacion, updateTitulacionDocumentacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacionDocumentacion=$titulacionDocumentacion->find($id);
		$titulacionDocumentacion->update( $input );

		return redirect()->route('titulacionDocumentacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request)
	{
		$titulacionDocumentacion=TitulacionDocumentacion::find($request['id']);
		$titulacion_id=$titulacionDocumentacion->titulacion_id;
		$titulacionDocumentacion->delete();

		return redirect()->route('titulacions.edit',$titulacion_id)->with('message', 'Registro Borrado.');
	}

	public function cargarImg(Request $request)
    {

        $r = $request->hasFile('file');
        $datos = $request->all();
        //dd($request->all());
        if ($r) {
            $logo_file = $request->file('file');
            $input['file'] = $logo_file->getClientOriginalName();
            $ruta_web = asset("/imagenes/titulacion/" . $datos['titulacion_id']);
            //dd($ruta_web);
            $ruta = public_path() . "/imagenes/titulacion/" . $datos['titulacion_id'] . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            if ($request->file('file')->move($ruta, $input['file'])) {
                $documento = new TitulacionDocumentacion();
                $documento->titulacion_id = $datos['titulacion_id'];
                $documento->titulacion_documento_id = $datos['titulacion_documento_id'];
                $documento->archivo = $input['file'];
                $documento->usu_alta_id = Auth::user()->id;
                $documento->usu_mod_id = Auth::user()->id;
                $documento->save();
                echo json_encode($ruta_web . "/" . $input['file']);
            } else {
                echo json_encode(0);
            }
        }
        //echo json_encode(0);
    }


}
