<?php

namespace App\Http\Controllers;

use App\Especialidad;
use App\Http\Controllers\Controller;
use App\Http\Requests\createEspecialidad;
use App\Http\Requests\updateEspecialidad;
use App\Lectivo;
use Auth;
use DB;
use Illuminate\Http\Request;
use Storage;

class EspecialidadsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $especialidads = Especialidad::getAllData($request);
        //dd($especialidads);

        return view('especialidads.index', compact('especialidads'))
            ->with('list', Especialidad::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $lectivos = Lectivo::where('id', '<', 3)->pluck('name', 'id');
        return view('especialidads.create', compact('lectivos'))
            ->with('list', Especialidad::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createEspecialidad $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Especialidad::create($input);

        return redirect()->route('especialidads.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Especialidad $especialidad)
    {
        $especialidad = $especialidad->find($id);
        return view('especialidads.show', compact('especialidad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Especialidad $especialidad)
    {
        $especialidad = $especialidad->find($id);
        $lectivos = Lectivo::where('id', '<', 3)->pluck('name', 'id');
        return view('especialidads.edit', compact('especialidad', 'lectivos'))
            ->with('list', Especialidad::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Especialidad $especialidad)
    {
        $especialidad = $especialidad->find($id);
        return view('especialidads.duplicate', compact('especialidad'))
            ->with('list', Especialidad::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Especialidad $especialidad, updateEspecialidad $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $especialidad = $especialidad->find($id);
        $especialidad->update($input);

        return redirect()->route('especialidads.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Especialidad $especialidad)
    {
        $especialidad = $especialidad->find($id);
        $especialidad->delete();

        return redirect()->route('especialidads.index')->with('message', 'Registro Borrado.');
    }

    public function getCmbEspecialidad(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');

            $final = array();
            $r2 = DB::table('especialidads as e')
                ->select('e.id', 'e.name')
                ->where('e.plantel_id', '=', $plantel)
                ->where('e.id', '>', '0')
                ->whereNull('deleted_at');
            //->get();

            $r = DB::table('especialidads as e')
                ->select('e.id', 'e.name')
                ->where('e.id', '0')
                ->union($r2)
                ->get();

            //dd($r);
            if (isset($especialidad) and $especialidad != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $especialidad) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected',
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => '',
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
            $r = Storage::disk('img_especialidads')->put($nombre, \File::get($file));
            $especialidad = Especialidad::find($request->get('especialidad'));
            if ($especialidad->imagen != "") {
                Storage::disk('img_especialidads')->delete($especialidad->imagen);
                $especialidad->imagen = $nombre;
            } else {
                $especialidad->imagen = $nombre;
            }
            $especialidad->save();
        } else {

            return "no";
        }

        if ($r) {
            return $nombre;
        } else {
            return "Error vuelva a intentarlo";
        }
    }

    public function cargaFondo(Request $request)
    {
        if ($request->hasFile('file_fondo')) {
            $file = $request->file('file_fondo');
            $extension = $file->getClientOriginalExtension();
            $nombre = date('dmYhmi') . $file->getClientOriginalName();
            $r = Storage::disk('img_especialidads')->put($nombre, \File::get($file));
            $especialidad = Especialidad::find($request->get('especialidad'));
            if ($especialidad->fondo_credencial != "") {
                Storage::disk('img_especialidads')->delete($especialidad->fondo_credencial);
                $especialidad->fondo_credencial = $nombre;
            } else {
                $especialidad->fondo_credencial = $nombre;
            }
            $especialidad->save();
        } else {

            return "no";
        }

        if ($r) {
            return $nombre;
        } else {
            return "Error vuelva a intentarlo";
        }
    }

    public function listaEspecialidades()
    {
        $especialidades = Especialidad::orderBy('plantel_id')->orderBy('id')->get();
        return view('combinacionClientes.reportes.cargas', compact('especialidades'));
    }

    public function apiListaXPlantel(Request $request)
    {
        $datos = $request->all();
        $lista = Especialidad::select('id', 'name')->where('plantel_id', $datos['plantel'])->get();
        if (count($lista) == 0) {
            return response()->json(['msj' => 'Sin registros'], 500);
        }
        return response()->json(['resultado' => $lista]);
    }
}
