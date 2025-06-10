@extends('plantillas.admin_template')

@include('procedenciaAlumnos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('procedenciaAlumnos.index') }}">@yield('procedenciaAlumnosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('procedenciaAlumnosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('procedenciaAlumnosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('procedenciaAlumnosAppTitle')
            @permission('procedenciaAlumnos.create')
            <a class="btn btn-success pull-right" href="{{ route('procedenciaAlumnos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="ProcedenciaAlumno_search" id="search" action="{{ route('procedenciaAlumnos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

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
                                <label class="col-sm-2 control-label" for="q_estado_id_gt">ESTADO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_id_gt']) ?: '' }}" name="q[estado_id_gt]" id="q_estado_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_id_lt']) ?: '' }}" name="q[estado_id_lt]" id="q_estado_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estado_id_cont">ESTADO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_id_cont']) ?: '' }}" name="q[estado_id_cont]" id="q_estado_id_cont" />
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
                                <label class="col-sm-2 control-label" for="q_fecha_terminacion_gt">FECHA_TERMINACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_terminacion_gt']) ?: '' }}" name="q[fecha_terminacion_gt]" id="q_fecha_terminacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_terminacion_lt']) ?: '' }}" name="q[fecha_terminacion_lt]" id="q_fecha_terminacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_terminacion_cont">FECHA_TERMINACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_terminacion_cont']) ?: '' }}" name="q[fecha_terminacion_cont]" id="q_fecha_terminacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_numero_cedula_string_gt">NUMERO_CEDULA_STRING</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['numero_cedula_string_gt']) ?: '' }}" name="q[numero_cedula_string_gt]" id="q_numero_cedula_string_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['numero_cedula_string_lt']) ?: '' }}" name="q[numero_cedula_string_lt]" id="q_numero_cedula_string_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_numero_cedula_string_cont">NUMERO_CEDULA_STRING</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['numero_cedula_string_cont']) ?: '' }}" name="q[numero_cedula_string_cont]" id="q_numero_cedula_string_cont" />
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
            @if($procedenciaAlumnos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cliente_id', 'title' => 'CLIENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'institucion_procedencia', 'title' => 'INSTITUCION_PROCEDENCIA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_t_estudio_antecedente_id', 'title' => 'SEP_T_ESTUDIO_ANTECEDENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'estado_id', 'title' => 'ESTADO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_inicio', 'title' => 'FECHA_INICIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_terminacion', 'title' => 'FECHA_TERMINACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'numero_cedula_string', 'title' => 'NUMERO_CEDULA_STRING'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($procedenciaAlumnos as $procedenciaAlumno)
                            <tr>
                                <td><a href="{{ route('procedenciaAlumnos.show', $procedenciaAlumno->id) }}">{{$procedenciaAlumno->id}}</a></td>
                                <td>{{$procedenciaAlumno->cliente_id}}</td>
                    <td>{{$procedenciaAlumno->institucion_procedencia}}</td>
                    <td>{{$procedenciaAlumno->sep_t_estudio_antecedente_id}}</td>
                    <td>{{$procedenciaAlumno->estado_id}}</td>
                    <td>{{$procedenciaAlumno->fecha_inicio}}</td>
                    <td>{{$procedenciaAlumno->fecha_terminacion}}</td>
                    <td>{{$procedenciaAlumno->numero_cedula_string}}</td>
                    <td>{{$procedenciaAlumno->usu_alta_id}}</td>
                    <td>{{$procedenciaAlumno->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('procedenciaAlumnos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('procedenciaAlumnos.duplicate', $procedenciaAlumno->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('procedenciaAlumnos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('procedenciaAlumnos.edit', $procedenciaAlumno->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('procedenciaAlumnos.destroy')
                                    {!! Form::model($procedenciaAlumno, array('route' => array('procedenciaAlumnos.destroy', $procedenciaAlumno->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $procedenciaAlumnos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection