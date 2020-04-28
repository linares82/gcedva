<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AutorizacionBeca;
use App\Aviso;
use App\AvisosEmpresa;
use App\Lectivo;
use App\AvisoGral;
use App\PivotAvisoGralEmpleado;
use App\Seguimiento;
use App\StSeguimiento;
use App\Empleado;
use App\Plantel;
use App\Menu;
use DB;
use Auth;
use Activity;
use App\HistoriaCliente;
use Log;

class HomeController extends Controller
{
    public $menuArmado = "";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $f = date("Y-m-d");
        $l = Lectivo::find(0)->first();

        /*Avisos del usuario
         * 
         */
        //dd(Auth::user()->id);
        $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
        //dd($e);
        $avisos = Aviso::select('avisos.id', 'a.name', 'avisos.detalle', 'avisos.fecha', 's.cliente_id')
            ->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
            ->join('seguimientos as s', 's.id', '=', 'avisos.seguimiento_id')
            ->join('clientes as c', 'c.id', '=', 's.cliente_id')
            ->where('avisos.activo', '=', '1')
            ->where('avisos.fecha', '>=', Db::Raw('CURDATE()'))
            ->where('c.empleado_id', '=', $e->id)
            ->orderBy('avisos.fecha')
            ->get();
        //dd($avisos);
        /* Fin avisos del usuario
         * 
         */
        $mes = (int) date('m');
        //dd($mes);
        /*
         * Cuadros con numeros
         */
        $a_1 = Seguimiento::select(Db::raw('count(c.nombre) as total'))
            ->where('st_seguimiento_id', '=', 1)
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            //->where('mes', '=', $mes)
            //->where('c.plantel_id', '=', $e->plantel_id)
            ->where('c.empleado_id', '=', $e->id)
            ->value('total');
        //dd($a_1);
        $lectivosSt2 = Lectivo::where('grafica_bnd', '=', '1')->get();
        $a_2 = array();
        $avance = array();
        $i = 0;
        $j = 0;
        foreach ($lectivosSt2 as $lSt2) {

            $a = Seguimiento::join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
                ->where('esp.lectivo_id', '=', $lSt2->id)
                //->where('seguimientos.created_at', '>=', $l->inicio)
                //->where('seguimientos.created_at', '<=', $l->fin)
                ->where('c.empleado_id', '=', $e->id)
                //->where('c.plantel_id', '=', $e->plantel_id)
                ->where('h.fecha', '>=', $lSt2->inicio)
                ->where('h.fecha', '<=', $lSt2->fin)
                ->where('h.detalle', '=', 'Concretado')
                ->where('h.asunto', '=', 'Cambio estatus ')
                ->count();
            array_push($a_2, array($a, $lSt2->name));
            //dd($a_2);
            $avance[$i] = 0;
            if ($a > 0) {
                $avance[$i] = (($a * 100) / $e->plantel->meta_total);
            }
            $i++;
        }

        //dd($avance);
        /*$a_2=Seguimiento::where('st_seguimiento_id', '=', 2)
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where('seguimientos.created_at', '>=', $l->inicio)
                    ->where('seguimientos.created_at', '<=', $l->fin)
                    ->where('c.empleado_id', '=', $e->id)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->count();
         
         
        //dd($e->plantel->meta_venta);
        $avance=0;
        if($a_2>0){
            $avance=(($a_2*100)/$e->plantel->meta_total);
        }
        */
        //dd($a_3."*100 / ".$e->plantel->meta_venta);
        $a_3 = Seguimiento::where('st_seguimiento_id', '=', 3)
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            //->where('mes', '=', $mes)
            ->where('c.empleado_id', '=', $e->id)
            //->where('c.plantel_id', '=', $e->plantel_id)
            ->count();

        $a_4 = Seguimiento::where('st_seguimiento_id', '=', 4)
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            //->where('mes', '=', $mes)
            ->where('c.empleado_id', '=', $e->id)
            //->where('c.plantel_id', '=', $e->plantel_id)
            ->count();
        $a_5 = Seguimiento::where('st_seguimiento_id', '=', 5)
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            //->where('mes', '=', $mes)
            ->where('c.empleado_id', '=', $e->id)
            //->where('c.plantel_id', '=', $e->plantel_id)
            ->count();

        /*
         * Fin cuadros con numeros
         */

