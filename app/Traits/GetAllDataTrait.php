<?php

/**
Copyright (c) 2016 dog-ears

This software is released under the MIT License.
http://dog-ears.net/
 */

namespace App\Traits;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\NameSolverTrait;
use App\Empleado;
use App\Plantel;
use Auth;

trait GetAllDataTrait
{

    use NameSolverTrait;

    /**
     * Get all data with condition formated like ransack
     *
     * @param  string $request, integer $paginate
     * @return LengthAwarePaginator Class
     */

    public static function getAllData(Request $request, $paginate = 20, $clientesa = 0)
    {

        $myObj = new self;
        $myQuery = $myObj;

        $names = explode('\\', get_class($myObj));
        //dd(end($names));
        $baseTable = $myObj->solveName(end($names), 'name_names');    //ex).apples
        if ($baseTable == 'est_asistencia') {
            $baseTable = $baseTable . 's';
        }

        //(i) join relation table

        if (is_array($myObj->relationApps)) {
            //dd($myObj->relationApps);
            foreach ($myObj->relationApps as $className => $classObj) {
                
                $relationTable = $myObj->solveName($className, 'name_names');    //ex).apple_types
                $relationColumnInBaseTable = $myObj->solveName($className, 'name_name') . '_id';    //ex).apple_type_id
                //dd($relationTable);
                $myQuery = $myQuery->leftJoin($relationTable, $baseTable . '.' . $relationColumnInBaseTable, '=', $relationTable . '.id');  //ex).leftJoin( 'apple_types', 'apples.apple_type_id', '=', 'apple_types.id' )
                //dd($myQuery);
                //Log::error("FLC: ".$relationTable);

            }
        }

        //(ii) add Constrain

        if (is_array($request->input('q'))) {

            foreach ($request->input('q') as $key => $value) {

                //skip s value that is for ordering
                if ($key === 's') {
                    continue;
                }

                //skip if value is blank
                if ($value === '') {
                    continue;
                }
                //dd($request);
                if (preg_match('#(.*)_([^_]*?)$#', $key, $m)) {
                    $column = $m[1];
                    $operator = $m[2];
                } else {
                    abort(500, 'query parameter has wrong value');
                }

                //if column is not relation table's column, add base table name at head.
                if (strpos($column, '.') === false) {
                    $column = $baseTable . '.' . $column;
                }

                if ($operator === 'cont' and ($value <> "" or $value <> 0)) {
                    $myQuery = $myQuery->Where($column, 'LIKE', '%' . $value . '%');
                    
                } elseif ($operator === 'lt' and $value <> 0) {
                    $myQuery = $myQuery->Where($column, '=', $value);
                } elseif ($operator === 'menorq' and $value <> "") {
                    str_replace("%3A", ":", $value);
                    str_replace("+", " ", $value);
                    $myQuery = $myQuery->where($column, '<=', $value);
                } elseif ($operator === 'mayorq' and $value <> "") {
                    str_replace("%3A", ":", $value);
                    str_replace("+", " ", $value);
                    $myQuery = $myQuery->where($column, '>=', $value);
                } elseif ($operator === 'date' and $value <> "") {
                    $myQuery = $myQuery->WhereDate($column, $value);
                } elseif ($operator === 'dateF' and $value <> "") {
                    $myQuery = $myQuery->WhereDate($column, ">=", $value);
                } elseif ($operator === 'dateT' and $value <> "") {
                    $myQuery = $myQuery->WhereDate($column, "<=", $value);
                }
                /*elseif( $operator === 'gt' ){
                    $myQuery = $myQuery->where($column, '>=', $value);                
                }*/
            }
        }

        //(iii) order setting
        if ($baseTable == "serie_folio_simplificados") {
            $myQuery = $myQuery->orderBy('serie_folio_simplificados.anio', 'desc')->orderBy('serie_folio_simplificados.mese_id');
        }

        if (is_array($request->input('q')) && array_key_exists('s', $request->input('q')) && $request->input('q')['s'] !== '') {

            if (preg_match('#(.*)_([^_]*?)$#', $request->input('q')['s'], $m)) {
                $column = $m[1];
                $order_dir = $m[2];

                if (mb_strtoupper($order_dir) !== 'ASC' && mb_strtoupper($order_dir) !== 'DESC') {
                    //abort(500, 'query parameter q[s] has wrong value');
                    $column = 'id';
                    $order_dir = 'desc';
                }
            } else {
                //abort(500, 'query parameter q[s] has wrong value');
                $column = 'id';
                $order_dir = 'desc';
            }

            //if column is not relation table's column, add base table name at head.
            if (strpos($column, '.') === false) {
                $column = $baseTable . '.' . $column;
            }
        } else {
            $column = $baseTable . '.id';
            $order_dir = 'DESC';
        }
        //dd(Auth::user()->can('IfiltroClientesXPlantel'));
        //dd();
        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id','<>',3)->first();
        
        $planteles = array();
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }

