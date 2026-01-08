<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use File;
use App\Grado;
use App\Modulo;
use App\Plantel;
use App\Seccion;
use App\SepCarrera;
use App\PlanEstudio;
use App\Http\Requests;
use App\DuracionPeriodo;
use Illuminate\Http\Request;
use App\Http\Requests\createGrado;
use App\Http\Requests\updateGrado;
use App\Http\Controllers\Controller;
use App\SepAutorizacionReconocimiento;
use Illuminate\Support\Facades\Storage;
use App\SepFundamentoLegalServicioSocial;

class GradosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $grados = Grado::getAllData($request);

        return view('grados.index', compact('grados'))->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $modulos = Modulo::pluck('name', 'id');
        $duracion_periodo = DuracionPeriodo::pluck('name', 'id');
        $duracion_periodo->prepend('Seleccionar opcion', "");
        $plan_estudio = PlanEstudio::pluck('name', 'id');
        $plan_estudio->prepend('Seleccionar opcion', "");
        $sep_carreras = SepCarrera::select(DB::raw('concat(cve_carrera,"-",descripcion) as name, id'))
            ->pluck('name', 'id');
        $sep_carreras->prepend("Seleccionar opcion", "");
        $sep_autorizacion_reconocimientos = SepAutorizacionReconocimiento::select(DB::raw('concat(id_autorizacion_reconocimiento,"-",autorizacion_reconocimiento) as name, id'))
            ->pluck('name', 'id');
        $sep_autorizacion_reconocimientos->prepend("Seleccionar opcion", "");
        $sep_fundamento_legal = SepFundamentoLegalServicioSocial::select(DB::raw('concat(id_fundamento_legal_servicio_social,"-",fundamento_legal_servicio_social) as name, id'))
            ->pluck('name', 'id');
        $sep_fundamento_legal->prepend("Seleccionar opcion", "");
        return view('grados.create', compact(
            'modulos',
            'sep_carreras',
            'sep_fundamento_legal',
            'sep_autorizacion_reconocimientos',
            'duracion_periodo',
            'plan_estudio'
        ))
            ->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createGrado $request)
    {

        $input = $request->all();
        //dd($input);

        if (isset($input['mexico_bnd'])) {
            $input['mexico_bnd'] = 1;
        } else {
            $input['mexico_bnd'] = 0;
        }
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //$input['seccion']=Seccion::where('id',$input['seccion_id'])->value('name');

        //create data
        Grado::create($input);

        return redirect()->route('grados.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Grado $grado)
    {
        $grado = $grado->find($id);
        return view('grados.show', compact('grado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Grado $grado)
    {
        $grado = $grado->find($id);
        //dd($grado->toArray());
        $modulos = Modulo::pluck('name', 'id');
        $duracion_periodo = DuracionPeriodo::pluck('name', 'id');
        $duracion_periodo->prepend('Seleccionar opcion', "");
        $plan_estudio = PlanEstudio::pluck('name', 'id');
        $plan_estudio->prepend('Seleccionar opcion', "");
        //dd($plan_estudio);
        $sep_carreras = SepCarrera::select(DB::raw('concat(cve_carrera,"-",descripcion) as name, id'))
            ->pluck('name', 'id');
        $sep_carreras->prepend("Seleccionar opcion", "");
        //dd($sep_carreras);
        $sep_autorizacion_reconocimientos = SepAutorizacionReconocimiento::select(DB::raw('concat(id_autorizacion_reconocimiento,"-",autorizacion_reconocimiento) as name, id'))
            ->pluck('name', 'id');
        $sep_autorizacion_reconocimientos->prepend("Seleccionar opcion", "");
        $sep_fundamento_legal = SepFundamentoLegalServicioSocial::select(DB::raw('concat(id_fundamento_legal_servicio_social,"-",fundamento_legal_servicio_social) as name, id'))
            ->pluck('name', 'id');
        $sep_fundamento_legal->prepend("Seleccionar opcion", "");
        return view('grados.edit', compact(
            'grado',
            'modulos',
            'sep_carreras',
            'sep_fundamento_legal',
            'sep_autorizacion_reconocimientos',
            'duracion_periodo',
            'plan_estudio'
        ))
            ->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Grado $grado)
    {
        $grado = $grado->find($id);
        return view('grados.duplicate', compact('grado'))
            ->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Grado $grado, updateGrado $request)
    {
        $input = $request->all();
        //dd($input);
        $input['usu_mod_id'] = Auth::user()->id;
        if (isset($input['mexico_bnd'])) {
            $input['mexico_bnd'] = 1;
        } else {
            $input['mexico_bnd'] = 0;
        }
        if (!isset($input['bnd_servicio_social'])) {
            $input['bnd_servicio_social'] = 0;
        }
        //$input['seccion']=Seccion::where('id',$input['seccion_id'])->value('name');
        //update data
        $grado = $grado->find($id);
        $grado->update($input);

        return redirect()->route('grados.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Grado $grado)
    {
        $grado = $grado->find($id);
        if (count($grado->combinacionClientes) == 0) {
            $grado->delete();
        }


        return redirect()->route('grados.index')->with('message', 'Registro Borrado.');
    }

    public function getCmbGrados(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $grado = $request->get('grado_id');
            $final = array();
            $r = DB::table('grados as g')
                ->select('g.id', 'g.name')
                ->where('g.plantel_id', '=', $plantel)
                ->where('g.especialidad_id', '=', $especialidad)
                ->where('g.nivel_id', '=', $nivel)
                ->where('g.id', '>', '0')
                ->whereNull('g.deleted_at')
                ->get();
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
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

    public function getCmbGradosXalumno(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $cliente = $request->get('cliente_id');
            $grado = $request->get('grado_id');

            $final = array();
            $r = DB::table('grados as g')
                ->join('inscripcions as i', 'i.grado_id', '=', 'g.id')
                ->join('clientes as c', 'i.cliente_id', '=', 'c.id')
                ->select('g.id', 'g.name')
                ->where('c.id', '=', $cliente)
                ->where('g.id', '>', '0')
                ->whereNull('i.deleted_at')
                ->get();
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
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

    public function getCmbGradosXAsignacion(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel');
            $lectivo = $request->get('lectivo');
            $grupo = $request->get('grupo');

            $final = array();
            $r = DB::table('grados as g')
                ->join('inscripcions as i', 'i.grado_id', '=', 'g.id')
                ->join('clientes as c', 'i.cliente_id', '=', 'c.id')
                ->select('g.id', 'g.name')
                ->where('i.plantel_id', '=', $plantel)
                ->where('i.lectivo_id', '=', $lectivo)
                ->where('i.grupo_id', '=', $grupo)
                ->where('g.id', '>', '0')
                ->distinct()
                ->get();
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
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

    public function listaGrados(Request $request)
    {
        $grados = Grado::whereIn('plantel_id', $request->input('plantel'))->orderBy('plantel_id')->orderBy('especialidad_id')->orderBy('nivel_id')->orderBy('id')->get();
        $plantels = Plantel::pluck('razon', 'id');
        return view('combinacionClientes.reportes.cargas', compact('grados', 'plantels'));
    }

    public function listaGradosTodos(Request $request)
    {
        $grados = Grado::orderBy('plantel_id')->orderBy('especialidad_id')->orderBy('nivel_id')->orderBy('id')->get();
        $plantels = Plantel::pluck('razon', 'id');
        $todos = true;
        return view('combinacionClientes.reportes.cargas', compact('grados', 'plantels', 'todos'));
    }

    public function apiListaXplantelYespecialidadYgrado(Request $request)
    {
        //dd($request);
        $datos = $request->all();
        $lista = Grado::select('id', 'name')
            ->where('plantel_id', $datos['plantel'])
            ->where('especialidad_id', $datos['especialidad'])
            ->where('nivel_id', $datos['nivel'])
            ->get();
        if (count($lista) == 0) {
            return response()->json(['msj' => 'Sin registros'], 500);
        }
        return response()->json(['resultado' => $lista]);
    }

    public function getCmbGradosGrupoInscripcion(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $grado = $request->get('grado_id');
            $grupo = $request->get('grupo_id');

            $final = array();
            $r = DB::table('grados as g')
                ->join('hacademicas as h', 'h.grado_id', '=', 'g.id')
                ->select('g.id', 'g.name')
                ->where('g.plantel_id', '=', $plantel)
                ->where('g.especialidad_id', '=', $especialidad)
                ->where('g.nivel_id', '=', $nivel)
                ->where('h.grupo_id', '=', $grupo)
                ->where('g.id', '>', '0')
                ->whereNull('g.deleted_at')
                ->whereNull('h.deleted_at')
                ->distinct()
                ->get();
            /*$r = DB::table('grados as g')
            ->join('inscripcions as i','i.grado_id','=','g.id')
                ->select('g.id', 'g.name')
                ->where('g.plantel_id', '=', $plantel)
                ->where('g.especialidad_id', '=', $especialidad)
                ->where('g.nivel_id', '=', $nivel)
                ->where('i.grupo_id', '=', $grupo)
                ->where('g.id', '>', '0')
                ->whereNull('g.deleted_at')
                ->whereNull('i.deleted_at')
                ->distinct()
                ->get();*/
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
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

    public function cargaArchivo(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $nombre = date('dmYhmi') . $file->getClientOriginalName();
            $r = Storage::disk('img_grados')->put($nombre, File::get($file));
            $grado = Grado::find($request->get('grado'));
            if ($grado->imagen != "") {
                Storage::disk('img_grados')->delete($grado->imagen);
                $grado->imagen = $nombre;
            } else {
                $grado->imagen = $nombre;
            }
            $grado->save();
        } else {

            return "no";
        }

        if ($r) {
            return $nombre;
        } else {
            return "Error vuelva a intentarlo";
        }
    }
}