        /*graficas de velocimetro
         * 
         */
        /*$gauge = array();
        if (!Auth::user()->can('WgaugesXplantelIndividual')) {
            $plantels = DB::table('plantels as p')->where('id', '>', 0)
                ->select('razon', 'id', 'meta_total')->get();
            foreach ($plantels as $p) {
                $c = Seguimiento::select(
                    'p.id',
                    'p.razon',
                    'p.meta_total',
                    DB::raw('count(c.nombre) as avance'),
                    DB::raw('((count(c.nombre)*100)/p.meta_total) as p_avance')
                )
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                    ->where('h.tarea', '=', 'Seguimiento')
                    ->where('h.detalle', '=', 'Concretado')
                    ->where('h.created_at', '>=', $l->inicio)
                    ->where('h.created_at', '<=', $l->fin)
                    ->where('c.st_cliente_id', '=', '4')
                    ->where('p.id', '=', $p->id)
                    ->groupBy('p.id')
                    ->groupBy('p.razon')
                    ->groupBy('p.meta_total')
                    ->first();
                if (is_null($c)) {
                    array_push($gauge, array('id' => $p->id, 'razon' => $p->razon, 'meta_total' => $p->meta_total, 'avance' => 0, 'p_avance' => 0));
                } else {
                    array_push($gauge, $c->toArray());
                }
            }
        } else {
            $plantels = DB::table('plantels as p')->where('id', '>', 0)->where('id', '=', $e->plantel_id)
                ->select('razon', 'id', 'meta_total')->get();
            foreach ($plantels as $p) {
                $c = Seguimiento::select(
                    'p.id',
                    'p.razon',
                    'p.meta_total',
                    DB::raw('count(c.nombre) as avance'),
                    DB::raw('((count(c.nombre)*100)/p.meta_total) as p_avance')
                )
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                    ->where('h.tarea', '=', 'Seguimiento')
                    ->where('h.detalle', '=', 'Concretado')
                    ->where('h.created_at', '>=', $l->inicio)
                    ->where('h.created_at', '<=', $l->fin)
                    ->where('c.st_cliente_id', '=', '4')
                    ->where('p.id', '=', $p->id)
                    ->groupBy('p.id')
                    ->groupBy('p.razon')
                    ->groupBy('p.meta_total')
                    ->first();
                if (is_null($c)) {
                    array_push($gauge, array('id' => $p->id, 'razon' => $p->razon, 'meta_total' => $p->meta_total, 'avance' => 0, 'p_avance' => 0));
                } else {
                    array_push($gauge, $c->toArray());
                }
            }
        }
        */
        /*
         * Fin graficas e velocimetro
         */

        //dd($a_2);
        //dd($gauges);

        $fecha = date('Y-m-d');
        $avisos_generales = PivotAvisoGralEmpleado::where('leido', '=', 0)
            ->where('enviado', '=', 1)
            ->where('empleado_id', '=', $e->id)
            ->get();
        //dd($avisos_generales);
        $fil = array();

        foreach ($lectivosSt2 as $lSt2) {
            $encabezado = ['Estatus', 'Cantidad Total', 'Meta'];
            $datos = array();
            array_push($datos, $encabezado);
            $encabezado = ['Estatus', 'Cantidad Total'];
            $datos2 = array();
            array_push($datos2, $encabezado);
            $mes = (int) date('m');
            $grafica = Seguimiento::select('sts.name as estatus', DB::raw('count(sts.name) as valor'))
                ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                ->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.st_seguimiento_id')
                //->where('mes', '=', $mes)
                ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
                ->where('esp.lectivo_id', '=', $lSt2->id)
                ->where('h.fecha', '>=', $lSt2->inicio)
                ->where('h.fecha', '<=', $lSt2->fin)
                ->where('h.detalle', '=', 'Concretado')
                ->where('h.asunto', '=', 'Cambio estatus ')
                ->where('c.empleado_id', '=', $e->id)
                //->where('c.plantel_id', '=', $e->plantel_id)
                ->where('sts.id', '=', 2)
                ->groupBy('sts.name')
                ->get();
            //dd($grafica);
            foreach ($grafica as $g) {
                if ($g->estatus == "Concretado" and $g->valor > 0) {
                    array_push($datos, array($g->estatus, $g->valor, $e->plantel->meta_venta));
                } else {
                    array_push($datos, array($g->estatus, $g->valor, 0));
                }
            }
            if (count($datos) > 1) {
                array_push($fil, $datos);
            }
        }

        //dd($fil);

        $grafica2 = Seguimiento::select('sts.name as estatus', DB::raw('count(sts.name) as valor'))
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.st_seguimiento_id')
            //->where('mes', '=', $mes)
            ->where('c.empleado_id', '=', $e->id)
            //->where('c.plantel_id', '=', $e->plantel_id)
            ->whereIn('sts.id', [1, 3, 4])
            ->groupBy('sts.name')
            ->get();
        foreach ($grafica2 as $g) {
            array_push($datos2, array($g->estatus, $g->valor));
        }
        //dd($datos2);

