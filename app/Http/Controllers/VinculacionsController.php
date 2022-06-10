<?php namespace App\Http\Controllers;

use DB;
use Auth;
use File;
use App\Cliente;
use App\Plantel;
use App\Vinculacion;
use App\StVinculacion;
use App\CombinacionCliente;
use App\EmpresasVinculacion;
use Illuminate\Http\Request;
use App\DocVinculacionVinculacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\createVinculacion;
use App\Http\Requests\updateVinculacion;

class VinculacionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $vinculacions = Vinculacion::getAllData($request);
        $datos = $request->all();

        return view('vinculacions.index', compact('vinculacions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $cliente = $request->input('cliente');
        $cli=Cliente::find($cliente);
        $empresas=EmpresasVinculacion::where('plantel_id',$cli->plantel_id)->pluck('razon_social','id');
        
        return view('vinculacions.create', compact('cliente','empresas'))
            ->with('list', Vinculacion::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createVinculacion $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        if (!isset($input['bnd_constacia_entregada'])) {
            $input['bnd_constacia_entregada'] = 0;
        }

        //create data
        Vinculacion::create($input);

        return redirect()->route('clientes.indexEventos')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Vinculacion $vinculacion)
    {
        $vinculacion = $vinculacion->find($id);
        return view('vinculacions.show', compact('vinculacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Vinculacion $vinculacion)
    {
        $vinculacion = $vinculacion->find($id);
        $cliente = $vinculacion->cliente_id;
        $cli=Cliente::find($cliente);
        $empresas=EmpresasVinculacion::where('plantel_id',$cli->plantel_id)->pluck('razon_social','id');

        $doc_existentes = DB::table('doc_vinculacion_vinculacions as dpp')->select('doc_vinculacion_id')
            ->join('vinculacions as p', 'p.id', '=', 'dpp.vinculacion_id')
            ->where('p.id', '=', $id)
            ->whereNull('p.deleted_at')
            ->get();

        $de_array = array();
        if ($doc_existentes->isNotEmpty()) {
            foreach ($doc_existentes as $de) {
                array_push($de_array, $de->doc_vinculacion_id);
            }
            //dd($de_array);
        }

        $documentos_faltantes = DB::table('doc_vinculacions')
            ->where('clasificacion_id', $vinculacion->clasificacion_id)
            ->whereNotIn('id', $de_array)
            ->orderBy('orden')
            ->get();

        $documentos_vinculacion=DB::table('doc_vinculacions')
        ->where('clasificacion_id', $vinculacion->clasificacion_id)
        ->orderBy('orden')
        ->pluck('name','id');

        return view('vinculacions.edit', compact('vinculacion', 'cliente', 'documentos_faltantes','documentos_vinculacion','empresas'))
            ->with('list', Vinculacion::getListFromAllRelationApps())
            ->with('list1', DocVinculacionVinculacion::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Vinculacion $vinculacion)
    {
        $vinculacion = $vinculacion->find($id);
        return view('vinculacions.duplicate', compact('vinculacion'))
            ->with('list', Vinculacion::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Vinculacion $vinculacion, updateVinculacion $request)
    {
        //dd($request);
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        if (!isset($input['bnd_constacia_entregada'])) {
            $input['bnd_constacia_entregada'] = 0;
        }
        if (!isset($input['bnd_busca_trabajo'])) {
            $input['bnd_busca_trabajo'] = 0;
        }
        if (!isset($input['bnd_requiere_empleo'])) {
            $input['bnd_requiere_empleo'] = 0;
        }
        if (!isset($input['bnd_cv_actualizado'])) {
            $input['bnd_cv_actualizado'] = 0;
        }
        
        //update data
        $vinculacion = $vinculacion->find($id);
        $vinculacion->update($input);
        $cliente = $vinculacion->cliente_id;

        return redirect()->route('vinculacions.index', array('q[cliente_id_lt]' => $vinculacion->cliente_id))
            ->with('message', 'Registro Actualizado.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Vinculacion $vinculacion)
    {
        $vinculacion = $vinculacion->find($id);
        $cliente = $vinculacion->cliente_id;
        $vinculacion->delete();

        return redirect()->route('vinculacions.index', array('q[cliente_id_lt]' => $cliente))->with('message', 'Registro Actualizado.');
        //return redirect()->route('vinculacions.index')->with('message', 'Registro Borrado.');
    }

    public function cargarImg(Request $request)
    {

        $r = $request->hasFile('file');
        $datos = $request->all();
        //dd($request->all());
        if ($r) {
            $logo_file = $request->file('file');
            $input['file'] = $logo_file->getClientOriginalName();
            $ruta_web = asset("/imagenes/vinculacions/" . $datos['vinculacion']);
            //dd($ruta_web);
            $ruta = public_path() . "/imagenes/vinculacions/" . $datos['vinculacion'] . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            if ($request->file('file')->move($ruta, $input['file'])) {
                $documento = new DocVinculacionVinculacion();
                $documento->vinculacion_id = $datos['vinculacion'];
                $documento->doc_vinculacion_id = $datos['doc_vinculacion_id'];
                $documento->archivo = $input['file'];
                $documento->fec_inicio=$datos['fec_inicio'];
                $documento->fec_fin=$datos['fec_fin'];
                $documento->usu_alta_id = Auth::user()->id;
                $documento->usu_mod_id = Auth::user()->id;
                $documento->save();

                $vinculacion = Vinculacion::find($documento->vinculacion_id);
                /*if (($documento->doc_vinculacion_id == 18 or $documento->doc_vinculacion_id == 11) and
                    $vinculacion->csc_vinculacion == 0 and
                    $vinculacion->clasificacion_id > 1) {
                    $tieneDocs = DocVinculacionVinculacion::where('vinculacion_id', $datos['vinculacion'])
                        ->whereRaw('(doc_vinculacion_id=? or doc_vinculacion_id=?)', [18, 11])
                        ->get();
                    //dd($tieneDocs->toArray());
                    if (count($tieneDocs) == 2) {
                        $plantel = Plantel::find($vinculacion->cliente->plantel_id);
                        $plantel->csc_vinculacion = $plantel->csc_vinculacion + 1;
                        $plantel->save();
                        $cadena = "00000";
                        $csc_numero = $plantel->csc_vinculacion;

                        //Log::info('flc-'.strlen($cadena)-strlen($csc_numero)."-".substr($cadena,(strlen($cadena)-strlen($csc_numero))));
                        $csc_str = $plantel->cve_vinculacion . substr($cadena, 0, (5 - strlen($csc_numero))) . $csc_numero;

                        $vinculacion->csc_vinculacion = $csc_str;
                        $vinculacion->save();
                    }
                } else if ($documento->doc_vinculacion_id == 11 and
                    $vinculacion->csc_vinculacion == 0 and
                    $vinculacion->clasificacion_id == 1) {
                    $plantel = Plantel::find($vinculacion->cliente->plantel_id);
                    $plantel->csc_vinculacion = $plantel->csc_vinculacion + 1;
                    $plantel->save();
                    $cadena = "00000";
                    $csc_numero = $plantel->csc_vinculacion;

                    //Log::info('flc-'.strlen($cadena)-strlen($csc_numero)."-".substr($cadena,(strlen($cadena)-strlen($csc_numero))));
                    $csc_str = $plantel->cve_vinculacion . substr($cadena, 0, (5 - strlen($csc_numero))) . $csc_numero;

                    $vinculacion->csc_vinculacion = $csc_str;
                    $vinculacion->save();
                }*/

                echo json_encode($ruta_web . "/" . $input['file']);
            } else {
                
                echo json_encode(0);
                
            }
        }else{
        
            $documento = new DocVinculacionVinculacion();
            $documento->vinculacion_id = $datos['vinculacion'];
            $documento->doc_vinculacion_id = $datos['doc_vinculacion_id'];
            $documento->fec_inicio=$datos['fec_inicio'];
            $documento->fec_fin=$datos['fec_fin'];
            $documento->usu_alta_id = Auth::user()->id;
            $documento->usu_mod_id = Auth::user()->id;
            
            $nuevo=$documento->save();
            
            echo $documento->toJson();
        }
        //echo json_encode(0);
    }

    public function cargarImgEditar(Request $request)
    {

        $r = $request->hasFile('file');
        $datos = $request->all();
        //dd($request->all());
        if ($r) {
            $logo_file = $request->file('file');
            $input['file'] = $logo_file->getClientOriginalName();
            $ruta_web = asset("/imagenes/vinculacions/" . $datos['vinculacion']);
            //dd($ruta_web);
            $ruta = public_path() . "/imagenes/vinculacions/" . $datos['vinculacion'] . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            if ($request->file('file')->move($ruta, $input['file'])) {
                $documento = DocVinculacionVinculacion::find($datos['id']);
                $documento->vinculacion_id = $datos['vinculacion'];
                $documento->doc_vinculacion_id = $datos['doc_vinculacion_id'];
                $documento->archivo = $input['file'];
                $documento->fec_inicio=$datos['fec_inicio'];
                $documento->fec_fin=$datos['fec_fin'];
                $documento->usu_alta_id = Auth::user()->id;
                $documento->usu_mod_id = Auth::user()->id;
                $documento->save();

                $vinculacion = Vinculacion::find($documento->vinculacion_id);
                /*if (($documento->doc_vinculacion_id == 18 or $documento->doc_vinculacion_id == 11) and
                    $vinculacion->csc_vinculacion == 0 and
                    $vinculacion->clasificacion_id > 1) {
                    $tieneDocs = DocVinculacionVinculacion::where('vinculacion_id', $datos['vinculacion'])
                        ->whereRaw('(doc_vinculacion_id=? or doc_vinculacion_id=?)', [18, 11])
                        ->get();
                    //dd($tieneDocs->toArray());
                    if (count($tieneDocs) == 2) {
                        $plantel = Plantel::find($vinculacion->cliente->plantel_id);
                        $plantel->csc_vinculacion = $plantel->csc_vinculacion + 1;
                        $plantel->save();
                        $cadena = "00000";
                        $csc_numero = $plantel->csc_vinculacion;

                        //Log::info('flc-'.strlen($cadena)-strlen($csc_numero)."-".substr($cadena,(strlen($cadena)-strlen($csc_numero))));
                        $csc_str = $plantel->cve_vinculacion . substr($cadena, 0, (5 - strlen($csc_numero))) . $csc_numero;

                        $vinculacion->csc_vinculacion = $csc_str;
                        $vinculacion->save();
                    }
                } else if ($documento->doc_vinculacion_id == 11 and
                    $vinculacion->csc_vinculacion == 0 and
                    $vinculacion->clasificacion_id == 1) {
                    $plantel = Plantel::find($vinculacion->cliente->plantel_id);
                    $plantel->csc_vinculacion = $plantel->csc_vinculacion + 1;
                    $plantel->save();
                    $cadena = "00000";
                    $csc_numero = $plantel->csc_vinculacion;

                    //Log::info('flc-'.strlen($cadena)-strlen($csc_numero)."-".substr($cadena,(strlen($cadena)-strlen($csc_numero))));
                    $csc_str = $plantel->cve_vinculacion . substr($cadena, 0, (5 - strlen($csc_numero))) . $csc_numero;

                    $vinculacion->csc_vinculacion = $csc_str;
                    $vinculacion->save();
                }*/

                echo json_encode($ruta_web . "/" . $input['file']);
            } else {
                
                echo json_encode(0);
                
            }
        }else{
        
            $documento = DocVinculacionVinculacion::find($datos['id']);
            $documento->vinculacion_id = $datos['vinculacion'];
            $documento->doc_vinculacion_id = $datos['doc_vinculacion_id'];
            $documento->fec_inicio=$datos['fec_inicio'];
            $documento->fec_fin=$datos['fec_fin'];
            $documento->usu_alta_id = Auth::user()->id;
            $documento->usu_mod_id = Auth::user()->id;
            
            $nuevo=$documento->save();
            
            echo $documento->toJson();
        }
        //echo json_encode(0);
    }

    public function listaVinculacion()
    {
        $plantels = Plantel::pluck('razon', 'id');
        $estatus = StVinculacion::pluck('name', 'id');
        return view('vinculacions.reportes.listaVinculacion', compact('plantels', 'estatus'));
    }

    public function listaVinculacionR(Request $request)
    {
        $data = $request->all();
        $registros = Vinculacion::select('p.razon', 'e.name as especialidad', 'n.name as nivel', 'g.name as grado',
            'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno', 'stv.name as st_vinculacion',
            'vinculacions.lugar_practica', 'vinculacions.fec_inicio', 'vinculacions.fec_fin',
            'vinculacions.csc_vinculacion')
            ->join('clientes as c', 'c.id', '=', 'vinculacions.cliente_id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
            ->join('plantels as p', 'p.id', '=', 'i.plantel_id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'i.nivel_id')
            ->join('grados as g', 'g.id', '=', 'i.grado_id')
            ->join('st_vinculacions as stv', 'stv.id', '=', 'vinculacions.st_vinculacion_id')
            ->where('p.id', $data['plantel_id'])
            ->where('e.id', $data['especialidad_id'])
            ->where('n.id', $data['nivel_id'])
            ->where('g.id', $data['grado_id'])
            ->where('vinculacions.st_vinculacion_id', $data['estatus_f'])
            ->get();
        return view('vinculacions.reportes.listaVinculacionR', compact('registros'));
    }

    public function formatoCartaPresentacion(Request $request){
        $datos=$request->all();
        $vinculacion=Vinculacion::find($datos['vinculacion']);
        $cliente=$vinculacion->cliente;
        $combinacion=CombinacionCliente::where('cliente_id',$cliente->id)->first();
        if($vinculacion->clasificacion_id==1){
            return view('vinculacions.reportes.formatoCartaPresentacionL', compact('vinculacion','cliente','combinacion'));
        }elseif($vinculacion->clasificacion_id==2){
            return view('vinculacions.reportes.formatoCartaPresentacionB', compact('vinculacion','cliente','combinacion'));
        }
        
    }

    public function formatoCartaPresentacionSS(Request $request){
        $datos=$request->all();
        $vinculacion=Vinculacion::find($datos['vinculacion']);
        $cliente=$vinculacion->cliente;
        $combinacion=CombinacionCliente::where('cliente_id',$cliente->id)->first();
        
            return view('vinculacions.reportes.formatoCartaPresentacionSS', compact('vinculacion','cliente','combinacion'));
        
    }
}
