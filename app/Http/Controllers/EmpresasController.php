<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Asunto;
use App\Empleado;
use App\AvisosEmpresa;
use App\TareasEmpresa;
use App\Empresa;
use App\CuestionarioDato;
use App\Cuestionario;
use App\Cliente;
use App\ActividadEmpresa;
use App\User;
use App\Tarea;
use App\StTarea;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEmpresa;
use App\Http\Requests\createEmpresa;
use DB;
use Log;

class EmpresasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $empresas = Empresa::getAllData($request);
        $union = collect(["Seleccionar Opción"]);
        $plantel=Empleado::where('user_id', Auth::user()->id)->value('plantel_id');
        $usuarios = $union->union(User::join('empleados as e','e.user_id','=','users.id')
                        ->where('e.plantel_id','=', $plantel)
                        ->pluck('users.name','users.id'));
        return view('empresas.index', compact('empresas','usuarios'))->with('list', Empresa::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $p = Empleado::where('user_id', '=', Auth::user()->id)
                ->value('plantel_id');
        $pl = DB::table('plantels as p')
                        ->join('empleados as e', 'e.plantel_id', '=', 'p.id')
                        ->where('e.user_id', Auth::user()->id)->value('p.id');
        $empleados=Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'),'id')
                           ->where('plantel_id',$p)
                           ->pluck('nombre','id');
        $cuestionarios = Cuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');
        return view('empresas.create', compact('p', 'pl', 'cuestionarios','empleados'))
                        ->with('list', Empresa::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createEmpresa $request) {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Empresa::create($input);

        return redirect()->route('empresas.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        return view('empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        //dd($empresa->combinaciones->toArray());
        $p = Empleado::where('user_id', '=', Auth::user()->id)
                ->value('plantel_id');
        $pl = DB::table('plantels as p')
                        ->join('empleados as e', 'e.plantel_id', '=', 'p.id')
                        ->where('e.user_id', Auth::user()->id)->value('p.id');
        $actividadesRelacionados = array();
        foreach ($empresa->actividades as $ar) {
            $actividadesRelacionados = array_add($actividadesRelacionados, $ar->id, $ar->name);
        }
        $actividadesList = ActividadEmpresa::where('plantel_id', '=', $pl)->pluck('name', 'id');
        $empleados=Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as nombre'),'id')
                           ->where('plantel_id',$p)
                           ->pluck('nombre','id');
        //dd($empleados->toArray());
        $cuestionarios = Cuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');
        return view('empresas.edit', compact('empresa', 'p', 'actividadesList', 'actividadesRelacionados', 'pl', 'cuestionarios','empleados'))
                        ->with('list', Empresa::getListFromAllRelationApps())
                        ->with('list1', Cliente::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        return view('empresas.duplicate', compact('empresa'))
                        ->with('list', Empresa::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Empresa $empresa, updateEmpresa $request) {
        $input = $request->except(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15',
            '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28',
            '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40',
            'nivel_id', 'grado_id', 'from', 'to', 'q']);
        $preguntas = $request->except(['razon_social', 'nombre_contacto', 'tel_fijo', 'tel_cel', 'correo1',
            'correo2', 'calle', 'no_int', 'no_ex', 'colonia', 'municipio_id',
            'estado_id', 'cp', 'giro_id', 'plantel_id', 'especialidad_id',
            'cuestionario_id', 'usu_alta_id', 'usu_mod_id', 'nivel_id', 'grado_id','st_empresa_id','empleado_id',
            'from', 'to', 'q']);
        //dd($preguntas);
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $empresa = $empresa->find($id);
        $cantidad_preguntas = $empresa->cuestionario->preguntas->count();
        //dd($cantidad_preguntas);
        $empresa->update($input);
        foreach ($preguntas as $llave => $valor) {
            if ($llave <> '_token') {
                //dd($preguntas);
                $dato = CuestionarioDato::where('empresa_id', '=', $id)
                        ->where('cuestionario_id', '=', $input['cuestionario_id'])
                        ->where('cuestionario_pregunta_id', '=', $llave)
                        ->first();
                //dd($dato);
                if (is_null($dato)) {
                    $r = new CuestionarioDato;
                    $r->cuestionario_id = $input['cuestionario_id'];
                    $r->empresa_id = $id;
                    $r->cuestionario_id = $input['cuestionario_id'];
                    $r->cuestionario_pregunta_id = $llave;
                    $r->cuestionario_respuesta_id = $valor;
                    $r->name = "";
                    $r->usu_alta_id = Auth::user()->id;
                    $r->usu_mod_id = Auth::user()->id;
                    //dd($r->toArray());
                    $r->save();
                } else {
                    $dato->cuestionario_respuesta_id = $valor;
                    $dato->name = "";
                    $dato->usu_alta_id = Auth::user()->id;
                    $dato->usu_mod_id = Auth::user()->id;
                    //dd($dato);
                    $dato->save();
                }
            }
        }
        $cantidad_respuestas = CuestionarioDato::where('empresa_id', '=', $id)
                ->where('cuestionario_id', '=', $input['cuestionario_id'])
                ->count();
        if ($cantidad_preguntas <> $cantidad_respuestas) {
            return redirect()->route('empresas.edit', $id)->with('message', 'Cuestionario incompleto.');
        }
        return redirect()->route('empresas.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        $empresa->delete();

        return redirect()->route('empresas.index')->with('message', 'Registro Borrado.');
    }

    public function getEmpleadosXmail(Request $request) {
        if ($request->ajax()) {
            //dd($request->all());
            $mail = $request->get('correo');
            $nombre = $request->get('nombre');
            //dd($mail);

            $sr = DB::table('empresas as e')
                    ->join('clientes as c', 'c.empresa_id', '=', 'e.id')
                    ->select('c.id', 'c.mail', 'c.nombre')
                    ->where('e.correo1', '=', $mail)
                    ->whereNotNull('c.mail')
                    ->get();
            //dd($sr->toArray());
            $resultado = array();
            $lcorreos = $mail . ",";
            $lnombres = $nombre . ",";


            foreach ($sr as $r) {
                $lcorreos = $lcorreos . $r->mail . ",";
                $lnombres = $lnombres . $r->nombre . ",";
            }
            $resultado = array(substr($lcorreos, 0, -1), substr($lnombres, 0, -2));
            return $resultado;
            //dd($r);
        }
    }

    public function addactividad(Request $request) {
        if ($request->ajax()) {
            $actividad = $request->get('actividad');
            $empresa = $request->get('empresa');
            $empresa = Empresa::findOrFail($empresa);
            $empresa->actividades()->attach($actividad);
        }
    }

    public function lessActividad(Request $request) {
        //dd($request);
        if ($request->ajax()) {
            $actividad = $request->get('actividad');
            $empresa = $request->get('empresa');
            $empresa = Empresa::findOrFail($empresa);
            $empresa->actividades()->detach($actividad);
        }
    }

    public function getEmpresasCsv() {
        return view('empresas.reportes.empresas_csv')->with('list', Empresa::getListFromAllRelationApps());
    }

    public function postEmpresasCsv(Request $request) {

        config(['APP_DEBUG' => false]);
        $data = $request->all();
        //dd($data);
        $registros = Empresa::select('empresas.id', 'empresas.razon_social', 'empresas.created_at', 'p.razon as plantel', DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado'), 'empresas.tel_fijo', 'empresas.tel_cel', 'empresas.correo1', 'empresas.correo2', 'est.name as estado', 'mun.name as municipio')
                ->join('plantels as p', 'p.id', '=', 'empresas.plantel_id')
                ->join('empleados as e', 'e.user_id', '=', 'empresas.usu_alta_id')
                ->join('estados as est', 'est.id', '=', 'empresas.estado_id')
                ->join('municipios as mun', 'mun.id', '=', 'empresas.municipio_id')
                ->whereBetween('empresas.plantel_id', [$data['plantel_f'], $data['plantel_t']])
                ->whereDate('empresas.created_at', '>', date_format(date_create($data['fecha_f']), 'Y/m/d H:i:s'))
                ->whereDate('empresas.created_at', '<', date_format(date_create($data['fecha_t']), 'Y/m/d H:i:s'))
                ->get();
        //dd($registros->toArray());
         $csvExporter = new \Laracsv\Export();
          $csvExporter->build($registros, ['id'=>'ID','razon_social'=>'RAZON SOCIAL',
          'created_at'=>'CREADO EL',
          'empleado'=>'CREADO POR',
          'plantel'=>'PLANTEL',
          'tel_fijo' => 'TELEFONO FIJO',
          'tel_cel' => 'CELULAR',
          'correo1' => 'CORREO 1',
          'correo2' => 'CORREO 2',
          'estado' => 'ESTADO',
          'municipio' => 'MUNICIPIO'])->download();
          config(['APP_DEBUG' => true]); 

        /* $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
          $registros->each(function($person) use($csv) {
          $csv->insertOne($person->toArray());
          });
          $csv->output('people.csv');
         * */
        //echo $this->generateCsv($registros->toArray(),'PRB1.csv',';');
    }

    function generateCsv($input_array, $output_file_name, $delimiter) {
        $temp_memory = fopen('php://memory', 'w');
// loop through the array
        foreach ($input_array as $line) {
// use the default csv handler
            fputcsv($temp_memory, $line, $delimiter);
        }

        fseek($temp_memory, 0);
// modify the header to be CSV format
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
// output the file to be downloaded
        fpassthru($temp_memory);
    }
    
    public function seguimiento($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        $avisos = AvisosEmpresa::select('avisos_empresas.id', 'a.name', 'avisos_empresas.detalle', 'avisos_empresas.fecha', 
                Db::Raw('DATEDIFF(avisos_empresas.fecha,CURDATE()) as dias_restantes'))
                ->join('asuntos as a', 'a.id', '=', 'avisos_empresas.asunto_id')
                ->where('empresa_id', '=', $empresa->id)
                ->get();
        $asignacionTareas = TareasEmpresa::where('empresa_id', '=', $empresa->id)->get();
        $asuntos= Asunto::where('bnd_empresa',1)->pluck('name','id');
        $tareas= Tarea::where('bnd_empresa',1)->pluck('name','id');
        $asuntos->prepend('Seleccionar Valor',0);
        $tareas->prepend('Seleccionar Valor',0);
        $estatusTareas=StTarea::where('bnd_empresa',1)->pluck('name','id');
        return view('empresas.seguimiento', compact('empresa','avisos','asignacionTareas','asuntos','tareas','estatusTareas'));
    }
    
    
}
