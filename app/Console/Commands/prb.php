<?php

namespace App\Console\Commands;

use DB;
use App\Grado;
use App\Materium;
use App\Hacademica;
use App\Calificacion;
use App\CargaPonderacion;
use App\PeticionMultipago;
use Illuminate\Console\Command;
use App\CalificacionPonderacion;
use Illuminate\Support\Facades\Auth;
use App\Observers\PeticionMultipagoObserver;

class prb extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:prb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*$peticion=PeticionMultipago::find(1);
        $peticion->mp_amount=$peticion->mp_amount+1;
        $peticion->save();*/


        /*
        Crea ponderaciones de calificaicon
        $materia = Materium::find(3426);
        $materias_validar = Hacademica::whereIn(
                'id', array(
                47645,
                47655,
                47675,
                47685,
                47695,
                47715,
                47725,
                47745,
                47765,
                47775,
                47805,
                47815,
                47835,
                47855,
                47875,
                47885,
                47895,
                47915,
                47925,
                47935,
                47955)
            )
            ->get();

        
        foreach ($materias_validar as $mv) {

            $c['hacademica_id'] = $mv->id;
            $c['tpo_examen_id'] = 1;
            $c['calificacion'] = 0;
            $c['fecha'] = date('Y-m-d');
            $c['reporte_bnd'] = 0;
            $c['usu_alta_id'] = 1;
            $c['usu_mod_id'] = 1;
            $calif = Calificacion::create($c);

            $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $materia->ponderacion_id)
                ->where('bnd_activo', 1)
                ->get();
          
            foreach ($ponderaciones as $p) {
                $ponde['calificacion_id'] = $calif->id;
                $ponde['carga_ponderacion_id'] = $p->id;
                $ponde['calificacion_parcial'] = 0;
                $ponde['ponderacion'] = $p->porcentaje;
                $ponde['usu_alta_id'] = 1;
                $ponde['usu_mod_id'] = 1;
                $ponde['tiene_detalle'] = $p->tiene_detalle;
                $ponde['padre_id'] = $p->padre_id;
                CalificacionPonderacion::create($ponde);
            }
        }
        */


        
        $tablas = array(
            'acta_finals',
'actividad_empresas',
'actividad_empresas_empresas',
'adeudo_pago_on_lines',
'adeudos',
'alumnos',
'alumnos_activos',
'apples',
'areas',
'articulos',
'asignacion_academicas',
'asignacion_tareas',
'asistencia_rs',
'asistencias_cs',
'asunto3s',
'asunto_prb2s',
'asuntos',
'autorizacion_beca_comentarios',
'autorizacion_becas',
'avances_tickets',
'aviso_grals',
'avisos',
'avisos_empresas',
'avisos_inicios',
'bandeja_adjuntos',
'bandejas',
'banderas',
'bs_bajas',
//'caja_concepto_regla_recargo',
'caja_conceptos',
'caja_cortes',
'caja_lns',
'cajas',
'calendario_evaluacions',
'calificacion_ponderacions',
'calificacions',
'cambio_st_seguimientos',
'carga_ponderacions',
'categoria_articulos',
'categoria_tickets',
'ccuestionario_datos',
'ccuestionario_pregunta',
'ccuestionario_respuesta',
'ccuestionarios',
'ciclo_matriculas',
'ciclos',
'clasificacions',
'clientes',
'combinacion_clientes',
'combinacion_empresas',
'comen_muebles',
//'concepto_multipago_plantel',
'concepto_multipagos',
'conciliacion_multi_detalles',
'conciliacion_multipagos',
'consecutivo_matriculas',
'consulta_calificacions',
'correos',
'cotizacion_cursos',
'cotizacion_lns',
'cp_sats',
'cuenta_contables',
'cuenta_ps',
'cuentas_efectivo_plantels',
'cuentas_efectivos',
'cuestionario_datos',
'cuestionario_preguntas',
'cuestionario_respuestas',
'cuestionarios',
'cursos',
'cursos_empresas',
'descuentos',
'dia_no_habils',
'dias',
'diplomados',
'discapacidads',
'doc_alumnos',
'doc_empleados',
'doc_plantel_plantels',
'doc_plantels',
'doc_vinculacion_vinculacions',
'doc_vinculacions',
'ebanxes',
'egresos',
'egresos_conceptos',
//'empleado_plantel',
'empleados',
'empresas',
'entrada_salidas',
'escolaridads',
'especialidads',
'est_asistencias',
'estado_civils',
'estados',
//'etiquetas_ticket_ticket',
'etiquetas_tickets',
'evento_clientes',
'existencia',
'factura_cotizacions',
'factura_general_lineas',
'factura_generals',
'fail_multipagos',
//'forma_pago_plantel',
'forma_pagos',
'frequency_parameters',
'giros',
'grados',
'grupo_periodo_estudios',
'grupos',
'h_asistencia_rs',
'h_calif_ponderacions',
'h_calificacions',
'h_cuentas_efectivos',
'h_estatuses',
'h_peticions',
'h_st_prospectos',
'hacademicas',
'hactividades',
'hadeudos',
'histori_cliente_inscripcions',
'historia_clientes',
'historia_eventos',
'historials',
'horarios',
'hs_seguimientos',
'imagenes_avances_tickets',
'imagenes_tickets',
'impresion_lista_asistens',
'impresion_tickets',
'incidence_clientes',
'incidences_clientes',
'ingreso_egresos',
'inscripcions',
'interes_estudios',
'jornadas',
'lectivos',
'materia',
'materium_periodos',
'medios',
'menus',
'mese',
'migrations',
'modulos',
'moodle_bajas',
'motivo_becas',
'movimientos',
'muebles',
'municipios',
'nivel_educativo_sats',
'nivel_estudios',
'nivels',
'oferta',
'otros',
'pagadors',
'pagos',
'paises',
'params',
//'password_resets',
'periodo_estudios',
'periodo_examens',
'periodo_materium',
'periodos',
//'permission_role',
'permissions',
'peticion_multipagos',
'pivot_aviso_gral_empleados',
'pivot_doc_clientes',
'pivot_doc_empleados',
'plan_campo_filtros',
'plan_condicion_filtros',
'plan_estudios',
'plan_pago_ln_regla_recargo',
'plan_pago_lns',
//'plan_pago_turno',
'plan_pagos',
'plantels',
'plantilla_empresa_campos',
'plantilla_empresa_conds',
'plantilla_empresas',
'plantillas',
'plantillas_especialidad',
'plantillas_estatus',
'ponderacions',
'pregunta',
'pregunta_clientes',
'prioridad_tickets',
'promo_plan_lns',
'promocions',
'prospectos',
'puestos',
'registro_historia_clientes',
'regla_recargos',
'role_user',
'roles',
'salons',
'seccions',
'segmento_mercados',
'seguimiento_tareas',
'seguimientos',
'serie_folio_simplificados',
'sessions',
'sms',
'sms_predefinidos',
'st_alumnos',
'st_autorizacion_becas',
'st_becas',
'st_cajas',
'st_clientes',
'st_cuestionarios',
'st_curso_empresas',
'st_empleados',
'st_empresas',
'st_historia_clientes',
'st_inscripcions',
'st_materias',
'st_mueble_usos',
'st_muebles',
'st_plantels',
'st_prospectos',
'st_seguimientos',
'st_tareas',
'st_tickets',
'st_vinculacions',
'subcursos',
'subdiplomados',
'subotros',
'success_multipagos',
'tareas',
'tareas_empresas',
'task_frequencies',
'task_results',
'tasks',
'tickets',
'tipo_becas',
'tipo_contratos',
'tipo_personas',
'tipo_precio_cotis',
'tipo_reglas',
'tpo_articulos',
'tpo_correos',
'tpo_examens',
'tpo_informes',
'tpo_plantels',
'transferences',
'turnos',
'ubicacion_arts',
'unidad_usos',
'users',
'uso_facturas',
'usuario_clientes',
'vinculacion_horas',
'vinculacions'
        );
        $registrosCero = array();
        foreach ($tablas as $tabla) {
            if ($tabla <> 'role_user' and 
                $tabla <> 'caja_concepto_recla_recargo') {
                $r = DB::table($tabla)->where('id', 0)->first();
                if (!is_null($r)) {
                    array_push($registrosCero, $tabla);
                }
            }
        }
        dd($registrosCero);
        
    }
}
