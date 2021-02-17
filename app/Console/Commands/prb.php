<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Grado;
use DB;

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
        $grado=Grado::find(10);
        dd($grado->total_relaciones);
        

        
        /*
        $tablas = array(
            'actividad_empresas',
            'actividad_empresas_empresas',
            'adeudos',
            'alumnos',
            'apples',
            'areas',
            'articulos',
            'asignacion_academicas',
            'asignacion_tareas',
            'asistencia_rs',
            'asistencias_cs',
            'asuntos',
            'autorizacion_beca_comentarios',
            'autorizacion_becas',
            'aviso_grals',
            'avisos',
            'avisos_empresas',
            'avisos_inicios',
            'banderas',
            'caja_conceptos',
            'caja_lns',
            'cajas',
            'calendario_evaluacions',
            'calificacion_ponderacions',
            'calificacions',
            'cambio_st_seguimientos',
            'carga_ponderacions',
            'categoria_articulos',
            'ccuestionario_datos',
            'ccuestionario_respuesta',
            'ccuestionarios',
            'ciclos',
            'clientes',
            'combinacion_clientes',
            'combinacion_empresas',
            'comen_muebles',
            'consulta_calificacions',
            'correos',
            'cotizacion_cursos',
            'cotizacion_lns',
            'cuenta_contables',
            'cuentas_efectivo_plantels',
            'cuentas_efectivos',
            'cuestionario_datos',
            'cuestionario_preguntas',
            'cuestionario_respuestas',
            'cuestionarios',
            'cursos',
            'cursos_empresas',
            'dia_no_habils',
            'dias',
            'diplomados',
            'doc_alumnos',
            'doc_empleados',
            'doc_plantel_plantels',
            'doc_plantels',
            'doc_vinculacion_vinculacions',
            'doc_vinculacions',
            'ebanxes',
            'egresos',
            'egresos_conceptos',
            'empleados',
            'empresas',
            'entrada_salidas',
            'escolaridads',
            'especialidads',
            'est_asistencias',
            'estados',
            'evento_clientes',
            'existencia',
            'factura_cotizacions',
            'forma_pagos',
            'frequency_parameters',
            'giros',
            'grados',
            'grupo_periodo_estudios',
            'grupos',
            'h_cuentas_efectivos',
            'h_estatuses',
            'hacademicas',
            'hactividades',
            'histori_cliente_inscripcions',
            'historia_clientes',
            'historia_eventos',
            'historials',
            'horarios',
            'hs_seguimientos',
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
            'movimientos',
            'muebles',
            'municipios',
            'nivels',
            'oferta',
            'otros',
            'pagos',
            'pagos_lectivos',
            'pagos_lectivos_lns',
            'paises',
            'params',
            'periodo_estudios',
            'periodo_examens',
            'periodo_materium',
            'periodos',
            'permissions',
            'pivot_aviso_gral_empleados',
            'pivot_doc_clientes',
            'pivot_doc_empleados',
            'plan_campo_filtros',
            'plan_condicion_filtros',
            'plan_pago_ln_regla_recargo',
            'plan_pago_lns',
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
            'promo_plan_lns',
            'promocions',
            'puestos',
            'registro_historia_clientes',
            'regla_recargos',
            'roles',
            'salons',
            'segmento_mercados',
            'seguimiento_tareas',
            'seguimientos',
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
            'st_seguimientos',
            'st_tareas',
            'st_vinculacions',
            'subcursos',
            'subdiplomados',
            'subotros',
            'tareas',
            'tareas_empresas',
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
            'vinculacion_horas',
            'vinculacions'
        );
        $registrosCero = array();
        foreach ($tablas as $tabla) {
            if ($tabla <> 'role_user') {
                $r = DB::table($tabla)->where('id', 0)->first();
                if (!is_null($r)) {
                    array_push($registrosCero, $tabla);
                }
            }
        }
        dd($registrosCero);
        */
    }
}