        /*
         * Graficas de valores para directores
         */
        $filtros['plantel_f'] = $e->plantel_id;
        //dd($e);
        $f = date("Y-m-d");
        $l = Lectivo::find(0)->first();

        //$lectivosSt2=Lectivo::where('grafica_bnd','=','1')->get();

        $tabla = array();
        $encabezado = array();
        $encabezado[0] = 'Empleado';
        $estatus = StSeguimiento::where('id', '>', 0)->get();
        $empleados = Empleado::where('plantel_id', '=', $filtros['plantel_f'])
            ->where('puesto_id', '=', 2)
            ->where('id', '>', 0)
            ->get();
        //dd($empleados->toArray());
        $i = 1;
        foreach ($estatus as $st) {
            if ($st->id > 0) {
                if ($st->id == 2) {
                    $encabezado[$i] = $st->name . " Trimestre";
                    $i++;
                    $encabezado[$i] = $st->name . " Sabatino";
                    $i++;
                    $encabezado[$i] = $st->name . " Cuatrimestre";
                    $i++;
                } else {
                    $encabezado[$i] = $st->name;
                    $i++;
                }
            }
        }
        array_push($tabla, $encabezado);
        //dd($encabezado);
        foreach ($empleados as $em) {
            $linea = array();
            $i = 0;
            $linea[$i] = $em->nombre . " " . $em->ape_paterno . " " . $em->ape_materno;
            foreach ($estatus as $st) {
                $i++;
                if ($st->id == 2) {

                    foreach ($lectivosSt2 as $lSt2) {
                        $valor = Seguimiento::select(DB::raw('count(st.name) as total'))
                            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                            ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
                            ->whereIn('e.st_empleado_id', array(1, 9))
                            ->where('esp.lectivo_id', '=', $lSt2->id)
                            ->where('st_seguimiento_id', '=', $st->id)
                            ->where('e.id', '=', $em->id)
                            ->where('c.plantel_id', '=', $filtros['plantel_f'])
                            ->where('h.fecha', '>=', $lSt2->inicio)
                            ->where('h.fecha', '<=', $lSt2->fin)
                            ->where('h.detalle', '=', 'Concretado')
                            ->where('h.asunto', '=', 'Cambio estatus ')
                            ->value('total');
                        $linea[$i] = $valor;
                        $i++;
                    }
                    $i--;
                } elseif ($st->id > 0) {
                    $valor = Seguimiento::select(DB::raw('count(st.name) as total'))
                        ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                        ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                        ->where('st_seguimiento_id', '=', $st->id)
                        ->where('e.id', '=', $em->id)
                        ->where('c.plantel_id', '=', $filtros['plantel_f'])
                        ->value('total');
                    //dd('stop fil');
                }
                $linea[$i] = $valor;
            }
            array_push($tabla, $linea);
        }
        //dd($tabla);
        $p = Plantel::find($filtros['plantel_f']);
        $plantel = $p->razon;
        //dd($plantel);

        /*
         * Fin Graficas de valores para directores
         */

        /* tabla de estatus por plantel
         * 
         */
        $estatusPlantel = Seguimiento::select('st.name as estatus', DB::raw('count(st.name) as total'))
            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->where('c.plantel_id', '=', $filtros['plantel_f'])
            ->where('e.id', '>', 0)
            ->where('e.puesto_id', '=', 2)
            ->where('st.id', '>', 0)
            ->groupBy('st.name')
            ->get();
        //dd($estatusPlantel->toArray());
        $tsuma = 0;
        foreach ($estatusPlantel as $ep) {
            $tsuma = $tsuma + $ep->total;
        }
        /* Fin tabla de estatus por plantel
         * 
         */

        /////////////////////////Grficas direccion////////////////////////////

        $lectivoss = Lectivo::where('id', '<', 3)->get();
        $tablass = array();
        $encabezados = array();

        $estatuss = StSeguimiento::where('id', '>', 0)->get();
        //dd($estatuss->toArray());
        /*$is=0;
        foreach($estatuss as $sts){
            if($sts->id>0){
                $encabezados[$is]=$sts->name;
                $is++;
            }
        }*/
        //array_push($encabezados,array('Estatus','Total'));
        //dd($encabezados);
        $lineas = array();
        $is = 0;
        $tabla_estatus = array();
        array_push($tabla_estatus, array('Lectivo', 'Total'));
        foreach ($lectivoss as $ls) {

            unset($tablas);
            $tablas = array();

            $lineas = array();
            array_push($lineas, array('Estatus', 'Total'));
            foreach ($estatuss as $sts) {
                if ($sts->id == 2) {

                    $valors = Seguimiento::select(DB::raw('count(st.name) as total'))
                        ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                        ->join('especialidads as es', 'es.id', '=', 'c.especialidad_id')
                        ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                        ->join('lectivos as l', 'l.id', '=', 'es.lectivo_id')
                        ->where('h.asunto', '=', 'Cambio estatus ')
                        ->where('h.detalle', '=', 'Concretado')
                        ->where('h.fecha', '>=', $ls->inicio)
                        ->where('h.fecha', '<=', $ls->fin)
                        ->where('st_seguimiento_id', '=', $sts->id)
                        ->where('es.lectivo_id', '=', $ls->id)
                        ->value('total');
                    array_push($tabla_estatus, array($ls->name, $valors));
                } elseif ($sts->id > 0) {
                    $valors = Seguimiento::select(DB::raw('count(st.name) as total'))
                        ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                        ->where('st_seguimiento_id', '=', $sts->id)
                        ->value('total');
                    array_push($lineas, array($sts->name, $valors));
                }
                //$lineas[$is]=$valors;

                $is++;
            }
            //dd($lineas);
            array_push($tablas, $lineas);
            //dd($tablas);
            //array_push($tablass, $tablas);
        }
        //dd($tablass[1][0]);
        //dd($tabla_estatus);
        /////////////////////////Fin Grficas direccion////////////////////////////


        //dd($estatusPlantel->toArray());
        //dd($lectivosSt2[0]);
        //$lectivos=Lectivo::where('id','<',3)->get();
        //dd($lectivos);
        //Avisos y tareas de empresas
        $avisosEmpresas = AvisosEmpresa::select(
            'avisos_empresas.empresa_id',
            'a.name',
            'avisos_empresas.detalle',
            'avisos_empresas.fecha',
            Db::Raw('DATEDIFF(avisos_empresas.fecha,CURDATE()) as dias_restantes')
        )
            ->join('asuntos as a', 'a.id', '=', 'avisos_empresas.asunto_id')
            ->join('empresas as e', 'e.id', '=', 'avisos_empresas.empresa_id')
            ->where('avisos_empresas.fecha', '>=', Db::Raw('CURDATE()'))
            ->where('e.empleado_id', '=', $e->id)
            ->get();
        //dd($e);
        //dd($avisosEmpresas->toArray());
        //$tareasEmpresas = TareasEmpresa::where('empresa_id', '=', $empresa->id)->get();

        //Procesos de Beca
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = array();
        foreach ($empleado->plantels as $p) {
            array_push($planteles, $p->id);
        }
        $becas_aux = AutorizacionBeca::select(
            'autorizacion_becas.id',
            'autorizacion_becas.cliente_id as cliente',
            'autorizacion_becas.solicitud',
            'autorizacion_becas.created_at',
            'acp.name as aut_caja_plantel',
            'adp.name as aut_dir_plantel',
            'acc.name as aut_caja_corp',
            'ase.name as aut_ser_esc',
            'ad.name as aut_dueno'
        )
            //->where('autorizacion_becas.usu_alta_id',Auth::user()->id)
            //->leftJoin('autorizacion_beca_comentarios as c','c.autorizacion_beca_id','=','autorizacion_becas.id')
            ->join('clientes as cli', 'cli.id', '=', 'autorizacion_becas.cliente_id')
            //->join('st_becas as st','st.id','=','c.st_beca_id')
            ->leftJoin('st_becas as acp', 'acp.id', '=', 'autorizacion_becas.aut_caja_plantel')
            ->leftJoin('st_becas as adp', 'adp.id', '=', 'autorizacion_becas.aut_dir_plantel')
            ->leftJoin('st_becas as acc', 'acc.id', '=', 'autorizacion_becas.aut_caja_corp')
            ->leftJoin('st_becas as ase', 'ase.id', '=', 'autorizacion_becas.aut_ser_esc')
            ->leftJoin('st_becas as ad', 'ad.id', '=', 'autorizacion_becas.aut_dueno')
            ->where('autorizacion_becas.id', '>', 560)
            ->whereRaw('(aut_caja_plantel <> 4 or aut_dir_plantel<> 4 or aut_caja_corp<> 4 or aut_ser_esc<> 4 or aut_dueno<> 4)');
        if (Auth::user()->can('autorizacionBecas.filtroPlantels')) {
            $becas_aux->whereIn('cli.plantel_id', $planteles);
        }
        //->whereNull('c.bnd_visto')
        $becas = $becas_aux->get();
        //dd($becas);