        //dd($empleado);
        //dd($baseTable);
        switch ($baseTable) {
            case "asignacion_academicas":
                //if (Auth::user()->can('IFiltroEmpleadosXPlantel')) {
                $myQuery = $myQuery->whereIn('asignacion_academicas.plantel_id', $planteles);
                //}
                $user = Auth::user()->id;
                $empleado = Empleado::where('user_id', $user)->where('st_empleado_id','<>',3)->first();
                
                if ($empleado->puesto_id == 3) {
                    
                    $myQuery = $myQuery->where('asignacion_academicas.empleado_id', '=', $empleado->id);
                }
                //dd($request);
                break;
            case "alumnos":
                //if (Auth::user()->can('IFiltroEmpleadosXPlantel')) {
                $myQuery = $myQuery->whereIn('alumnos.plantel_id', $planteles);
                //}
                break;
            case "autorizacion_becas":
                $myQuery = $myQuery->orderBy('autorizacion_becas.st_beca_id');
                break;
            case "clientes":
                $myQuery = $myQuery->with('plantel', 'especialidad', 'nivel', 'grado', 'stCliente', 'pais', 'empleado');
                //if ($baseTable == "clientes" and (Auth::user()->can('IfiltroClientesXPlantel'))) {
                $myQuery = $myQuery->whereIn('clientes.plantel_id', $planteles);
                $myQuery = $myQuery->whereNull('clientes.deleted_at');
                //}
                break;
            case "corte_cajas":
                $myQuery = $myQuery->whereIn('corte_cajas.plantel_id', $planteles);
                break;
            case "calendario_evaluacions":
                if ($baseTable == "calendario_evaluacions") {
                    $myQuery = $myQuery->whereIn('calendario_evaluacions.plantel_id', $planteles);
                }
                break;
                case "doc_vinculacions":
                    
                    $myQuery = $myQuery->orderBy('clasificacion_id')->orderBy('orden');
                    
                    break;
            case "empleados":
                if ($baseTable == "empleados") { // and Auth::user()->can('IfiltroEmpleadosXPlantel')
                    $myQuery = $myQuery->whereIn('empleados.plantel_id', $planteles);
                }
                if ($baseTable == "empleados" and Auth::user()->can('empleados.bajas')) {
                    $myQuery = $myQuery->where('empleados.st_empleado_id', '<>', 3);
                }

                break;

            case "egresos":
                if ($empleado->puesto_id == 23) {
                    $planteles_rl = Plantel::where('responsable_id', $empleado->id)->pluck('id');
                    $myQuery = $myQuery->whereIn('egresos.plantel_id', $planteles_rl->toArray());
                }
                //dd(!Auth::user()->can('IfiltroEgresosCreador'));
                if ($baseTable == "egresos" and !Auth::user()->can('IfiltroEgresosCreador')) {
                    $myQuery = $myQuery->where('egresos.usu_alta_id', '=', Auth::user()->id);
                }
                break;
            case "especialidads":
                $myQuery = $myQuery->whereIn('especialidads.plantel_id', $planteles);
                break;
            case "grados":
                $myQuery = $myQuery->whereIn('grados.plantel_id', $planteles);
                break;
            case "grupos":
                //if (Auth::user()->can('IFiltroEmpleadosXPlantel')) {
                //dd("fil");
                $myQuery = $myQuery->whereIn('grupos.plantel_id', $planteles);
                //}
                break;
            case "materia":
                //if (Auth::user()->can('IFiltroEmpleadosXPlantel')) {
                $myQuery = $myQuery->whereIn('materia.plantel_id', $planteles);
                //}
                break;
            case "movimientos":
                //if (Auth::user()->can('IfiltroClientesXPlantel')) {
                $myQuery = $myQuery->whereIn('movimientos.plantel_id', $planteles);
                //}
                break;
            case "muebles":
                //if (Auth::user()->can('IfiltroClientesXPlantel')) {
                $myQuery = $myQuery->whereIn('muebles.plantel_id', $planteles);
                //}
                break;
            case "nivels":
                //dd(Auth::user()->can('IfiltroNivelXplantel'));
                //if ($baseTable == "nivels") { // and Auth::user()->can('IfiltroNivelXplantel')
                $myQuery = $myQuery->whereIn('nivels.plantel_id', $planteles);
                //}
                break;
            case "pivot_aviso_gral_empleados":
                if ($baseTable == "pivot_aviso_gral_empleados" and Auth::user()->can('IfiltroAvisosXempleado')) {
                    $myQuery = $myQuery->where('pivot_aviso_gral_empleados.empleado_id', '=', $empleado->id);
                }
                break;
            case "periodo_estudios":
                //if (Auth::user()->can('IFiltroEmpleadosXPlantel')) {
                $myQuery = $myQuery->whereIn('periodo_estudios.plantel_id', $planteles);
                //}
                break;
            case "plan_pagos":
                if (Auth::user()->can('IPlanPagosXPlantel')) {
                $myQuery = $myQuery->whereIn('plan_pagos.plantel_id', $planteles);
                }
                break;
            case "plan_estudios":
                //dd(Auth::user()->can('IPlanEstudiosXPlantel'));
                if (Auth::user()->can('IPlanEstudiosXPlantel')) {
                $myQuery = $myQuery->whereIn('plan_estudios.plantel_id', $planteles);
                }
                break;
            case "periodo_estudios":
                if (Auth::user()->can('IPlanEstudiosXPlantel')) {
                $myQuery = $myQuery->whereIn('periodo_estudios.plantel_id', $planteles);
                }
                break;
            case "plantels":
                $myQuery = $myQuery->whereIn('plantels.id', $planteles);
                break;
            case "prospectos":
                //dd($planteles);
                $myQuery = $myQuery->whereIn('prospectos.plantel_id', $planteles);
                if (Auth::user()->can('prospectos.CallCenter')) {
                    $myQuery = $myQuery->where('prospectos.st_prospecto_id', '<>', 2);
                }
                if (Auth::user()->can('prospectos.Asesores')) {
                    $myQuery = $myQuery->where('prospectos.st_prospecto_id', '<>', 1);
                }
                break;
            case "salons":
                //if (Auth::user()->can('IFiltroEmpleadosXPlantel')) {
                $myQuery = $myQuery->whereIn('salons.plantel_id', $planteles);
                //}
                break;
            case "seguimientos":
                $myQuery = $myQuery->with(['cliente', 'stSeguimiento']);
                $myQuery = $myQuery->whereNull('clientes.deleted_at');
                if ($baseTable == "seguimientos" and Auth::user()->can('IfiltroClientesXEmpleado')) {
                    $myQuery = $myQuery->where('clientes.empleado_id', '=', $empleado->id);
                }
                if ($baseTable == "seguimientos") { //and Auth::user()->can('IfiltroClientesXPlantel')
                    $myQuery = $myQuery->whereIn('clientes.plantel_id', $planteles);
                }
                if ($baseTable == "seguimientos") { //and Auth::user()->can('IfiltroClientesXPlantel')
                    $myQuery = $myQuery->whereIn('clientes.plantel_id', $planteles)
                        ->where('st_seguimiento_id', '<>', '3');
                }
                if ($baseTable == "seguimientos" and Auth::user()->can('IfiltroRechazados')) {
                    $myQuery = $myQuery->where('st_seguimiento_id', '<>', '3');
                }
                //dd($clientesa);
                if ($clientesa == 1) {
                    //dd($clientesa);
                    $myQuery = $myQuery->where('seguimientos.st_seguimiento_id', '=', 2);
                }

                break;
            /*case "historia_clientes":
                if ($baseTable == "historia_clientes") { //and Auth::user()->can('IfiltroClientesXPlantel')
                    $myQuery = $myQuery->whereIn('clientes.plantel_id', $planteles);
                }
                break;*/
            case "tickets":
                if (Auth::user()->can('tickets.usuarioTickets')) {
                    $myQuery = $myQuery->orWhere('tickets.asignado_a', Auth::user()->id)
                        ->orWhere('tickets.usu_alta_id', Auth::user()->id);
                }
                break;

            case 'transferences':
                if (Auth::user()->can('transferencia.filtroPlantel')) {
                    $myQuery = $myQuery->whereRaw('(plantel_id in (?) or plantel_destino_id in (?))', [$planteles, $planteles]);
                }
                break;
                case "turnos":
                    $myQuery = $myQuery->whereIn('turnos.plantel_id', $planteles);
                    break;
        }



        //dd(Auth::user()->can('IfiltroAvisosXempleado'));


        $myQuery = $myQuery->orderBy($column, $order_dir);

        //(iv) get base table data

        $myQuery = $myQuery->select([$baseTable . '.*']);

        //(v) pagenate

        return $myQuery->paginate($paginate);
    }

    
}
