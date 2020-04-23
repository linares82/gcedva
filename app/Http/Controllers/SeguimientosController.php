<?php

namespace App\Http\Controllers;

use App\Adeudo;
use App\AsignacionTarea;
use App\Asunto;
use App\Aviso;
use App\Caja;
use App\CajaLn;
use App\Cliente;
use App\CombinacionCliente;
use App\Empleado;
use App\Especialidad;
use App\Hactividade;
use App\Http\Controllers\Controller;
use App\Http\Requests\createSeguimiento;
use App\Http\Requests\updateAsignacionTarea;
use App\Http\Requests\updateSeguimiento;
use App\Inscripcion;
use App\Lectivo;
use App\Plantel;
use App\PromoPlanLn;
use App\Seguimiento;
use App\SmsPredefinido;
use App\StSeguimiento;
use App\StTarea;
use App\Tarea;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SeguimientosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $seguimientos = Seguimiento::getAllData($request);

        return view('seguimientos.index', compact('seguimientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('seguimientos.create')
            ->with('list', Seguimiento::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createSeguimiento $request)
    {
        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input_seguimiento['mes'] = date('m');

        //create data
        Seguimiento::create($input);

        return redirect()->route('seguimientos.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Seguimiento $seguimiento, updateAsignaciontarea $request)
    {
        /* $seguimiento=$seguimiento->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
        ->where('cliente_id', '=', $id)->first();
         */
        //dd($seguimiento);
        $seguimiento = $seguimiento->where('cliente_id', '=', $id)->first();
        if (!isset($seguimiento->id)) {
            $input_seguimiento['cliente_id'] = $id;
            $input_seguimiento['estatus_id'] = 1;
            $input_seguimiento['usu_alta_id'] = Auth::user()->id;
            $input_seguimiento['usu_mod_id'] = Auth::user()->id;
            $seguimiento = Seguimiento::create($input_seguimiento);
        }
        //$seguimiento->getAllData();
        $sts = StSeguimiento::pluck('name', 'id');
        $asignacionTareas = AsignacionTarea::where('cliente_id', '=', $seguimiento->cliente_id)->get();
        $avisos = Aviso::select('avisos.id', 'a.name', 'avisos.detalle', 'avisos.fecha', Db::Raw('DATEDIFF(avisos.fecha,CURDATE()) as dias_restantes'))
            ->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
            ->where('seguimiento_id', '=', $seguimiento->id)
            ->get();
        $actividades = Hactividade::where('seguimiento_id', '=', $seguimiento->id)->get();
        $smss = SmsPredefinido::pluck('name', 'id');
        $asuntos = Asunto::where('bnd_empresa', 0)->pluck('name', 'id');
        $tareas = Tarea::where('bnd_empresa', 0)->pluck('name', 'id');
        $estatusTareas = StTarea::where('bnd_empresa', 0)->pluck('name', 'id');
        //dd($actividades->toArray());
        //$dias=round((strtotime($a->fecha)-strtotime(date('Y-m-d')))/86400);
        //dd($seguimiento);
        return view('seguimientos.show', compact('seguimiento', 'sts', 'asignacionTareas', 'avisos', 'actividades', 'smss', 'asuntos', 'tareas', 'estatusTareas'))
            ->with('list', AsignacionTarea::getListFromAllRelationApps());
    }

    public function showPrint($id, Seguimiento $seguimiento, updateAsignaciontarea $request)
    {
        /* $seguimiento=$seguimiento->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
        ->where('cliente_id', '=', $id)->first();
         */
        //dd($seguimiento);
        $seguimiento = $seguimiento->where('cliente_id', '=', $id)->first();
        if (!isset($seguimiento->id)) {
            $input_seguimiento['cliente_id'] = $id;
            $input_seguimiento['estatus_id'] = 1;
            $input_seguimiento['usu_alta_id'] = Auth::user()->id;
            $input_seguimiento['usu_mod_id'] = Auth::user()->id;
            $seguimiento = Seguimiento::create($input_seguimiento);
        }
        //$seguimiento->getAllData();
        $sts = StSeguimiento::pluck('name', 'id');
        $asignacionTareas = AsignacionTarea::where('cliente_id', '=', $seguimiento->cliente_id)->get();
        $avisos = Aviso::select('avisos.id', 'a.name', 'avisos.detalle', 'avisos.fecha', Db::Raw('DATEDIFF(avisos.fecha,CURDATE()) as dias_restantes'))
            ->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
            ->where('seguimiento_id', '=', $seguimiento->id)
            ->where('avisos.activo', '=', '1')
            ->get();
        //$dias=round((strtotime($a->fecha)-strtotime(date('Y-m-d')))/86400);
        //dd($seguimiento);
        $fecha = date('d-m-Y');
        PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.showPrint', array('seguimiento' => $seguimiento, 'sts' => $sts, 'asignacionTareas' => $asignacionTareas, 'avisos' => $avisos, 'fecha' => $fecha))
            ->setPaper('letter', 'portrait');
        return $pdf->download('reporte.pdf');
        /* return view('seguimientos.show', compact('seguimiento', 'sts', 'asignacionTareas', 'avisos'))
    ->with( 'list', AsignacionTarea::getListFromAllRelationApps() );
     */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Seguimiento $seguimiento)
    {
        $seguimiento = $seguimiento->find($id);
        return view('seguimientos.edit', compact('seguimiento'))
            ->with('list', Seguimiento::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Seguimiento $seguimiento)
    {
        $seguimiento = $seguimiento->find($id);
        return view('seguimientos.duplicate', compact('seguimiento'))
            ->with('list', Seguimiento::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Seguimiento $seguimiento, updateSeguimiento $request)
    {
        $input = $request->all();
        if (isset($input['combinacion-field'])) {
            $combinacion = $input['combinacion-field'];
            unset($input['combinacion-field']);
            $c = \App\CombinacionCliente::find($combinacion);
            DB::table('combinacion_clientes')->where('cliente_id', '=', $c->cliente_id)
                ->update(['bnd_inscrito' => 0]);
            $c->bnd_inscrito = 1;
            $c->fecha_incrito = date('Y/m/d');
            $c->save();
        }

        //dd($input);
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $seguimiento = $seguimiento->find($id);

        $seguimiento->update($input);

        $stsf = DB::table('params')->where('llave', 'st_seguimiento_final')->first();
        if ($seguimiento->st_seguimiento_id == $stsf->valor) {
            $c = Cliente::find($seguimiento->cliente_id);
            //dd($c->toArray());
            $st = DB::table('params')->where('llave', 'st_cliente_final')->first();
            $c->st_cliente_id = $st->valor;
            $c->save();
        }
        return redirect()->route('seguimientos.show', $seguimiento->cliente_id)->with('message', 'Registro Actualizado.');
    }

    public function updateEstatus($id, Seguimiento $seguimiento, updateSeguimiento $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $seguimiento = $seguimiento->find($id);
        $seguimiento->update($input);

        return redirect()->route('seguimientos.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Seguimiento $seguimiento)
    {
        $seguimiento = $seguimiento->find($id);
        $seguimiento->delete();

        return redirect()->route('seguimientos.index')->with('message', 'Registro Borrado.');
    }

    public function reporteSeguimientosXEmpleado()
    {
        $estatus = $_REQUEST['estatus'];
        $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $mes = (int) date('m');
        $fecha = date('d-m-Y');

        $seguimientos = Seguimiento::select('c.nombre as Nombre', 'c.nombre2 as Segundo Nombre', 'c.ape_paterno as Apellido_Paterno', 'c.ape_materno as Apellido_Materno', 'c.calle as Calle', 'c.no_interior as No_Interior', 'c.no_exterior as No_Exterior', 'm.name as Municipio', 'e.name as Estado', 'c.tel_fijo as TelÃ©fono_Fijo', 'tel_cel as TelÃ©fono_Celular', 'mail as Correo_ElectrÃ³nico', 'sts.name as Estatus_Seguimiento', 'stc.name as Estatus_Cliente')
            ->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.estatus_id')
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('municipios as m', 'm.id', '=', 'c.municipio_id')
            ->join('estados as e', 'e.id', '=', 'c.estado_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            //->leftJoin('asignacion_tareas as at', 'at.cliente_id', '=','seguimientos.cliente_id')
            ->where('mes', '=', $mes)
            ->where('c.plantel_id', '=', $e->plantel_id)
            ->where('c.empleado_id', '=', $e->id)
            ->where('seguimientos.estatus_id', '=', $estatus)
            ->get()->toArray();
        //dd($seguimientos);
        /* PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.reportes.seguimientosXempleado', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'e'=>$e))
        ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        //return view('seguimientos.reportes.seguimientosXempleado', compact('seguimientos', 'fecha', 'e'));
        Excel::create('Laravel Excel', function ($excel) use ($seguimientos) {
            $excel->sheet('Productos', function ($sheet) use ($seguimientos) {
                $sheet->fromArray($seguimientos);
            });
        })->export('xls');
    }

    public function seguimientosXempleadoG()
    {
        return view('seguimientos.reportes.seguimientosXempleadoG')
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list1', Seguimiento::getListFromAllRelationApps());
    }

    public function seguimientosXempleadoGr(updateSeguimiento $request)
    {
        $input = $request->all();
        $fecha = date('d-m-Y');

        $seguimientos = Seguimiento::select('p.razon', DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as nombre'), 'sts.name', DB::raw('count(sts.name) as total'))
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.st_seguimiento_id')
            ->whereBetween('c.empleado_id', [$input['empleado_f'], $input['empleado_t']])
            ->whereBetween('c.plantel_id', [$input['plantel_f'], $input['plantel_t']])
            ->whereBetween('seguimientos.st_seguimiento_id', [$input['estatus_f'], $input['estatus_t']])
            ->whereBetween('seguimientos.created_at', [$input['fecha_f'], $input['fecha_t']])
            ->groupBy('p.razon', 'e.nombre', 'e.ape_paterno', 'e.ape_materno', 'sts.name')
            ->get();

        /*$seguimientos = DB::select('CALL seguimientosXempleadoGr(?, ?, ?, ?, ?, ?,?,?)',
        array($input['empleado_f'], $input['empleado_t'], $input['plantel_f'], $input['plantel_t'],
        $input['estatus_f'], $input['estatus_t'], $input['fecha_f'], $input['fecha_t']));
         */
        //dd($seguimientos);

        //dd($clientes);
        PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.reportes.seguimientosXempleadoGr', array('seguimientos' => $seguimientos, 'fecha' => $fecha))
            ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');

        //return view('seguimientos.reportes.seguimientosXempleadoGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha));
        /* Excel::create('Laravel Excel', function($excel) use($seguimientos) {
    $excel->sheet('Productos', function($sheet) use($seguimientos) {
    $sheet->fromArray($seguimientos);
    });
    })->export('xls');
     */
    }

    public function seguimientosXespecialidadG()
    {
        return view('seguimientos.reportes.seguimientosXespecialidadG')
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list1', Seguimiento::getListFromAllRelationApps());
    }

    public function seguimientosXespecialidadGr(updateSeguimiento $request)
    {
        $input = $request->all();
        $fecha = date('d-m-Y');

        /* $seguimientos=Seguimiento::select(DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as nombre'), DB::raw('count(seguimientos.st_seguimiento_id) as total'), 'esp.meta')
        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
        ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
        ->join('especialidads as esp', 'esp.id', '=', 'c.especialidad_id')
        ->where('c.plantel_id', '=', $input['plantel_f'])
        ->where('c.especialidad_id', '=', $input['especialidad_f'])
        ->where('seguimientos.st_seguimiento_id', '=', '2')
        ->whereBetween('seguimientos.created_at', [$input['fecha_f'], $input['fecha_t']])
        ->orderBy('nombre')
        ->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
        ->get();
        $encabezado = ['Empleado', 'Total', 'Meta'];
        $datos=array();
        array_push($datos,$encabezado);
        foreach($seguimientos as $s){
        array_push($datos,array($s->nombre, $s->total, $s->meta));
        } */

        $especialidades = DB::table('especialidads as e')->select('e.id', 'e.name as especialidad', 'e.meta')
            //->join('empleados as emp', 'emp.id', '=', 'c.empleado_id')
            ->where('e.plantel_id', '=', $input['plantel_f'])
            //->where('c.plantel_id', '=', 1)
            //->where('c.especialidad_id', '=', $input['especialidad_f'])
            //->where('seguimientos.st_seguimiento_id', '=', '2')
            ->orderby('e.plantel_id', 'asc')
            ->orderby('e.id', 'asc')
            //->orderby('empleado_id', 'asc')
            //->orderBy('name', 'asc')
            ->get();
        //dd($especialidades->toArray());
        $encabezado = array();
        array_push($encabezado, "Especialidad");
        array_push($encabezado, "Meta");
        $encabezado_agregado = 0;
        $datos = array();
        $j = 0;
        foreach ($especialidades as $e) {
            $linea = array();

            //dd($linea);
            $empleados = Db::table('empleados as e')->select('id', DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as nombre'))
                ->where('puesto_id', '=', '2')
                ->where('plantel_id', '=', $input['plantel_f'])
                ->get();

            //dd($encabezado_agregado);
            if ($encabezado_agregado == 0) {
                foreach ($empleados as $emp) {

                    //Log::info($emp->nombre."-Antes");

                    array_push($encabezado, $emp->nombre);
                    //Log::info($emp->nombre."-Despues");
                }
                //dd($encabezado);
                array_push($datos, $encabezado);
                $encabezado_agregado++;
            }
            //dd($datos);
            $total = 0;
            array_push($linea, $e->especialidad);
            array_push($linea, $e->meta);
            foreach ($empleados as $emp) {
                $total = DB::table('clientes as c')->select(
                    DB::raw('count(st.name) as total')
                )
                    ->join('seguimientos', 'seguimientos.cliente_id', '=', 'c.id')
                    ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                    //->where('c.plantel_id', '=', $input['plantel_f'])
                    //->where('c.plantel_id', '=', 1)
                    ->where('cc.especialidad_id', '=', $e->id)
                    ->where('c.empleado_id', '=', $emp->id)
                    //->where('seguimientos.st_seguimiento_id', '=', '2')
                    ->orderby('c.plantel_id', 'asc')
                    //->orderby('especialidad_id', 'asc')
                    ->orderby('empleado_id', 'asc')
                    //->orderBy('name', 'asc')
                    ->groupBy('seguimientos.cliente_id')
                    ->value('total');
                array_push($linea, $total);
            }
            //dd($linea);
            array_push($datos, $linea);
            /* $j++;
        if($j==30){break;} */
        }
        //dd($datos);
        //dd($clientes);
        /* PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.reportes.seguimientosXespecialidadGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'datos'=>json_encode($datos)))
        ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.seguimientosXespecialidadGr', array('fecha' => $fecha, 'registros' => $datos))
            ->with('datos', json_encode($datos));

        /* Excel::create('Laravel Excel', function($excel) use($seguimientos) {
    $excel->sheet('Productos', function($sheet) use($seguimientos) {
    $sheet->fromArray($seguimientos);
    });
    })->export('xls');
     */
    }

    public function seguimientos()
    {
        return view('seguimientos.reportes.seguimientos')
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list1', Seguimiento::getListFromAllRelationApps());
    }

    public function seguimientosr(updateSeguimiento $request)
    {
        $input = $request->all();
        $fecha = date('d-m-Y');
        if (!$request->has('plantel_f') and !$request->has('plantel_t')) {
            $input['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            $input['plantel_t'] = $input['plantel_f'];
        }

        $seguimientos = Seguimiento::select('cve_plantel as Plantel', 'esp.name as Especialidad', 'n.name as Nivel', 'g.name as Grado', 'seguimientos.mes as Mes', DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as Empleado'), 'st.name as Estatus', 'st.id as st_contar', 'esp.meta as Meta')
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
            ->where('c.plantel_id', '>=', $input['plantel_f'])
            ->where('c.plantel_id', '<=', $input['plantel_t'])
            //->where('c.especialidad_id', '=', $input['especialidad_f'])
            //->where('seguimientos.st_seguimiento_id', '=', '2')
            ->whereBetween('seguimientos.created_at', [$input['fecha_f'], $input['fecha_t']])
            ->orderBy('Plantel')
            //->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
            ->get();

        //dd($seguimientos->toArray());
        /* PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.reportes.seguimientosXespecialidadGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'datos'=>json_encode($datos)))
        ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.seguimientosr', array('fecha' => $fecha))
            ->with('datos', json_encode($seguimientos));

        /* Excel::create('Laravel Excel', function($excel) use($seguimientos) {
    $excel->sheet('Productos', function($sheet) use($seguimientos) {
    $sheet->fromArray($seguimientos);
    });
    })->export('xls');
     */
    }

    public function seguimientosGrf()
    {
        return view('seguimientos.reportes.seguimientosGrf')
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list1', Seguimiento::getListFromAllRelationApps());
    }

    public function seguimientosGrfr(updateSeguimiento $request)
    {
        $input = $request->all();
        //dd($input);
        $fecha = date('d-m-Y');
        if (!$request->has('plantel_f') and !$request->has('plantel_t')) {
            $input['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            $input['plantel_t'] = $input['plantel_f'];
        }

        $seguimientos = Seguimiento::select(
            'c.id',
            DB::raw('concat(c.nombre," ", c.ape_paterno," ", c.ape_materno) as cliente'),
            'cve_plantel as Plantel',
            'esp.name as Especialidad',
            'n.name as Nivel',
            'g.name as Grado',
            'seguimientos.mes as Mes',
            'm.name as medio',
            'lec.name as lectivo',
            DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as Empleado'),
            'h.detalle as Estatus',
            'esp.meta as Meta',
            'u.name as Usuario'
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            //->join('inscripcions as i','i.cliente_id','=','c.id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
            ->join('lectivos as lec', 'lec.id', '=', 'esp.lectivo_id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            //->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
            ->join('medios as m', 'm.id', '=', 'c.medio_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->join('users as u', 'u.id', '=', 'h.usu_alta_id')
            ->where('h.asunto', '=', 'Cambio estatus ')
            //->orWhere('h.asunto','=','Creacion')
            /*->orWhere(function($q){
        $q->orWhere('h.asunto','=','Cambio estatus ');
        $q->orWhere('h.asunto','=','Concretado');
        })*/
            ->where('h.detalle', 'Concretado')
            ->whereNull('cc.deleted_at')
            ->whereNull('h.deleted_at')
            ->where('c.plantel_id', '>=', $input['plantel_f'])
            ->where('c.plantel_id', '<=', $input['plantel_t'])
            ->where('h.fecha', '>=', $input['fecha_f'])
            ->where('h.fecha', '<=', $input['fecha_t'])
            ->orderBy('Plantel')
            ->get();

        /*
        $seguimientos = Seguimiento::select('cve_plantel as Plantel', 'esp.name as Especialidad', 'n.name as Nivel', 'g.name as Grado', 'seguimientos.mes as Mes', 'm.name as medio', DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as Empleado'), 'st.name as Estatus', 'st.id as st_contar', 'esp.meta as Meta', 'u.name as Usuario')
        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
        ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
        ->join('users as u', 'u.id', '=', 'e.user_id')
        ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
        ->join('especialidads as esp', 'esp.id', '=', 'c.especialidad_id')
        ->join('nivels as n', 'n.id', '=', 'c.nivel_id')
        ->join('grados as g', 'g.id', '=', 'c.grado_id')
        ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
        ->join('medios as m', 'm.id', '=', 'c.medio_id')
        ->where('c.plantel_id', '>=', $input['plantel_f'])
        ->where('c.plantel_id', '<=', $input['plantel_t'])
        //->where('c.especialidad_id', '=', $input['especialidad_f'])
        //->where('seguimientos.st_seguimiento_id', '=', '2')
        ->whereBetween('seguimientos.created_at', [$input['fecha_f'], $input['fecha_t']])
        ->orderBy('Plantel')
        //->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
        ->get();
         *
         */
        //dd($seguimientos->toArray());
        //dd($seguimientos->toArray());
        /* PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.reportes.seguimientosXespecialidadGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'datos'=>json_encode($datos)))
        ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.seguimientosGrfr', array('fecha' => $fecha))
            ->with('datos', json_encode($seguimientos));

        /* Excel::create('Laravel Excel', function($excel) use($seguimientos) {
    $excel->sheet('Productos', function($sheet) use($seguimientos) {
    $sheet->fromArray($seguimientos);
    });
    })->export('xls');
     */
    }

    public function analitica_actividades()
    {
        return view('seguimientos.reportes.analitica_actividades')
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function analitica_actividadesr(Request $request)
    {
        $input = $request->all();

        $fecha_inicio = date('Y-m-j', strtotime('-8 day', strtotime(date('Y-m-j'))));
        //dd($fecha_inicio);
        $ds_actividades = DB::table('hactividades as has')
            ->select(
                'p.razon as plantel',
                DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado'),
                "c.id as cli",
                DB::raw('concat(c.nombre," ",c.ape_paterno," ",c.ape_materno) as cliente'),
                'has.tarea',
                'has.fecha',
                'has.detalle'
            )
            ->join('clientes as c', 'c.id', '=', 'has.cliente_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('plantels as p', 'p.id', '=', 'e.plantel_id')
            ->where('has.asunto', '=', 'Cambio estatus ')
            ->where('has.fecha', '>=', $input['fecha_f'])
            ->where('has.fecha', '<=', $input['fecha_t'])
            ->where('c.plantel_id', '>=', $input['plantel_f'])
            ->where('c.plantel_id', '<=', $input['plantel_t'])
            ->get();
        //dd($ds_actividades->toArray());
        return view('seguimientos.reportes.analitica_actividadesr')
            ->with('actividades', json_encode($ds_actividades));
    }

    public function analitica_actividadesf()
    {
        $fecha_inicio = date('Y-m-j', strtotime('-15 day', strtotime(date('Y-m-j'))));
        $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $plantel = $e->plantel_id;
        $planteles = array();
        foreach ($e->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }
        //dd($fecha_inicio);
        if (Auth::user()->can('WgaugesXplantelIndividual')) {
            $ds_actividades = DB::table('hactividades as has')
                ->select(
                    'p.razon as plantel',
                    DB::raw('concat(e.nombre,e.ape_paterno,e.ape_materno) as empleado'),
                    DB::raw('concat(c.nombre,c.ape_paterno,c.ape_materno) as cliente'),
                    'has.tarea',
                    'has.fecha',
                    'has.asunto',
                    'has.detalle',
                    'stc.name as estatus_cliente'
                )
                ->join('clientes as c', 'c.id', '=', 'has.cliente_id')
                ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                ->join('plantels as p', 'p.id', '=', 'e.plantel_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->where('has.fecha', '>', $fecha_inicio)
                ->whereIn('p.id', '=', $planteles)
                ->get();
        } else {
            $ds_actividades = DB::table('hactividades as has')
                ->select(
                    'p.razon as plantel',
                    DB::raw('concat(e.nombre,e.ape_paterno,e.ape_materno) as empleado'),
                    DB::raw('concat(c.nombre,c.ape_paterno,c.ape_materno) as cliente'),
                    'has.tarea',
                    'has.fecha',
                    'has.asunto',
                    'has.detalle',
                    'stc.name as estatus_cliente'
                )
                ->join('clientes as c', 'c.id', '=', 'has.cliente_id')
                ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                ->join('plantels as p', 'p.id', '=', 'e.plantel_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->where('has.fecha', '>', $fecha_inicio)
                ->get();
        }

        return view('seguimientos.reportes.analitica_actividadesr')
            ->with('actividades', json_encode($ds_actividades));
    }

    public function analiticaGraficaEmpleado(Request $request)
    {
        $parametros = $request->all();
        //dd($parametros);
        $fecha = date('Y-m-d');
        //dd($fecha_inicio);
        $lectivo = array();

        $lectivo = DB::table('lectivos')
            ->where('inicio', '<=', $fecha)
            ->where('fin', '>=', $fecha)
            ->where('id', '>', 0)
            ->where('carrera_bnd', '=', 1)
            ->first();

        $ds_actividades = DB::table('hactividades as has')
            ->select('p.razon as plantel', 'esp.name as especialidad', DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado'), DB::raw('concat(c.nombre," ",c.ape_paterno," ",c.ape_materno) as cliente'), 'has.tarea', 'has.fecha', 'has.asunto', 'has.detalle', 'stc.name as estatus_cliente')
            ->join('clientes as c', 'c.id', '=', 'has.cliente_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('plantels as p', 'p.id', '=', 'e.plantel_id')
            ->join('especialidads as esp', 'esp.plantel_id', '=', 'p.id')
            ->join('lectivos as l', 'l.id', '=', 'esp.lectivo_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->whereColumn('has.fecha', '>=', 'l.inicio')
            ->whereColumn('has.fecha', '<=', 'l.fin')
            ->where('p.id', '=', $parametros['plantel'])
            ->where('e.id', '=', $parametros['empleado'])
            ->where('esp.id', '=', $parametros['especialidad'])
            ->get();
        //dd($ds_actividades->toArray());
        return view('seguimientos.reportes.analitica_actividadesr')
            ->with('actividades', json_encode($ds_actividades));
    }

    public function seguimientosGraficaGrfr(updateSeguimiento $request)
    {
        $parametros = $request->all();
        //dd($parametros);
        $fecha = date('Y-m-d');
        //dd($fecha_inicio);
        $lectivo = array();

        $lectivo = DB::table('lectivos')
            ->where('inicio', '<=', $fecha)
            ->where('fin', '>=', $fecha)
            ->where('id', '>', 0)
            ->where('carrera_bnd', '=', 1)
            ->first();

        //dd($input);
        $fecha = date('d-m-Y');

        $seguimientos = Seguimiento::select(
            'cve_plantel as Plantel',
            'esp.name as Especialidad',
            'n.name as Nivel',
            'g.name as Grado',
            'seguimientos.mes as Mes',
            'm.name as medio',
            DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as Empleado'),
            DB::raw('concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ", c.ape_materno) as cliente'),
            'st.name as Estatus',
            'st.id as st_contar',
            'esp.meta as Meta',
            'u.name as Usuario'
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('users as u', 'u.id', '=', 'e.user_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
            ->join('lectivos as l', 'l.id', '=', 'esp.lectivo_id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
            ->join('medios as m', 'm.id', '=', 'c.medio_id')
            ->where('c.plantel_id', '=', $parametros['plantel'])
            ->where('e.id', '=', $parametros['empleado'])
            ->where('esp.id', '=', $parametros['especialidad'])
            //->where('c.especialidad_id', '=', $input['especialidad_f'])
            //->where('seguimientos.st_seguimiento_id', '=', '2')
            ->whereColumn('seguimientos.created_at', '>=', 'l.inicio')
            ->whereColumn('seguimientos.created_at', '<=', 'l.fin')
            ->orderBy('Plantel')
            //->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
            ->get();
        //dd($seguimientos->toArray());
        //dd($seguimientos->toArray());
        /* PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('seguimientos.reportes.seguimientosXespecialidadGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'datos'=>json_encode($datos)))
        ->setPaper('letter', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.seguimientosGrfr', array('fecha' => $fecha))
            ->with('datos', json_encode($seguimientos));

        /* Excel::create('Laravel Excel', function($excel) use($seguimientos) {
    $excel->sheet('Productos', function($sheet) use($seguimientos) {
    $sheet->fromArray($seguimientos);
    });
    })->export('xls');
     */
    }

    public function dEstatusPlantelEspecialidad()
    {
        return view('seguimientos.reportes.dEstatusPlantelEspecialidad')
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function dEstatusPlantelEspecialidadR(Request $request)
    {
        $parametros = $request->all();
        //dd($parametros);
        $especialidades = Especialidad::where('plantel_id', '=', $parametros['plantel_f'])->where('id', '>', 0)->get();
        $estatus = StSeguimiento::where('id', '>', 0)->get();
        $encabezado = array();
        $tabla = array();
        $i = 1;
        $encabezado[0] = "Especialidad";
        foreach ($estatus as $st) {
            $encabezado[$i] = $st->name;
            $i++;
            //array_push($encabezado, $st->name);
        }
        array_push($tabla, $encabezado);
        foreach ($especialidades as $e) {
            $linea = array();
            $i = 0;
            $linea[$i] = $e->name;
            //array_push($linea,$e->name);
            foreach ($estatus as $st) {
                $i++;
                $resultado = Cliente::join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
                    ->where('cc.especialidad_id', '=', $e->id)
                    ->where('s.st_seguimiento_id', '=', $st->id)
                    ->whereNull('cc.deleted_at')
                    ->count();
                $linea[$i] = $resultado;
                //array_push($linea, $resultado);
            }
            array_push($tabla, $linea);
        }
        $p = Plantel::find($parametros['plantel_f']);
        $plantel = $p->razon;
        //dd($tabla);
        //        foreach($tabla as $ln){
        //            echo $ln[1];
        //        }
        //        dd('fil');
        return view('seguimientos.reportes.dEstatusPlantelEspecialidadR', compact('tabla', 'plantel'))
            ->with('datos_grafica', json_encode($tabla));
    }

    public function concretadosEspecialidadPlantel()
    {
        $lectivos = Lectivo::pluck('name', 'id');
        return view('seguimientos.reportes.concretadosEspecialidadPlantel', compact('lectivos'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function concretadosEspecialidadPlantelR(Request $request)
    {
        $parametros = $request->all();
        //dd($parametros);
        $especialidades = Especialidad::where('plantel_id', '=', $parametros['plantel_f'])->where('id', '>', 0)->get();
        $lectivos = Lectivo::whereIn('id', $parametros['to'])->get();
        //dd($lectivos->toArray());
        $encabezado = array();
        $encabezado[0] = 'Especialidades';
        $i = 0;
        $columnas = 0;
        foreach ($lectivos as $l) {
            $i++;
            $encabezado[$i] = $l->name;
            $columnas = $i;
        }
        $tabla = array();
        array_push($tabla, $encabezado);
        foreach ($especialidades as $e) {
            $i = 0;
            $linea = array();
            $linea[$i] = $e->name;
            foreach ($lectivos as $l) {
                $i++;
                $resultado = Cliente::join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
                    ->where('cc.especialidad_id', '=', $e->id)
                    ->where('s.st_seguimiento_id', '=', 2)
                    ->where('cc.fecha_incrito', '>=', $l->inicio)
                    ->where('cc.fecha_incrito', '<=', $l->fin)
                    ->count();
                $linea[$i] = $resultado;
            }
            array_push($tabla, $linea);
        }
        $p = Plantel::find($parametros['plantel_f']);
        $plantel = $p->razon;
        //dd($tabla);
        return view('seguimientos.reportes.concretadosEspecialidadPlantelR', compact('tabla', 'plantel', 'columnas'))
            ->with('datos_grafica', json_encode($tabla));
    }

    public function InscritosUnPago()
    {

        return view('seguimientos.reportes.inscritosUnPago')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosUnPagoR(Request $request)
    {
        $data = $request->all();
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        $registros = CombinacionCliente::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
            . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, caj.id as caja, p.fecha, m.name as medio, '
            . 'c.beca_bnd, esp.name as especialidad'))
            ->join('clientes as c', 'c.id', '=', 'combinacion_clientes.cliente_id')
            ->join('medios as m', 'm.id', '=', 'c.medio_id')
            ->join('especialidads as esp', 'esp.id', '=', 'combinacion_clientes.especialidad_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('cajas as caj', 'caj.cliente_id', '=', 'c.id')
            ->join('caja_lns as clns', 'clns.caja_id', '=', 'caj.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'clns.caja_concepto_id')
            ->join('pagos as p', 'p.caja_id', '=', 'caj.id')
            ->where('combinacion_clientes.plantel_id', '>=', $data['plantel_f'])
            ->where('combinacion_clientes.plantel_id', '<=', $data['plantel_t'])
            ->where('p.fecha', '>=', $data['fecha_f'])
            ->where('p.fecha', '<=', $data['fecha_t'])
            ->where('combinacion_clientes.especialidad_id', '<>', 0)
            ->where('combinacion_clientes.nivel_id', '<>', 0)
            ->where('combinacion_clientes.grado_id', '<>', 0)
            ->where('combinacion_clientes.turno_id', '<>', 0)
            ->whereNull('combinacion_clientes.deleted_at', '<>', 0)
            ->where('combinacion_clientes.plan_pago_id', '>', 0)
            ->whereNull('p.deleted_at')
            ->whereNull('clns.deleted_at')
            ->whereIn('caj.st_caja_id', [1, 3])
            ->where(function ($query) {
                $query->orWhere('cc.name', 'LIKE', 'INSCRIP%');
            })
            ->orderBy('colaborador')
            ->distinct()
            ->get();
        //dd($registros->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.inscritosUnPagoR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'data' => $data,
        ));
    }

    public function InscritosPagos()
    {

        return view('seguimientos.reportes.inscritosPagos')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosPagosR(Request $request)
    {
        $data = $request->all();
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        $registros_pagados = Caja::select(
            'pla.razon',
            'c.id',
            DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
                . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, cajas.id as caja, cajas.consecutivo,'
                . 'c.beca_bnd, st.name as estatus_caja, conce.name as concepto, ln.total as monto_linea, a.monto as monto_adeudo,'
                . 'pag.monto as monto_pago, ln.total as monto_caja, fp.name as forma_pago, pag.fecha as fecha_pago, cajas.fecha as fecha_caja')
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('plantels as pla', 'pla.id', '=', 'c.plantel_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as conce', 'conce.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->join('adeudos as a', 'a.id', '=', 'ln.adeudo_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pag.forma_pago_id')
            ->where('cajas.plantel_id', '>=', $data['plantel_f'])
            ->where('cajas.plantel_id', '<=', $data['plantel_t'])
            ->where('cajas.fecha', '>=', $data['fecha_f'])
            ->where('cajas.fecha', '<=', $data['fecha_t'])
            ->whereNull('ln.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('pag.deleted_at')
            ->where('cajas.st_caja_id', '=', 1)
            ->orderBy('colaborador', 'asc')
            ->orderBy('cajas.st_caja_id', 'asc')
            ->distinct()
            ->get();

        $registros_pagados1 = Caja::select(
            'pla.razon',
            'c.id',
            DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
                . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, cajas.id as caja, cajas.consecutivo,'
                . 'c.beca_bnd, st.name as estatus_caja,'
                . 'pag.monto as monto_pago, fp.name as forma_pago, pag.fecha as fecha_pago, cajas.fecha as fecha_caja')
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('plantels as pla', 'pla.id', '=', 'c.plantel_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            //->join('caja_lns as ln','ln.caja_id','=','caj.id')
            //->join('caja_conceptos as conce','conce.id','=','ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            //->join('adeudos as a','a.id','=','ln.adeudo_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pag.forma_pago_id')
            ->where('cajas.plantel_id', '=', $data['plantel_f'])
            ->where('cajas.fecha', '=', $data['fecha_f'])
            ->whereNull('pag.deleted_at')
            ->where('cajas.st_caja_id', '=', 1)
            ->orderBy('colaborador', 'asc')
            ->orderBy('cajas.st_caja_id', 'asc')
            ->distinct()
            ->get();

        //dd($registros_pagados->toArray());

        $registros_parciales = Caja::select(
            'pla.razon',
            'c.id',
            DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
                . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, cajas.id as caja, cajas.consecutivo,'
                . 'c.beca_bnd, st.name as estatus_caja, conce.name as concepto, ln.total as monto_linea, a.monto as monto_adeudo,'
                . 'pag.monto as monto_pago, ln.total as monto_caja, fp.name as forma_pago, pag.fecha as fecha_pago, cajas.fecha as fecha_caja')
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('plantels as pla', 'pla.id', '=', 'c.plantel_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as conce', 'conce.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->join('adeudos as a', 'a.id', '=', 'ln.adeudo_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pag.forma_pago_id')
            ->where('cajas.plantel_id', '=', $data['plantel_f'])
            ->where('cajas.fecha', '=', $data['fecha_f'])
            ->whereNull('ln.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('pag.deleted_at')
            ->where('cajas.st_caja_id', '=', 3)
            ->orderBy('colaborador', 'asc')
            ->orderBy('cajas.st_caja_id', 'asc')
            ->distinct()
            ->get();

        //dd($registros_parciales->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.inscritosPagosR', array(
            'registros_pagados' => $registros_pagados,
            'registros_parciales' => $registros_parciales,
            'registros_pagados1' => 'registros_pagados1',
            'plantel' => $plantel,
            'data' => $data,
        ));
    }

    public function InscritosAdeudos()
    {
        return view('seguimientos.reportes.inscritosAdeudos')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosAdeudosR(Request $request)
    {
        $data = $request->all();
        //dd($data);
        if (!$request->has('plantel_f')) {
            $data['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            $data['plantel_t'] = $data['plantel_f'];
        }

        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);

        $hoy = date('Y-m-d');
        //dd($hoy);

        $adeudos_tomados = Adeudo::select(
            'stc.id',
            'adeudos.id as adeudo',
            'adeudos.*',
            'cc.*',
            'g.id as grupo_id',
            'g.name as grupo',
            'stc.name as st_cliente',
            'sts.name as st_seguimiento',
            'e.name as especialidad'
        )
            ->join('combinacion_clientes as cc', 'cc.id', '=', 'adeudos.combinacion_cliente_id')
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
            ->where('fecha_pago', '>=', $data['fecha_f'])
            ->where('fecha_pago', '<=', $data['fecha_t'])
            ->where('c.plantel_id', '>=', $data['plantel_f'])
            ->where('c.plantel_id', '<=', $data['plantel_t'])
            ->where('i.grupo_id', '>', 0)
            ->whereIn('stc.id', array(4, 20, 25))
            ->whereIn('sts.id', array(2, 7))
            ->whereIn('i.lectivo_id', $data['lectivo_f'])
            ->whereNull('cc.deleted_at')
            ->whereNull('s.deleted_at')
            ->whereNull('i.deleted_at')
            ->whereNull('g.deleted_at')
            ->whereNull('adeudos.deleted_at')
            ->distinct()
            ->orderBy('stc.id', 'desc')
            ->orderBy('e.name')
            ->orderBy('g.id')
            ->get();

        /*
        $adeudos_tomados = Adeudo::select(
        'stc.id',
        'adeudos.id as adeudo',
        'adeudos.*',
        'cc.*',
        'g.id as grupo_id',
        'g.name as grupo',
        'stc.name as st_cliente',
        'sts.name as st_seguimiento',
        'e.name as especialidad'
        )
        ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
        ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
        ->join('hacademicas as h', 'h.cliente_id', '=', 'c.id')
        ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
        ->join('combinacion_clientes as cc', 'cc.id', '=', 'i.combinacion_cliente_id')
        ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
        ->join('grupos as g', 'g.id', '=', 'h.grupo_id')
        ->where('adeudos.fecha_pago', '>=', $data['fecha_f'])
        ->where('adeudos.fecha_pago', '<=', $data['fecha_t'])
        ->where('c.plantel_id', '>=', $data['plantel_f'])
        ->where('c.plantel_id', '<=', $data['plantel_t'])
        ->where('i.grupo_id', '>', 0)
        ->whereIn('stc.id', array(4, 25))
        ->where('sts.id', 2)
        ->whereIn('h.lectivo_id', $data['lectivo_f'])
        ->whereNull('h.deleted_at')
        ->whereNull('cc.deleted_at')
        ->whereNull('s.deleted_at')
        ->whereNull('i.deleted_at')
        ->whereNull('g.deleted_at')
        ->whereNull('adeudos.deleted_at')
        ->distinct()
        ->orderBy('stc.id', 'desc')
        ->orderBy('e.name')
        ->orderBy('g.id')
        ->get();
         */

        $registros = array();
        foreach ($adeudos_tomados as $adeudo_tomado) {
            //$adeudos=Adeudo::where('id', '=', $adeudo_tomado)->get();
            //dd($adeudo_tomado);
            $cliente = Cliente::find($adeudo_tomado->cliente_id);
            $caja_ln['fecha_real_pago'] = "";
            //dd($adeudos->toArray());
            $subtotal = 0;
            $recargo = 0;
            $descuento = 0;
            //dd($adeudos->toArray());

            //foreach($adeudos as $adeudo){
            $existe_linea = CajaLn::where('adeudo_id', '=', $adeudo_tomado->adeudo)->whereNull('caja_lns.deleted_at')->first();
            //dd($existe_linea);

            if (!is_object($existe_linea)) {

                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['tel_fijo'] = $cliente->tel_fijo;
                $caja_ln['tel_cel'] = $cliente->tel_cel;
                $caja_ln['cliente_id'] = $cliente->id;
                $caja_ln['estatus_caja'] = "";
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                $caja_ln['subtotal'] = $adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->bnd_pagado;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                $caja_ln['fecha_real_pago'] = "";
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['total'] = 0;
                $caja_ln['recargo'] = 0;
                $caja_ln['descuento'] = 0;
                foreach ($adeudo_tomado->planPagoLn->reglaRecargos as $regla) {

                    $dias = date_diff(date_create($hoy), date_create($adeudo_tomado->fecha_pago));
                    //dd($dias);
                    $dia = $dias->format('%R%a') * -1;

                    //calcula recargo o descuento segun regla y aplica
                    if ($dia >= $regla->dia_inicio and $dia <= $regla->dia_fin) {
                        if ($regla->tipo_regla_id == 1) {
                            //dd($regla->porcentaje);
                            if ($regla->porcentaje > 0) {
                                //dd($regla->porcentaje);
                                $caja_ln['recargo'] = $adeudo_tomado->monto * $regla->porcentaje;
                                //echo $caja_ln['recargo'];
                            } else {
                                $caja_ln['descuento'] = $adeudo_tomado->monto * $regla->porcentaje * -1;
                                //echo $caja_ln['descuento'];
                            }
                        } elseif ($regla->tipo_regla_id == 2) {
                            if ($regla->monto > 0) {
                                $caja_ln['recargo'] = $regla->monto;
                            } else {
                                $caja_ln['descuento'] = $regla->monto * -1;
                            }
                        }
                    }
                }
                $caja_ln['total'] = 0;
                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                //calcula descuento segun promocion ligada a la linea del plan considerando la fecha de pago de la
                //inscripcion del cliente
                //dd($adeudo);
                try {
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo_tomado->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    if ($cliente->beca_bnd != 1) {
                        foreach ($promociones as $promocion) {
                            $inscripcion = Adeudo::where('cliente_id', $adeudo_tomado->cliente_id)
                                //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                ->where('caja_concepto_id', 1)
                                ->where('combinacion_cliente_id', $adeudo_tomado->combinacion_cliente_id)
                                ->where('pagado_bnd', 1)
                                ->first();
                            //dd($inscripcion);
                            if (is_object($inscripcion)) {
                                $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                //$hoy=date('Y-m-d');
                                //$hoy=Carbon::now();
                                //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                $caja_inscripcion = Caja::find($inscripcion->caja_id);
                                //dd($caja);
                                $hoy = Carbon::createFromFormat('Y-m-d', $caja_inscripcion->fecha);
                                //$hoy=Carbon::createFromFormat('Y-m-d', $adeudo->caja->fecha);
                                //dd($hoy);
                                $monto_promocion = 0;
                                //dd($hoy);
                                if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                    $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                    $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                    $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                }
                            } else {
                                $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                //$hoy=date('Y-m-d');
                                //$hoy=Carbon::now();
                                //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                //$caja_inscripcion=Caja::find($inscripcion->caja_id);
                                $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                $monto_promocion = 0;
                                //dd($hoy);
                                if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                    $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                    $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                    $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    dd($e);
                }
                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                $caja_ln['adeudo_id'] = $adeudo_tomado->id;
                $caja_ln['usu_alta_id'] = Auth::user()->id;
                $caja_ln['usu_mod_id'] = Auth::user()->id;

                //    }
                array_push($registros, $caja_ln);
            } elseif (is_object($existe_linea) and $existe_linea->caja->st_caja_id == 3) {
                if ($adeudo_tomado->adeudo == 107301) {
                    dd($existe_linea->caja->st_caja_id);
                }
                //dd($adeudo_tomado->toArray());
                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['tel_fijo'] = $cliente->tel_fijo;
                $caja_ln['tel_cel'] = $cliente->tel_cel;
                $caja_ln['cliente_id'] = $cliente->id;
                $caja_ln['estatus_caja'] = $existe_linea->caja->stCaja->name;
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                //$caja_ln['subtotal']=$adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->pagado_bnd;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['subtotal'] = $existe_linea->subtotal;
                $caja_ln['total'] = $existe_linea->total;
                $caja_ln['recargo'] = $existe_linea->recargo;
                $caja_ln['descuento'] = $existe_linea->descuento;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                foreach ($existe_linea->caja->pagos as $pago) {
                    if (is_null($pago->deleted_at)) {
                        $caja_ln['fecha_real_pago'] = $caja_ln['fecha_real_pago'] . " " . $pago->fecha;
                    }
                }

                array_push($registros, $caja_ln);
            } else {
                //dd($adeudo_tomado->toArray());
                $caja_ln['razon'] = $adeudo_tomado->razon;
                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['tel_fijo'] = $cliente->tel_fijo;
                $caja_ln['tel_cel'] = $cliente->tel_cel;
                $caja_ln['cliente_id'] = $cliente->id;
                $caja_ln['estatus_caja'] = $existe_linea->caja->stCaja->name;
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                //$caja_ln['subtotal']=$adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->pagado_bnd;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['subtotal'] = $existe_linea->subtotal;
                $caja_ln['total'] = $existe_linea->total;
                $caja_ln['recargo'] = $existe_linea->recargo;
                $caja_ln['descuento'] = $existe_linea->descuento;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                foreach ($existe_linea->caja->pagos as $pago) {
                    if (is_null($pago->deleted_at)) {
                        $caja_ln['fecha_real_pago'] = $caja_ln['fecha_real_pago'] . " " . $pago->fecha;
                    }
                }
                array_push($registros, $caja_ln);
            }
        }

        $fecha = date('d-m-Y');
        //dd($registros);
        //dd($registros);

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('seguimientos.reportes.inscritosAdeudosR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'fecha' => $fecha,
            'data' => $data,
        ));
    }
}