        $autorizacionBajas = HistoriaCliente::select('historia_clientes.*', 'c.plantel_id')
            ->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
            ->where('historia_clientes.id', '>', 1011)
            ->whereNotIn('st_historia_cliente_id', array(0, 2))
            ->where('evento_cliente_id', 2)
            ->whereRaw('(aut_ser_esc <> 2 or aut_caja <> 2 or aut_ser_esc_corp <>2) ');

        if (Auth::user()->can('autorizacionBajas.filtroPlantels')) {
            $autorizacionBajas->whereIn('c.plantel_id', $planteles);
        }
        //dd(Auth::user()->can('aut_ser_esc'));
        //if (Auth::user()->can('autorizacionBaja.aut_servicios_escolares')) {
        //$autorizacionBajas->orWhere('aut_ser_esc', '<>', 2);
        //}
        //if (Auth::user()->can('autorizacionBaja.aut_caja')) {
        //$autorizacionBajas->orWhere('aut_caja', '<>', 2);
        //}
        //if (Auth::user()->can('autorizacionBaja.aut_servicios_escolares_c')) {
        //$autorizacionBajas->orWhere('aut_ser_esc_cor', '<>', 2);
        //}
        $bajas = $autorizacionBajas->get();
        //dd($bajas->toArray());
        $plantels = Plantel::where('id', '>', 1)->get();

