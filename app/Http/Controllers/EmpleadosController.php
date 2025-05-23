<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use File;
use Hash;
use App\User;

use App\Estado;
use App\Lectivo;
use App\Plantel;
use App\Empleado;
use App\Historial;
use Carbon\Carbon;
use App\DocEmpleado;
use App\NivelEstudio;
use App\TipoContrato;
use App\Http\Requests;
use App\PivotDocEmpleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createEmpleado;
use App\Http\Requests\updateEmpleado;

class EmpleadosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $empleados = Empleado::getAllData($request);
        //$historials = Historial::getAllData($request);

        return view('empleados.index', compact('empleados'))
            ->with('list', Empleado::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //$plantel=DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id');
        $jefes = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
            ->where('jefe_bnd', '=', '1')
            //->where('plantel_id', '=', $plantel)
            ->pluck('name', 'id');
        $tipoContratos = TipoContrato::pluck('name', 'id');
        $responsables = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
            //->where('plantel_id', '=', $plantel)
            ->pluck('name', 'id');
        $estados = Estado::pluck('name', 'id');
        $nivel_estudios = NivelEstudio::pluck('name', 'id');
        
        return view('empleados.create', compact('estados', 'jefes', 'responsables', 'tipoContratos', 'nivel_estudios'))
            ->with('list', Empleado::getListFromAllRelationApps())
            ->with('list1', PivotDocEmpleado::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createEmpleado $request)
    {

        $input = $request->except('plantel_id');
        $input2 = $request->only('plantel_id');
        //dd($input);
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input['plantel_id'] = $input['pertenece_a'];
        if (!isset($input['jefe_bnd'])) {
            $input['jefe_bnd'] = 0;
        } else {
            $input['jefe_bnd'] = 1;
        }
        if (!isset($input['alerta_bnd'])) {
            $input['alerta_bnd'] = 0;
        } else {
            $input['alerta_bnd'] = 1;
        }
        if (!isset($input['alimenticia_bnd'])) {
            $input['alimenticia_bnd'] = 0;
        } else {
            $input['alimenticia_bnd'] = 1;
        }
        if (!isset($input['extranjero_bnd'])) {
            $input['extranjero_bnd'] = 0;
        } else {
            $input['extranjero_bnd'] = 1;
        }

        //dd($input);
        $e = Empleado::create($input);

        if(count($input2)>0){
            $e->plantels()->sync($input2['plantel_id']);    
        }
        
        if ($request->has('doc_empleado_id') and $request->has('archivo')) {
            $input3['doc_empleado_id'] = $request->get('doc_empleado_id');
            $input3['archivo'] = $request->get('archivo');
            $input3['empleado_id'] = $id;
            $input3['usu_alta_id'] = Auth::user()->id;
            $input3['usu_mod_id'] = Auth::user()->id;
            PivotDocEmpleado::create($input2);
        }

        return redirect()->route('empleados.edit', $e->id)->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Empleado $empleado)
    {
        $empleado = $empleado->find($id);
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Empleado $empleado, PivotDocEmpleado $pivotDocEmpleado)
    {
        $empleado = $empleado->find($id);
        $planteles = array();
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }
        if ($empleado->cve_empleado == "") {
            $empleado->cve_empleado = substr(Hash::make(rand(0, 1000)), 2, 8);
        }
        $jefes = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
            ->join('empleado_plantel as ep','ep.empleado_id','=','empleados.id')
            ->where('jefe_bnd', '=', '1')
            ->whereIn('ep.plantel_id', $planteles)
            //->whereIn('plantel_id', $planteles)
            ->pluck('name', 'id');
        //dd($jefes->toArray());

        $responsables = Empleado::select('empleados.id', DB::raw('concat(empleados.nombre," ",empleados.ape_paterno," ",empleados.ape_materno) as name'))
            ->join('puestos as p', 'p.id', '=', 'empleados.puesto_id')
            //->where('p.name', '=', 'RH')
            ->pluck('empleados.name', 'empleados.id');
        $doc_existentes = DB::table('pivot_doc_empleados as pde')->select('doc_empleado_id')
            ->join('empleados as e', 'e.id', '=', 'pde.empleado_id')
            ->where('e.id', '=', $id)
            ->where('pde.deleted_at', '=', NULL)->get();
        $estados = Estado::pluck('name', 'id');
        //dd($doc_existentes->toArray());
        $tipoContratos = TipoContrato::pluck('name', 'id');
        $de_array = array();
        if ($doc_existentes->isNotEmpty()) {
            foreach ($doc_existentes as $de) {
                array_push($de_array, $de->doc_empleado_id);
            }
            //dd($de_array);
        }
        $nivel_estudios = NivelEstudio::pluck('name', 'id');
        //dd($de_array);

        $documentos_faltantes = DB::table('doc_empleados')
            ->select()
            //->where('doc_obligatorio', 1)
            ->whereNotIn('id', $de_array)
            ->get();
        //dd($documentos_faltantes->toArray());
        return view('empleados.edit', compact('estados', 'tipoContratos', 'empleado', 'pivotDocEmpleado', 'jefes', 'responsables', 'documentos_faltantes', 'nivel_estudios'))
            ->with('list', Empleado::getListFromAllRelationApps())
            ->with('list1', PivotDocEmpleado::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Empleado $empleado)
    {
        $empleado = $empleado->find($id);

        $planteles = array();
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }
        $jefes = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
            ->where('jefe_bnd', '=', '1')
            //->where('plantel_id', '=', $plantel)
            ->pluck('name', 'id');
        $responsables = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
            //->where('plantel_id', '=', $empleado->plantel_id)
            ->whereIn('plantel_id', $planteles)
            ->pluck('name', 'id');
        $doc_existentes = DB::table('pivot_doc_empleados as pde')->select('doc_empleado_id')
            ->join('empleados as e', 'e.id', '=', 'pde.empleado_id')
            ->where('e.id', '=', $id)
            ->where('pde.deleted_at', '=', NULL)->get();

        $de_array = array();
        if ($doc_existentes->isNotEmpty()) {
            foreach ($doc_existentes as $de) {
                array_push($de_array, $de->doc_empleado_id);
            }
            //dd($de_array);
        }

        $documentos_faltantes = DB::table('doc_empleados')
            ->select()
            ->whereNotIn('id', $de_array)
            ->get();
        return view('empleados.duplicate', compact('empleado', 'jefes', 'responsables', 'documentos_faltantes'))
            ->with('list', Empleado::getListFromAllRelationApps())
            ->with('list1', PivotDocEmpleado::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    //Primera version
    /* public function update($id, Empleado $empleado, updateEmpleado $request)
      {
      $input = $request->all();
      $input['usu_mod_id']=Auth::user()->id;
      //update data
      //dd($request->all());
      $r=$request->hasFile('foto_file');
      //dd($r);
      if($r){
      $foto_file = $request->file('foto_file');
      $input['foto'] = $foto_file->getClientOriginalName();

      }
      $r=$request->hasFile('identificacion_file');
      if($r){
      $identificacion_file = $request->file('identificacion_file');
      $input['identificacion'] = $identificacion_file->getClientOriginalName();
      }
      $r=$request->hasFile('contrato_file');
      if($r){
      $contrato_file = $request->file('contrato_file');
      $input['contrato'] = $contrato_file->getClientOriginalName();
      }
      $r=$request->hasFile('evaluacion_psico_file');
      if($r){
      $evaluacion_psico_file = $request->file('evaluacion_psico_file');
      $input['evaluacion_psico'] = $evaluacion_psico_file->getClientOriginalName();
      }

      //dd($input);
      //dd($request->all());
      $empleado=$empleado->find($id);

      $e=$empleado->update( $input );
      //dd($e);

      if ( $e ){
      $ruta=public_path()."/imagenes/empleados/".$id."/";
      if(!file_exists($ruta)){
      File::makeDirectory($ruta, 0777, true, true);
      }
      if($request->file('foto_file')){
      //Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
      $request->file('foto_file')->move($ruta, $input['foto']);
      }
      if($request->file('identificacion_file')){
      //\Storage::disk('local')->put($input['slogan'],  \File::get($slogan_file));
      $request->file('identificacion_file')->move($ruta, $input['identificacion']);
      }
      if($request->file('contrato_file')){
      //\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
      $request->file('contrato_file')->move($ruta, $input['contrato']);
      }
      if($request->file('evaluacion_psico_file')){
      //\Storage::disk('local')->put($input['membrete'],  \File::get($membrete_file));
      $request->file('evaluacion_psico_file')->move($ruta, $input['evaluacion_psico']);
      }
      }

      return redirect()->route('empleados.index')->with('message', 'Registro Actualizado.');
      }
     */
    public function update($id, Empleado $empleado, updateEmpleado $request)
    {
        $input = $request->except(['doc_empleado_id', 'archivo', 'plantel_id']);
        //dd($input);

        $input2 = $request->only(['plantel_id']);
        //dd($input2['plantel_id']);
        if(isset($input['pertenece_a'])){
            $input['plantel_id'] = $input['pertenece_a'];
        }
        
        $input['usu_mod_id'] = Auth::user()->id;
        if (!isset($input['bnd_recontratable'])) {
            $input['bnd_recontratable'] = 0;
        } 
        //dd($input['jefe_bnd']);
        if (!isset($input['jefe_bnd'])) {
            $input['jefe_bnd'] = 0;
        } else {
            $input['jefe_bnd'] = 1;
        }
        if (!isset($input['alerta_bnd'])) {
            $input['alerta_bnd'] = 0;
        } else {
            $input['alerta_bnd'] = 1;
        }
        //dd($input);
        $empleado = $empleado->find($id);

        $e = $empleado->update($input);
        
        //dd($input['plantel_id']);
        if(count($input2)>0){
            $empleado->plantels()->sync($input2['plantel_id']);
        }
        

        if ($request->has('doc_empleado_id') and $request->get('doc_empleado_id') > 0 and $request->has('archivo')) {
            $input3['doc_empleado_id'] = $request->get('doc_empleado_id');
            $input3['archivo'] = $request->get('archivo');
            $input3['empleado_id'] = $id;
            $input3['usu_alta_id'] = Auth::user()->id;
            $input3['usu_mod_id'] = Auth::user()->id;
            PivotDocEmpleado::create($input3);
        }

        return redirect()->route('empleados.edit', $id)->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Empleado $empleado)
    {
        $empleado = $empleado->find($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('message', 'Registro Borrado.');
    }

    public function usuarios(Request $request)
    {
        //dd($_REQUEST);
        $data = User::select(DB::raw('concat(name, " - ", email) as n, id as d'))
            ->where("name", "LIKE", "%" . $request->input('term') . "%")
            ->get();
        //dd($data);
        $results = array();
        foreach ($data as $value) {
            //dd($value);
            $results[] = ['id' => $value->d, 'text' => $value->n];
        }
        return response()->json($results);
    }

    public function getPlantel($id = 0)
    {
        //dd($_REQUEST['estado']);
        $e = $_REQUEST['empleado'];
        $plantel = Empleado::find($e)->plantel_id;
        //dd($municipios);
        return $plantel;
    }

    public function getEmpleadosXplantelXpuesto(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $puesto = $request->get('puesto_id');
            $empleado = $request->get('empleado_id');

            $final = array();
            if ($plantel <> 0) {
                $r = DB::table('empleados as e')
                    ->select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'))
                    ->join('empleado_plantel as ep', 'ep.empleado_id', '=', 'e.id')
                    ->where('ep.plantel_id', '=', $plantel)
                    ->where('e.puesto_id', '=', $puesto)
                    ->where('e.id', '>', '0')
                    ->get();
            } else {
                $r = DB::table('empleados as e')
                    ->select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'))
                    ->where('e.puesto_id', '=', $puesto)
                    ->where('e.id', '>', '0')
                    ->get();
            }

            //dd($r);
            if (isset($empleado) and $empleado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $empleado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'nombre' => $r1->nombre,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'nombre' => $r1->nombre,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function getEmpleadosXplantel(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $input = $request->all();
            if (isset($input['asignacion_academicas.empleado_id_lt'])) {
                $plantel = $request->get('plantel_id');
                $empleado = $input['q']['asignacion_academicas.empleado_id_lt'];
            } else {
                $plantel = $request->get('plantel_id');
                $empleado = $request->get('empleado_id');
            }
            $e = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($e->plantels as $p) {
                array_push($planteles, $p->id);
            }

            $final = array();
            
            $r = DB::table('empleados as e')
                ->select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'))
                ->join('empleado_plantel as ep', 'ep.empleado_id', '=', 'e.id')
                ->where('ep.plantel_id', $plantel)
                //->where('e.puesto_id', 3)
                ->whereOr('e.id', '0')
                ->whereNotIn('st_empleado_id', array(3, 2, 10))
                ->distinct()
                ->get();
            //dd($r->toArray());

            if (isset($empleado) and $empleado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $empleado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'nombre' => $r1->nombre,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'nombre' => $r1->nombre,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                foreach ($r as $r1) {
                    array_push($final, array(
                        'id' => $r1->id,
                        'nombre' => $r1->nombre,
                        'selectec' => ''
                    ));
                }
                return $final;
            }
        }
    }

    public function getAsesoresXplantel(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $input = $request->all();
            if (isset($input['asignacion_academicas.empleado_id_lt'])) {
                $plantel = $request->get('plantel_id');
                $empleado = $input['q']['asignacion_academicas.empleado_id_lt'];
            } else {
                $plantel = $request->get('plantel_id');
                $empleado = $request->get('empleado_id');
            }

            $final = array();
            $r = DB::table('empleados as e')
                ->select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'))
                ->where('e.plantel_id', '=', $plantel)
                //->where('puesto_id',2)
                ->where('e.id', '>', '0')
                ->whereNotIn('st_empleado_id', array(3, 2, 10))
                ->get();

            //dd($r);
            if (isset($empleado) and $empleado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $empleado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'nombre' => $r1->nombre,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'nombre' => $r1->nombre,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                foreach ($r as $r1) {
                    array_push($final, array(
                        'id' => $r1->id,
                        'nombre' => $r1->nombre,
                        'selectec' => ''
                    ));
                }
                return $final;
            }
        }
    }

    public function cargarImg(Request $request)
    {

        $r = $request->hasFile('file');
        $datos = $request->all();
        //dd($request->all());
        if ($r) {
            $logo_file = $request->file('file');
            $input['file'] = $logo_file->getClientOriginalName();
            $ruta_web = asset("/imagenes/empleados/" . $datos['empleado']);
            //dd($ruta_web);
            $ruta = public_path() . "/imagenes/empleados/" . $datos['empleado'] . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            if ($request->file('file')->move($ruta, $input['file'])) {
                $documento = new PivotDocEmpleado();
                $documento->empleado_id = $datos['empleado'];
                $documento->doc_empleado_id = $datos['doc_empleado_id'];
                $documento->archivo = $ruta_web . "/" . $input['file'];
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

    public function ListaDocumentos()
    {
        return view('empleados.reportes.listaDocumentos')
            ->with('list', Empleado::getListFromAllRelationApps());
    }

    public function ListaDocumentosR(Request $request)
    {
        $datos = $request->all();


        $empleados = Empleado::select('empleados.*', 'ste.name as estatus')->where('empleados.plantel_id', $datos['plantel_f'])
            ->join('st_empleados as ste', 'ste.id', '=', 'empleados.st_empleado_id')
            ->whereIn('st_empleado_id', $datos['estatus_f'])
            ->get();
        $documentos_faltantes = array();
        foreach ($empleados as $empleado) {
            $documentos_obligatorios_Aux = DocEmpleado::where('doc_obligatorio', 1);
            if ($empleado->extranjero_bnd == 1) {
                $documentos_obligatorios_Aux->orWhere('id', 18);
            }
            if ($empleado->alimenticia_bnd == 1) {
                $documentos_obligatorios_Aux->orWhere('id', 17);
            }
            if ($empleado->genero == 1) {
                $documentos_obligatorios_Aux->orWhere('id', 14);
            }

            $documentos_obligatorios = $documentos_obligatorios_Aux->get();
            //dd($documentos_obligatorios);

            $docsPorEmpleado = PivotDocEmpleado::where('empleado_id', $empleado->id)
                ->select('pivot_doc_empleados.doc_empleado_id')
                ->get();
            //dd($docsPorEmpleado->toArray());
            if (!is_null($docsPorEmpleado)) {
                $array_docsPorEmpleado = array();
                $i = 0;
                foreach ($docsPorEmpleado as $do) {
                    //dd($do);
                    $array_docsPorEmpleado[$i] = $do->doc_empleado_id;
                    $i++;
                }
                //dd($array_docsPorEmpleado);
                foreach ($documentos_obligatorios as $do) {
                    if (!in_array($do->id, $array_docsPorEmpleado)) {
                        //dd($do->id);
                        array_push($documentos_faltantes, array(
                            'empleado' => $empleado->id,
                            'nombre' => $empleado->nombre . ' ' . $empleado->ape_paterno . ' ' . $empleado->ape_materno,
                            'documento' => $do->name,
                            'estatus' => $empleado->estatus
                        ));
                    }
                }
            }
        }
        //dd($documentos_faltantes);
        return view('empleados.reportes.listaDocumentosR', compact('documentos_faltantes'));
    }

    public function registroDocentes()
    {
        $lectivos=Lectivo::pluck('name','id');
        return view('empleados.reportes.registroDocentes', compact('lectivos'))
        ->with('list', Empleado::getListFromAllRelationApps());;
    }

    public function registroDocentesR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = Empleado::select(
            'curp',
            'ape_paterno',
            'ape_materno',
            'nombre',
            'fec_nacimiento',
            'genero',
            'est_nacimiento.id as estado_nacimiento',
            'pais_nacimiento',
            'ne.id as nivel_estudio',
            'profesion',
            'profordems',
            'fec_inicio_experiencia_academicas',
            'cedula'
        )
            ->leftJoin('nivel_estudios as ne', 'ne.id', '=', 'empleados.nivel_estudio_id')
            ->leftJoin('estados as est_nacimiento', 'est_nacimiento.id', '=', 'empleados.estado_nacimiento_id')
            ->join('asignacion_academicas as aa','aa.docente_oficial_id','=','empleados.id')
            ->join('materia as m','m.id','aa.materium_id')
            ->where('aa.plantel_id', $datos['plantel_f'])
            //->whereIn('empleados.st_empleado_id', $datos['estatus_f'])
            ->where('aa.lectivo_id',$datos['lectivo_f'])
            //->where('empleados.puesto_id', 3)
            ->where('m.bnd_oficial', 1)
            ->WhereNull('empleados.deleted_at')
            //->where('aa.docente_oficial_id','>',0)
            ->distinct()
            ->get();
        //dd($registros->toArray());
        return view('empleados.reportes.registroDocentesR', compact('registros'));
    }

    public function registroInfDocentes()
    {

        $lectivos = Lectivo::pluck('name', 'id');
        return view('empleados.reportes.registroInfDocentes', compact('lectivos'))
            ->with('list', Empleado::getListFromAllRelationApps());;
    }

    public function registroInfDocentesR(Request $request)
    {
        $datos = $request->all();
        $registros_aux = Empleado::select(
            'g.rvoe',
            'empleados.curp',
            'm.codigo as clave',
            'l.inicio'
        )
            ->join('asignacion_academicas as aa', 'aa.docente_oficial_id', '=', 'empleados.id')
            ->join('lectivos as l', 'l.id', '=', 'aa.lectivo_id')
            ->join('materia as m', 'm.id', '=', 'aa.materium_id')
            ->join('hacademicas as h', 'h.materium_id', '=', 'm.id')
            ->whereColumn('h.lectivo_id', 'aa.lectivo_id')
            ->whereColumn('h.grupo_id', 'aa.grupo_id')
            ->whereColumn('h.plantel_id', 'aa.plantel_id')
            ->join('grados as g', 'g.id', '=', 'h.grado_id')
            ->where('aa.lectivo_id', $datos['lectivo_f'])
            ->where('aa.plantel_id', $datos['plantel_f'])
            //->whereIn('empleados.st_empleado_id', $datos['estatus_f'])
            //->where('empleados.puesto_id', 3)
            ->WhereNull('empleados.deleted_at');
            if($datos['oficiales_f']==2){
                $registros_aux->where('bnd_oficial',1);
            }
            $registros=$registros_aux
            ->distinct()
            ->get();
        //dd($registros->toArray());
        return view('empleados.reportes.registroInfDocentesR', compact('registros'));
    }

    public function baja(Request $request)
    {
        $datos = $request->all();
        $empleado = Empleado::find($datos['id']);
        $empleado->st_empleado_id = 3;
        $empleado->save();
        return redirect(url('/home'));
    }

    public function finContratos(){
        $e = Empleado::where('user_id', Auth::user()->id)->first();
            $plantels = array();
            foreach ($e->plantels as $p) {
                array_push($plantels, $p->id);
            }
        $planteles=Plantel::whereIn('id',$plantels)->pluck('razon','id');
        return view('empleados.reportes.finContratos',compact('planteles'));
    }

    public function finContratosR(Request $request){
        $datos=$request->all();
        //dd($datos);
        $contratosVencidos = Empleado::where('st_empleado_id', '<>', 3)
            ->where('dias_alerta', '>', 0)
            ->whereIn('plantel_id', $datos['plantel_f'])
            ->whereRaw('DATEDIFF(fin_contrato, "' . Date("Y-m-d") . '") <= dias_alerta')
            ->orderBy('plantel_id')
            ->orderBy('fin_contrato')
            ->get();
        return view('empleados.reportes.finContratosR',compact('contratosVencidos'));
    }

    public function listadoColaboradores(){
        $e = Empleado::where('user_id', Auth::user()->id)->first();
            $plantels = array();
            foreach ($e->plantels as $p) {
                array_push($plantels, $p->id);
            }
        $planteles=Plantel::whereIn('id',$plantels)->pluck('razon','id');
        return view('empleados.reportes.listadoColaboradores',compact('planteles'))
        ->with('list', Empleado::getListFromAllRelationApps());
    }



    public function listadoColaboradoresR(Request $request){
        $datos=$request->all();
        $empleados=Empleado::select('pla.razon','empleados.id', 'empleados.nombre', 'empleados.ape_paterno', 
        'empleados.ape_materno', 'empleados.curp', 'empleados.rfc', 'empleados.direccion', 'p.name AS puesto', 
        'empleados.mail_empresa', 'empleados.tel_cel', 'empleados.tel_emergencia', 'empleados.parentesco', 
        'empleados.contacto_emergencia','empleados.tel_fijo',
        'stc.name as estatus','empleados.fec_nacimiento','empleados.fec_ingreso',
        'empleados.cve_empleado','empleados.cel_empresa','empleados.mail','u.name as user',
        'empleados.extranjero_bnd','empleados.genero','empleados.alimenticia_bnd','empleados.jefe_bnd', 
        'j.nombre as nombre_jefe','j.ape_paterno as ape_paterno_jefe','j.ape_materno as ape_materno_jefe',
        'e.name as estado_nacimiento',
        'empleados.pais_nacimiento','ne.name as nivel_estudio', 'empleados.profesion','empleados.cedula',
        'empleados.anios_servicio_escuela','empleados.fec_inicio_experiencia_academicas',
        'empleados.profordems','empleados.bnd_recontratable','empleados.just_recontratable',
        'tc.name as tipo_contrato','pla_contrato1.razon as pla_contrato1','empleados.fin_contrato',
        'tc2.name as tipo_contrato2','pla_contrato2.razon as pla_contrato2','empleados.fec_fin_contrato2'
        //'his.descripcion as evento_descripcion','his.fecha as evento_fecha'
        )
        ->join('puestos as p','p.id','empleados.puesto_id')
        ->leftJoin('plantels as pla','pla.id','empleados.plantel_id')
        ->leftJoin('plantels as pla_contrato1','pla_contrato1.id','empleados.plantel_contrato1_id')
        ->leftJoin('plantels as pla_contrato2','pla_contrato2.id','empleados.plantel_contrato2_id')
        ->join('st_empleados as stc','stc.id','empleados.st_empleado_id')
        ->join('users as u','u.id','empleados.user_id')
        ->join('empleados as j','j.id', 'empleados.jefe_id')
        ->leftJoin('tipo_contratos as tc','tc.id', 'empleados.tipo_contrato_id')
        ->leftJoin('tipo_contratos as tc2','tc2.id', 'empleados.tipo_contrato2_id')
        ->leftJoin('estados as e','e.id', 'empleados.estado_nacimiento_id')
        ->leftJoin('nivel_estudios as ne','ne.id', 'empleados.nivel_estudio_id')
        //->leftJoin('historials as his','his.empleado_id', 'empleados.id')
        ->whereIn('empleados.plantel_id', $datos['plantel_f']) 
        ->whereIn('empleados.st_empleado_id', $datos['estatus_f']) 
        ->with('historials')
        ->get();
        /*foreach($empleados as $e){
            if($e->id==2) dd($e->historials->last());
        }*/
        
        return view('empleados.reportes.listadoColaboradoresR',compact('empleados'));
    }

    public function listadoCumples(){
        $e = Empleado::where('user_id', Auth::user()->id)->first();
            $plantels = array();
            foreach ($e->plantels as $p) {
                array_push($plantels, $p->id);
            }
        $planteles=Plantel::whereIn('id',$plantels)->pluck('razon','id');
        return view('empleados.reportes.listadoCumples',compact('planteles'))
        ->with('list', Empleado::getListFromAllRelationApps());
    }



    public function listadoCumplesR(Request $request){
        $datos=$request->all();
        $fecha=Carbon::createFromFormat('Y-m-d',$datos['fecha_f']);
        $empleados=Empleado::select('pla.razon','empleados.id', 'empleados.nombre', 'empleados.ape_paterno', 
        'empleados.ape_materno', 'empleados.curp', 'empleados.rfc', 'empleados.direccion', 'p.name AS puesto', 
        'empleados.mail_empresa', 'empleados.tel_cel', 'empleados.tel_emergencia', 'empleados.parentesco', 
        'empleados.fin_contrato','stc.name as estatus','empleados.fec_nacimiento','empleados.fec_ingreso')
        ->join('puestos as p','p.id','empleados.puesto_id')
        ->join('plantels as pla','pla.id','empleados.plantel_id')
        ->join('st_empleados as stc','stc.id','empleados.st_empleado_id')
        ->whereIn('plantel_id', $datos['plantel_f']) 
        ->whereNotIn('empleados.st_empleado_id',[2,3,])
        ->whereMonth('fec_nacimiento', $fecha->month) 
        ->get();
        return view('empleados.reportes.listadoCumplesR',compact('empleados'));
    }

    public function listadoAniversarios(){
        $e = Empleado::where('user_id', Auth::user()->id)->first();
            $plantels = array();
            foreach ($e->plantels as $p) {
                array_push($plantels, $p->id);
            }
        $planteles=Plantel::whereIn('id',$plantels)->pluck('razon','id');
        return view('empleados.reportes.listadoAniversarios',compact('planteles'))
        ->with('list', Empleado::getListFromAllRelationApps());
    }



    public function listadoAniversariosR(Request $request){
        $datos=$request->all();
        $fecha=Carbon::createFromFormat('Y-m-d',$datos['fecha_f']);
        $empleados=Empleado::select('pla.razon','empleados.id', 'empleados.nombre', 'empleados.ape_paterno', 
        'empleados.ape_materno', 'empleados.curp', 'empleados.rfc', 'empleados.direccion', 'p.name AS puesto', 
        'empleados.mail_empresa', 'empleados.tel_cel', 'empleados.tel_emergencia', 'empleados.parentesco', 
        'empleados.fin_contrato','stc.name as estatus','empleados.fec_nacimiento','empleados.fec_ingreso')
        ->join('puestos as p','p.id','empleados.puesto_id')
        ->join('plantels as pla','pla.id','empleados.plantel_id')
        ->join('st_empleados as stc','stc.id','empleados.st_empleado_id')
        ->whereIn('plantel_id', $datos['plantel_f']) 
        ->whereMonth('fec_ingreso', $fecha->month) 
        ->whereNotIn('empleados.st_empleado_id',[2,3,])
        ->get();
        return view('empleados.reportes.listadoAniversariosR',compact('empleados'));
    }

    public function getEmpleadosStProspectos(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            
            $st_prospecto = $request->get('st_prospecto_id');
            
            $final = array();
            $r = DB::table('empleados as e')
                ->select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'))
                ->where('e.st_prospecto_id', '=', $st_prospecto)
                ->where('e.id', '>', '0')
                ->whereNotIn('st_empleado_id',array(3))
                ->pluck('id');
            return $r;
            
        }
    }


}
