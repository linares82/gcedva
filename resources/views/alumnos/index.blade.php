@extends('plantillas.admin_template')

@include('alumnos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('alumnos.index') }}">@yield('alumnosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('alumnosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('alumnosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('alumnosAppTitle')
            @permission('alumnos.create')
            <a class="btn btn-success pull-right" href="{{ route('alumnos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Alumno_search" id="search" action="{{ route('alumnos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_matricula_gt">MATRICULA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['matricula_gt']) ?: '' }}" name="q[matricula_gt]" id="q_matricula_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['matricula_lt']) ?: '' }}" name="q[matricula_lt]" id="q_matricula_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_matricula_cont">MATRICULA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['matricula_cont']) ?: '' }}" name="q[matricula_cont]" id="q_matricula_cont" />
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
                                <label class="col-sm-2 control-label" for="q_nombre2_gt">NOMBRE2</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_gt']) ?: '' }}" name="q[nombre2_gt]" id="q_nombre2_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_lt']) ?: '' }}" name="q[nombre2_lt]" id="q_nombre2_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre2_cont">NOMBRE2</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_cont']) ?: '' }}" name="q[nombre2_cont]" id="q_nombre2_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_paterno_gt">APE_PATERNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_gt']) ?: '' }}" name="q[ape_paterno_gt]" id="q_ape_paterno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_lt']) ?: '' }}" name="q[ape_paterno_lt]" id="q_ape_paterno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_paterno_cont">APE_PATERNO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_cont']) ?: '' }}" name="q[ape_paterno_cont]" id="q_ape_paterno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_materno_gt">APE_MATERNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_gt']) ?: '' }}" name="q[ape_materno_gt]" id="q_ape_materno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_lt']) ?: '' }}" name="q[ape_materno_lt]" id="q_ape_materno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_materno_cont">APE_MATERNO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_cont']) ?: '' }}" name="q[ape_materno_cont]" id="q_ape_materno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_genero_gt">GENERO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['genero_gt']) ?: '' }}" name="q[genero_gt]" id="q_genero_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['genero_lt']) ?: '' }}" name="q[genero_lt]" id="q_genero_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_genero_cont">GENERO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['genero_cont']) ?: '' }}" name="q[genero_cont]" id="q_genero_cont" />
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
                                <label class="col-sm-2 control-label" for="q_fec_nacimiento_gt">FEC_NACIMIENTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_nacimiento_gt']) ?: '' }}" name="q[fec_nacimiento_gt]" id="q_fec_nacimiento_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_nacimiento_lt']) ?: '' }}" name="q[fec_nacimiento_lt]" id="q_fec_nacimiento_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_nacimiento_cont">FEC_NACIMIENTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_nacimiento_cont']) ?: '' }}" name="q[fec_nacimiento_cont]" id="q_fec_nacimiento_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_lugar_nacimiento_gt">LUGAR_NACIMIENTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['lugar_nacimiento_gt']) ?: '' }}" name="q[lugar_nacimiento_gt]" id="q_lugar_nacimiento_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['lugar_nacimiento_lt']) ?: '' }}" name="q[lugar_nacimiento_lt]" id="q_lugar_nacimiento_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_lugar_nacimiento_cont">LUGAR_NACIMIENTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['lugar_nacimiento_cont']) ?: '' }}" name="q[lugar_nacimiento_cont]" id="q_lugar_nacimiento_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_extranjero_gt">EXTRANJERO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['extranjero_gt']) ?: '' }}" name="q[extranjero_gt]" id="q_extranjero_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['extranjero_lt']) ?: '' }}" name="q[extranjero_lt]" id="q_extranjero_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_extranjero_cont">EXTRANJERO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['extranjero_cont']) ?: '' }}" name="q[extranjero_cont]" id="q_extranjero_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inscripcion_gt">FEC_INSCRIPCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inscripcion_gt']) ?: '' }}" name="q[fec_inscripcion_gt]" id="q_fec_inscripcion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inscripcion_lt']) ?: '' }}" name="q[fec_inscripcion_lt]" id="q_fec_inscripcion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inscripcion_cont">FEC_INSCRIPCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inscripcion_cont']) ?: '' }}" name="q[fec_inscripcion_cont]" id="q_fec_inscripcion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_fijo_gt">TEL_FIJO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_gt']) ?: '' }}" name="q[tel_fijo_gt]" id="q_tel_fijo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_lt']) ?: '' }}" name="q[tel_fijo_lt]" id="q_tel_fijo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_fijo_cont">TEL_FIJO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_cont']) ?: '' }}" name="q[tel_fijo_cont]" id="q_tel_fijo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_cel_gt">TEL_CEL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_gt']) ?: '' }}" name="q[tel_cel_gt]" id="q_tel_cel_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_lt']) ?: '' }}" name="q[tel_cel_lt]" id="q_tel_cel_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_cel_cont">TEL_CEL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_cont']) ?: '' }}" name="q[tel_cel_cont]" id="q_tel_cel_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_empresa_gt">CEL_EMPRESA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_empresa_gt']) ?: '' }}" name="q[cel_empresa_gt]" id="q_cel_empresa_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_empresa_lt']) ?: '' }}" name="q[cel_empresa_lt]" id="q_cel_empresa_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_empresa_cont">CEL_EMPRESA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_empresa_cont']) ?: '' }}" name="q[cel_empresa_cont]" id="q_cel_empresa_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_gt">MAIL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_gt']) ?: '' }}" name="q[mail_gt]" id="q_mail_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_lt']) ?: '' }}" name="q[mail_lt]" id="q_mail_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_cont">MAIL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_cont']) ?: '' }}" name="q[mail_cont]" id="q_mail_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_empresa_gt">MAIL_EMPRESA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_empresa_gt']) ?: '' }}" name="q[mail_empresa_gt]" id="q_mail_empresa_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_empresa_lt']) ?: '' }}" name="q[mail_empresa_lt]" id="q_mail_empresa_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_empresa_cont">MAIL_EMPRESA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_empresa_cont']) ?: '' }}" name="q[mail_empresa_cont]" id="q_mail_empresa_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calle_gt">CALLE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calle_gt']) ?: '' }}" name="q[calle_gt]" id="q_calle_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calle_lt']) ?: '' }}" name="q[calle_lt]" id="q_calle_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calle_cont">CALLE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calle_cont']) ?: '' }}" name="q[calle_cont]" id="q_calle_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_interior_gt">NO_INTERIOR</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_interior_gt']) ?: '' }}" name="q[no_interior_gt]" id="q_no_interior_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_interior_lt']) ?: '' }}" name="q[no_interior_lt]" id="q_no_interior_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_interior_cont">NO_INTERIOR</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_interior_cont']) ?: '' }}" name="q[no_interior_cont]" id="q_no_interior_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_exterior_gt">NO_EXTERIOR</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_exterior_gt']) ?: '' }}" name="q[no_exterior_gt]" id="q_no_exterior_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_exterior_lt']) ?: '' }}" name="q[no_exterior_lt]" id="q_no_exterior_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_exterior_cont">NO_EXTERIOR</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_exterior_cont']) ?: '' }}" name="q[no_exterior_cont]" id="q_no_exterior_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_colonia_gt">COLONIA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['colonia_gt']) ?: '' }}" name="q[colonia_gt]" id="q_colonia_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['colonia_lt']) ?: '' }}" name="q[colonia_lt]" id="q_colonia_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_colonia_cont">COLONIA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['colonia_cont']) ?: '' }}" name="q[colonia_cont]" id="q_colonia_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cp_gt">CP</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cp_gt']) ?: '' }}" name="q[cp_gt]" id="q_cp_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cp_lt']) ?: '' }}" name="q[cp_lt]" id="q_cp_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cp_cont">CP</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cp_cont']) ?: '' }}" name="q[cp_cont]" id="q_cp_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_municipios.name_gt">MUNICIPIO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['municipios.name_gt']) ?: '' }}" name="q[municipios.name_gt]" id="q_municipios.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['municipios.name_lt']) ?: '' }}" name="q[municipios.name_lt]" id="q_municipios.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_municipios.name_cont">MUNICIPIO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['municipios.name_cont']) ?: '' }}" name="q[municipios.name_cont]" id="q_municipios.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estados.name_gt">ESTADO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estados.name_gt']) ?: '' }}" name="q[estados.name_gt]" id="q_estados.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estados.name_lt']) ?: '' }}" name="q[estados.name_lt]" id="q_estados.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estados.name_cont">ESTADO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estados.name_cont']) ?: '' }}" name="q[estados.name_cont]" id="q_estados.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_clientes.name_gt">ST_CLIENTE_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_clientes.name_gt']) ?: '' }}" name="q[st_clientes.name_gt]" id="q_st_clientes.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_clientes.name_lt']) ?: '' }}" name="q[st_clientes.name_lt]" id="q_st_clientes.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_clientes.name_cont">ST_CLIENTE_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_clientes.name_cont']) ?: '' }}" name="q[st_clientes.name_cont]" id="q_st_clientes.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_distancia_escuela_gt">DISTANCIA_ESCUELA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['distancia_escuela_gt']) ?: '' }}" name="q[distancia_escuela_gt]" id="q_distancia_escuela_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['distancia_escuela_lt']) ?: '' }}" name="q[distancia_escuela_lt]" id="q_distancia_escuela_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_distancia_escuela_cont">DISTANCIA_ESCUELA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['distancia_escuela_cont']) ?: '' }}" name="q[distancia_escuela_cont]" id="q_distancia_escuela_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_peso_gt">PESO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['peso_gt']) ?: '' }}" name="q[peso_gt]" id="q_peso_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['peso_lt']) ?: '' }}" name="q[peso_lt]" id="q_peso_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_peso_cont">PESO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['peso_cont']) ?: '' }}" name="q[peso_cont]" id="q_peso_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatura_gt">ESTATURA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatura_gt']) ?: '' }}" name="q[estatura_gt]" id="q_estatura_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatura_lt']) ?: '' }}" name="q[estatura_lt]" id="q_estatura_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatura_cont">ESTATURA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatura_cont']) ?: '' }}" name="q[estatura_cont]" id="q_estatura_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_sangre_gt">TIPO_SANGRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_sangre_gt']) ?: '' }}" name="q[tipo_sangre_gt]" id="q_tipo_sangre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_sangre_lt']) ?: '' }}" name="q[tipo_sangre_lt]" id="q_tipo_sangre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_sangre_cont">TIPO_SANGRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_sangre_cont']) ?: '' }}" name="q[tipo_sangre_cont]" id="q_tipo_sangre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_alergias_gt">ALERGIAS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['alergias_gt']) ?: '' }}" name="q[alergias_gt]" id="q_alergias_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['alergias_lt']) ?: '' }}" name="q[alergias_lt]" id="q_alergias_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_alergias_cont">ALERGIAS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['alergias_cont']) ?: '' }}" name="q[alergias_cont]" id="q_alergias_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_medicinas_contraindicadas_gt">MEDICINAS_CONTRAINDICADAS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medicinas_contraindicadas_gt']) ?: '' }}" name="q[medicinas_contraindicadas_gt]" id="q_medicinas_contraindicadas_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medicinas_contraindicadas_lt']) ?: '' }}" name="q[medicinas_contraindicadas_lt]" id="q_medicinas_contraindicadas_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_medicinas_contraindicadas_cont">MEDICINAS_CONTRAINDICADAS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medicinas_contraindicadas_cont']) ?: '' }}" name="q[medicinas_contraindicadas_cont]" id="q_medicinas_contraindicadas_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_color_piel_gt">COLOR_PIEL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['color_piel_gt']) ?: '' }}" name="q[color_piel_gt]" id="q_color_piel_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['color_piel_lt']) ?: '' }}" name="q[color_piel_lt]" id="q_color_piel_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_color_piel_cont">COLOR_PIEL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['color_piel_cont']) ?: '' }}" name="q[color_piel_cont]" id="q_color_piel_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_color_cabello_gt">COLOR_CABELLO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['color_cabello_gt']) ?: '' }}" name="q[color_cabello_gt]" id="q_color_cabello_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['color_cabello_lt']) ?: '' }}" name="q[color_cabello_lt]" id="q_color_cabello_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_color_cabello_cont">COLOR_CABELLO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['color_cabello_cont']) ?: '' }}" name="q[color_cabello_cont]" id="q_color_cabello_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_senas_particulares_gt">SENAS_PARTICULARES</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['senas_particulares_gt']) ?: '' }}" name="q[senas_particulares_gt]" id="q_senas_particulares_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['senas_particulares_lt']) ?: '' }}" name="q[senas_particulares_lt]" id="q_senas_particulares_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_senas_particulares_cont">SENAS_PARTICULARES</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['senas_particulares_cont']) ?: '' }}" name="q[senas_particulares_cont]" id="q_senas_particulares_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_padre_gt">NOMBRE_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_padre_gt']) ?: '' }}" name="q[nombre_padre_gt]" id="q_nombre_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_padre_lt']) ?: '' }}" name="q[nombre_padre_lt]" id="q_nombre_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_padre_cont">NOMBRE_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_padre_cont']) ?: '' }}" name="q[nombre_padre_cont]" id="q_nombre_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_padre_gt">CURP_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_padre_gt']) ?: '' }}" name="q[curp_padre_gt]" id="q_curp_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_padre_lt']) ?: '' }}" name="q[curp_padre_lt]" id="q_curp_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_padre_cont">CURP_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_padre_cont']) ?: '' }}" name="q[curp_padre_cont]" id="q_curp_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dir_padre_gt">DIR_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_padre_gt']) ?: '' }}" name="q[dir_padre_gt]" id="q_dir_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_padre_lt']) ?: '' }}" name="q[dir_padre_lt]" id="q_dir_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dir_padre_cont">DIR_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_padre_cont']) ?: '' }}" name="q[dir_padre_cont]" id="q_dir_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_padre_gt">TEL_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_padre_gt']) ?: '' }}" name="q[tel_padre_gt]" id="q_tel_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_padre_lt']) ?: '' }}" name="q[tel_padre_lt]" id="q_tel_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_padre_cont">TEL_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_padre_cont']) ?: '' }}" name="q[tel_padre_cont]" id="q_tel_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_padre_gt">CEL_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_padre_gt']) ?: '' }}" name="q[cel_padre_gt]" id="q_cel_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_padre_lt']) ?: '' }}" name="q[cel_padre_lt]" id="q_cel_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_padre_cont">CEL_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_padre_cont']) ?: '' }}" name="q[cel_padre_cont]" id="q_cel_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_ofi_padre_gt">TEL_OFI_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_padre_gt']) ?: '' }}" name="q[tel_ofi_padre_gt]" id="q_tel_ofi_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_padre_lt']) ?: '' }}" name="q[tel_ofi_padre_lt]" id="q_tel_ofi_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_ofi_padre_cont">TEL_OFI_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_padre_cont']) ?: '' }}" name="q[tel_ofi_padre_cont]" id="q_tel_ofi_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_padre_gt">MAIL_PADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_padre_gt']) ?: '' }}" name="q[mail_padre_gt]" id="q_mail_padre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_padre_lt']) ?: '' }}" name="q[mail_padre_lt]" id="q_mail_padre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_padre_cont">MAIL_PADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_padre_cont']) ?: '' }}" name="q[mail_padre_cont]" id="q_mail_padre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_madre_gt">NOMBRE_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_madre_gt']) ?: '' }}" name="q[nombre_madre_gt]" id="q_nombre_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_madre_lt']) ?: '' }}" name="q[nombre_madre_lt]" id="q_nombre_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_madre_cont">NOMBRE_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_madre_cont']) ?: '' }}" name="q[nombre_madre_cont]" id="q_nombre_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_madre_gt">CURP_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_madre_gt']) ?: '' }}" name="q[curp_madre_gt]" id="q_curp_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_madre_lt']) ?: '' }}" name="q[curp_madre_lt]" id="q_curp_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_madre_cont">CURP_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_madre_cont']) ?: '' }}" name="q[curp_madre_cont]" id="q_curp_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dir_madre_gt">DIR_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_madre_gt']) ?: '' }}" name="q[dir_madre_gt]" id="q_dir_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_madre_lt']) ?: '' }}" name="q[dir_madre_lt]" id="q_dir_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dir_madre_cont">DIR_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_madre_cont']) ?: '' }}" name="q[dir_madre_cont]" id="q_dir_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_madre_gt">TEL_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_madre_gt']) ?: '' }}" name="q[tel_madre_gt]" id="q_tel_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_madre_lt']) ?: '' }}" name="q[tel_madre_lt]" id="q_tel_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_madre_cont">TEL_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_madre_cont']) ?: '' }}" name="q[tel_madre_cont]" id="q_tel_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_madre_gt">CEL_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_madre_gt']) ?: '' }}" name="q[cel_madre_gt]" id="q_cel_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_madre_lt']) ?: '' }}" name="q[cel_madre_lt]" id="q_cel_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_madre_cont">CEL_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_madre_cont']) ?: '' }}" name="q[cel_madre_cont]" id="q_cel_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_ofi_madre_gt">TEL_OFI_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_madre_gt']) ?: '' }}" name="q[tel_ofi_madre_gt]" id="q_tel_ofi_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_madre_lt']) ?: '' }}" name="q[tel_ofi_madre_lt]" id="q_tel_ofi_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_ofi_madre_cont">TEL_OFI_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_madre_cont']) ?: '' }}" name="q[tel_ofi_madre_cont]" id="q_tel_ofi_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_madre_gt">MAIL_MADRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_madre_gt']) ?: '' }}" name="q[mail_madre_gt]" id="q_mail_madre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_madre_lt']) ?: '' }}" name="q[mail_madre_lt]" id="q_mail_madre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_madre_cont">MAIL_MADRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_madre_cont']) ?: '' }}" name="q[mail_madre_cont]" id="q_mail_madre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_acudiente_gt">NOMBRE_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_acudiente_gt']) ?: '' }}" name="q[nombre_acudiente_gt]" id="q_nombre_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_acudiente_lt']) ?: '' }}" name="q[nombre_acudiente_lt]" id="q_nombre_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_acudiente_cont">NOMBRE_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_acudiente_cont']) ?: '' }}" name="q[nombre_acudiente_cont]" id="q_nombre_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_acudiente_gt">CURP_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_acudiente_gt']) ?: '' }}" name="q[curp_acudiente_gt]" id="q_curp_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_acudiente_lt']) ?: '' }}" name="q[curp_acudiente_lt]" id="q_curp_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_curp_acudiente_cont">CURP_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['curp_acudiente_cont']) ?: '' }}" name="q[curp_acudiente_cont]" id="q_curp_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dir_acudiente_gt">DIR_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_acudiente_gt']) ?: '' }}" name="q[dir_acudiente_gt]" id="q_dir_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_acudiente_lt']) ?: '' }}" name="q[dir_acudiente_lt]" id="q_dir_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dir_acudiente_cont">DIR_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dir_acudiente_cont']) ?: '' }}" name="q[dir_acudiente_cont]" id="q_dir_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_acudiente_gt">TEL_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_acudiente_gt']) ?: '' }}" name="q[tel_acudiente_gt]" id="q_tel_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_acudiente_lt']) ?: '' }}" name="q[tel_acudiente_lt]" id="q_tel_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_acudiente_cont">TEL_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_acudiente_cont']) ?: '' }}" name="q[tel_acudiente_cont]" id="q_tel_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_acudiente_gt">CEL_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_acudiente_gt']) ?: '' }}" name="q[cel_acudiente_gt]" id="q_cel_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_acudiente_lt']) ?: '' }}" name="q[cel_acudiente_lt]" id="q_cel_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cel_acudiente_cont">CEL_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cel_acudiente_cont']) ?: '' }}" name="q[cel_acudiente_cont]" id="q_cel_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_ofi_acudiente_gt">TEL_OFI_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_acudiente_gt']) ?: '' }}" name="q[tel_ofi_acudiente_gt]" id="q_tel_ofi_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_acudiente_lt']) ?: '' }}" name="q[tel_ofi_acudiente_lt]" id="q_tel_ofi_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_ofi_acudiente_cont">TEL_OFI_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_ofi_acudiente_cont']) ?: '' }}" name="q[tel_ofi_acudiente_cont]" id="q_tel_ofi_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_acudiente_gt">MAIL_ACUDIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_acudiente_gt']) ?: '' }}" name="q[mail_acudiente_gt]" id="q_mail_acudiente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_acudiente_lt']) ?: '' }}" name="q[mail_acudiente_lt]" id="q_mail_acudiente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_acudiente_cont">MAIL_ACUDIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_acudiente_cont']) ?: '' }}" name="q[mail_acudiente_cont]" id="q_mail_acudiente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_gt">PLANTEL_RAZON</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_gt']) ?: '' }}" name="q[plantels.razon_gt]" id="q_plantels.razon_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_lt']) ?: '' }}" name="q[plantels.razon_lt]" id="q_plantels.razon_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_cont">PLANTEL_RAZON</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_cont']) ?: '' }}" name="q[plantels.razon_cont]" id="q_plantels.razon_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_especialidads.name_gt">ESPECIALIDAD_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidads.name_gt']) ?: '' }}" name="q[especialidads.name_gt]" id="q_especialidads.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidads.name_lt']) ?: '' }}" name="q[especialidads.name_lt]" id="q_especialidads.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_especialidads.name_cont">ESPECIALIDAD_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidads.name_cont']) ?: '' }}" name="q[especialidads.name_cont]" id="q_especialidads.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivels.name_gt">NIVEL_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivels.name_gt']) ?: '' }}" name="q[nivels.name_gt]" id="q_nivels.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivels.name_lt']) ?: '' }}" name="q[nivels.name_lt]" id="q_nivels.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivels.name_cont">NIVEL_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivels.name_cont']) ?: '' }}" name="q[nivels.name_cont]" id="q_nivels.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grados.name_gt">GRADO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grados.name_gt']) ?: '' }}" name="q[grados.name_gt]" id="q_grados.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grados.name_lt']) ?: '' }}" name="q[grados.name_lt]" id="q_grados.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grados.name_cont">GRADO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grados.name_cont']) ?: '' }}" name="q[grados.name_cont]" id="q_grados.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_alumno_gt">CVE_ALUMNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_alumno_gt']) ?: '' }}" name="q[cve_alumno_gt]" id="q_cve_alumno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_alumno_lt']) ?: '' }}" name="q[cve_alumno_lt]" id="q_cve_alumno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_alumno_cont">CVE_ALUMNO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_alumno_cont']) ?: '' }}" name="q[cve_alumno_cont]" id="q_cve_alumno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_cont">USU_ALTA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_cont']) ?: '' }}" name="q[usu_alta_id_cont]" id="q_usu_alta_id_cont" />
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
            @if($alumnos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'matricula', 'title' => 'MATRICULA'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cve_alumno', 'title' => 'CLAVE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre2', 'title' => 'NOMBRE2'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ape_paterno', 'title' => 'APE_PATERNO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ape_materno', 'title' => 'APE_MATERNO'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td><a href="{{ route('alumnos.show', $alumno->id) }}">{{$alumno->id}}</a></td>
                                <td>{{$alumno->matricula}}</td>
                                <td>{{$alumno->cve_alumno}}</td>
                                <td>{{$alumno->nombre}}</td>
                                <td>{{$alumno->nombre2}}</td>
                                <td>{{$alumno->ape_paterno}}</td>
                                <td>{{$alumno->ape_materno}}</td>
                    
                                <td class="text-right">
                                    @permission('alumnos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('alumnos.duplicate', $alumno->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('alumnos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('alumnos.edit', $alumno->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('alumnos.destroy')
                                    {!! Form::model($alumno, array('route' => array('alumnos.destroy', $alumno->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $alumnos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection