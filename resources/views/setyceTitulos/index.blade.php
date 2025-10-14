@extends('plantillas.admin_template')

@include('setyceTitulos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('setyceTitulos.index') }}">@yield('setyceTitulosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('setyceTitulosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('setyceTitulosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('setyceTitulosAppTitle')
            @permission('setyceTitulos.create')
            <a class="btn btn-success pull-right" href="{{ route('setyceTitulos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            @endpermission
        </h3>

    </div>

    <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
        <div class="panel panel-default">
            <div id="headingOne" role="tab" class="panel-heading">
                <h4 class="panel-title">
                <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Buscar
                </a>
                </h4>
            </div>
            <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <form class="SetyceTitulo_search" id="search" action="{{ route('setyceTitulos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_setyce_lote_id_gt">SETYCE_LOTE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['setyce_lote_id_gt']) ?: '' }}" name="q[setyce_lote_id_gt]" id="q_setyce_lote_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['setyce_lote_id_lt']) ?: '' }}" name="q[setyce_lote_id_lt]" id="q_setyce_lote_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_setyce_lote_id_cont">SETYCE_LOTE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['setyce_lote_id_cont']) ?: '' }}" name="q[setyce_lote_id_cont]" id="q_setyce_lote_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_gt">CLIENTE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_gt']) ?: '' }}" name="q[cliente_id_gt]" id="q_cliente_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_lt']) ?: '' }}" name="q[cliente_id_lt]" id="q_cliente_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_cont">CLIENTE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_cont']) ?: '' }}" name="q[cliente_id_cont]" id="q_cliente_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carrera_gt">CARRERA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carrera_gt']) ?: '' }}" name="q[carrera_gt]" id="q_carrera_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carrera_lt']) ?: '' }}" name="q[carrera_lt]" id="q_carrera_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carrera_cont">CARRERA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carrera_cont']) ?: '' }}" name="q[carrera_cont]" id="q_carrera_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_inicio_gt">FECHA_INICIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_inicio_gt']) ?: '' }}" name="q[fecha_inicio_gt]" id="q_fecha_inicio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_inicio_lt']) ?: '' }}" name="q[fecha_inicio_lt]" id="q_fecha_inicio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_inicio_cont">FECHA_INICIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_inicio_cont']) ?: '' }}" name="q[fecha_inicio_cont]" id="q_fecha_inicio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fechat_terminacion_gt">FECHAT_TERMINACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fechat_terminacion_gt']) ?: '' }}" name="q[fechat_terminacion_gt]" id="q_fechat_terminacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fechat_terminacion_lt']) ?: '' }}" name="q[fechat_terminacion_lt]" id="q_fechat_terminacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fechat_terminacion_cont">FECHAT_TERMINACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fechat_terminacion_cont']) ?: '' }}" name="q[fechat_terminacion_cont]" id="q_fechat_terminacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_folio_gt">FOLIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_gt']) ?: '' }}" name="q[folio_gt]" id="q_folio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_lt']) ?: '' }}" name="q[folio_lt]" id="q_folio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_folio_cont">FOLIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_cont']) ?: '' }}" name="q[folio_cont]" id="q_folio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_gt">CURP</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_gt']) ?: '' }}" name="q[curp_gt]" id="q_curp_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_lt']) ?: '' }}" name="q[curp_lt]" id="q_curp_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_cont">CURP</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_cont']) ?: '' }}" name="q[curp_cont]" id="q_curp_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_gt']) ?: '' }}" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_lt']) ?: '' }}" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_cont">NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_cont']) ?: '' }}" name="q[nombre_cont]" id="q_nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_primer_apellido_gt">PRIMER_APELLIDO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['primer_apellido_gt']) ?: '' }}" name="q[primer_apellido_gt]" id="q_primer_apellido_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['primer_apellido_lt']) ?: '' }}" name="q[primer_apellido_lt]" id="q_primer_apellido_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_primer_apellido_cont">PRIMER_APELLIDO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['primer_apellido_cont']) ?: '' }}" name="q[primer_apellido_cont]" id="q_primer_apellido_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_segundo_apellido_gt">SEGUNDO_APELLIDO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['segundo_apellido_gt']) ?: '' }}" name="q[segundo_apellido_gt]" id="q_segundo_apellido_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['segundo_apellido_lt']) ?: '' }}" name="q[segundo_apellido_lt]" id="q_segundo_apellido_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_segundo_apellido_cont">SEGUNDO_APELLIDO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['segundo_apellido_cont']) ?: '' }}" name="q[segundo_apellido_cont]" id="q_segundo_apellido_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_correo_electronico_gt">CORREO_ELECTRONICO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['correo_electronico_gt']) ?: '' }}" name="q[correo_electronico_gt]" id="q_correo_electronico_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['correo_electronico_lt']) ?: '' }}" name="q[correo_electronico_lt]" id="q_correo_electronico_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_correo_electronico_cont">CORREO_ELECTRONICO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['correo_electronico_cont']) ?: '' }}" name="q[correo_electronico_cont]" id="q_correo_electronico_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_expedicion_gt">FECHA_EXPEDICION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_expedicion_gt']) ?: '' }}" name="q[fecha_expedicion_gt]" id="q_fecha_expedicion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_expedicion_lt']) ?: '' }}" name="q[fecha_expedicion_lt]" id="q_fecha_expedicion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_expedicion_cont">FECHA_EXPEDICION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_expedicion_cont']) ?: '' }}" name="q[fecha_expedicion_cont]" id="q_fecha_expedicion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_modalidad_titulacion_id_gt">SEP_MODALIDAD_TITULACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_modalidad_titulacion_id_gt']) ?: '' }}" name="q[sep_modalidad_titulacion_id_gt]" id="q_sep_modalidad_titulacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_modalidad_titulacion_id_lt']) ?: '' }}" name="q[sep_modalidad_titulacion_id_lt]" id="q_sep_modalidad_titulacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_modalidad_titulacion_id_cont">SEP_MODALIDAD_TITULACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_modalidad_titulacion_id_cont']) ?: '' }}" name="q[sep_modalidad_titulacion_id_cont]" id="q_sep_modalidad_titulacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_examen_profesional_gt">FECHA_EXAMEN_PROFESIONAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_examen_profesional_gt']) ?: '' }}" name="q[fecha_examen_profesional_gt]" id="q_fecha_examen_profesional_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_examen_profesional_lt']) ?: '' }}" name="q[fecha_examen_profesional_lt]" id="q_fecha_examen_profesional_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_examen_profesional_cont">FECHA_EXAMEN_PROFESIONAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_examen_profesional_cont']) ?: '' }}" name="q[fecha_examen_profesional_cont]" id="q_fecha_examen_profesional_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cumplio_servicio_social_gt">CUMPLIO_SERVICIO_SOCIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cumplio_servicio_social_gt']) ?: '' }}" name="q[cumplio_servicio_social_gt]" id="q_cumplio_servicio_social_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cumplio_servicio_social_lt']) ?: '' }}" name="q[cumplio_servicio_social_lt]" id="q_cumplio_servicio_social_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cumplio_servicio_social_cont">CUMPLIO_SERVICIO_SOCIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cumplio_servicio_social_cont']) ?: '' }}" name="q[cumplio_servicio_social_cont]" id="q_cumplio_servicio_social_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_fundamento_legal_servicio_social_id_gt">SEP_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_fundamento_legal_servicio_social_id_gt']) ?: '' }}" name="q[sep_fundamento_legal_servicio_social_id_gt]" id="q_sep_fundamento_legal_servicio_social_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_fundamento_legal_servicio_social_id_lt']) ?: '' }}" name="q[sep_fundamento_legal_servicio_social_id_lt]" id="q_sep_fundamento_legal_servicio_social_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_fundamento_legal_servicio_social_id_cont">SEP_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_fundamento_legal_servicio_social_id_cont']) ?: '' }}" name="q[sep_fundamento_legal_servicio_social_id_cont]" id="q_sep_fundamento_legal_servicio_social_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_t_estudio_antecedente_id_gt">SEP_T_ESTUDIO_ANTECEDENTE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_t_estudio_antecedente_id_gt']) ?: '' }}" name="q[sep_t_estudio_antecedente_id_gt]" id="q_sep_t_estudio_antecedente_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_t_estudio_antecedente_id_lt']) ?: '' }}" name="q[sep_t_estudio_antecedente_id_lt]" id="q_sep_t_estudio_antecedente_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_t_estudio_antecedente_id_cont">SEP_T_ESTUDIO_ANTECEDENTE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_t_estudio_antecedente_id_cont']) ?: '' }}" name="q[sep_t_estudio_antecedente_id_cont]" id="q_sep_t_estudio_antecedente_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_entidad_expedicion_gt">ENTIDAD_EXPEDICION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entidad_expedicion_gt']) ?: '' }}" name="q[entidad_expedicion_gt]" id="q_entidad_expedicion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entidad_expedicion_lt']) ?: '' }}" name="q[entidad_expedicion_lt]" id="q_entidad_expedicion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_entidad_expedicion_cont">ENTIDAD_EXPEDICION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entidad_expedicion_cont']) ?: '' }}" name="q[entidad_expedicion_cont]" id="q_entidad_expedicion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_institucion_procedencia_gt">INSTITUCION_PROCEDENCIA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['institucion_procedencia_gt']) ?: '' }}" name="q[institucion_procedencia_gt]" id="q_institucion_procedencia_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['institucion_procedencia_lt']) ?: '' }}" name="q[institucion_procedencia_lt]" id="q_institucion_procedencia_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_institucion_procedencia_cont">INSTITUCION_PROCEDENCIA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['institucion_procedencia_cont']) ?: '' }}" name="q[institucion_procedencia_cont]" id="q_institucion_procedencia_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_entidad_antecedente_gt">ENTIDAD_ANTECEDENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entidad_antecedente_gt']) ?: '' }}" name="q[entidad_antecedente_gt]" id="q_entidad_antecedente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entidad_antecedente_lt']) ?: '' }}" name="q[entidad_antecedente_lt]" id="q_entidad_antecedente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_entidad_antecedente_cont">ENTIDAD_ANTECEDENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entidad_antecedente_cont']) ?: '' }}" name="q[entidad_antecedente_cont]" id="q_entidad_antecedente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_inicio_antecedente_gt">FECHA_INICIO_ANTECEDENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_inicio_antecedente_gt']) ?: '' }}" name="q[fecha_inicio_antecedente_gt]" id="q_fecha_inicio_antecedente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_inicio_antecedente_lt']) ?: '' }}" name="q[fecha_inicio_antecedente_lt]" id="q_fecha_inicio_antecedente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_inicio_antecedente_cont">FECHA_INICIO_ANTECEDENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_inicio_antecedente_cont']) ?: '' }}" name="q[fecha_inicio_antecedente_cont]" id="q_fecha_inicio_antecedente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_terminoa_antecedente_gt">FECHA_TERMINOA_ANTECEDENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_terminoa_antecedente_gt']) ?: '' }}" name="q[fecha_terminoa_antecedente_gt]" id="q_fecha_terminoa_antecedente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_terminoa_antecedente_lt']) ?: '' }}" name="q[fecha_terminoa_antecedente_lt]" id="q_fecha_terminoa_antecedente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_terminoa_antecedente_cont">FECHA_TERMINOA_ANTECEDENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_terminoa_antecedente_cont']) ?: '' }}" name="q[fecha_terminoa_antecedente_cont]" id="q_fecha_terminoa_antecedente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_cedula_gt">NO_CEDULA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_cedula_gt']) ?: '' }}" name="q[no_cedula_gt]" id="q_no_cedula_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_cedula_lt']) ?: '' }}" name="q[no_cedula_lt]" id="q_no_cedula_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_cedula_cont">NO_CEDULA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_cedula_cont']) ?: '' }}" name="q[no_cedula_cont]" id="q_no_cedula_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_gt">USU_MOD_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_gt']) ?: '' }}" name="q[usu_mod_id_gt]" id="q_usu_mod_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_lt']) ?: '' }}" name="q[usu_mod_id_lt]" id="q_usu_mod_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_cont">USU_MOD_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_cont']) ?: '' }}" name="q[usu_mod_id_cont]" id="q_usu_mod_id_cont" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($setyceTitulos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'setyce_lote_id', 'title' => 'SETYCE_LOTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cliente_id', 'title' => 'CLIENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'carrera', 'title' => 'CARRERA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_inicio', 'title' => 'FECHA_INICIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fechat_terminacion', 'title' => 'FECHAT_TERMINACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'folio', 'title' => 'FOLIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'curp', 'title' => 'CURP'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'primer_apellido', 'title' => 'PRIMER_APELLIDO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'segundo_apellido', 'title' => 'SEGUNDO_APELLIDO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'correo_electronico', 'title' => 'CORREO_ELECTRONICO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_expedicion', 'title' => 'FECHA_EXPEDICION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_modalidad_titulacion_id', 'title' => 'SEP_MODALIDAD_TITULACION_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_examen_profesional', 'title' => 'FECHA_EXAMEN_PROFESIONAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cumplio_servicio_social', 'title' => 'CUMPLIO_SERVICIO_SOCIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_fundamento_legal_servicio_social_id', 'title' => 'SEP_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_t_estudio_antecedente_id', 'title' => 'SEP_T_ESTUDIO_ANTECEDENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'entidad_expedicion', 'title' => 'ENTIDAD_EXPEDICION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'institucion_procedencia', 'title' => 'INSTITUCION_PROCEDENCIA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'entidad_antecedente', 'title' => 'ENTIDAD_ANTECEDENTE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_inicio_antecedente', 'title' => 'FECHA_INICIO_ANTECEDENTE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_terminoa_antecedente', 'title' => 'FECHA_TERMINOA_ANTECEDENTE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'no_cedula', 'title' => 'NO_CEDULA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($setyceTitulos as $setyceTitulo)
                            <tr>
                                <td><a href="{{ route('setyceTitulos.show', $setyceTitulo->id) }}">{{$setyceTitulo->id}}</a></td>
                                <td>{{$setyceTitulo->setyce_lote_id}}</td>
                    <td>{{$setyceTitulo->cliente_id}}</td>
                    <td>{{$setyceTitulo->carrera}}</td>
                    <td>{{$setyceTitulo->fecha_inicio}}</td>
                    <td>{{$setyceTitulo->fechat_terminacion}}</td>
                    <td>{{$setyceTitulo->folio}}</td>
                    <td>{{$setyceTitulo->curp}}</td>
                    <td>{{$setyceTitulo->nombre}}</td>
                    <td>{{$setyceTitulo->primer_apellido}}</td>
                    <td>{{$setyceTitulo->segundo_apellido}}</td>
                    <td>{{$setyceTitulo->correo_electronico}}</td>
                    <td>{{$setyceTitulo->fecha_expedicion}}</td>
                    <td>{{$setyceTitulo->sep_modalidad_titulacion_id}}</td>
                    <td>{{$setyceTitulo->fecha_examen_profesional}}</td>
                    <td>{{$setyceTitulo->cumplio_servicio_social}}</td>
                    <td>{{$setyceTitulo->sep_fundamento_legal_servicio_social_id}}</td>
                    <td>{{$setyceTitulo->sep_t_estudio_antecedente_id}}</td>
                    <td>{{$setyceTitulo->entidad_expedicion}}</td>
                    <td>{{$setyceTitulo->institucion_procedencia}}</td>
                    <td>{{$setyceTitulo->entidad_antecedente}}</td>
                    <td>{{$setyceTitulo->fecha_inicio_antecedente}}</td>
                    <td>{{$setyceTitulo->fecha_terminoa_antecedente}}</td>
                    <td>{{$setyceTitulo->no_cedula}}</td>
                    <td>{{$setyceTitulo->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('setyceTitulos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('setyceTitulos.duplicate', $setyceTitulo->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('setyceTitulos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('setyceTitulos.edit', $setyceTitulo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('setyceTitulos.destroy')
                                    {!! Form::model($setyceTitulo, array('route' => array('setyceTitulos.destroy', $setyceTitulo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $setyceTitulos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection