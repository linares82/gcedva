<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;

use App\Caja;
use App\Param;
use Exception;
use App\Adeudo;
use App\Cliente;
use App\Plantel;
use App\Empleado;
use App\StCliente;
use Carbon\Carbon;
use App\PromoPlanLn;
use App\Seguimiento;
use App\CajaConcepto;
use App\Http\Requests;
use App\CicloMatricula;
use App\AsignacionTarea;
use App\HistoriaCliente;
use App\AutorizacionBeca;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PlantelAgrupamiento;

class ReportesCedvaController extends Controller
{
    public function reportesCedva()
    {
        $reportes = array(1 => 'Activos', 2 => 'Adeudos', 3 => 'Pagados', 4 => 'Inscritos Por Ciclo', 5 => 'Pagos con Baja', 6 => "Activos X Mes", 7 => "Activos X Plantel");
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $agrupamientoPlantels = PlantelAgrupamiento::pluck('name', 'id');
        $agrupamientoPlantels->prepend('Seleccionar Opcion', 0);
        $planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first()->plantels->pluck('razon', 'id');

        $estatus = array('0' => 'Todos', '1' => 'Vigente', '2' => "Baja");
        $pagos = array('0' => 'Todos', '1' => 'Pagado', '2' => 'Pendiente');
        $caja_conceptos = CajaConcepto::pluck('name', 'id');
        $caja_conceptos->prepend('Todos');
        $ciclos = CicloMatricula::pluck('name', 'id');


        //dd($caja_conceptos);
        return view('reportesCedva.varios', compact('reportes', 'planteles', 'estatus', 'pagos', 'caja_conceptos', 'ciclos', 'agrupamientoPlantels'));
    }

    public function reportesCedvaR(Request $request)
    {
        //ini_set('memory_limit', '-1');
        $datos = $request->all();
        //dd($datos);
        $estatus = array();
        if ($datos['estatus_f'] == 0) {
            $estatus = StCliente::whereNotIn('id', array(19))->pluck('id');
        } elseif ($datos['estatus_f'] == 1) {
            $estatus = array(4, 5, 17, 20, 22, 25, 26, 30, 31);
        } elseif ($datos['estatus_f'] == 2) {
            $estatus = array(3, 27, 28);
        }
        if ($datos['pagos_f'] == 0) {
            $pagos = array(0, 1);
        } elseif ($datos['pagos_f'] == 1) {
            $pagos = array(1);
        } elseif ($datos['pagos_f'] == 2) {
            $pagos = array(0);
        }

        if (in_array(0, $datos['concepto_caja_f'])) {
            $concepto_caja = CajaConcepto::pluck('id');
        } else {
            $concepto_caja = $datos['concepto_caja_f'];
        }
        //dd($pagos);
        $resultado2 = array();
        //dd($estatus);
        switch ($datos['reportes_f']) {
            //Filtros que operan
            case 1:
                //planeados Pendiente de pago
                if ($pagos == array(0)) {
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'caj.descuento',
                        'caj.recargo',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.id as adeudo_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'ad.bnd_eximir_descuento_beca',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->get();

                    foreach ($registros->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    //dd($resultado2);
                    //planeados y pagados
                } elseif ($pagos == array(1)) {

                    //planeado y pagado, pero sin caja tienen monto 0

                    $pagos0_sin_caja = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        //'caj.id as caja_id',
                        //'caj.consecutivo',
                        //'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as caja_id'),
                        DB::raw('0 as consecutivo'),
                        DB::raw('0 as fecha_caja'),
                        'caj.descuento',
                        'caj.recargo',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.id as adeudo_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'ad.bnd_eximir_descuento_beca',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->where('ad.monto', 0)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    //dd($pagos0_sin_caja->toArray());
                    foreach ($pagos0_sin_caja->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as adeudo_id'),
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', $pagos) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }

                    //planeados y pagados con caja
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'caj.descuento',
                        'caj.recargo',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.id as adeudo_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'ad.bnd_eximir_descuento_beca',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //pagados y pendientes en una union
                } else {

                    //registros planeados y pagados
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.id as adeudo_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'ad.bnd_eximir_descuento_beca',
                        'cm.name as ciclo',
                        'caj.descuento',
                        'caj.recargo',
                        'pag.monto as total_caja',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        //->union($registros_pendientes)
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'caj.descuento',
                        'caj.recargo',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as adeudo_id'),
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', array(1)) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    //registro sin caja, adeudo pagado y monto 0

                    $pagos0_sin_caja = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        //'caj.id as caja_id',
                        //'caj.consecutivo',
                        //'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as caja_id'),
                        DB::raw('0 as consecutivo'),
                        DB::raw('0 as fecha_caja'),
                        'caj.descuento',
                        'caj.recargo',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.id as adeudo_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'ad.bnd_eximir_descuento_beca',
                        'cm.name as ciclo',
                        'tur.name as turno'

                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->where('ad.monto', 0)
                        ->where('ad.caja_id', 0)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos0_sin_caja->toArray());
                    foreach ($pagos0_sin_caja->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    $registros_pendientes = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.genero',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'fec_nacimiento',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'cc.bnd_mensualidad',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'caj.descuento',
                        'caj.recargo',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.id as adeudo_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'ad.bnd_eximir_descuento_beca',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(0))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('g.seccion')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($registros_pendientes->toArray());
                    foreach ($registros_pendientes->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }
                }


                //dd($resultado2);
                /*$resumen=array();
                $linea=array();
                $linea['matricula_total_activa']=0;
                $linea['vigentes_sin_adeudos']=0;
                $linea['vigentes_con_1_adeudos']=0;
                $linea['baja_temporal_por_pago']=0;
                $linea['baja_administrativa']=0;
                $linea['preinscrito']=0;
                $aplantel="";

                foreach($resultado2 as $r){    
                    $registro=$r[0];
                    //dd($registro);
                    if($aplantel<>$registro['razon'] and $aplantel<>""){
                        array_push($linea,$resumen);
                        $linea['matricula_total_activa']=0;
                        $linea['vigentes_sin_adeudos']=0;
                        $linea['vigentes_con_1_adeudos']=0;
                        $linea['baja_temporal_por_pago']=0;
                        $linea['baja_administrativa']=0;
                    }
                    $linea['razon']=$registro['razon'];
                    if($registro['estatus_cliente_id']==4){
                        $linea['matricula_total_activa']=$linea['matricula_total_activa']+1;
                    }elseif($registro['estatus_cliente_id']==25){
                        $linea['baja_temporal_por_pago']=$linea['baja_temporal_por_pago']+1;
                    }if($registro['estatus_cliente_id']==26){
                        $linea['baja_administrativa']=$linea['baja_administrativa']+1;
                    }if($registro['estatus_cliente_id']==22){
                        $linea['preinscrito']=$linea['preinscrito']+1;
                    }
                    if($registro['estatus_cliente_id']==4 and $registro['pagado_bnd']==1){
                        $linea['vigentes_sin_adeudos']=$linea['vigentes_sin_adeudos']+1;
                    }elseif($registro['estatus_cliente_id']==4 and $registro['pagado_bnd']==0){
                        $linea['vigentes_con_1_adeudos']=$linea['vigentes_con_1_adeudos']+1;
                    }
                    //dd($linea);
                    $aplantel=$registro['razon'];
                }
                //dd($linea);
                array_push($resumen,$linea);
                */
                //dd($resultado2);
                $combinaciones_plantel_seccion = array();
                foreach ($resultado2 as $r) {
                    //dd($r);
                    //Log::info($r);
                    $linea = Arr::only($r, ['plantel_id', 'seccion']);
                    $marcador = 0;
                    foreach ($combinaciones_plantel_seccion as $revision) {
                        if ($revision['plantel_id'] == $linea['plantel_id'] and $revision['seccion'] == $linea['seccion']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        array_push($combinaciones_plantel_seccion, array(
                            'plantel_id' => $linea['plantel_id'],
                            'seccion' => $linea['seccion'],
                            'registros' => array(),
                            'nueva_inscripcion' => array(),
                            'activos_sin_adeudo' => array(),
                            'activos_1_adeudo' => array(),
                            'baja_temporal_por_pago' => array(),
                            'baja_administrativa' => array(),
                            'preinscrito' => array(),
                            'baja' => array(),
                        ));
                    }
                }
                //dd($combinaciones_plantel_seccion[0]);

                $resumen = array();
                $resumen_pagados = array();
                $resumen_no_pagados = array();
                $resumen_dinero = array();
                $resumen_dinero_pagados = array();
                $resumen_dinero_no_pagados = array();
                $registros_ordenados = array();


                foreach ($combinaciones_plantel_seccion as $combinacion_plantel_seccion) {
                    $linea = array();

                    $linea['razon'] = "";
                    $linea['razon_pagados'] = "";
                    $linea['razon_no_pagados'] = "";
                    $linea['seccion'] = "";
                    $linea['seccion_pagados'] = "";
                    $linea['seccion_no_pagados'] = "";
                    $linea['nueva_inscripcion'] = 0;
                    $linea['nueva_inscripcion_pagados'] = 0;
                    $linea['nueva_inscripcion_no_pagados'] = 0;
                    $linea['matricula_total_activa'] = 0;
                    $linea['matricula_total_activa_pagados'] = 0;
                    $linea['matricula_total_activa_no_pagados'] = 0;
                    $linea['vigentes_sin_adeudos'] = 0;
                    $linea['vigentes_sin_adeudos_pagados'] = 0;
                    $linea['vigentes_sin_adeudos_no_pagados'] = 0;
                    $linea['vigentes_con_1_adeudos'] = 0;
                    $linea['vigentes_con_1_adeudos_pagados'] = 0;
                    $linea['vigentes_con_1_adeudos_no_pagados'] = 0;
                    $linea['baja_temporal_por_pago'] = 0;
                    $linea['baja_temporal_por_pago_pagados'] = 0;
                    $linea['baja_temporal_por_pago_no_pagados'] = 0;
                    $linea['baja_administrativa'] = 0;
                    $linea['baja_administrativa_pagados'] = 0;
                    $linea['baja_administrativa_no_pagados'] = 0;
                    $linea['preinscrito'] = 0;
                    $linea['preinscrito_pagados'] = 0;
                    $linea['preinscrito_no_pagados'] = 0;
                    $linea['bajas'] = 0;
                    $linea['bajas_pagados'] = 0;
                    $linea['bajas_no_pagados'] = 0;
                    //$linea['razon'] = "";
                    $aplantel = "";

                    $linea_dinero = array();
                    $linea_dinero['razon'] = "";
                    $linea_dinero['razon_pagados'] = "";
                    $linea_dinero['razon_no_pagados'] = "";
                    $linea_dinero['seccion'] = "";
                    $linea_dinero['seccion_pagados'] = "";
                    $linea_dinero['seccion_no_pagados'] = "";
                    $linea_dinero['nueva_inscripcion'] = 0;
                    $linea_dinero['nueva_inscripcion_pagados'] = 0;
                    $linea_dinero['nueva_inscripcion_no_pagados'] = 0;
                    $linea_dinero['matricula_total_activa'] = 0;
                    $linea_dinero['matricula_total_activa_pagados'] = 0;
                    $linea_dinero['matricula_total_activa_no_pagados'] = 0;
                    $linea_dinero['vigentes_sin_adeudos'] = 0;
                    $linea_dinero['vigentes_sin_adeudos_pagados'] = 0;
                    $linea_dinero['vigentes_sin_adeudos_no_pagados'] = 0;
                    $linea_dinero['vigentes_con_1_adeudos'] = 0;
                    $linea_dinero['vigentes_con_1_adeudos_pagados'] = 0;
                    $linea_dinero['vigentes_con_1_adeudos_no_pagados'] = 0;
                    $linea_dinero['baja_temporal_por_pago'] = 0;
                    $linea_dinero['baja_temporal_por_pago_pagados'] = 0;
                    $linea_dinero['baja_temporal_por_pago_no_pagados'] = 0;
                    $linea_dinero['baja_administrativa'] = 0;
                    $linea_dinero['baja_administrativa_pagados'] = 0;
                    $linea_dinero['baja_administrativa_no_pagados'] = 0;
                    $linea_dinero['preinscrito'] = 0;
                    $linea_dinero['preinscrito_pagados'] = 0;
                    $linea_dinero['preinscrito_no_pagados'] = 0;
                    $linea_dinero['bajas'] = 0;
                    $linea_dinero['bajas_pagados'] = 0;
                    $linea_dinero['bajas_no_pagados'] = 0;
                    //$linea_dinero['razon'] = "";
                    //$i=1;
                    //dd($resultado2);
                    foreach ($resultado2 as $r) {
                        $registro = $r;
                        //dd($registro);
                        /*if($registro['cliente']==80985 and $combinacion_plantel_seccion['plantel_id']==13 and
                        $combinacion_plantel_seccion['seccion']=="MGS"){
                            //dd($combinacion_plantel_seccion);
                            dd($registro);
                            //dd($registro['plantel_id']==$combinacion_plantel_seccion['plantel_id'] and
                            //$registro['seccion']==$combinacion_plantel_seccion['seccion']);
                            
                        }*/
                        //dd($registro);
                        if (
                            $registro['plantel_id'] == $combinacion_plantel_seccion['plantel_id'] and
                            $registro['seccion'] == $combinacion_plantel_seccion['seccion']
                        ) {
                            $linea['razon'] = $registro['razon'];
                            $linea['razon_pagados'] = $registro['razon'];
                            $linea['razon_no_pagados'] = $registro['razon'];
                            $linea['seccion'] = $registro['seccion'];
                            $linea['seccion_pagados'] = $registro['seccion'];
                            $linea['seccion_no_pagados'] = $registro['seccion'];

                            $linea_dinero['razon'] = $registro['razon'];
                            $linea_dinero['razon_pagados'] = $registro['razon'];
                            $linea_dinero['razon_no_pagados'] = $registro['razon'];
                            $linea_dinero['seccion'] = $registro['seccion'];
                            $linea_dinero['seccion_pagados'] = $registro['seccion'];
                            $linea_dinero['seccion_no_pagados'] = $registro['seccion'];



                            if ($registro['estatus_cliente_id'] == 5) {
                                $linea['nueva_inscripcion'] = $linea['nueva_inscripcion'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['nueva_inscripcion_pagado'] = $linea['nueva_inscripcion_pagados'] + 1;
                                } else {
                                    $linea['nueva_inscripcion_no_pagados'] = $linea['nueva_inscripcion_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['nueva_inscripcion'] = $linea_dinero['nueva_inscripcion'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['nueva_inscripcion'] = $linea_dinero['nueva_inscripcion'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['nueva_inscripcion_pagados'] = $linea_dinero['nueva_inscripcion_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['nueva_inscripcion_no_pagados'] = $linea_dinero['nueva_inscripcion_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['nueva_inscripcion'], $registro);
                            }

                            if ( //( $registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or 
                                $registro['estatus_cliente_id'] == 31 or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)
                                //($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or estus egresado se ingnora
                                //($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and activo con titulacion en proceso se ignora
                                //$registro['pagado_bnd'] == 1
                            ) {
                                $linea['vigentes_sin_adeudos'] = $linea['vigentes_sin_adeudos'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['vigentes_sin_adeudos_pagados'] = $linea['vigentes_sin_adeudos_pagados'] + 1;
                                } else {
                                    $linea['vigentes_sin_adeudos_no_pagados'] = $linea['vigentes_sin_adeudos_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['vigentes_sin_adeudos'] = $linea_dinero['vigentes_sin_adeudos'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['vigentes_sin_adeudos'] = $linea_dinero['vigentes_sin_adeudos'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['vigentes_sin_adeudos_pagados'] = $linea_dinero['vigentes_sin_adeudos_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['vigentes_sin_adeudos_no_pagados'] = $linea_dinero['vigentes_sin_adeudos_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['activos_sin_adeudo'], $registro);
                                //array_push($combinacion_plantel_seccion['activos_sin_adeudo_pagados'],$registro);
                                //array_push($combinacion_plantel_seccion['activos_sin_adeudo_no_pagados'],$registro);
                            }
                            if ( //( $registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or
                                ($registro['estatus_cliente_id'] == 17) //or
                                //($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                //($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                //($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                //$registro['pagado_bnd'] == 0
                            ) {
                                //dd($registro);
                                $linea['vigentes_con_1_adeudos'] = $linea['vigentes_con_1_adeudos'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['vigentes_con_1_adeudos_pagados'] = $linea['vigentes_con_1_adeudos_pagados'] + 1;
                                } else {
                                    $linea['vigentes_con_1_adeudos_no_pagados'] = $linea['vigentes_con_1_adeudos_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['vigentes_con_1_adeudos'] = $linea_dinero['vigentes_con_1_adeudos'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['vigentes_con_1_adeudos'] = $linea_dinero['vigentes_con_1_adeudos'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['vigentes_con_1_adeudos_pagados'] = $linea_dinero['vigentes_con_1_adeudos_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['vigentes_con_1_adeudos_no_pagados'] = $linea_dinero['vigentes_con_1_adeudos_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['activos_1_adeudo'], $registro);
                            }

                            if ($registro['estatus_cliente_id'] == 25) {
                                $linea['baja_temporal_por_pago'] = $linea['baja_temporal_por_pago'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['baja_temporal_por_pago_pagados'] = $linea['baja_temporal_por_pago_pagados'] + 1;
                                } else {
                                    $linea['baja_temporal_por_pago_no_pagados'] = $linea['baja_temporal_por_pago_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['baja_temporal_por_pago'] = $linea_dinero['baja_temporal_por_pago'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['baja_temporal_por_pago'] = $linea_dinero['baja_temporal_por_pago'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['baja_temporal_por_pago_pagados'] = $linea_dinero['baja_temporal_por_pago_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['baja_temporal_por_pago_no_pagados'] = $linea_dinero['baja_temporal_por_pago_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['baja_temporal_por_pago'], $registro);
                            }
                            if ($registro['estatus_cliente_id'] == 26) {
                                $linea['baja_administrativa'] = $linea['baja_administrativa'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['baja_administrativa_pagados'] = $linea['baja_administrativa_pagados'] + 1;
                                } else {
                                    $linea['baja_administrativa_no_pagados'] = $linea['baja_administrativa_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['baja_administrativa'] = $linea_dinero['baja_administrativa'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['baja_administrativa'] = $linea_dinero['baja_administrativa'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['baja_administrativa_pagados'] = $linea_dinero['baja_administrativa_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['baja_administrativa_no_pagados'] = $linea_dinero['baja_administrativa_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['baja_administrativa'], $registro);
                            }
                            if ($registro['estatus_cliente_id'] == 22 /*or $registro['estatus_cliente_id'] == 5*/) {
                                $linea['preinscrito'] = $linea['preinscrito'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['preinscrito_pagados'] = $linea['preinscrito_pagados'] + 1;
                                } else {
                                    $linea['preinscrito_no_pagados'] = $linea['preinscrito_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['preinscrito'] = $linea_dinero['preinscrito'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['preinscrito'] = $linea_dinero['preinscrito'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['preinscrito_pagados'] = $linea_dinero['preinscrito_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['preinscrito_no_pagados'] = $linea_dinero['preinscrito_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['preinscrito'], $registro);
                            }

                            if (
                                ($registro['estatus_cliente_id'] == 5) or
                                ($registro['estatus_cliente_id'] == 22) or
                                $registro['estatus_cliente_id'] == 31 or
                                ($registro['estatus_cliente_id'] == 17) or
                                $registro['estatus_cliente_id'] == 25 or
                                $registro['estatus_cliente_id'] == 26 or
                                $registro['estatus_cliente_id'] == 4
                                //($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) 
                                //or
                                /*($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)*/
                            ) {
                                $linea['matricula_total_activa'] = $linea['matricula_total_activa'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['matricula_total_activa_pagados'] = $linea['matricula_total_activa_pagados'] + 1;
                                } else {
                                    $linea['matricula_total_activa_no_pagados'] = $linea['matricula_total_activa_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 0) {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['monto'];
                                } else {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['total_caja'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['matricula_total_activa_pagados'] = $linea_dinero['matricula_total_activa_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['matricula_total_activa_no_pagados'] = $linea_dinero['matricula_total_activa_no_pagados'] + $registro['monto'];
                                }

                                /*echo $i."__";
                                echo $registro['cliente']."--";
                                echo $registro['seccion'];
                                $i++;
                                */
                            }
                            if ($registro['estatus_cliente_id'] == 3) {
                                //dd("si hay baja");
                                $linea['bajas'] = $linea['bajas'] + 1;
                                if ($registro['pagado_bnd'] == 1) {
                                    $linea['bajas_pagados'] = $linea['bajas_pagados'] + 1;
                                } else {
                                    $linea['bajas_no_pagados'] = $linea['bajas_no_pagados'] + 1;
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['bajas'] = $linea_dinero['bajas'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['bajas'] = $linea_dinero['bajas'] + $registro['monto'];
                                }

                                if ($registro['pagado_bnd'] == 1) {
                                    $linea_dinero['bajas_pagados'] = $linea_dinero['bajas_pagados'] + $registro['total_caja'];
                                } else {
                                    $linea_dinero['bajas_no_pagados'] = $linea_dinero['bajas_no_pagados'] + $registro['monto'];
                                }

                                array_push($combinacion_plantel_seccion['baja'], $registro);
                            }
                        }
                    }
                    if ($linea['matricula_total_activa'] > 0) {
                        array_push($resumen, $linea);
                    }

                    if ($linea_dinero['matricula_total_activa'] > 0) {
                        array_push($resumen_dinero, $linea_dinero);
                    }

                    if (count($combinacion_plantel_seccion['activos_sin_adeudo']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['activos_sin_adeudo']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['activos_sin_adeudo_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['activos_sin_adeudo_no_pagados']);
                    }
                    //dd($registros_ordenados);
                    if (count($combinacion_plantel_seccion['activos_1_adeudo']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['activos_1_adeudo']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['activos_1_adeudo_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['activos_1_adeudo_no_pagados']);
                    }
                    if (count($combinacion_plantel_seccion['baja_temporal_por_pago']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['baja_temporal_por_pago']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['baja_temporal_por_pago_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['baja_temporal_por_pago_no_pagados']);
                    }
                    if (count($combinacion_plantel_seccion['baja_administrativa']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['baja_administrativa']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['baja_administrativa_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['baja_administrativa_no_pagados']);        
                    }
                    if (count($combinacion_plantel_seccion['preinscrito']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['preinscrito']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['preinscrito_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['preinscrito_no_pagados']);
                    }
                    if (count($combinacion_plantel_seccion['nueva_inscripcion']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['nueva_inscripcion']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['nueva_inscripcion_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['nueva_inscripcion_no_pagados']);
                    }
                    //dd($combinacion_plantel_seccion['baja']);
                    if (count($combinacion_plantel_seccion['baja']) > 0) {
                        array_push($registros_ordenados, $combinacion_plantel_seccion['baja']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['bajas_pagados']);
                        //array_push($registros_ordenados, $combinacion_plantel_seccion['bajas_no_pagados']);
                    }
                }





                $plantel = Plantel::find($datos['plantel_f']);

                //dd($registros->toArray());
                //dd($resumen);
                //dd($registros_ordenados);
                return view('reportesCedva.activos', array('registros' => $resultado2, 'plantel' => $plantel, 'datos' => $datos, 'resumen' => $resumen, 'resumen_dinero' => $resumen_dinero, 'registros_ordenados' => $registros_ordenados));
                break;
            case 2:
                $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                $lineas_procesadas = array();
                $lineas_detalle = array();
                foreach ($datos['plantel_f'] as $plantel) {
                    $registros_totales = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'adeudos.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                        ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                        ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                        ->select(
                            'p.id as plantel_id',
                            'p.razon',
                            'c.id',
                            'c.nombre',
                            'c.nombre2',
                            'c.ape_paterno',
                            'c.ape_materno',
                            'c.matricula',
                            'adeudos.pagado_bnd',
                            'adeudos.monto as adeudo_planeado',
                            DB::raw('0 as adeudo_planeado_calculado'),
                            'g.seccion',
                            'cc.name as concepto',
                            'cc.id as concepto_id',
                            'c.st_cliente_id',
                            'stc.name as st_cliente',
                            'adeudos.fecha_pago',
                            'adeudos.caja_id',
                            'adeudo_concepto.bnd_mensualidad as mensualidad',
                            'adeudos.id as adeudo'
                        )
                        ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                        ->where('p.id', $plantel)
                        ->whereIn('adeudos.caja_concepto_id', $datos['concepto_caja_f'])
                        //->where('c.matricula','like',$datos['ciclo_f'].'%')
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        ->where('adeudos.pagado_bnd', 0)
                        //->where('c.st_cliente_id', '<>', 3)
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('adeudos.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->orderBy('p.id')
                        ->orderBy('seccion')
                        ->orderBy('concepto_id')
                        ->get();
                    //dd($registros_totales->toArray());
                }
                foreach ($registros_totales as $registro) {
                    $registro->adeudo_planeado = $this->getMontoPlaneadoCalculado($registro->adeudo, $registro->id);
                    array_push($lineas_detalle, $registro->toArray());
                }
                //dd($lineas_detalle);

                return view('reportesCedva.adeudos', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
                break;
            case 3:
                $datos = $request->all();
                //dd($datos);
                $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                $lineas_procesadas = array();
                $lineas_detalle = array();
                foreach ($datos['plantel_f'] as $plantel) {

                    $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'adeudos.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                        ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                        ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('turnos as t', 't.id', '=', 'ccli.turno_id');

                    $cajas_sin_adeudos = Caja::select(
                        'p.id',
                        'p.razon',
                        'c.id as cliente_id',
                        'c.nombre',
                        'c.nombre2',
                        'c.ape_paterno',
                        'c.ape_materno',
                        DB::raw('"vacio" as especialidad'),
                        'g.seccion',
                        'c.matricula',
                        'cc.name as concepto',
                        'cc.id as concepto_id',
                        'cln.total as pago_calculado_adeudo',
                        'cajas.id as caja',
                        'cajas.consecutivo',
                        'cln.deleted_at as borrado_cln',
                        'cajas.deleted_at as borrado_c',
                        'cajas.usu_alta_id',
                        'c.st_cliente_id',
                        'stc.name as st_cliente',
                        's.st_seguimiento_id',
                        'sts.name as st_seguimiento',
                        DB::raw('date(0000-00-00) as fecha_pago'),
                        'cajas.id',
                        'cc.name as mensualidad',
                        DB::raw('1 as pagado_bnd'),
                        't.name as turno',
                        'pag.monto as monto_pago'
                    )
                        ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                        ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
                        ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
                        ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                        ->where('cajas.plantel_id', $plantel)
                        ->where('cajas.st_caja_id', 1)
                        ->where('cln.adeudo_id', 0)
                        ->whereNull('cln.deleted_at')
                        ->whereNull('pag.deleted_at')
                        ->whereIn('cc.id', $datos['concepto_caja_f'])
                        ->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('p.deleted_at')
                        ->whereNull('cajas.deleted_at')
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('c.deleted_at');
                    //->get();
                    //dd($cajas_sin_adeudos->toArray());
                    $registros_totales_aux->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                        ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                        ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
                        ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
                        //->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                        //->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                        ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                        ->where('caj.st_caja_id', 1)
                        ->whereNull('cln.deleted_at')
                        ->whereNull('pag.deleted_at')
                        ->select(
                            'p.id',
                            'p.razon',
                            'c.id as cliente_id',
                            'c.nombre',
                            'c.nombre2',
                            'c.ape_paterno',
                            'c.ape_materno',
                            'esp.name as especialidad',
                            'g.seccion',
                            'c.matricula',
                            'cc.name as concepto',
                            'cc.id as concepto_id',
                            'cln.total as pago_calculado_adeudo',
                            'caj.id as caja',
                            'caj.consecutivo',
                            'cln.deleted_at as borrado_cln',
                            'caj.deleted_at as borrado_c',
                            'caj.usu_alta_id',
                            'c.st_cliente_id',
                            'stc.name as st_cliente',
                            's.st_seguimiento_id',
                            'sts.name as st_seguimiento',
                            'adeudos.fecha_pago',
                            'adeudos.caja_id',
                            'adeudo_concepto.bnd_mensualidad as mensualidad',
                            'adeudos.pagado_bnd',
                            't.name as turno',
                            'pag.monto as monto_pago'
                        )
                        ->whereNull('caj.deleted_at')
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->where('adeudos.pagado_bnd', 1)
                        ->where('caj.plantel_id', $plantel)
                        ->union($cajas_sin_adeudos);

                    $registros_totales = $registros_totales_aux->where('p.id', $plantel)

                        ->whereIn('adeudos.caja_concepto_id', $datos['concepto_caja_f'])
                        //->where('c.matricula','like',$datos['ciclo_f'].'%')
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        ->whereNull('adeudos.deleted_at')
                        ->whereNull('s.deleted_at')
                        ->orderBy('seccion')
                        ->orderBy('concepto_id')
                        ->orderBy('matricula')
                        ->get();
                    //dd($registros_totales->toArray());


                    //recorrido linea de totales
                    foreach ($registros_totales as $registro) {
                        array_push($lineas_detalle, $registro->toArray());
                    }
                }
                //dd($lineas_detalle);
                return view('reportesCedva.pagados', compact('lineas_procesadas', 'pagos', 'lineas_detalle', 'datos'));

                break;
            case 4:
                $registros = Cliente::select(
                    'p.razon',
                    'clientes.id as cliente',
                    'clientes.matricula',
                    'g.seccion',
                    'clientes.ape_paterno',
                    'clientes.ape_materno',
                    'clientes.nombre',
                    'clientes.nombre2',
                    'clientes.tel_fijo',
                    'clientes.tel_cel',
                    'stc.name as estatus',
                    'cc.name as concepto',
                    'cm.name as ciclo_matricula'
                )
                    ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
                    ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'a.plan_pago_ln_id')
                    ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                    ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
                    ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                    ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                    ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                    ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                    ->where('a.pagado_bnd', 1)
                    ->whereDate('a.fecha_pago', '>=', $datos['fecha_f'])
                    ->whereDate('a.fecha_pago', '<=', $datos['fecha_t'])
                    //->whereIn('s.st_seguimiento_id',$estatus)
                    ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                    ->whereIn('a.caja_concepto_id', array(1, 23, 25))
                    //->where('clientes.matricula','like',$datos['ciclo_f']."%")
                    ->whereIn('cm.id', $datos['ciclo_f'])
                    ->whereNull('ccli.deleted_at')
                    ->whereNull('a.deleted_at')
                    ->whereNull('ppl.deleted_at')
                    ->orderBy('p.razon')
                    ->orderBy('clientes.ape_paterno')
                    ->orderBy('clientes.ape_materno')
                    ->orderBy('clientes.nombre')
                    ->orderBy('clientes.nombre2')
                    ->get();
                //dd($registros->toArray());

                $plantel = Plantel::find($datos['plantel_f']);
                //dd($registros->toArray());
                return view('reportesCedva.inscritosPorCiclo', compact('registros', 'plantel', 'datos'));
                break;
            case 5:
                $bajas = HistoriaCliente::select(
                    'historia_clientes.id as historia_cliente',
                    'c.id as cliente_id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    'c.tel_fijo',
                    'c.tel_cel',
                    'c.calle',
                    'c.no_exterior',
                    'stc.name as st_cliente',
                    'historia_clientes.updated_at as fecha_baja',
                    'descripcion',
                    'cm.name as ciclo_matricula',
                    'g.seccion',
                    'emp.nombre as emp_nombre',
                    'emp.ape_paterno as emp_ape_paterno',
                    'emp.ape_materno as emp_ape_materno',
                    'emp.st_prospecto_id',
                    'stp.name as st_prospecto'
                )
                    ->whereDate('historia_clientes.updated_at', '>=', $datos['fecha_f'])
                    ->join('clientes as c', 'c.id', 'historia_clientes.cliente_id')
                    ->join('empleados as emp', 'emp.id', 'c.empleado_id')
                    ->join('st_prospectos as stp', 'stp.id', 'emp.st_prospecto_id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', 'c.id')
                    ->join('plan_pagos as plp', 'plp.id', 'cc.plan_pago_id')
                    ->join('ciclo_matriculas as cm', 'cm.id', 'plp.ciclo_matricula_id')
                    ->join('grados as g', 'g.id', 'cc.grado_id')
                    ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
                    ->whereDate('historia_clientes.updated_at', '<=', $datos['fecha_t'])
                    ->where('historia_clientes.evento_cliente_id', 2)
                    ->where('historia_clientes.st_historia_cliente_id', 2)
                    ->where('historia_clientes.reactivado', 0)
                    ->where('c.st_cliente_id', 3)
                    ->orderBy('c.plantel_id')
                    ->orderBy('cm.name')
                    ->orderBy('g.seccion')
                    ->get();

                $registros = array();

                foreach ($bajas as $baja) {
                    $ultimo_adeudo_pagado = Adeudo::select(
                        'cln.total',
                        'p.created_at as fecha_creacion',
                        'p.fecha as fecha_pago',
                        'cajas.consecutivo',
                        'pla.razon',
                        'cc.name as concepto',
                        'p.monto',
                        'fp.name as forma_pago'
                    )
                        ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                        ->join('cajas as cajas', 'cajas.id', 'adeudos.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', 'cajas.id')
                        ->join('pagos as p', 'p.caja_id', 'cajas.id')
                        ->join('forma_pagos as fp', 'fp.id', 'p.forma_pago_id')
                        ->join('plantels as pla', 'pla.id', 'cajas.plantel_id')
                        ->join('historia_clientes as hc', 'hc.cliente_id', 'adeudos.cliente_id')
                        ->where('adeudos.cliente_id', $baja->cliente_id)
                        ->whereIn('cajas.plantel_id', $datos['plantel_f'])
                        ->orderBy('p.fecha', 'desc')
                        ->take(1)
                        ->first();

                    $tarea = AsignacionTarea::where('cliente_id', $baja->cliente_id)->orderBy('id', 'desc')->first();
                    $seguimiento = Seguimiento::where('cliente_id', $baja->cliente_id)->first();


                    if (!is_null($ultimo_adeudo_pagado)) {
                        array_push($registros, array(
                            'cliente_id' => $baja->cliente_id,
                            'nombre' => $baja->nombre,
                            'nombre2' => $baja->nombre2,
                            'ape_paterno' => $baja->ape_paterno,
                            'ape_materno' => $baja->ape_materno,
                            'tel_fijo' => $baja->tel_fijo,
                            'tel_cel' => $baja->tel_cel,
                            'calle' => $baja->calle,
                            'no_exterior' => $baja->no_exterior,
                            'fecha_baja' => $baja->fecha_baja,
                            'st_cliente' => $baja->st_cliente,
                            'cln.total' => $ultimo_adeudo_pagado->total,
                            'fecha_creacion' => $ultimo_adeudo_pagado->fecha_creacion,
                            'fecha_pago' => $ultimo_adeudo_pagado->fecha_pago,
                            'consecutivo' => $ultimo_adeudo_pagado->consecutivo,
                            'razon' => $ultimo_adeudo_pagado->razon,
                            'concepto' => $ultimo_adeudo_pagado->concepto,
                            'monto' => $ultimo_adeudo_pagado->monto,
                            'forma_pago' => $ultimo_adeudo_pagado->forma_pago,
                            'fecha_baja' => $baja->fecha_baja,
                            'justificacion' => $baja->descripcion,
                            'ultima_tarea' => $tarea, //->asunto,//->name." - ".optional($tarea)->detalle,
                            'sts' => $seguimiento->stSeguimiento->name,
                            'ciclo_matricula' => $baja->ciclo_matricula,
                            'seccion' => $baja->seccion,
                            'emp_nombre' => $baja->emp_nombre,
                            'emp_ape_paterno' => $baja->emp_ape_paterno,
                            'emp_ape_materno' => $baja->emp_ape_materno,
                            'st_prospecto_id' => $baja->st_prospecto_id,
                            'st_prospecto' => $baja->st_prospecto
                        ));
                    }
                }

                //dd($registros);

                /*
                $registros=Caja::select('c.id as cliente_id','c.nombre','c.nombre2','c.ape_paterno','c.ape_materno',
                'cln.total','p.created_at as fecha_creacion','p.fecha as fecha_pago','cajas.consecutivo','pla.razon',
                'stc.name as st_cliente','cc.name as concepto','p.monto','fp.name as forma_pago', 'hc.updated_at as fecha_baja')
                ->join('caja_lns as cln','cln.caja_id','cajas.id')
                ->join('caja_conceptos as cc','cc.id','cln.caja_concepto_id')
                ->join('clientes as c','c.id','cajas.cliente_id')
                ->join('st_clientes as stc','stc.id','c.st_cliente_id')
                ->join('pagos as p','p.caja_id','cajas.id')
                ->join('forma_pagos as fp','fp.id','p.forma_pago_id')
                ->join('plantels as pla','pla.id','cajas.plantel_id')
                ->join('historia_clientes as hc','hc.cliente_id','c.id')
                ->whereIn('hc.id',$bajas)
                ->whereColumn('hc.updated_at','<=','p.fecha')
                ->where('cajas.st_caja_id',1)
                ->where('c.st_cliente_id',3)
                ->whereIn('cajas.plantel_id', $datos['plantel_f'])
                ->whereDate('p.fecha','>=',$datos['fecha_f'])
                ->whereDate('p.fecha','<=',$datos['fecha_t'])
                ->whereNull('p.deleted_at')
                ->whereNull('cajas.deleted_at')
                ->whereNull('cln.deleted_at')
                ->orderBy('pla.razon')
                ->orderBy('cc.name')
                ->distinct()
                ->groupBy()
                ->get();
                */
                //dd($registros->toArray());
                return view('reportesCedva.pagosBajas', compact('registros'));
                break;
            case 6:
                //planeados Pendiente de pago
                if ($pagos == array(0)) {
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    foreach ($registros->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }
                    //dd($resultado2);
                    //planeados y pagados
                } elseif ($pagos == array(1)) {


                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        DB::raw("0 as anio_planeado"),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20,3,25,26,27))
                        ->whereIn('caj.st_caja_id', $pagos) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    //planeados y pagados con caja
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        DB::raw("concat(cc.id, '-',cc.name) as concepto"),
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        DB::raw("year(ad.fecha_pago) as anio_planeado"),
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20,3,25,26,27))
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);

                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //pagados y pendientes en una union
                } else {

                    //registros pagados
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'pag.monto as total_caja',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        //->union($registros_pendientes)
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', array(1)) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }

                    $registros_pendientes = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(0))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($registros_pendientes);
                    foreach ($registros_pendientes->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }
                }



                //dd($resultado2);
                /*
                $combinaciones_plantel_seccion = array();
                foreach ($resultado2 as $r) {
                    $linea = Arr::only($r[0], ['plantel_id', 'seccion']);
                    $marcador = 0;
                    foreach ($combinaciones_plantel_seccion as $revision) {
                        if ($revision['plantel_id'] == $linea['plantel_id'] and $revision['seccion'] == $linea['seccion']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        array_push($combinaciones_plantel_seccion, $linea);
                    }
                }
                //dd($combinaciones_plantel_seccion);

                $resumen = array();
                $resumen_dinero = array();

                foreach ($combinaciones_plantel_seccion as $combinacion_plantel_seccion) {
                    $linea = array();

                    $linea['razon'] = "";
                    $linea['seccion'] = "";
                    $linea['matricula_total_activa'] = 0;
                    $linea['vigentes_sin_adeudos'] = 0;
                    $linea['vigentes_con_1_adeudos'] = 0;
                    $linea['baja_temporal_por_pago'] = 0;
                    $linea['baja_administrativa'] = 0;
                    $linea['preinscrito'] = 0;
                    $linea['razon'] = "";
                    $aplantel = "";

                    $linea_dinero = array();
                    $linea_dinero['razon'] = "";
                    $linea_dinero['seccion'] = "";
                    $linea_dinero['matricula_total_activa'] = 0;
                    $linea_dinero['vigentes_sin_adeudos'] = 0;
                    $linea_dinero['vigentes_con_1_adeudos'] = 0;
                    $linea_dinero['baja_temporal_por_pago'] = 0;
                    $linea_dinero['baja_administrativa'] = 0;
                    $linea_dinero['preinscrito'] = 0;
                    $linea_dinero['razon'] = "";
                    //$i=1;
                    foreach ($resultado2 as $r) {
                        $registro = $r[0];
                        //dd($registro);
                        
                        if (
                            $registro['plantel_id'] == $combinacion_plantel_seccion['plantel_id'] and
                            $registro['seccion'] == $combinacion_plantel_seccion['seccion']
                        ) {
                            $linea['razon'] = $registro['razon'];
                            $linea['seccion'] = $registro['seccion'];

                            $linea_dinero['razon'] = $registro['razon'];
                            $linea_dinero['seccion'] = $registro['seccion'];

                            if (
                                $registro['estatus_cliente_id'] == 25 or $registro['estatus_cliente_id'] == 26 or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)
                            ) {
                                $linea['matricula_total_activa'] = $linea['matricula_total_activa'] + 1;
                                if ($registro['total_caja'] == 0) {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['monto'];
                                } else {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['total_caja'];
                                }

                                
                            }
                            if ($registro['estatus_cliente_id'] == 25) {
                                $linea['baja_temporal_por_pago'] = $linea['baja_temporal_por_pago'] + 1;
                                $linea_dinero['baja_temporal_por_pago'] = $linea_dinero['baja_temporal_por_pago'] + $registro['monto'];
                            }
                            if ($registro['estatus_cliente_id'] == 26) {
                                $linea['baja_administrativa'] = $linea['baja_administrativa'] + 1;
                                $linea_dinero['baja_administrativa'] = $linea_dinero['baja_administrativa'] + $registro['monto'];
                            }
                            if ($registro['estatus_cliente_id'] == 22 or $registro['estatus_cliente_id'] == 5) {
                                $linea['preinscrito'] = $linea['preinscrito'] + 1;
                                $linea_dinero['preinscrito'] = $linea_dinero['preinscrito'] + $registro['monto'];
                            }
                            if (( //$registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or 
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                    ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                $registro['pagado_bnd'] == 1
                            ) {
                                $linea['vigentes_sin_adeudos'] = $linea['vigentes_sin_adeudos'] + 1;
                                $linea_dinero['vigentes_sin_adeudos'] = $linea_dinero['vigentes_sin_adeudos'] + $registro['total_caja'];
                            }
                            if (( //$registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                    ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                $registro['pagado_bnd'] == 0
                            ) {
                                $linea['vigentes_con_1_adeudos'] = $linea['vigentes_con_1_adeudos'] + 1;
                                $linea_dinero['vigentes_con_1_adeudos'] = $linea_dinero['vigentes_con_1_adeudos'] + $registro['monto'];
                            }
                        }
                    }
                    if ($linea['matricula_total_activa'] > 0) {
                        array_push($resumen, $linea);
                    }
                    if ($linea_dinero['matricula_total_activa'] > 0) {
                        array_push($resumen_dinero, $linea_dinero);
                    }
                }


                //dd($resumen);

*/

                $plantel = Plantel::find($datos['plantel_f']);

                //dd($resultado2);
                //dd($resumen);
                return view('reportesCedva.activos_grafica', array('registros' => json_encode($resultado2), 'plantel' => $plantel/*, 'datos' => $datos, 'resumen' => $resumen, 'resumen_dinero' => $resumen_dinero*/));
                break;

            case 7:
                //planeados Pendiente de pago
                if ($pagos == array(0)) {
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    foreach ($registros->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }
                    //dd($resultado2);
                    //planeados y pagados
                } elseif ($pagos == array(1)) {

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        DB::raw("0 as anio_planeado"),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20))
                        ->whereIn('caj.st_caja_id', $pagos) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    //planeados y pagados con caja
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        DB::raw("concat(cc.id, '-',cc.name) as concepto"),
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        DB::raw("year(ad.fecha_pago) as anio_planeado"),
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20))
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('anio_planeado', 'asc')
                        ->orderBy('cc.name', 'asc')
                        //->orderBy('cm.name')
                        //->orderBy('ad.fecha_pago')
                        //->orderBy('cc.id')

                        //->orderBy('clientes.ape_paterno')
                        //->orderBy('clientes.ape_materno')
                        //->orderBy('clientes.nombre')
                        //->orderBy('clientes.nombre')
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);

                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //pagados y pendientes en una union
                } else {

                    //registros pagados
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'pag.monto as total_caja',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        //->union($registros_pendientes)
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', array(1)) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }

                    $registros_pendientes = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(0))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($registros_pendientes);
                    foreach ($registros_pendientes->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }
                }



                //dd($resultado2);

                $combinaciones_plantel_seccion = array();
                foreach ($resultado2 as $r) {
                    $linea = Arr::only($r, ['razon', 'plantel_id', 'seccion']);
                    $marcador = 0;
                    foreach ($combinaciones_plantel_seccion as $revision) {
                        if ($revision['plantel_id'] == $linea['plantel_id'] and $revision['seccion'] == $linea['seccion']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        array_push($combinaciones_plantel_seccion, $linea);
                    }
                }
                //dd($combinaciones_plantel_seccion);

                $combinaciones_anio_concepto = array();
                foreach ($resultado2 as $r) {
                    $linea = Arr::only($r, ['anio_planeado', 'concepto']);
                    //dd($linea);
                    $marcador = 0;
                    foreach ($combinaciones_anio_concepto as $revision) {
                        if ($revision['anio_planeado'] == $linea['anio_planeado'] and $revision['concepto'] == $linea['concepto']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        //dd($linea);

                        array_push($combinaciones_anio_concepto, $linea);
                    }
                }
                //dd($combinaciones_anio_concepto);
                //dd(Arr::sortRecursive($combinacion_anio_concepto));


                $resumen = array();
                $resumen_dinero = array();

                foreach ($combinaciones_anio_concepto as $combinacion_anio_concepto) {
                    foreach ($combinaciones_plantel_seccion as $combinacion_plantel_seccion) {
                        $linea = array();

                        $linea['razon'] = "";
                        $linea['seccion'] = "";
                        $linea['matricula_total_activa'] = 0;
                        $linea['vigentes_sin_adeudos'] = 0;
                        $linea['vigentes_con_1_adeudos'] = 0;
                        $linea['baja_temporal_por_pago'] = 0;
                        $linea['baja_administrativa'] = 0;
                        $linea['preinscrito'] = 0;
                        $linea['razon'] = "";
                        $linea['anio'] = "";
                        $linea["concepto"] = "";
                        $linea["total"] = 0;
                        $aplantel = "";

                        $linea_dinero = array();
                        $linea_dinero['razon'] = "";
                        $linea_dinero['seccion'] = "";
                        $linea_dinero['matricula_total_activa'] = 0;
                        $linea_dinero['vigentes_sin_adeudos'] = 0;
                        $linea_dinero['vigentes_con_1_adeudos'] = 0;
                        $linea_dinero['baja_temporal_por_pago'] = 0;
                        $linea_dinero['baja_administrativa'] = 0;
                        $linea_dinero['preinscrito'] = 0;
                        $linea_dinero['razon'] = "";
                        $linea_dinero['anio'] = "";
                        $linea_dinero["concepto"] = "";
                        //$i=1;
                        foreach ($resultado2 as $registro) {

                            //$registro = $r;
                            //dd($registro);

                            if (
                                $registro['plantel_id'] == $combinacion_plantel_seccion['plantel_id'] and
                                $registro['seccion'] == $combinacion_plantel_seccion['seccion'] and
                                $registro['anio_planeado'] == $combinacion_anio_concepto['anio_planeado'] and
                                $registro['concepto'] == $combinacion_anio_concepto['concepto']
                            ) {
                                //dd($registro);
                                $linea['razon'] = $registro['razon'];
                                $linea['seccion'] = $registro['seccion'];
                                $linea['anio_planeado'] = $registro['anio_planeado'];
                                $linea['concepto'] = $registro['concepto'];

                                $linea_dinero['razon'] = $registro['razon'];
                                $linea_dinero['seccion'] = $registro['seccion'];
                                $linea_dinero['anio_planeado'] = $registro['anio_planeado'];
                                $linea_dinero['concepto'] = $registro['concepto'];

                                $linea['total'] = $linea['total'] + 1;
                                /*
                            if (
                                $registro['estatus_cliente_id'] == 25 or $registro['estatus_cliente_id'] == 26 or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)
                            ) {
                                $linea['matricula_total_activa'] = $linea['matricula_total_activa'] + 1;
                                if ($registro['total_caja'] == 0) {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['monto'];
                                } else {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['total_caja'];
                                }

                                
                            }
                            if ($registro['estatus_cliente_id'] == 25) {
                                $linea['baja_temporal_por_pago'] = $linea['baja_temporal_por_pago'] + 1;
                                $linea_dinero['baja_temporal_por_pago'] = $linea_dinero['baja_temporal_por_pago'] + $registro['monto'];
                            }
                            if ($registro['estatus_cliente_id'] == 26) {
                                $linea['baja_administrativa'] = $linea['baja_administrativa'] + 1;
                                $linea_dinero['baja_administrativa'] = $linea_dinero['baja_administrativa'] + $registro['monto'];
                            }
                            if ($registro['estatus_cliente_id'] == 22 or $registro['estatus_cliente_id'] == 5) {
                                $linea['preinscrito'] = $linea['preinscrito'] + 1;
                                $linea_dinero['preinscrito'] = $linea_dinero['preinscrito'] + $registro['monto'];
                            }
                            if (( //$registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or 
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                    ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                $registro['pagado_bnd'] == 1
                            ) {
                                $linea['vigentes_sin_adeudos'] = $linea['vigentes_sin_adeudos'] + 1;
                                $linea_dinero['vigentes_sin_adeudos'] = $linea_dinero['vigentes_sin_adeudos'] + $registro['total_caja'];
                            }
                            if (( //$registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                    ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                $registro['pagado_bnd'] == 0
                            ) {
                                $linea['vigentes_con_1_adeudos'] = $linea['vigentes_con_1_adeudos'] + 1;
                                $linea_dinero['vigentes_con_1_adeudos'] = $linea_dinero['vigentes_con_1_adeudos'] + $registro['monto'];
                            }
*/
                            }
                        }
                        /*
                    if ($linea['matricula_total_activa'] > 0) {
                        array_push($resumen, $linea);
                    }
*/
                        if ($linea['total'] > 0) {
                            array_push($resumen, $linea);
                        }
                        if ($linea_dinero['matricula_total_activa'] > 0) {
                            array_push($resumen_dinero, $linea_dinero);
                        }
                    }
                }

                //dd($resultado2);
                //dd($resumen);



                $plantel = Plantel::find($datos['plantel_f']);

                //dd($resultado2);
                //dd($resumen);
                return view(
                    'reportesCedva.activos_plantel',
                    array(
                        'registros' => json_encode($resultado2),
                        'plantel' => $plantel,
                        'datos' => $datos,
                        'resumen' => $resumen,
                        'resumen_dinero' => $resumen_dinero,
                        'combinaciones_plantel_seccion' => $combinaciones_plantel_seccion,
                        'combinaciones_anio_concepto' => $combinaciones_anio_concepto
                    )
                );
                break;
        }
    }

    public function pagosCt()
    {
        $reportes = array(1 => 'Activos', 2 => 'Adeudos', 3 => 'Pagados', 4 => 'Inscritos Por Ciclo', 5 => 'Pagos con Baja', 6 => "Activos X Mes", 7 => "Activos X Plantel");
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        $estatus = array('0' => 'Todos', '1' => 'Vigente', '2' => "Baja");
        $pagos = array('0' => 'Todos', '1' => 'Pagado', '2' => 'Pendiente');
        $caja_conceptos = CajaConcepto::pluck('name', 'id');
        $caja_conceptos->prepend('Todos');
        $ciclos = CicloMatricula::pluck('name', 'id');
        //dd($caja_conceptos);
        return view('reportesCedva.pagosCt', compact('reportes', 'planteles', 'estatus', 'pagos', 'caja_conceptos', 'ciclos'));
    }

    public function pagosCtR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $estatus = array();
        if ($datos['estatus_f'] == 0) {
            $estatus = StCliente::whereNotIn('id', array(19))->pluck('id');
        } elseif ($datos['estatus_f'] == 1) {
            $estatus = array(4, 5, 17, 20, 22, 25, 26);
        } elseif ($datos['estatus_f'] == 2) {
            $estatus = array('3', '27', '28');
        }
        if ($datos['pagos_f'] == 0) {
            $pagos = array(0, 1);
        } elseif ($datos['pagos_f'] == 1) {
            $pagos = array(1);
        } elseif ($datos['pagos_f'] == 2) {
            $pagos = array(0);
        }

        if (in_array(0, $datos['concepto_caja_f'])) {
            $concepto_caja = CajaConcepto::pluck('id');
        } else {
            $concepto_caja = $datos['concepto_caja_f'];
        }
        //dd($concepto_caja);
        $resultado2 = array();
        switch ($datos['reportes_f']) {
            //Filtros que operan
            case 1:
                //planeados Pendiente de pago
                if ($pagos == array(0)) {
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    foreach ($registros->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }


                    //dd($resultado2);
                    //planeados y pagados
                } elseif ($pagos == array(1)) {

                    //planeado y pagado, pero sin caja tienen monto 0

                    $pagos0_sin_caja = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        //'caj.id as caja_id',
                        //'caj.consecutivo',
                        //'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as caja_id'),
                        DB::raw('0 as consecutivo'),
                        DB::raw('0 as fecha_caja'),
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->where('ad.monto', 0)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    //dd($pagos0_sin_caja->toArray());
                    foreach ($pagos0_sin_caja->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', $pagos) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }

                    //planeados y pagados con caja
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro->toArray());
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg->total_caja;
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg->total_caja = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, array($reg->toArray()));
                                }
                            }
                        }
                    }

                    //pagados y pendientes en una union
                } else {

                    //registros pagados
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'pag.monto as total_caja',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        //->union($registros_pendientes)
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro->toArray());
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg->total_caja;
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg->total_caja = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, array($reg->toArray()));
                                }
                            }
                        }
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', array(1)) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }


                    //registro sin caja, adeudo pagado y monto 0

                    $pagos0_sin_caja = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        //'caj.id as caja_id',
                        //'caj.consecutivo',
                        //'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as caja_id'),
                        DB::raw('0 as consecutivo'),
                        DB::raw('0 as fecha_caja'),
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'

                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->where('ad.monto', 0)
                        ->where('ad.caja_id', 0)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos0_sin_caja->toArray());
                    foreach ($pagos0_sin_caja->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }


                    $registros_pendientes = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(0))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($registros_pendientes);
                    foreach ($registros_pendientes->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }
                }


                //dd($resultado2);
                /*$resumen=array();
                $linea=array();
                $linea['matricula_total_activa']=0;
                $linea['vigentes_sin_adeudos']=0;
                $linea['vigentes_con_1_adeudos']=0;
                $linea['baja_temporal_por_pago']=0;
                $linea['baja_administrativa']=0;
                $linea['preinscrito']=0;
                $aplantel="";

                foreach($resultado2 as $r){    
                    $registro=$r[0];
                    //dd($registro);
                    if($aplantel<>$registro['razon'] and $aplantel<>""){
                        array_push($linea,$resumen);
                        $linea['matricula_total_activa']=0;
                        $linea['vigentes_sin_adeudos']=0;
                        $linea['vigentes_con_1_adeudos']=0;
                        $linea['baja_temporal_por_pago']=0;
                        $linea['baja_administrativa']=0;
                    }
                    $linea['razon']=$registro['razon'];
                    if($registro['estatus_cliente_id']==4){
                        $linea['matricula_total_activa']=$linea['matricula_total_activa']+1;
                    }elseif($registro['estatus_cliente_id']==25){
                        $linea['baja_temporal_por_pago']=$linea['baja_temporal_por_pago']+1;
                    }if($registro['estatus_cliente_id']==26){
                        $linea['baja_administrativa']=$linea['baja_administrativa']+1;
                    }if($registro['estatus_cliente_id']==22){
                        $linea['preinscrito']=$linea['preinscrito']+1;
                    }
                    if($registro['estatus_cliente_id']==4 and $registro['pagado_bnd']==1){
                        $linea['vigentes_sin_adeudos']=$linea['vigentes_sin_adeudos']+1;
                    }elseif($registro['estatus_cliente_id']==4 and $registro['pagado_bnd']==0){
                        $linea['vigentes_con_1_adeudos']=$linea['vigentes_con_1_adeudos']+1;
                    }
                    //dd($linea);
                    $aplantel=$registro['razon'];
                }
                //dd($linea);
                array_push($resumen,$linea);
                */
                //dd($resultado2);
                $combinaciones_plantel_seccion = array();
                foreach ($resultado2 as $r) {
                    $linea = Arr::only($r[0], ['plantel_id', 'seccion']);
                    $marcador = 0;
                    foreach ($combinaciones_plantel_seccion as $revision) {
                        if ($revision['plantel_id'] == $linea['plantel_id'] and $revision['seccion'] == $linea['seccion']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        array_push($combinaciones_plantel_seccion, $linea);
                    }
                }
                //dd($combinaciones_plantel_seccion);

                $resumen = array();
                $resumen_dinero = array();

                foreach ($combinaciones_plantel_seccion as $combinacion_plantel_seccion) {
                    $linea = array();

                    $linea['razon'] = "";
                    $linea['seccion'] = "";
                    $linea['matricula_total_activa'] = 0;
                    $linea['vigentes_sin_adeudos'] = 0;
                    $linea['vigentes_con_1_adeudos'] = 0;
                    $linea['baja_temporal_por_pago'] = 0;
                    $linea['baja_administrativa'] = 0;
                    $linea['preinscrito'] = 0;
                    $linea['razon'] = "";
                    $aplantel = "";

                    $linea_dinero = array();
                    $linea_dinero['razon'] = "";
                    $linea_dinero['seccion'] = "";
                    $linea_dinero['matricula_total_activa'] = 0;
                    $linea_dinero['vigentes_sin_adeudos'] = 0;
                    $linea_dinero['vigentes_con_1_adeudos'] = 0;
                    $linea_dinero['baja_temporal_por_pago'] = 0;
                    $linea_dinero['baja_administrativa'] = 0;
                    $linea_dinero['preinscrito'] = 0;
                    $linea_dinero['razon'] = "";
                    //$i=1;
                    //dd($resultado2);
                    foreach ($resultado2 as $r) {
                        $registro = $r[0];
                        //dd($registro);
                        /*if($registro['cliente']==80985 and $combinacion_plantel_seccion['plantel_id']==13 and
                        $combinacion_plantel_seccion['seccion']=="MGS"){
                            //dd($combinacion_plantel_seccion);
                            dd($registro);
                            //dd($registro['plantel_id']==$combinacion_plantel_seccion['plantel_id'] and
                            //$registro['seccion']==$combinacion_plantel_seccion['seccion']);
                            
                        }*/
                        if (
                            $registro['plantel_id'] == $combinacion_plantel_seccion['plantel_id'] and
                            $registro['seccion'] == $combinacion_plantel_seccion['seccion']
                        ) {
                            $linea['razon'] = $registro['razon'];
                            $linea['seccion'] = $registro['seccion'];

                            $linea_dinero['razon'] = $registro['razon'];
                            $linea_dinero['seccion'] = $registro['seccion'];

                            if (
                                ($registro['estatus_cliente_id'] == 17 and $registro['pagado_bnd'] == 0) or
                                $registro['estatus_cliente_id'] == 25 or $registro['estatus_cliente_id'] == 26 or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)
                            ) {
                                $linea['matricula_total_activa'] = $linea['matricula_total_activa'] + 1;
                                if ($registro['total_caja'] == 0) {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['monto'];
                                } else {
                                    $linea_dinero['matricula_total_activa'] = $linea_dinero['matricula_total_activa'] + $registro['total_caja'];
                                }

                                /*echo $i."__";
                                echo $registro['cliente']."--";
                                echo $registro['seccion'];
                                $i++;
                                */
                            }
                            if ($registro['estatus_cliente_id'] == 25) {
                                $linea['baja_temporal_por_pago'] = $linea['baja_temporal_por_pago'] + 1;
                                $linea_dinero['baja_temporal_por_pago'] = $linea_dinero['baja_temporal_por_pago'] + $registro['monto'];
                            }
                            if ($registro['estatus_cliente_id'] == 26) {
                                $linea['baja_administrativa'] = $linea['baja_administrativa'] + 1;
                                $linea_dinero['baja_administrativa'] = $linea_dinero['baja_administrativa'] + $registro['monto'];
                            }
                            if ($registro['estatus_cliente_id'] == 22 or $registro['estatus_cliente_id'] == 5) {
                                $linea['preinscrito'] = $linea['preinscrito'] + 1;
                                $linea_dinero['preinscrito'] = $linea_dinero['preinscrito'] + $registro['monto'];
                            }
                            if (( //$registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or 
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                    ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                $registro['pagado_bnd'] == 1
                            ) {
                                $linea['vigentes_sin_adeudos'] = $linea['vigentes_sin_adeudos'] + 1;
                                $linea_dinero['vigentes_sin_adeudos'] = $linea_dinero['vigentes_sin_adeudos'] + $registro['total_caja'];
                            }
                            if (( //$registro['estatus_cliente_id']==25 or $registro['estatus_cliente_id']==26 or
                                    ($registro['estatus_cliente_id'] == 17 and $registro['pagado_bnd'] == 0) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 2) or
                                    ($registro['estatus_cliente_id'] == 20 and $registro['estatus_seguimiento_id'] == 7) or
                                    ($registro['estatus_cliente_id'] == 4 and $registro['estatus_seguimiento_id'] == 9)) and
                                $registro['pagado_bnd'] == 0
                            ) {
                                //dd($registro);
                                $linea['vigentes_con_1_adeudos'] = $linea['vigentes_con_1_adeudos'] + 1;
                                $linea_dinero['vigentes_con_1_adeudos'] = $linea_dinero['vigentes_con_1_adeudos'] + $registro['monto'];
                            }
                        }
                    }
                    if ($linea['matricula_total_activa'] > 0) {
                        array_push($resumen, $linea);
                    }
                    if ($linea_dinero['matricula_total_activa'] > 0) {
                        array_push($resumen_dinero, $linea_dinero);
                    }
                }


                //dd($resumen);



                $plantel = Plantel::find($datos['plantel_f']);

                //dd($resultado2);
                //dd($resumen);
                return view('reportesCedva.pagosCtR', array('registros' => $resultado2, 'plantel' => $plantel, 'datos' => $datos, 'resumen' => $resumen, 'resumen_dinero' => $resumen_dinero));
                break;
            case 2:
                $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                $lineas_procesadas = array();
                $lineas_detalle = array();
                foreach ($datos['plantel_f'] as $plantel) {
                    $registros_totales = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'adeudos.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                        ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                        ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                        ->select(
                            'p.id as plantel_id',
                            'p.razon',
                            'c.id',
                            'c.nombre',
                            'c.nombre2',
                            'c.ape_paterno',
                            'c.ape_materno',
                            'c.matricula',
                            'adeudos.pagado_bnd',
                            'adeudos.monto as adeudo_planeado',
                            DB::raw('0 as adeudo_planeado_calculado'),
                            'g.seccion',
                            'cc.name as concepto',
                            'cc.id as concepto_id',
                            'c.st_cliente_id',
                            'stc.name as st_cliente',
                            'adeudos.fecha_pago',
                            'adeudos.caja_id',
                            'adeudo_concepto.bnd_mensualidad as mensualidad',
                            'adeudos.id as adeudo'
                        )
                        ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                        ->where('p.id', $plantel)
                        ->whereIn('adeudos.caja_concepto_id', $datos['concepto_caja_f'])
                        //->where('c.matricula','like',$datos['ciclo_f'].'%')
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        ->where('adeudos.pagado_bnd', 0)
                        //->where('c.st_cliente_id', '<>', 3)
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('adeudos.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->orderBy('p.id')
                        ->orderBy('seccion')
                        ->orderBy('concepto_id')
                        ->get();
                    //dd($registros_totales->toArray());
                }
                foreach ($registros_totales as $registro) {
                    $registro->adeudo_planeado = $this->getMontoPlaneadoCalculado($registro->adeudo, $registro->id);
                    array_push($lineas_detalle, $registro->toArray());
                }
                //dd($lineas_detalle);

                return view('reportesCedva.adeudos', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
                break;
            case 3:
                $datos = $request->all();
                //dd($datos);
                $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                $lineas_procesadas = array();
                $lineas_detalle = array();
                foreach ($datos['plantel_f'] as $plantel) {

                    $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'adeudos.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                        ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                        ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('turnos as t', 't.id', '=', 'ccli.turno_id');

                    $cajas_sin_adeudos = Caja::select(
                        'p.id',
                        'p.razon',
                        'c.id as cliente_id',
                        'c.nombre',
                        'c.nombre2',
                        'c.ape_paterno',
                        'c.ape_materno',
                        DB::raw('"vacio" as especialidad'),
                        'g.seccion',
                        'c.matricula',
                        'cc.name as concepto',
                        'cc.id as concepto_id',
                        'cln.total as pago_calculado_adeudo',
                        'cajas.id as caja',
                        'cajas.consecutivo',
                        'cln.deleted_at as borrado_cln',
                        'cajas.deleted_at as borrado_c',
                        'cajas.usu_alta_id',
                        'c.st_cliente_id',
                        'stc.name as st_cliente',
                        's.st_seguimiento_id',
                        'sts.name as st_seguimiento',
                        DB::raw('date(0000-00-00) as fecha_pago'),
                        'cajas.id',
                        'cc.name as mensualidad',
                        DB::raw('1 as pagado_bnd'),
                        't.name as turno',
                        'pag.monto as monto_pago'
                    )
                        ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                        ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
                        ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
                        ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                        ->where('cajas.plantel_id', $plantel)
                        ->where('cajas.st_caja_id', 1)
                        ->where('cln.adeudo_id', 0)
                        ->whereNull('cln.deleted_at')
                        ->whereNull('pag.deleted_at')
                        ->whereIn('cc.id', $datos['concepto_caja_f'])
                        ->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('p.deleted_at')
                        ->whereNull('cajas.deleted_at')
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('c.deleted_at');
                    //->get();
                    //dd($cajas_sin_adeudos->toArray());
                    $registros_totales_aux->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                        ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                        ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
                        ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
                        //->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                        //->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                        ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                        ->where('caj.st_caja_id', 1)
                        ->whereNull('cln.deleted_at')
                        ->whereNull('pag.deleted_at')
                        ->select(
                            'p.id',
                            'p.razon',
                            'c.id as cliente_id',
                            'c.nombre',
                            'c.nombre2',
                            'c.ape_paterno',
                            'c.ape_materno',
                            'esp.name as especialidad',
                            'g.seccion',
                            'c.matricula',
                            'cc.name as concepto',
                            'cc.id as concepto_id',
                            'cln.total as pago_calculado_adeudo',
                            'caj.id as caja',
                            'caj.consecutivo',
                            'cln.deleted_at as borrado_cln',
                            'caj.deleted_at as borrado_c',
                            'caj.usu_alta_id',
                            'c.st_cliente_id',
                            'stc.name as st_cliente',
                            's.st_seguimiento_id',
                            'sts.name as st_seguimiento',
                            'adeudos.fecha_pago',
                            'adeudos.caja_id',
                            'adeudo_concepto.bnd_mensualidad as mensualidad',
                            'adeudos.pagado_bnd',
                            't.name as turno',
                            'pag.monto as monto_pago'
                        )
                        ->whereNull('caj.deleted_at')
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->where('adeudos.pagado_bnd', 1)
                        ->where('caj.plantel_id', $plantel)
                        ->union($cajas_sin_adeudos);

                    $registros_totales = $registros_totales_aux->where('p.id', $plantel)

                        ->whereIn('adeudos.caja_concepto_id', $datos['concepto_caja_f'])
                        //->where('c.matricula','like',$datos['ciclo_f'].'%')
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        ->whereNull('adeudos.deleted_at')
                        ->whereNull('s.deleted_at')
                        ->orderBy('seccion')
                        ->orderBy('concepto_id')
                        ->orderBy('matricula')
                        ->get();
                    //dd($registros_totales->toArray());


                    //recorrido linea de totales
                    foreach ($registros_totales as $registro) {
                        array_push($lineas_detalle, $registro->toArray());
                    }
                }
                //dd($lineas_detalle);
                return view('reportesCedva.pagados', compact('lineas_procesadas', 'pagos', 'lineas_detalle', 'datos'));

                break;
            case 4:
                $registros = Cliente::select(
                    'p.razon',
                    'clientes.id as cliente',
                    'clientes.matricula',
                    'g.seccion',
                    'clientes.ape_paterno',
                    'clientes.ape_materno',
                    'clientes.nombre',
                    'clientes.nombre2',
                    'clientes.tel_fijo',
                    'clientes.tel_cel',
                    'stc.name as estatus',
                    'cc.name as concepto',
                    'cm.name as ciclo_matricula'
                )
                    ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
                    ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'a.plan_pago_ln_id')
                    ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                    ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
                    ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                    ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                    ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                    ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                    ->where('a.pagado_bnd', 1)
                    ->whereDate('a.fecha_pago', '>=', $datos['fecha_f'])
                    ->whereDate('a.fecha_pago', '<=', $datos['fecha_t'])
                    //->whereIn('s.st_seguimiento_id',$estatus)
                    ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                    ->whereIn('a.caja_concepto_id', array(1, 23, 25))
                    //->where('clientes.matricula','like',$datos['ciclo_f']."%")
                    ->whereIn('cm.id', $datos['ciclo_f'])
                    ->whereNull('ccli.deleted_at')
                    ->whereNull('a.deleted_at')
                    ->whereNull('ppl.deleted_at')
                    ->orderBy('p.razon')
                    ->orderBy('clientes.ape_paterno')
                    ->orderBy('clientes.ape_materno')
                    ->orderBy('clientes.nombre')
                    ->orderBy('clientes.nombre2')
                    ->get();
                //dd($registros->toArray());

                $plantel = Plantel::find($datos['plantel_f']);
                //dd($registros->toArray());
                return view('reportesCedva.inscritosPorCiclo', compact('registros', 'plantel', 'datos'));
                break;
            case 5:
                $bajas = HistoriaCliente::select(
                    'historia_clientes.id as historia_cliente',
                    'c.id as cliente_id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    'c.tel_fijo',
                    'c.tel_cel',
                    'c.calle',
                    'c.no_exterior',
                    'stc.name as st_cliente',
                    'historia_clientes.updated_at as fecha_baja',
                    'descripcion'
                )
                    ->whereDate('historia_clientes.updated_at', '>=', $datos['fecha_f'])
                    ->join('clientes as c', 'c.id', 'historia_clientes.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
                    ->whereDate('historia_clientes.updated_at', '<=', $datos['fecha_t'])
                    ->where('historia_clientes.evento_cliente_id', 2)
                    ->where('historia_clientes.st_historia_cliente_id', 2)
                    ->where('historia_clientes.reactivado', 0)
                    ->where('c.st_cliente_id', 3)
                    ->get();

                $registros = array();

                foreach ($bajas as $baja) {
                    $ultimo_adeudo_pagado = Adeudo::select(
                        'cln.total',
                        'p.created_at as fecha_creacion',
                        'p.fecha as fecha_pago',
                        'cajas.consecutivo',
                        'pla.razon',
                        'cc.name as concepto',
                        'p.monto',
                        'fp.name as forma_pago'
                    )
                        ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                        ->join('cajas as cajas', 'cajas.id', 'adeudos.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', 'cajas.id')
                        ->join('pagos as p', 'p.caja_id', 'cajas.id')
                        ->join('forma_pagos as fp', 'fp.id', 'p.forma_pago_id')
                        ->join('plantels as pla', 'pla.id', 'cajas.plantel_id')
                        ->join('historia_clientes as hc', 'hc.cliente_id', 'adeudos.cliente_id')
                        ->where('adeudos.cliente_id', $baja->cliente_id)
                        ->whereIn('cajas.plantel_id', $datos['plantel_f'])
                        ->orderBy('adeudos.id', 'desc')
                        ->take(1)
                        ->first();

                    $tarea = AsignacionTarea::where('cliente_id', $baja->cliente_id)->orderBy('id', 'desc')->first();
                    $seguimiento = Seguimiento::where('cliente_id', $baja->cliente_id)->first();


                    if (!is_null($ultimo_adeudo_pagado)) {
                        array_push($registros, array(
                            'cliente_id' => $baja->cliente_id,
                            'nombre' => $baja->nombre,
                            'nombre2' => $baja->nombre2,
                            'ape_paterno' => $baja->ape_paterno,
                            'ape_materno' => $baja->ape_materno,
                            'tel_fijo' => $baja->tel_fijo,
                            'tel_cel' => $baja->tel_cel,
                            'calle' => $baja->calle,
                            'no_exterior' => $baja->no_exterior,
                            'fecha_baja' => $baja->fecha_baja,
                            'st_cliente' => $baja->st_cliente,
                            'cln.total' => $ultimo_adeudo_pagado->total,
                            'fecha_creacion' => $ultimo_adeudo_pagado->fecha_creacion,
                            'fecha_pago' => $ultimo_adeudo_pagado->fecha_pago,
                            'consecutivo' => $ultimo_adeudo_pagado->consecutivo,
                            'razon' => $ultimo_adeudo_pagado->razon,
                            'concepto' => $ultimo_adeudo_pagado->concepto,
                            'monto' => $ultimo_adeudo_pagado->monto,
                            'forma_pago' => $ultimo_adeudo_pagado->forma_pago,
                            'fecha_baja' => $baja->fecha_baja,
                            'justificacion' => $baja->descripcion,
                            'ultima_tarea' => $tarea, //->asunto,//->name." - ".optional($tarea)->detalle,
                            'sts' => $seguimiento->stSeguimiento->name
                        ));
                    }
                }

                //dd($registros);


                /*
                $registros=Caja::select('c.id as cliente_id','c.nombre','c.nombre2','c.ape_paterno','c.ape_materno',
                'cln.total','p.created_at as fecha_creacion','p.fecha as fecha_pago','cajas.consecutivo','pla.razon',
                'stc.name as st_cliente','cc.name as concepto','p.monto','fp.name as forma_pago', 'hc.updated_at as fecha_baja')
                ->join('caja_lns as cln','cln.caja_id','cajas.id')
                ->join('caja_conceptos as cc','cc.id','cln.caja_concepto_id')
                ->join('clientes as c','c.id','cajas.cliente_id')
                ->join('st_clientes as stc','stc.id','c.st_cliente_id')
                ->join('pagos as p','p.caja_id','cajas.id')
                ->join('forma_pagos as fp','fp.id','p.forma_pago_id')
                ->join('plantels as pla','pla.id','cajas.plantel_id')
                ->join('historia_clientes as hc','hc.cliente_id','c.id')
                ->whereIn('hc.id',$bajas)
                ->whereColumn('hc.updated_at','<=','p.fecha')
                ->where('cajas.st_caja_id',1)
                ->where('c.st_cliente_id',3)
                ->whereIn('cajas.plantel_id', $datos['plantel_f'])
                ->whereDate('p.fecha','>=',$datos['fecha_f'])
                ->whereDate('p.fecha','<=',$datos['fecha_t'])
                ->whereNull('p.deleted_at')
                ->whereNull('cajas.deleted_at')
                ->whereNull('cln.deleted_at')
                ->orderBy('pla.razon')
                ->orderBy('cc.name')
                ->distinct()
                ->groupBy()
                ->get();
                */
                //dd($registros->toArray());
                return view('reportesCedva.pagosBajas', compact('registros'));
                break;
            case 6:
                //planeados Pendiente de pago
                if ($pagos == array(0)) {
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    foreach ($registros->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }
                    //dd($resultado2);
                    //planeados y pagados
                } elseif ($pagos == array(1)) {


                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        DB::raw("0 as anio_planeado"),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20,3,25,26,27))
                        ->whereIn('caj.st_caja_id', $pagos) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    //planeados y pagados con caja
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        DB::raw("concat(cc.id, '-',cc.name) as concepto"),
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        DB::raw("year(ad.fecha_pago) as anio_planeado"),
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20,3,25,26,27))
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);

                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //pagados y pendientes en una union
                } else {

                    //registros pagados
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'pag.monto as total_caja',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        //->union($registros_pendientes)
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', array(1)) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }

                    $registros_pendientes = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(0))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($registros_pendientes);
                    foreach ($registros_pendientes->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }
                }



                //dd($resultado2);


                $plantel = Plantel::find($datos['plantel_f']);

                //dd($resultado2);
                //dd($resumen);
                return view('reportesCedva.activos_grafica', array('registros' => json_encode($resultado2), 'plantel' => $plantel/*, 'datos' => $datos, 'resumen' => $resumen, 'resumen_dinero' => $resumen_dinero*/));
                break;

            case 7:
                //planeados Pendiente de pago
                if ($pagos == array(0)) {
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        //'pag.monto as total_caja',
                        //'pag.deleted_at',
                        //'pag.id as pago_id',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();

                    foreach ($registros->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }
                    //dd($resultado2);
                    //planeados y pagados
                } elseif ($pagos == array(1)) {

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        DB::raw("0 as anio_planeado"),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20))
                        ->whereIn('caj.st_caja_id', $pagos) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, $registro);
                    }


                    //planeados y pagados con caja
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        DB::raw("concat(cc.id, '-',cc.name) as concepto"),
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        DB::raw("year(ad.fecha_pago) as anio_planeado"),
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        //->whereIn('clientes.st_cliente_id', $estatus)
                        //->whereIn('clientes.st_cliente_id', array(4,20))
                        ->whereIn('ad.pagado_bnd', $pagos)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('anio_planeado', 'asc')
                        ->orderBy('cc.name', 'asc')
                        //->orderBy('cm.name')
                        //->orderBy('ad.fecha_pago')
                        //->orderBy('cc.id')

                        //->orderBy('clientes.ape_paterno')
                        //->orderBy('clientes.ape_materno')
                        //->orderBy('clientes.nombre')
                        //->orderBy('clientes.nombre')
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);

                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //pagados y pendientes en una union
                } else {

                    //registros pagados
                    $registros = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'pag.monto as total_caja',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(1))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        //->union($registros_pendientes)
                        ->get();

                    $r = $registros->groupBy('caja_id');
                    //dd($r->toArray());

                    foreach ($r->toArray() as $registro) {

                        if (count($registro) == 1) {
                            //$resultado2->push($registro);
                            array_push($resultado2, $registro[0]);
                        } else {
                            $suma = 0;
                            foreach ($registro as $reg) {
                                $suma = $suma + $reg['total_caja'];
                            }
                            $i = 0;
                            foreach ($registro as $reg) {
                                $i++;
                                $reg['total_caja'] = $suma;
                                if ($i == 1) {
                                    array_push($resultado2, $reg);
                                }
                            }
                        }
                    }

                    //$pagos no planeados con caja
                    $pagos_no_planeados = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        'pag.monto as total_caja',
                        'pag.deleted_at',
                        'pag.id as pago_id',
                        DB::raw('0 as fecha_pago'),
                        //'ad.fecha_pago',
                        DB::raw('0 as monto'),
                        //'ad.monto',
                        DB::raw('1 as pagado_bnd'),
                        //'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        //->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        //->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        //->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        //->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->Join('cajas as caj', 'caj.cliente_id', '=', 'clientes.id')
                        ->join('caja_lns as cln', 'cln.caja_id', '=', 'caj.id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ccli.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        ->join('pagos as pag', 'pag.caja_id', 'caj.id')
                        ->whereNull('pag.deleted_at')
                        ->whereNull('cln.deleted_at')
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        //->where('clientes.id', 47884)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('caj.st_caja_id', array(1)) //array pagos, 0 abierta, 1 pagado
                        ->where('cln.adeudo_id', 0)
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('cln.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('caj.fecha', '>=', $datos['fecha_f'])
                        ->whereDate('caj.fecha', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('caj.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($pagos_no_planeados->toArray());
                    foreach ($pagos_no_planeados->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }

                    $registros_pendientes = Cliente::select(
                        'p.id as plantel_id',
                        'p.razon',
                        'clientes.id as cliente',
                        'clientes.matricula',
                        'g.seccion',
                        'clientes.ape_paterno',
                        'clientes.ape_materno',
                        'clientes.nombre',
                        'clientes.nombre2',
                        'clientes.tel_fijo',
                        'clientes.tel_cel',
                        'stc.name as estatus_cliente',
                        'stc.id as estatus_cliente_id',
                        'sts.name as estatus_seguimiento',
                        'sts.id as estatus_seguimiento_id',
                        'cc.name as concepto',
                        'caj.id as caja_id',
                        'caj.consecutivo',
                        'caj.fecha as fecha_caja',
                        DB::raw('0 as total_caja'),
                        DB::raw('0 as deleted_at'),
                        DB::raw('0 as pago_id'),
                        'ad.fecha_pago',
                        'ad.monto',
                        'ad.pagado_bnd',
                        'cm.name as ciclo',
                        'tur.name as turno'
                    )
                        ->join('adeudos as ad', 'ad.cliente_id', '=', 'clientes.id')
                        ->join('plan_pago_lns as ppl', 'ppl.id', '=', 'ad.plan_pago_ln_id')
                        ->join('plan_pagos as pp', 'pp.id', '=', 'ppl.plan_pago_id')
                        ->join('ciclo_matriculas as cm', 'cm.id', '=', 'pp.ciclo_matricula_id')
                        ->leftJoin('cajas as caj', 'caj.id', '=', 'ad.caja_id')
                        ->join('caja_conceptos as cc', 'cc.id', '=', 'ad.caja_concepto_id')
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
                        ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
                        ->join('turnos as tur', 'tur.id', 'ccli.turno_id')
                        ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                        //->join('pagos as pag','pag.caja_id','caj.id')
                        //->whereNull('pag.deleted_at)
                        ->where('ccli.especialidad_id', '>', 0)
                        ->where('ccli.nivel_id', '>', 0)
                        ->where('ccli.grado_id', '>', 0)
                        ->where('ccli.turno_id', '>', 0)
                        ->whereIn('clientes.st_cliente_id', $estatus)
                        ->whereIn('ad.pagado_bnd', array(0))
                        ->whereIn('clientes.plantel_id', $datos['plantel_f'])
                        ->whereIn('ad.caja_concepto_id', $concepto_caja)
                        ->whereIn('cm.id', $datos['ciclo_f'])
                        //->where('clientes.matricula','like',$datos['ciclo_f'].'%')
                        ->whereDate('ad.fecha_pago', '>=', $datos['fecha_f'])
                        ->whereDate('ad.fecha_pago', '<=', $datos['fecha_t'])
                        ->whereNull('ccli.deleted_at')
                        ->whereNull('ad.deleted_at')
                        ->orderBy('p.razon')
                        ->orderBy('cm.name')
                        ->orderBy('cc.name')
                        ->orderBy('clientes.ape_paterno')
                        ->orderBy('clientes.ape_materno')
                        ->orderBy('clientes.nombre')
                        ->orderBy('clientes.nombre')
                        ->get();
                    //dd($registros_pendientes);
                    foreach ($registros_pendientes->toArray() as $registro) {
                        array_push($resultado2, array($registro));
                    }
                }



                //dd($resultado2);

                $combinaciones_plantel_seccion = array();
                foreach ($resultado2 as $r) {
                    $linea = Arr::only($r, ['razon', 'plantel_id', 'seccion']);
                    $marcador = 0;
                    foreach ($combinaciones_plantel_seccion as $revision) {
                        if ($revision['plantel_id'] == $linea['plantel_id'] and $revision['seccion'] == $linea['seccion']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        array_push($combinaciones_plantel_seccion, $linea);
                    }
                }
                //dd($combinaciones_plantel_seccion);

                $combinaciones_anio_concepto = array();
                foreach ($resultado2 as $r) {
                    $linea = Arr::only($r, ['anio_planeado', 'concepto']);
                    //dd($linea);
                    $marcador = 0;
                    foreach ($combinaciones_anio_concepto as $revision) {
                        if ($revision['anio_planeado'] == $linea['anio_planeado'] and $revision['concepto'] == $linea['concepto']) {
                            $marcador = 1;
                        }
                    }
                    if ($marcador == 0) {
                        //dd($linea);

                        array_push($combinaciones_anio_concepto, $linea);
                    }
                }
                //dd($combinaciones_anio_concepto);
                //dd(Arr::sortRecursive($combinacion_anio_concepto));


                $resumen = array();
                $resumen_dinero = array();

                foreach ($combinaciones_anio_concepto as $combinacion_anio_concepto) {
                    foreach ($combinaciones_plantel_seccion as $combinacion_plantel_seccion) {
                        $linea = array();

                        $linea['razon'] = "";
                        $linea['seccion'] = "";
                        $linea['matricula_total_activa'] = 0;
                        $linea['vigentes_sin_adeudos'] = 0;
                        $linea['vigentes_con_1_adeudos'] = 0;
                        $linea['baja_temporal_por_pago'] = 0;
                        $linea['baja_administrativa'] = 0;
                        $linea['preinscrito'] = 0;
                        $linea['razon'] = "";
                        $linea['anio'] = "";
                        $linea["concepto"] = "";
                        $linea["total"] = 0;
                        $aplantel = "";

                        $linea_dinero = array();
                        $linea_dinero['razon'] = "";
                        $linea_dinero['seccion'] = "";
                        $linea_dinero['matricula_total_activa'] = 0;
                        $linea_dinero['vigentes_sin_adeudos'] = 0;
                        $linea_dinero['vigentes_con_1_adeudos'] = 0;
                        $linea_dinero['baja_temporal_por_pago'] = 0;
                        $linea_dinero['baja_administrativa'] = 0;
                        $linea_dinero['preinscrito'] = 0;
                        $linea_dinero['razon'] = "";
                        $linea_dinero['anio'] = "";
                        $linea_dinero["concepto"] = "";
                        //$i=1;
                        foreach ($resultado2 as $registro) {

                            //$registro = $r;
                            //dd($registro);

                            if (
                                $registro['plantel_id'] == $combinacion_plantel_seccion['plantel_id'] and
                                $registro['seccion'] == $combinacion_plantel_seccion['seccion'] and
                                $registro['anio_planeado'] == $combinacion_anio_concepto['anio_planeado'] and
                                $registro['concepto'] == $combinacion_anio_concepto['concepto']
                            ) {
                                //dd($registro);
                                $linea['razon'] = $registro['razon'];
                                $linea['seccion'] = $registro['seccion'];
                                $linea['anio_planeado'] = $registro['anio_planeado'];
                                $linea['concepto'] = $registro['concepto'];

                                $linea_dinero['razon'] = $registro['razon'];
                                $linea_dinero['seccion'] = $registro['seccion'];
                                $linea_dinero['anio_planeado'] = $registro['anio_planeado'];
                                $linea_dinero['concepto'] = $registro['concepto'];

                                $linea['total'] = $linea['total'] + 1;
                            }
                        }

                        if ($linea['total'] > 0) {
                            array_push($resumen, $linea);
                        }
                        if ($linea_dinero['matricula_total_activa'] > 0) {
                            array_push($resumen_dinero, $linea_dinero);
                        }
                    }
                }

                //dd($resultado2);
                //dd($resumen);



                $plantel = Plantel::find($datos['plantel_f']);

                //dd($resultado2);
                //dd($resumen);
                return view(
                    'reportesCedva.activos_plantel',
                    array(
                        'registros' => json_encode($resultado2),
                        'plantel' => $plantel,
                        'datos' => $datos,
                        'resumen' => $resumen,
                        'resumen_dinero' => $resumen_dinero,
                        'combinaciones_plantel_seccion' => $combinaciones_plantel_seccion,
                        'combinaciones_anio_concepto' => $combinaciones_anio_concepto
                    )
                );
                break;
        }
    }




    public function getMontoPlaneadoCalculado($adeudo, $cliente)
    {
        $adeudos = Adeudo::where('id', '=', $adeudo)->get();

        $cliente = Cliente::find($cliente);


        $subtotal = 0;
        $recargo = 0;
        $descuento = 0;
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {

            //$existe_linea = CajaLn::where('adeudo_id', '=', $adeudo->id)->first();
            //dd($existe_linea->toArray());
            //if (!is_object($existe_linea)) {
            //$adeudo->caja_id = $caja->id;
            //$adeudo->save();
            //$caja_ln['caja_id'] = $caja->id;
            $caja_ln['cliente'] = $cliente->id;
            $caja_ln['caja_concepto_id'] = $adeudo->caja_concepto_id;
            $caja_ln['subtotal'] = $adeudo->monto;
            $caja_ln['total'] = 0;
            $caja_ln['recargo'] = 0;
            $caja_ln['descuento'] = 0;

            //Realiza descuento para inscripciones
            $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
            if (($param->valor == 0 or $param->valor == "AZ") and
                isset(optional($adeudo->descuento)->id) and
                ($adeudo->caja_concepto_id == 1 or $adeudo->caja_concepto_id == 23 or $adeudo->caja_concepto_id == 25)
            ) {
                $caja_ln['descuento'] = $caja_ln['subtotal'] * $adeudo->descuento->porcentaje;
            } else {
                //********************************* */
                //Calcula descuento por beca
                //********************************* */
                $beca_a = 0;
                foreach ($cliente->autorizacionBecas as $beca) {
                    //dd(is_null($beca->deleted_at));
                    $mesAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->month;
                    $anioAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->year;
                    $mesInicio = Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->month;
                    $anioInicio = Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->year;
                    $mesFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->month;
                    $anioFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->year;

                    //dd($anioInicio."-".$anioAdeudo."-".$mesInicio."-".$mesAdeudo."-".);
                    //dd(($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo));
                    //dd(($anioInicio < $anioAdeudo or $mesInicio >= $mesAdeudo) and ($anioFin >= $anioAdeudo and $mesFin <= $mesAdeudo));

                    if (
                        (($beca->lectivo->inicio <= $adeudo->fecha_pago and $beca->lectivo->fin >= $adeudo->fecha_pago) or
                            (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo)) or
                            (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin > $anioAdeudo)) or
                            (($anioInicio < $anioAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo))) and
                        $beca->st_beca_id == 4 and is_null($beca->deleted_at)
                    ) {
                        $beca_a = $beca->id;
                        //dd($beca);
                    }
                }

                $beca_autorizada = AutorizacionBeca::find($beca_a);
                //dd($beca_autorizada);
                if (
                    !is_null($beca_autorizada) and
                    $beca_autorizada->monto_mensualidad > 0 and
                    $adeudo->cajaConcepto->bnd_mensualidad == 1 and
                    ($adeudo->bnd_eximir_descuento_beca == 0 or is_null($adeudo->bnd_eximir_descuento_beca))
                ) {
                    $calculo_monto_mensualidad = $caja_ln['subtotal'] * $beca->monto_mensualidad;
                    $caja_ln['descuento'] = $caja_ln['descuento'] + $calculo_monto_mensualidad;
                    $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                } else {
                    $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                }
                //dd($caja_ln);
                //********************************* */
                //Fin Calculo descuento por beca
                //********************************* */

                //********************************* */
                //calcula descuento segun promocion ligada a 
                //la linea del plan considerando la fecha de pago de la
                //inscripcion del cliente
                //********************************* */
                try {
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    //if ($beca_a == 0 and $adeudo->bnd_eximir_descuentos == 0) {
                    if ($adeudo->bnd_eximir_descuentos == 0 or is_null($adeudo->bnd_eximir_descuentos)) {
                        foreach ($promociones as $promocion) {
                            /*
                                    $inscripcion = Adeudo::where('cliente_id', $adeudo->cliente_id)
                                        //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                        ->where('caja_concepto_id', 1)
                                        ->where('combinacion_cliente_id', $adeudo->combinacion_cliente_id)
                                        ->where('pagado_bnd', 1)
                                        ->first();

                                    //dd($inscripcion);
                                    if (is_object($inscripcion)) {
                                        $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                        $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                        $caja_inscripcion = Caja::find($inscripcion->caja_id);
                                        //dd($caja);
                                        $hoy = Carbon::createFromFormat('Y-m-d', $caja_inscripcion->fecha);
                                        //dd($hoy);
                                        $monto_promocion = 0;
                                        //dd($hoy);
                                        if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                            $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                            $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                            $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                            $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                        }
                                    } else {
                                        */
                            $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                            $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);
                            //$hoy = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                            $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $monto_promocion = 0;
                            //dd($hoy);
                            if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                $caja_ln['promo_plan_ln_id'] = $promocion->id;
                            }
                            //}
                        }
                    } else {
                        //$caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                    }
                } catch (Exception $e) {
                    dd($e);
                }
                //********************************* */
                //Fin calculo descuento por promocion
                //********************************* */    


                //********************************* */
                //Calcula regla descuento recargo
                //********************************* */
                $regla_recargo = 0;
                $regla_descuento = 0;
                //dd($caja_ln);
                //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                //Log::info("Adeudo-".$adeudo->id);
                //Log::info("linea plan pago-".$adeudo->planPagoLn->id);
                //$planPagoLn=PlanPagoLn::whereNull('deleted_at')->where('id',$adeudo->plan_pago_ln_id)->first();
                //$reglas=ReglaRecargo::whereNull('deleted_at')->where('')
                //$adeudo->planPagoLn->whereNull('plan_pago_lns.deleted_at')->get();
                $reglas = optional($adeudo->planPagoLn)->reglaRecargos;
                if (is_null($reglas)) {
                    //dd($reglas);
                }
                if (!is_null($reglas)) {
                    foreach ($reglas as $regla) {
                        if (($adeudo->bnd_eximir_descuento_regla == 0 or is_null($adeudo->bnd_eximir_descuento_regla)) and $adeudo->cajaConcepto->bnd_mensualidad == 1) {
                            //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                            //$fecha_caja = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                            $fecha_caja = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $fecha_adeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                            //dd($fecha_caja->greaterThanOrEqualTo($fecha_adeudo));
                            if ($fecha_caja->greaterThanOrEqualTo($fecha_adeudo)) {

                                $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                if ($fecha_caja < $fecha_adeudo) {
                                    $dias = $dias * -1;
                                }
                                //dd($dias);

                                //calcula recargo o descuento segun regla y aplica
                                if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                                    if ($regla->tipo_regla_id == 1) {
                                        //dd($regla->porcentaje);

                                        if ($regla->porcentaje > 0) {
                                            //dd($regla->porcentaje);
                                            $regla_recargo = $caja_ln['subtotal'] * $regla->porcentaje;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $caja_ln['total'] * $regla->porcentaje * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['total'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                                //echo $caja_ln['descuento'];
                                            }
                                        }
                                    } elseif ($regla->tipo_regla_id == 2) {
                                        //dd($regla->porcentaje);
                                        if ($regla->monto > 0) {
                                            $regla_recargo = $regla->monto;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $regla->monto;
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $regla->monto * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $regla->monto * -1;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                if ($fecha_caja < $fecha_adeudo) {
                                    $dias = $dias * -1;
                                }
                                //dd($dias);

                                //calcula recargo o descuento segun regla y aplica
                                if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                                    if ($regla->tipo_regla_id == 1) {
                                        //dd($regla->porcentaje);

                                        if ($regla->porcentaje > 0) {
                                            //dd($regla->porcentaje);
                                            $regla_recargo = $adeudo->monto * $regla->porcentaje;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $caja_ln['subtotal'] * $regla->porcentaje * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                                //echo $caja_ln['descuento'];
                                            }
                                        }
                                    } elseif ($regla->tipo_regla_id == 2) {
                                        //dd($regla->porcentaje);
                                        if ($regla->monto > 0) {
                                            $regla_recargo = $regla->monto;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $regla->monto;
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $regla->monto * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $regla->monto * -1;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            //$caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                        }
                    }
                } //end regla recargo descuento
                //dd($caja_ln);
                //$caja_ln['total'] = 0;
                //$monto_regla = $promocion->descuento * $caja_ln['total'];
                //$caja_ln['recargo']=$caja_ln['recargo']+$regla_recargo;
                //$caja_ln['descuento']=$caja_ln['descuento']+$regla_descuento;
                //$caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                //********************************* */
                //Fin calculo descuento por regla 
                //********************************* */


                //}

                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                $caja_ln['adeudo_id'] = $adeudo->id;

                $caja_ln['subtotal'] = round($caja_ln['subtotal'], 0);
                $caja_ln['total'] = round($caja_ln['total'], 0);
                $caja_ln['recargo'] = round($caja_ln['recargo'], 0);
                $caja_ln['descuento'] = round($caja_ln['descuento'], 0);

                //dd($caja_ln);
                return $caja_ln['total'];
            }
        }
    }

    public function reportesCedva2()
    {
        $reportes = array(1 => 'Bajas', 2 => '2', 3 => '3', 4 => '4', 5 => '5');
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        $estatus = array('0' => 'Todos', '1' => 'Vigente', '2' => "Baja");
        $pagos = array('0' => 'Todos', '1' => 'Pagado', '2' => 'Pendiente');
        $caja_conceptos = CajaConcepto::pluck('name', 'id');
        $caja_conceptos->prepend('Todos');
        $ciclos = CicloMatricula::pluck('name', 'id');
        //dd($caja_conceptos);
        return view('reportesCedva.varios2', compact('reportes', 'planteles', 'estatus', 'pagos', 'caja_conceptos', 'ciclos'));
    }

    public function reportesCedva2R(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $estatus = array();
        /*
        if ($datos['estatus_f'] == 0) {
            $estatus = StCliente::whereNotIn('id', array(19))->pluck('id');
        } elseif ($datos['estatus_f'] == 1) {
            $estatus = array(4, 20, 22, 25, 26);
        } elseif ($datos['estatus_f'] == 2) {
            $estatus = array('3', '27', '28');
        }
        if ($datos['pagos_f'] == 0) {
            $pagos = array(0, 1);
        } elseif ($datos['pagos_f'] == 1) {
            $pagos = array(1);
        } elseif ($datos['pagos_f'] == 2) {
            $pagos = array(0);
        }

        if (in_array(0, $datos['concepto_caja_f'])) {
            $concepto_caja = CajaConcepto::pluck('id');
        } else {
            $concepto_caja = $datos['concepto_caja_f'];
        }*/
        //dd($concepto_caja);
        $resultado2 = array();
        switch ($datos['reportes_f']) {
            case 1:
                $bajas = HistoriaCliente::select(
                    'historia_clientes.id as historia_cliente',
                    'c.id as cliente_id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    'c.tel_fijo',
                    'c.tel_cel',
                    'c.calle',
                    'c.no_exterior',
                    'stc.name as st_cliente',
                    'historia_clientes.updated_at as fecha_baja',
                    'descripcion'
                )
                    ->whereDate('historia_clientes.updated_at', '>=', $datos['fecha_f'])
                    ->join('clientes as c', 'c.id', 'historia_clientes.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
                    ->whereDate('historia_clientes.updated_at', '<=', $datos['fecha_t'])
                    ->where('historia_clientes.evento_cliente_id', 2)
                    ->where('historia_clientes.st_historia_cliente_id', 2)
                    ->where('historia_clientes.reactivado', 0)
                    ->where('c.st_cliente_id', 3)
                    ->get();

                $registros = array();

                foreach ($bajas as $baja) {
                    $ultimo_adeudo_pagado = Adeudo::select(
                        'cln.total',
                        'p.created_at as fecha_creacion',
                        'p.fecha as fecha_pago',
                        'cajas.consecutivo',
                        'pla.razon',
                        'cc.name as concepto',
                        'p.monto',
                        'fp.name as forma_pago',
                    )
                        ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                        ->join('cajas as cajas', 'cajas.id', 'adeudos.caja_id')
                        ->join('caja_lns as cln', 'cln.caja_id', 'cajas.id')
                        ->join('pagos as p', 'p.caja_id', 'cajas.id')
                        ->join('forma_pagos as fp', 'fp.id', 'p.forma_pago_id')
                        ->join('plantels as pla', 'pla.id', 'cajas.plantel_id')
                        ->join('historia_clientes as hc', 'hc.cliente_id', 'adeudos.cliente_id')
                        ->where('adeudos.cliente_id', $baja->cliente_id)
                        ->whereIn('cajas.plantel_id', $datos['plantel_f'])
                        ->where('cc.bnd_mensualidad', $datos['mensualidad'])
                        ->orderBy('adeudos.id', 'desc')
                        ->take(1)
                        ->first();

                    $tarea = AsignacionTarea::where('cliente_id', $baja->cliente_id)->orderBy('id', 'desc')->first();
                    $seguimiento = Seguimiento::where('cliente_id', $baja->cliente_id)->first();


                    if (!is_null($ultimo_adeudo_pagado)) {
                        array_push($registros, array(
                            'cliente_id' => $baja->cliente_id,
                            'matricula' => $baja->cliente->matricula,
                            'nombre' => $baja->nombre,
                            'nombre2' => $baja->nombre2,
                            'ape_paterno' => $baja->ape_paterno,
                            'ape_materno' => $baja->ape_materno,
                            'tel_fijo' => $baja->tel_fijo,
                            'tel_cel' => $baja->tel_cel,
                            'municipio' => $baja->cliente->municipio->name,
                            'colonia' => $baja->cliente->colonia,
                            'calle' => $baja->calle,
                            'no_exterior' => $baja->no_exterior,
                            'fecha_baja' => $baja->fecha_baja,
                            'st_cliente' => $baja->st_cliente,
                            'cln.total' => $ultimo_adeudo_pagado->total,
                            'fecha_creacion' => $ultimo_adeudo_pagado->fecha_creacion,
                            'fecha_pago' => $ultimo_adeudo_pagado->fecha_pago,
                            'consecutivo' => $ultimo_adeudo_pagado->consecutivo,
                            'razon' => $ultimo_adeudo_pagado->razon,
                            'concepto' => $ultimo_adeudo_pagado->concepto,
                            'monto' => $ultimo_adeudo_pagado->monto,
                            'forma_pago' => $ultimo_adeudo_pagado->forma_pago,
                            'fecha_baja' => $baja->fecha_baja,
                            'justificacion' => $baja->descripcion,
                            'ultima_tarea' => $tarea, //->asunto,//->name." - ".optional($tarea)->detalle,
                            'sts' => $seguimiento->stSeguimiento->name
                        ));
                    }
                }


                //dd($registros->toArray());
                return view('reportesCedva.pagosBajas2', compact('registros'));
                break;
            case 2:
                break;
        }
    }
}