        return view('home', compact(
            'avisos',
            'a_1',
            'a_2',
            'a_3',
            'a_4',
            'a_5',
            'grafica2',
            'grafica',
            'fil',
            'lectivosSt2',
            'avisosEmpresas',
            'avisos_generales',
            'avance',
            //'gauge',
            'tabla',
            'plantel',
            'estatusPlantel',
            'tsuma',
            'lectivoss',
            'becas',
            'bajas',
            'plantels'
        ))
            ->with('datos_grafica', json_encode($tabla))
            ->with('datos', json_encode($datos))
            ->with('datos2', json_encode($datos2))
            ->with('grfDir1', json_encode($lineas))
            ->with('grfDir2', json_encode($tabla_estatus));
    }

    public function grfEstatusXEmpleado()
    {
        $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $mes = (int) date('m');
        return $grafica = Seguimiento::select('sts.name as Estatus', DB::raw('count(sts.name) as Valor'))
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.st_seguimiento_id')
            //->where('mes', '=', $mes)
            ->where('c.empleado_id', '=', $e->id)
            ->where('c.plantel_id', '=', $e->plantel_id)
            ->groupBy('sts.name')
            ->get()->toJson();
    }

    public function armaMenuPrimario($padre = 1)
    {
        //$menu=$this->menuRepository->search(array('padre'=>$padre));
        //$usuario_actual=User::find(Auth::user()->id)->is('admin');
        $menu = Menu::where('padre', $padre)
            ->where('activo', true)
            ->orderBy('prioridad', 'asc')->get();

        //dd($menu);

        if (!empty($menu)) {
            //dd($menu);
            foreach ($menu as $item) {
                //$permiso=User::find(Auth::user()->id)->can($item->permiso);

                if ($item->permiso <> "home") {
                    $permiso = Auth::user()->can($item->permiso);
                } else {
                    $permiso = true;
                }
                $link = route($item->link);
                //dd($permiso);
                if ($permiso and $item->activo == 1 and $item->parametros == "_blank") {
                    $this->menuArmado = $this->menuArmado . "<li class='active'><a href='" . $link . "' target='" . $item->parametros . "'><i class='" . $item->imagen . "'></i><span>" . $item->item . "</span></a></li>";
                }
            }
        }

        //dd($this->menuArmado);
        return $this->menuArmado;
    }

    public function armaMenu($padre = 1)
    {
        if (session()->has('menu')) {
            return session('menu');
        } else {
            $m = $this->armaMenuPrincipal();
            session(['menu' => $m]);

            //dd($this->menuArmado);
            return session('menu');
            //return $this->menuArmado;
        }
    }
    public function armaMenu2($padre = 43)
    {
        if (session()->has('menu2')) {
            //Log::info(session('menu2'));
            return session('menu2');
        } else {
            $m = $this->armaMenuPrincipal($padre);
            session(['menu2' => $m]);

            //dd($this->menuArmado);
            return session('menu2');
            //return $this->menuArmado;
        }
    }

    public function armaMenuPrincipal($padre = 1)
    {

        //$menu=$this->menuRepository->search(array('padre'=>$padre));
        //$usuario_actual=User::find(Auth::user()->id)->is('admin');
        $menu = Menu::where('padre', $padre)
            ->where('activo', true)
            ->orderBy('prioridad', 'asc')->get();

        //dd($menu);

        if (!empty($menu)) {
            //dd($menu);
            foreach ($menu as $item) {
                //$permiso=User::find(Auth::user()->id)->can($item->permiso);

                if ($item->permiso <> "home" and $item->permiso <> "logout") {

                    $permiso = Auth::user()->can($item->permiso);
                } else {
                    //dd($item->permiso);
                    $permiso = true;
                }
                $link = route($item->link);
                //dd($permiso);
                if ($permiso and $item->activo == 1) {
                    //dd($item->id);
                    $r = intval($this->tieneItems($item->id));
                    //dd(action($item->link));

                    if ($r == 1) {
                        $this->menuArmado = $this->menuArmado . "<li class='treeview'>
									                <a href=' " . $link . " '>
														<i class='" . $item->imagen . "'></i><span>" . $item->item . "</span> <i class='fa fa-angle-left pull-right'></i>
													</a>
									                <ul class='treeview-menu'>";
                        $this->menuArmado = $this->armaMenuPrincipal($item->id);
                        $this->menuArmado = $this->menuArmado . "</ul></li>";
                    } else {
                        //dd($this->menuArmado);
                        $this->menuArmado = $this->menuArmado . "<li class='active'><a href='" . $link . "'><i class='" . $item->imagen . "'></i><span>" . $item->item . "</span></a></li>";
                    }
                    //Log::info($this->menuArmado);
                }
            }
            return $this->menuArmado;
        }


        //dd($this->menuArmado);

        //return $this->menuArmado;

    }

    public function tieneItems($padre)
    {
        $menu = Menu::where('padre', $padre)->where('activo', true)->count();

        //dd($menu);
        if ($menu == 0) {
            return -1;
        } else {
            return 1;
        }
    }

    public function WidgetsMetaEspecialidad()
    {
        $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $planteles = array();
        foreach ($e->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }
        if (!Auth::user()->can('WgaugesXplantelIndividual')) {
            $planteles = DB::table('plantels')->where('id', '>', 0)->get();
        } else {
            $planteles = DB::table('plantels')->where('id', '>', 0)->whereIn('id', $planteles)->get();
        }

        //dd($planteles);
        $gauge = array();
        foreach ($planteles as $plantel) {
            //Log::info("plantel:".$plantel->id);
            $especialidades = DB::table('especialidads')
                ->where('id', '>', 0)
                ->where('especialidads.plantel_id', '=', $plantel->id)
                ->get();
            //dd($especialidades);

            $empleados = DB::table('empleados')
                ->where('plantel_id', '=', $plantel->id)
                ->where('puesto_id', '=', 2)
                ->get();

            //dd($empleados);


            $fecha = date('Y-m-d');
            foreach ($especialidades as $especialidad) {
                //Log::info("especialidad:".$especialidad->id);
                $lectivo = array();
                if ($especialidad->bnd_usar_lectivo == 1) {
                    $lectivo = DB::table('lectivos')
                        ->where('inicio', '<=', $fecha)
                        ->where('fin', '>=', $fecha)
                        ->where('id', '>', 0)
                        ->where('carrera_bnd', '=', 1)
                        ->first();
                }
                //dd($lectivo);
                //Log::info($lectivo);
                $i = 0;
                foreach ($empleados as $empleado) {
                    $cs = Seguimiento::select(
                        DB::raw('concat(p.id,e.id,emp.id) as id'),
                        'p.razon',
                        'e.name as especialidad',
                        'l.fin',
                        DB::raw('concat(emp.nombre, " ", emp.ape_paterno, " ", emp.ape_materno) as empleado'),
                        'e.meta',
                        'p.id as plantel_id',
                        'e.id as especialidad_id',
                        'emp.id as empleado_id',
                        DB::raw('count(c.nombre) as avance'),
                        DB::raw('((count(c.nombre)*100)/e.meta) as p_avance')
                    )
                        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                        ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                        ->join('plantels as p', 'p.id', '=', 'cc.plantel_id')
                        ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
                        ->join('lectivos as l', 'l.id', '=', 'e.lectivo_id')
                        ->join('empleados as emp', 'emp.id', '=', 'c.empleado_id')
                        ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                        ->where('h.tarea', '=', 'Seguimiento')
                        ->where('h.detalle', '=', 'Concretado')
                        ->where('cc.bnd_inscrito', '=', 1)
                        ->whereColumn('h.created_at', '>=', 'l.inicio')
                        ->whereColumn('h.created_at', '<=', 'l.fin')
                        ->where('e.id', '=', $especialidad->id)
                        ->where('emp.id', '=', $empleado->id)
                        ->where('c.st_cliente_id', '=', '4')
                        ->groupBy('p.id')
                        ->groupBy('e.id')
                        ->groupBy('emp.id')
                        ->groupBy('p.razon')
                        ->groupBy('e.name')
                        ->groupBy('e.meta')
                        ->groupBy('l.fin')
                        ->groupBy('emp.nombre')
                        ->groupBy('emp.ape_paterno')
                        ->groupBy('emp.ape_materno')
                        ->first();


                    /*$cs=Seguimiento::select(DB::raw('concat(p.id,e.id,emp.id) as id'),
                                'p.razon', 'e.name as especialidad', 'l.fin',
                            DB::raw('concat(emp.nombre, " ", emp.ape_paterno, " ", emp.ape_materno) as empleado'),
                            'e.meta', 'p.id as plantel_id', 'e.id as especialidad_id', 'emp.id as empleado_id',
                            DB::raw('count(c.nombre) as avance'), DB::raw('((count(c.nombre)*100)/e.meta) as p_avance'))
                            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                            ->join('especialidads as e', 'e.id', '=', 'c.especialidad_id')
                            ->join('lectivos as l', 'l.id', '=', 'e.lectivo_id')
                            ->join('empleados as emp', 'emp.id', '=', 'c.empleado_id')
                            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                            ->where('h.tarea', '=', 'Seguimiento')
                            ->where('h.detalle', '=', 'Concretado')
                            ->whereColumn('h.created_at', '>=', 'l.inicio')
                            ->whereColumn('h.created_at', '<=', 'l.fin')
                            ->where('e.id', '=', $especialidad->id)
                            ->where('emp.id', '=', $empleado->id)
                            ->where('c.st_cliente_id', '=', '4')
                            ->groupBy('p.id')
                            ->groupBy('e.id')
                            ->groupBy('emp.id')
                            ->groupBy('p.razon')
                            ->groupBy('e.name')
                            ->groupBy('e.meta')
                            ->groupBy('l.fin')
                            ->groupBy('emp.nombre')
                            ->groupBy('emp.ape_paterno')
                            ->groupBy('emp.ape_materno')
                            ->first();
                    */
                    //dd($cs->toArray());
                    if (!is_null($cs)) {
                        array_push($gauge, $cs->toArray());
                    }
                }
            }
        }
        //dd($gauge);
        return view('gauges_especialidad', compact('gauge'));
    }

    public function tieneAvisos()
    {
        $total_msj = 0;
        $id = Auth::user()->id;
        if (isset($id)) {
            $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            $avisos_generales = PivotAvisoGralEmpleado::where('leido', '=', 0)
                ->where('enviado', '=', 1)
                ->where('empleado_id', '=', $e->id)
                ->get();

            foreach ($avisos_generales as $ag) {
                $total_msj++;
            }
        }
        return $total_msj;
    }

    public function wConcretados(Request $request)
    {

        $datos = $request->all();

        $gauge = array();
        $l = Lectivo::find(0)->first();
        //dd($l);
        $plantel = DB::table('plantels as p')->where('id', '>', 0)->where('id', '=', $datos['plantel'])
            ->select('razon', 'id', 'meta_total')->first();

        $c = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            DB::raw('count(c.nombre) as avance'),
            DB::raw('((count(c.nombre)*100)/p.meta_total) as p_avance')
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->groupBy('p.id')
            ->groupBy('p.razon')
            ->groupBy('p.meta_total')
            ->first();

        if (is_null($c)) {
            array_push(
                $gauge,
                array(
                    'id' => $plantel->id, 'razon' => $plantel->razon, 'meta_total' => $plantel->meta_total,
                    'avance' => 0, 'p_avance' => 0, 'inicio' => $l->inicio, 'fin' => $l->fin
                )
            );
        } else {
            //array_push($gauge, $c->toArray());
            array_push(
                $gauge,
                array(
                    'id' => $plantel->id, 'razon' => $plantel->razon, 'meta_total' => $plantel->meta_total,
                    'avance' => $c->avance, 'p_avance' => round($c->p_avance, 2), 'inicio' => $l->inicio, 'fin' => $l->fin
                )
            );
        }

        echo json_encode($gauge);
    }

    public function wConcretadosDetalle(Request $request)
    {

        $datos = $request->all();

        $gauge_corto = array();
        $gauge_largo = array();
        $l = Lectivo::find(0)->first();
        //dd($l);
        $plantel = DB::table('plantels as p')->where('id', '>', 0)->where('id', '=', $datos['plantel'])
            ->select('razon', 'id', 'meta_total')->first();

        $c = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            DB::raw('count(c.nombre) as avance'),
            DB::raw('((count(c.nombre)*100)/p.meta_total) as p_avance')
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->groupBy('p.id')
            ->groupBy('p.razon')
            ->groupBy('p.meta_total')
            ->first();
        $detalle1 = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            'seguimientos.cliente_id',
            'h.fecha',
            'h.hora'
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->orderBy('p.id')
            ->orderBy('p.razon')
            //->groupBy('p.id')
            //->groupBy('p.razon')
            //->groupBy('p.meta_total')
            ->get();

        //dd($detalle1->toArray());

        $resumenCorto = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            DB::raw('count(c.nombre) as avance'),
            DB::raw('((count(c.nombre)*100)/p.meta_total) as p_avance')
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->where('n.bnd_corto', 1)
            ->where('cc.plan_pago_id', '>', 0)
            ->where('cc.cuenta_ticket_pago', '>', 0)
            ->whereNull('cc.deleted_at')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->groupBy('p.id')
            ->groupBy('p.razon')
            ->groupBy('p.meta_total')
            ->first();

        $detalleCorto = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            'seguimientos.cliente_id',
            'h.fecha',
            'h.hora'
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->where('n.bnd_corto', 1)
            ->where('cc.plan_pago_id', '>', 0)
            ->where('cc.cuenta_ticket_pago', '>', 0)
            ->whereNull('cc.deleted_at')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->orderBy('p.id')
            ->orderBy('p.razon')
            ->get();
        //dd($detalleCorto->toArray());
        $resumenLargo = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            DB::raw('count(c.nombre) as avance'),
            DB::raw('((count(c.nombre)*100)/p.meta_total) as p_avance')
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->where('n.bnd_corto', 0)
            ->where('cc.plan_pago_id', '>', 0)
            ->where('cc.cuenta_ticket_pago', '>', 0)
            ->whereNull('cc.deleted_at')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->groupBy('p.id')
            ->groupBy('p.razon')
            ->groupBy('p.meta_total')
            ->first();
        //dd($resumenLargo);
        $detalleLargo = Seguimiento::select(
            'p.id',
            'p.razon',
            'p.meta_total',
            'seguimientos.cliente_id',
            'h.fecha',
            'h.hora'
        )
            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->where('n.bnd_corto', 0)
            ->where('cc.plan_pago_id', '>', 0)
            ->where('cc.cuenta_ticket_pago', '>', 0)
            ->whereNull('cc.deleted_at')
            ->where('h.tarea', '=', 'Seguimiento')
            ->where('h.detalle', '=', 'Concretado')
            ->where('h.created_at', '>=', $l->inicio)
            ->where('h.created_at', '<=', $l->fin)
            ->where('seguimientos.st_seguimiento_id', '=', '2')
            ->where('p.id', '=', $plantel->id)
            ->orderBy('p.id')
            ->orderBy('p.razon')
            ->get();

        if (is_null($resumenCorto)) {
            array_push(
                $gauge_corto,
                array(
                    'id' => $plantel->id, 'razon' => $plantel->razon, 'meta_total' => $plantel->meta_total,
                    'avance' => 0, 'p_avance' => 0, 'inicio' => $l->inicio, 'fin' => $l->fin
                )
            );
        } else {
            array_push(
                $gauge_corto,
                array(
                    'id' => $plantel->id, 'razon' => $plantel->razon, 'meta_total' => $plantel->meta_total,
                    'avance' => $resumenCorto->avance, 'p_avance' => round($resumenCorto->p_avance, 2), 'inicio' => $l->inicio, 'fin' => $l->fin
                )
            );
        }

        if (is_null($resumenLargo)) {
            array_push(
                $gauge_largo,
                array(
                    'id' => $plantel->id, 'razon' => $plantel->razon, 'meta_total' => $plantel->meta_total,
                    'avance' => 0, 'p_avance' => 0, 'inicio' => $l->inicio, 'fin' => $l->fin
                )
            );
        } else {
            array_push(
                $gauge_largo,
                array(
                    'id' => $plantel->id, 'razon' => $plantel->razon, 'meta_total' => $plantel->meta_total,
                    'avance' => $resumenLargo->avance, 'p_avance' => round($resumenLargo->p_avance, 2), 'inicio' => $l->inicio, 'fin' => $l->fin
                )
            );
        }
        //dd($gauge_largo[0]);

        return view('wConcretadosDetalle')
            ->with('detalle1', $detalle1)
            ->with('detalleCorto', $detalleCorto)
            ->with('resumenCorto', $gauge_corto[0])
            ->with('detalleLargo', $detalleLargo)
            ->with('resumenLargo', $gauge_largo[0]);
    }
}
