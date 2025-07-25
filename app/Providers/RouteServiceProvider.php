<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
		Route::model('apples', 'App\Apple');// generated by scaffold - Apple
		Route::model('menus', 'App\Menu');// generated by scaffold - Menu
		Route::model('banderas', 'App\Bandera');// generated by scaffold - Bandera
		Route::model('lectivos', 'App\Lectivo');// generated by scaffold - Lectivo
		Route::model('menus', 'App\Menu');// generated by scaffold - Menu
		Route::model('plantels', 'App\Plantel');// generated by scaffold - Plantel
		Route::model('banderas', 'App\Bandera');// generated by scaffold - Bandera
		Route::model('lectivos', 'App\Lectivo');// generated by scaffold - Lectivo
		Route::model('plantels', 'App\Plantel');// generated by scaffold - Plantel
		Route::model('areas', 'App\Area');// generated by scaffold - Area
		Route::model('puestos', 'App\Puesto');// generated by scaffold - Puesto
		Route::model('stPuestos', 'App\StPuesto');// generated by scaffold - StPuesto
		Route::model('empleados', 'App\Empleado');// generated by scaffold - Empleado
		Route::model('stEmpleados', 'App\StEmpleado');// generated by scaffold - StEmpleado
		Route::model('stClientes', 'App\StCliente');// generated by scaffold - StCliente
		Route::model('ofertas', 'App\Ofertum');// generated by scaffold - Ofertum
		Route::model('medios', 'App\Medio');// generated by scaffold - Medio
		Route::model('tareas', 'App\Tarea');// generated by scaffold - Tarea
		Route::model('estados', 'App\Estado');// generated by scaffold - Estado
		Route::model('municipios', 'App\Municipio');// generated by scaffold - Municipio
		Route::model('clientes', 'App\Cliente');// generated by scaffold - Cliente
		Route::model('preguntas', 'App\Preguntum');// generated by scaffold - Preguntum
		Route::model('preguntaClientes', 'App\PreguntaCliente');// generated by scaffold - PreguntaCliente
		Route::model('periodos', 'App\Periodo');// generated by scaffold - Periodo
		Route::model('plantillas', 'App\Plantilla');// generated by scaffold - Plantilla
		Route::model('nivels', 'App\Nivel');// generated by scaffold - Nivel
		Route::model('grados', 'App\Grado');// generated by scaffold - Grado
		Route::model('cursos', 'App\Curso');// generated by scaffold - Curso
		Route::model('subcursos', 'App\Subcurso');// generated by scaffold - Subcurso
		Route::model('diplomados', 'App\Diplomado');// generated by scaffold - Diplomado
		Route::model('subdiplomados', 'App\Subdiplomado');// generated by scaffold - Subdiplomado
		Route::model('otros', 'App\Otro');// generated by scaffold - Otro
		Route::model('subotros', 'App\Subotro');// generated by scaffold - Subotro
		Route::model('promocions', 'App\Promocion');// generated by scaffold - Promocion
		Route::model('tpoCorreos', 'App\TpoCorreo');// generated by scaffold - TpoCorreo
		Route::model('sms', 'App\Sm');// generated by scaffold - Sm
		Route::model('correos', 'App\Correo');// generated by scaffold - Correo
		Route::model('params', 'App\Param');// generated by scaffold - Param
		Route::model('stTareas', 'App\StTarea');// generated by scaffold - StTarea
		Route::model('asignacionTareas', 'App\AsignacionTarea');// generated by scaffold - AsignacionTarea
		Route::model('seguimientoTareas', 'App\SeguimientoTarea');// generated by scaffold - SeguimientoTarea
		Route::model('asuntos', 'App\Asunto');// generated by scaffold - Asunto
		Route::model('tpoPlantels', 'App\TpoPlantel');// generated by scaffold - TpoPlantel
		Route::model('especialidads', 'App\Especialidad');// generated by scaffold - Especialidad
		Route::model('seguimientos', 'App\Seguimiento');// generated by scaffold - Seguimiento
		Route::model('stSeguimientos', 'App\StSeguimiento');// generated by scaffold - StSeguimiento
		Route::model('avisos', 'App\Aviso');// generated by scaffold - Aviso
		Route::model('cambioStSeguimientos', 'App\CambioStSeguimiento');// generated by scaffold - CambioStSeguimiento
		Route::model('avisoGrals', 'App\AvisoGral');// generated by scaffold - AvisoGral
		Route::model('avisoGrals', 'App\AvisoGral');// generated by scaffold - AvisoGral
		Route::model('docEmpleados', 'App\DocEmpleado');// generated by scaffold - DocEmpleado
		Route::model('pivotDocEmpleados', 'App\PivotDocEmpleado');// generated by scaffold - PivotDocEmpleado
		Route::model('pivotAvisoGralEmpleados', 'App\PivotAvisoGralEmpleado');// generated by scaffold - PivotAvisoGralEmpleado
		Route::model('asuntos', 'App\Asunto');// generated by scaffold - Asunto
		Route::model('alumnos', 'App\Alumno');// generated by scaffold - Alumno
		Route::model('jornadas', 'App\Jornada');// generated by scaffold - Jornada
		Route::model('salons', 'App\Salon');// generated by scaffold - Salon
		Route::model('periodos', 'App\Periodo');// generated by scaffold - Periodo
		Route::model('periodoEstudios', 'App\PeriodoEstudio');// generated by scaffold - PeriodoEstudio
		Route::model('grupos', 'App\Grupo');// generated by scaffold - Grupo
		Route::model('materias', 'App\Materium');// generated by scaffold - Materium
		Route::model('stAlumnos', 'App\StAlumno');// generated by scaffold - StAlumno
		Route::model('inscripcions', 'App\Inscripcion');// generated by scaffold - Inscripcion
		Route::model('docAlumnos', 'App\DocAlumno');// generated by scaffold - DocAlumno
		Route::model('stPlantels', 'App\StPlantel');// generated by scaffold - StPlantel
		Route::model('dias', 'App\Dium');// generated by scaffold - Dium
		Route::model('asignacionAcademicas', 'App\AsignacionAcademica');// generated by scaffold - AsignacionAcademica
		Route::model('horarios', 'App\Horario');// generated by scaffold - Horario
		Route::model('stMaterias', 'App\StMateria');// generated by scaffold - StMateria
		Route::model('tpoExamens', 'App\TpoExamen');// generated by scaffold - TpoExaman
		Route::model('hacademicas', 'App\Hacademica');// generated by scaffold - Hacademica
		Route::model('calificacions', 'App\Calificacion');// generated by scaffold - Calificacion
		Route::model('ponderacions', 'App\Ponderacion');// generated by scaffold - Ponderacion
		Route::model('cargaPonderacions', 'App\CargaPonderacion');// generated by scaffold - CargaPonderacion
		Route::model('calificacionPonderacions', 'App\CalificacionPonderacion');// generated by scaffold - CalificacionPonderacion
		Route::model('hsSeguimientos', 'App\HsSeguimiento');// generated by scaffold - HsSeguimiento
		Route::model('calendarioEvaluacions', 'App\CalendarioEvaluacion');// generated by scaffold - CalendarioEvaluacion
		Route::model('asuntos', 'App\Asunto');// generated by scaffold - Asunto
		Route::model('giros', 'App\Giro');// generated by scaffold - Giro
		Route::model('empresas', 'App\Empresa');// generated by scaffold - Empresa
		Route::model('asistenciasCs', 'App\AsistenciasC');// generated by scaffold - AsistenciasC
		Route::model('estAsistencias', 'App\EstAsistencium');// generated by scaffold - EstAsistencium
		Route::model('asistenciaRs', 'App\AsistenciaR');// generated by scaffold - AsistenciaR
		Route::model('modulos', 'App\Modulo');// generated by scaffold - Modulo
		Route::model('grupoPeriodoEstudios', 'App\GrupoPeriodoEstudio');// generated by scaffold - GrupoPeriodoEstudio
		Route::model('materiumPeriodos', 'App\MateriumPeriodo');// generated by scaffold - MateriumPeriodo
		Route::model('actividadEmpresas', 'App\ActividadEmpresa');// generated by scaffold - ActividadEmpresa
		Route::model('actividadEmpresas', 'App\ActividadEmpresa');// generated by scaffold - ActividadEmpresa
		Route::model('combinacionEmpresas', 'App\CombinacionEmpresa');// generated by scaffold - CombinacionEmpresa
		Route::model('stCuestionarios', 'App\StCuestionario');// generated by scaffold - StCuestionario
		Route::model('cuestionarios', 'App\Cuestionario');// generated by scaffold - Cuestionario
		Route::model('cuestionarioPreguntas', 'App\CuestionarioPregunta');// generated by scaffold - CuestionarioPregunta
		Route::model('cuestionarioRespuestas', 'App\CuestionarioRespuesta');// generated by scaffold - CuestionarioRespuesta
		Route::model('cuestionarioDatos', 'App\CuestionarioDato');// generated by scaffold - CuestionarioDato
		Route::model('combinacionClientes', 'App\CombinacionCliente');// generated by scaffold - CombinacionCliente
		Route::model('combinacionClientes', 'App\CombinacionCliente');// generated by scaffold - CombinacionCliente
		Route::model('diaNoHabils', 'App\DiaNoHabil');// generated by scaffold - DiaNoHabil
		Route::model('diaNoHabils', 'App\DiaNoHabil');// generated by scaffold - DiaNoHabil
		Route::model('ccuestionarios', 'App\Ccuestionario');// generated by scaffold - Ccuestionario
		Route::model('ccuestionarioPreguntas', 'App\CcuestionarioPreguntum');// generated by scaffold - CcuestionarioPreguntum
		Route::model('ccuestionarioRespuestas', 'App\CcuestionarioRespuestum');// generated by scaffold - CcuestionarioRespuestum
		Route::model('ccuestionarioDatos', 'App\CcuestionarioDato');// generated by scaffold - CcuestionarioDato
		Route::model('pagosLectivos', 'App\PagosLectivo');// generated by scaffold - PagosLectivo
		Route::model('cuentaContables', 'App\CuentaContable');// generated by scaffold - CuentaContable
		Route::model('reglaRecargos', 'App\ReglaRecargo');// generated by scaffold - ReglaRecargo
		Route::model('pagosLectivosLns', 'App\PagosLectivosLn');// generated by scaffold - PagosLectivosLn
		Route::model('planCampoFiltros', 'App\PlanCampoFiltro');// generated by scaffold - PlanCampoFiltro
		Route::model('planCondicionFiltros', 'App\PlanCondicionFiltro');// generated by scaffold - PlanCondicionFiltro
		Route::model('tpoInformes', 'App\TpoInforme');// generated by scaffold - TpoInforme
		Route::model('avisosInicios', 'App\AvisosInicio');// generated by scaffold - AvisosInicio
		Route::model('smsPredefinidos', 'App\SmsPredefinido');// generated by scaffold - SmsPredefinido
		Route::model('cajaConceptos', 'App\CajaConcepto');// generated by scaffold - CajaConcepto
		Route::model('cuentaContables', 'App\CuentaContable');// generated by scaffold - CuentaContable
		Route::model('planPagos', 'App\PlanPago');// generated by scaffold - PlanPago
		Route::model('planPagoLns', 'App\PlanPagoLn');// generated by scaffold - PlanPagoLn
		Route::model('formaPagos', 'App\FormaPago');// generated by scaffold - FormaPago
		Route::model('reglaRecargos', 'App\ReglaRecargo');// generated by scaffold - ReglaRecargo
		Route::model('tipoReglas', 'App\TipoRegla');// generated by scaffold - TipoRegla
		Route::model('adeudos', 'App\Adeudo');// generated by scaffold - Adeudo
		Route::model('cajas', 'App\Caja');// generated by scaffold - Caja
		Route::model('cajaLns', 'App\CajaLn');// generated by scaffold - CajaLn
		Route::model('stCajas', 'App\StCaja');// generated by scaffold - StCaja
		Route::model('segmentoMercados', 'App\SegmentoMercado');// generated by scaffold - SegmentoMercado
		Route::model('pagos', 'App\Pago');// generated by scaffold - Pago
		Route::model('pagos', 'App\Pago');// generated by scaffold - Pago
		Route::model('paises', 'App\Paise');// generated by scaffold - Paise
		Route::model('historiaEventos', 'App\HistoriaEvento');// generated by scaffold - HistoriaEvento
		Route::model('historials', 'App\Historial');// generated by scaffold - Historial
		Route::model('ebanxes', 'App\Ebanx');// generated by scaffold - Ebanx
		Route::model('promocions', 'App\Promocion');// generated by scaffold - Promocion
		Route::model('promoPlanLns', 'App\PromoPlanLn');// generated by scaffold - PromoPlanLn
		Route::model('stEmpresas', 'App\StEmpresa');// generated by scaffold - StEmpresa
		Route::model('tareasEmpresas', 'App\TareasEmpresa');// generated by scaffold - TareasEmpresa
		Route::model('avisosEmpresas', 'App\AvisosEmpresa');// generated by scaffold - AvisosEmpresa
		Route::model('mese', 'App\Mese');// generated by scaffold - Mese
		Route::model('stBecas', 'App\StBeca');// generated by scaffold - StBeca
		Route::model('autorizacionBecas', 'App\AutorizacionBeca');// generated by scaffold - AutorizacionBeca
		Route::model('autorizacionBecaComentarios', 'App\AutorizacionBecaComentario');// generated by scaffold - AutorizacionBecaComentario
		Route::model('cursos', 'App\Curso');// generated by scaffold - Curso
		Route::model('cursosEmpresas', 'App\CursosEmpresa');// generated by scaffold - CursosEmpresa
		Route::model('stCursoEmpresas', 'App\StCursoEmpresa');// generated by scaffold - StCursoEmpresa
		Route::model('cursosEmpresas', 'App\CursosEmpresa');// generated by scaffold - CursosEmpresa
		Route::model('cotizacionCursos', 'App\CotizacionCurso');// generated by scaffold - CotizacionCurso
		Route::model('tipoPrecioCotis', 'App\TipoPrecioCoti');// generated by scaffold - TipoPrecioCoti
		Route::model('cotizacionLns', 'App\CotizacionLn');// generated by scaffold - CotizacionLn
		Route::model('facturaCotizacions', 'App\FacturaCotizacion');// generated by scaffold - FacturaCotizacion
		Route::model('stInscripcions', 'App\StInscripcion');// generated by scaffold - StInscripcion
		Route::model('consultaCalificacions', 'App\ConsultaCalificacion');// generated by scaffold - ConsultaCalificacion
		Route::model('eventoClientes', 'App\EventoCliente');// generated by scaffold - EventoCliente
		Route::model('historiaClientes', 'App\HistoriaCliente');// generated by scaffold - HistoriaCliente
		Route::model('cuentasEfectivos', 'App\CuentasEfectivo');// generated by scaffold - CuentasEfectivo
		Route::model('egresosConceptos', 'App\EgresosConcepto');// generated by scaffold - EgresosConcepto
		Route::model('asuntos', 'App\Asunto');// generated by scaffold - Asunto
		Route::model('egresos', 'App\Egreso');// generated by scaffold - Egreso
		Route::model('cuentasEfectivoPlantels', 'App\CuentasEfectivoPlantel');// generated by scaffold - CuentasEfectivoPlantel
		Route::model('hCuentasEfectivos', 'App\HCuentasEfectivo');// generated by scaffold - HCuentasEfectivo
		Route::model('ingresoEgresos', 'App\IngresoEgreso');// generated by scaffold - IngresoEgreso
		Route::model('transferences', 'App\Transference');// generated by scaffold - Transference
		Route::model('transferences', 'App\Transference');// generated by scaffold - Transference
		Route::model('hEstatuses', 'App\HEstatus');// generated by scaffold - HEstatus
		Route::model('docPlantels', 'App\DocPlantel');// generated by scaffold - DocPlantel
		Route::model('docPlantelPlantels', 'App\DocPlantelPlantel');// generated by scaffold - DocPlantelPlantel
		Route::model('vinculacions', 'App\Vinculacion');// generated by scaffold - Vinculacion
		Route::model('vinculacions', 'App\Vinculacion');// generated by scaffold - Vinculacion
		Route::model('vinculacionHoras', 'App\VinculacionHora');// generated by scaffold - VinculacionHora
		Route::model('docVinculacions', 'App\DocVinculacion');// generated by scaffold - DocVinculacion
		Route::model('docVinculacionVinculacions', 'App\DocVinculacionVinculacion');// generated by scaffold - DocVinculacionVinculacion
		Route::model('escolaridads', 'App\Escolaridad');// generated by scaffold - Escolaridad
		Route::model('unidadUsos', 'App\UnidadUso');// generated by scaffold - UnidadUso
		Route::model('categoriaArticulos', 'App\CategoriaArticulo');// generated by scaffold - CategoriaArticulo
		Route::model('articulos', 'App\Articulo');// generated by scaffold - Articulo
		Route::model('entradaSalidas', 'App\EntradaSalida');// generated by scaffold - EntradaSalida
		Route::model('existencias', 'App\Existencium');// generated by scaffold - Existencium
		Route::model('movimientos', 'App\Movimiento');// generated by scaffold - Movimiento
		Route::model('plantillaEmpresas', 'App\PlantillaEmpresa');// generated by scaffold - PlantillaEmpresa
		Route::model('plantillaEmpresaCampos', 'App\PlantillaEmpresaCampo');// generated by scaffold - PlantillaEmpresaCampo
		Route::model('plantillaEmpresaConds', 'App\PlantillaEmpresaCond');// generated by scaffold - PlantillaEmpresaCond
		Route::model('ubicacionArts', 'App\UbicacionArt');// generated by scaffold - UbicacionArt
		Route::model('tpoArticulos', 'App\TpoArticulo');// generated by scaffold - TpoArticulo
		Route::model('stMuebles', 'App\StMueble');// generated by scaffold - StMueble
		Route::model('stMuebleUsos', 'App\StMuebleUso');// generated by scaffold - StMuebleUso
		Route::model('muebles', 'App\Mueble');// generated by scaffold - Mueble
		Route::model('historiClienteInscripcions', 'App\HistoriClienteInscripcion');// generated by scaffold - HistoriClienteInscripcion
		Route::model('peridoExamens', 'App\PeridoExaman');// generated by scaffold - PeridoExaman
		Route::model('periodoExamens', 'App\PeriodoExaman');// generated by scaffold - PeriodoExaman
		Route::model('stHistoriaClientes', 'App\StHistoriaCliente');// generated by scaffold - StHistoriaCliente
		Route::model('registroHistoriaClientes', 'App\RegistroHistoriaCliente');// generated by scaffold - RegistroHistoriaCliente
		Route::model('registroHistoriaClientes', 'App\RegistroHistoriaCliente');// generated by scaffold - RegistroHistoriaCliente
		Route::model('stAutorizacionBecas', 'App\StAutorizacionBeca');// generated by scaffold - StAutorizacionBeca
		Route::model('interesEstudios', 'App\InteresEstudio');// generated by scaffold - InteresEstudio
		Route::model('stVinculacions', 'App\StVinculacion');// generated by scaffold - StVinculacion
		Route::model('comenMuebles', 'App\ComenMueble');// generated by scaffold - ComenMueble
		Route::model('impresionTickets', 'App\ImpresionTicket');// generated by scaffold - ImpresionTicket
		Route::model('impresionListaAsistens', 'App\ImpresionListaAsisten');// generated by scaffold - ImpresionListaAsisten
		Route::model('hAsistenciaRs', 'App\HAsistenciaR');// generated by scaffold - HAsistenciaR
		Route::model('hCalifPonderacions', 'App\HCalifPonderacion');// generated by scaffold - HCalifPonderacion
		Route::model('cajaCortes', 'App\CajaCorte');// generated by scaffold - CajaCorte
		Route::model('clasificacions', 'App\Clasificacion');// generated by scaffold - Clasificacion
		Route::model('bandejaAdjuntos', 'App\BandejaAdjunto');// generated by scaffold - BandejaAdjunto
		Route::model('bandejas', 'App\Bandeja');// generated by scaffold - Bandeja
		Route::model('moodleBajas', 'App\MoodleBaja');// generated by scaffold - MoodleBaja
		Route::model('planEstudios', 'App\PlanEstudio');// generated by scaffold - PlanEstudio
		Route::model('descuentos', 'App\Descuento');// generated by scaffold - Descuento
		Route::model('tipoBecas', 'App\TipoBeca');// generated by scaffold - TipoBeca
		Route::model('multipagos', 'App\Multipago');// generated by scaffold - Multipago
		Route::model('multipagos', 'App\Multipago');// generated by scaffold - Multipago
		Route::model('peticionMultipagos', 'App\PeticionMultipago');// generated by scaffold - PeticionMultipago
		Route::model('successMultipagos', 'App\SuccessMultipago');// generated by scaffold - SuccessMultipago
		Route::model('failMultipagos', 'App\FailMultipago');// generated by scaffold - FailMultipago
		Route::model('tipoContratos', 'App\TipoContrato');// generated by scaffold - TipoContrato
		Route::model('conciliacionMultipagos', 'App\ConciliacionMultipago');// generated by scaffold - ConciliacionMultipago
		Route::model('conciliacionMultiDetalles', 'App\ConciliacionMultiDetalle');// generated by scaffold - ConciliacionMultiDetalle
		Route::model('nivelEstudios', 'App\NivelEstudio');// generated by scaffold - NivelEstudio
		Route::model('estadoCivils', 'App\EstadoCivil');// generated by scaffold - EstadoCivil
		Route::model('conceptoMultipagos', 'App\ConceptoMultipago');// generated by scaffold - ConceptoMultipago
		Route::model('motivoBecas', 'App\MotivoBeca');// generated by scaffold - MotivoBeca
		Route::model('consecutivoMatriculas', 'App\ConsecutivoMatricula');// generated by scaffold - ConsecutivoMatricula
		Route::model('adeudoPagoOnLines', 'App\AdeudoPagoOnLine');// generated by scaffold - AdeudoPagoOnLine
		Route::model('pagadors', 'App\Pagador');// generated by scaffold - Pagador
		Route::model('discapacidads', 'App\Discapacidad');// generated by scaffold - Discapacidad
		Route::model('discapacidads', 'App\Discapacidad');// generated by scaffold - Discapacidad
		Route::model('cuentaPs', 'App\CuentaP');// generated by scaffold - CuentaP
		Route::model('serieFolioSimplificados', 'App\SerieFolioSimplificado');// generated by scaffold - SerieFolioSimplificado
		Route::model('tipoPersonas', 'App\TipoPersona');// generated by scaffold - TipoPersona
		Route::model('cpSats', 'App\CpSat');// generated by scaffold - CpSat
		Route::model('nivelEducativoSats', 'App\NivelEducativoSat');// generated by scaffold - NivelEducativoSat
		Route::model('seccions', 'App\Seccion');// generated by scaffold - Seccion
		Route::model('uusarioClientes', 'App\UusarioCliente');// generated by scaffold - UusarioCliente
		Route::model('usarioClientes', 'App\UsarioCliente');// generated by scaffold - UsarioCliente
		Route::model('hadeudos', 'App\Hadeudo');// generated by scaffold - Hadeudo
		Route::model('facturaGenerals', 'App\FacturaGeneral');// generated by scaffold - FacturaGeneral
		Route::model('facturaGeneralLineas', 'App\FacturaGeneralLinea');// generated by scaffold - FacturaGeneralLinea
		Route::model('bsBajas', 'App\BsBaja');// generated by scaffold - BsBaja
		Route::model('incidenceClientes', 'App\IncidenceCliente');// generated by scaffold - IncidenceCliente
		Route::model('incidencesClientes', 'App\IncidencesCliente');// generated by scaffold - IncidencesCliente
		Route::model('stTickets', 'App\StTicket');// generated by scaffold - StTicket
		Route::model('categoriaTickets', 'App\CategoriaTicket');// generated by scaffold - CategoriaTicket
		Route::model('tickets', 'App\Ticket');// generated by scaffold - Ticket
		Route::model('avancesTickets', 'App\AvancesTicket');// generated by scaffold - AvancesTicket
		Route::model('prioridadTickets', 'App\PrioridadTicket');// generated by scaffold - PrioridadTicket
		Route::model('etiquetasTickets', 'App\EtiquetasTicket');// generated by scaffold - EtiquetasTicket
		Route::model('imagenesTickets', 'App\ImagenesTicket');// generated by scaffold - ImagenesTicket
		Route::model('imagenesAvancesTickets', 'App\ImagenesAvancesTicket');// generated by scaffold - ImagenesAvancesTicket
		Route::model('usoFacturas', 'App\UsoFactura');// generated by scaffold - UsoFactura
		Route::model('ciclos', 'App\Ciclo');// generated by scaffold - Ciclo
		Route::model('cicloMatriculas', 'App\CicloMatricula');// generated by scaffold - CicloMatricula
		Route::model('stProspectos', 'App\StProspecto');// generated by scaffold - StProspecto
		Route::model('prospectos', 'App\Prospecto');// generated by scaffold - Prospecto
		Route::model('hStProspectos', 'App\HStProspecto');// generated by scaffold - HStProspecto
		Route::model('hPeticions', 'App\HPeticion');// generated by scaffold - HPeticion
		Route::model('actaFinals', 'App\ActaFinal');// generated by scaffold - ActaFinal
		Route::model('hCambiosCajas', 'App\HCambiosCaja');// generated by scaffold - HCambiosCaja
		Route::model('opcionTitulacions', 'App\OpcionTitulacion');// generated by scaffold - OpcionTitulacion
		Route::model('titulacions', 'App\Titulacion');// generated by scaffold - Titulacion
		Route::model('titulacionIntentos', 'App\TitulacionIntento');// generated by scaffold - TitulacionIntento
		Route::model('titulacionPagos', 'App\TitulacionPago');// generated by scaffold - TitulacionPago
		Route::model('titulacionDocumentos', 'App\TitulacionDocumento');// generated by scaffold - TitulacionDocumento
		Route::model('titulacionDocumentacions', 'App\TitulacionDocumentacion');// generated by scaffold - TitulacionDocumentacion
		Route::model('regimenFiscals', 'App\RegimenFiscal');// generated by scaffold - RegimenFiscal
		Route::model('empresasVinculacions', 'App\EmpresasVinculacion');// generated by scaffold - EmpresasVinculacion
		Route::model('captacions', 'App\Captacion');// generated by scaffold - Captacion
		Route::model('sueldos', 'App\Sueldo');// generated by scaffold - Sueldo
		Route::model('facturaGs', 'App\FacturaG');// generated by scaffold - FacturaG
		Route::model('facturaGLineas', 'App\FacturaGLinea');// generated by scaffold - FacturaGLinea
		Route::model('titulacionGrupos', 'App\TitulacionGrupo');// generated by scaffold - TitulacionGrupo
		Route::model('titulacionConceptos', 'App\TitulacionConcepto');// generated by scaffold - TitulacionConcepto
		Route::model('titulacionEgresos', 'App\TitulacionEgreso');// generated by scaffold - TitulacionEgreso
		Route::model('inventarios', 'App\Inventario');// generated by scaffold - Inventario
		Route::model('inventarioLevantamientos', 'App\InventarioLevantamiento');// generated by scaffold - InventarioLevantamiento
		Route::model('inventarioObservacions', 'App\InventarioObservacion');// generated by scaffold - InventarioObservacion
		Route::model('inventarioLevantamientoSts', 'App\InventarioLevantamientoSt');// generated by scaffold - InventarioLevantamientoSt
		Route::model('prospectoStSegs', 'App\ProspectoStSeg');// generated by scaffold - ProspectoStSeg
		Route::model('prospectoTareas', 'App\ProspectoTarea');// generated by scaffold - ProspectoTarea
		Route::model('prospectoAsuntos', 'App\ProspectoAsunto');// generated by scaffold - ProspectoAsunto
		Route::model('prospectoAsignacionTareas', 'App\ProspectoAsignacionTarea');// generated by scaffold - ProspectoAsignacionTarea
		Route::model('prospectoSeguimientos', 'App\ProspectoSeguimiento');// generated by scaffold - ProspectoSeguimiento
		Route::model('prospectoAvisos', 'App\ProspectoAviso');// generated by scaffold - ProspectoAviso
		Route::model('prospectoStTareas', 'App\ProspectoStTarea');// generated by scaffold - ProspectoStTarea
		Route::model('prospectoHistoricoSts', 'App\ProspectoHistoricoSt');// generated by scaffold - ProspectoHistoricoSt
		Route::model('plantelInventarios', 'App\PlantelInventario');// generated by scaffold - PlantelInventario
		Route::model('prospectoHactividads', 'App\ProspectoHactividad');// generated by scaffold - ProspectoHactividad
		Route::model('prospectoHEstatuses', 'App\ProspectoHEstatuse');// generated by scaffold - ProspectoHEstatuse
		Route::model('procesoActivoABajas', 'App\ProcesoActivoABaja');// generated by scaffold - ProcesoActivoABaja
		Route::model('plantelAgrupamientos', 'App\PlantelAgrupamiento');// generated by scaffold - PlantelAgrupamiento
		Route::model('sepGrupos', 'App\SepGrupo');// generated by scaffold - SepGrupo
		Route::model('sepMaterias', 'App\SepMaterium');// generated by scaffold - SepMaterium
		Route::model('scholarDays', 'App\ScholarDay');// generated by scaffold - ScholarDay
		Route::model('duracionPeriodos', 'App\DuracionPeriodo');// generated by scaffold - DuracionPeriodo
		Route::model('sepCargos', 'App\SepCargo');// generated by scaffold - SepCargo
		Route::model('sepTipoCertificados', 'App\SepTipoCertificado');// generated by scaffold - SepTipoCertificado
		Route::model('sepObservacions', 'App\SepObservacion');// generated by scaffold - SepObservacion
		Route::model('sepCertificadoCs', 'App\SepCertificadoC');// generated by scaffold - SepCertificadoC
		Route::model('asuntos', 'App\Asunto');// generated by scaffold - Asunto
		Route::model('seps', 'App\Sep');// generated by scaffold - Sep
		Route::model('sepInstitucionEducativas', 'App\SepInstitucionEducativa');// generated by scaffold - SepInstitucionEducativa
		Route::model('sepCarreras', 'App\SepCarrera');// generated by scaffold - SepCarrera
		Route::model('sepAutorizacionReconocimientos', 'App\SepAutorizacionReconocimiento');// generated by scaffold - SepAutorizacionReconocimiento
		Route::model('sepModalidadTitulacions', 'App\SepModalidadTitulacion');// generated by scaffold - SepModalidadTitulacion
		Route::model('sepFundamentoLegalServicioSocials', 'App\SepFundamentoLegalServicioSocial');// generated by scaffold - SepFundamentoLegalServicioSocial
		Route::model('sepTEstudioAntecedentes', 'App\SepTEstudioAntecedente');// generated by scaffold - SepTEstudioAntecedente
		Route::model('procedenciaAlumnos', 'App\ProcedenciaAlumno');// generated by scaffold - ProcedenciaAlumno
		Route::model('sepTitulos', 'App\SepTitulo');// generated by scaffold - SepTitulo
		Route::model('sepTituloLs', 'App\SepTituloL');// generated by scaffold - SepTituloL
		Route::model('sepCertInstitucions', 'App\SepCertInstitucion');// generated by scaffold - SepCertInstitucion
		Route::model('generos', 'App\Genero');// generated by scaffold - Genero
		Route::model('sepCertTipos', 'App\SepCertTipo');// generated by scaffold - SepCertTipo
		Route::model('sepCertObservacions', 'App\SepCertObservacion');// generated by scaffold - SepCertObservacion
		Route::model('sepCertificados', 'App\SepCertificado');// generated by scaffold - SepCertificado
		Route::model('sepCertificadoLs', 'App\SepCertificadoL');// generated by scaffold - SepCertificadoL
		Route::model('incidenciasCalificacions', 'App\IncidenciasCalificacion');// generated by scaffold - IncidenciasCalificacion
		Route::model('porcentajeBecas', 'App\PorcentajeBeca');// generated by scaffold - PorcentajeBeca
		Route::model('prebecas', 'App\Prebeca');// generated by scaffold - Prebeca
		Route::model('webhookOpenpays', 'App\WebhookOpenpay');// generated by scaffold - WebhookOpenpay
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
