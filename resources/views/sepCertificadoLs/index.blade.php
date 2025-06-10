@extends('plantillas.admin_template')

@include('sepCertificadoLs._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepCertificadoLs.index') }}">@yield('sepCertificadoLsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepCertificadoLsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepCertificadoLsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepCertificadoLsAppTitle')
            @permission('sepCertificadoLs.create')
            <a class="btn btn-success pull-right" href="{{ route('sepCertificadoLs.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepCertificadoL_search" id="search" action="{{ route('sepCertificadoLs.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_certificado_id_gt">SEP_CERTIFICADO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_certificado_id_gt']) ?: '' }}" name="q[sep_certificado_id_gt]" id="q_sep_certificado_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_certificado_id_lt']) ?: '' }}" name="q[sep_certificado_id_lt]" id="q_sep_certificado_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_certificado_id_cont">SEP_CERTIFICADO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_certificado_id_cont']) ?: '' }}" name="q[sep_certificado_id_cont]" id="q_sep_certificado_id_cont" />
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
                                <label class="col-sm-2 control-label" for="q_hacademica_id_id_gt">HACADEMICA_ID_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['hacademica_id_id_gt']) ?: '' }}" name="q[hacademica_id_id_gt]" id="q_hacademica_id_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['hacademica_id_id_lt']) ?: '' }}" name="q[hacademica_id_id_lt]" id="q_hacademica_id_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_hacademica_id_id_cont">HACADEMICA_ID_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['hacademica_id_id_cont']) ?: '' }}" name="q[hacademica_id_id_cont]" id="q_hacademica_id_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_cert_id_gt">SEP_CERT_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cert_id_gt']) ?: '' }}" name="q[sep_cert_id_gt]" id="q_sep_cert_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cert_id_lt']) ?: '' }}" name="q[sep_cert_id_lt]" id="q_sep_cert_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_cert_id_cont">SEP_CERT_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cert_id_cont']) ?: '' }}" name="q[sep_cert_id_cont]" id="q_sep_cert_id_cont" />
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
                                <label class="col-sm-2 control-label" for="q_id_carrera_gt">ID_CARRERA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_carrera_gt']) ?: '' }}" name="q[id_carrera_gt]" id="q_id_carrera_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_carrera_lt']) ?: '' }}" name="q[id_carrera_lt]" id="q_id_carrera_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_carrera_cont">ID_CARRERA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_carrera_cont']) ?: '' }}" name="q[id_carrera_cont]" id="q_id_carrera_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_asignatura_gt">ID_ASIGNATURA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_asignatura_gt']) ?: '' }}" name="q[id_asignatura_gt]" id="q_id_asignatura_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_asignatura_lt']) ?: '' }}" name="q[id_asignatura_lt]" id="q_id_asignatura_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_asignatura_cont">ID_ASIGNATURA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_asignatura_cont']) ?: '' }}" name="q[id_asignatura_cont]" id="q_id_asignatura_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_numero_asignaturas_cursadas_gt">NUMERO_ASIGNATURAS_CURSADAS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['numero_asignaturas_cursadas_gt']) ?: '' }}" name="q[numero_asignaturas_cursadas_gt]" id="q_numero_asignaturas_cursadas_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['numero_asignaturas_cursadas_lt']) ?: '' }}" name="q[numero_asignaturas_cursadas_lt]" id="q_numero_asignaturas_cursadas_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_numero_asignaturas_cursadas_cont">NUMERO_ASIGNATURAS_CURSADAS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['numero_asignaturas_cursadas_cont']) ?: '' }}" name="q[numero_asignaturas_cursadas_cont]" id="q_numero_asignaturas_cursadas_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_promedio_general_gt">PROMEDIO_GENERAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['promedio_general_gt']) ?: '' }}" name="q[promedio_general_gt]" id="q_promedio_general_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['promedio_general_lt']) ?: '' }}" name="q[promedio_general_lt]" id="q_promedio_general_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_promedio_general_cont">PROMEDIO_GENERAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['promedio_general_cont']) ?: '' }}" name="q[promedio_general_cont]" id="q_promedio_general_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_cert_observacion_id_gt">SEP_CERT_OBSERVACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cert_observacion_id_gt']) ?: '' }}" name="q[sep_cert_observacion_id_gt]" id="q_sep_cert_observacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cert_observacion_id_lt']) ?: '' }}" name="q[sep_cert_observacion_id_lt]" id="q_sep_cert_observacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_cert_observacion_id_cont">SEP_CERT_OBSERVACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cert_observacion_id_cont']) ?: '' }}" name="q[sep_cert_observacion_id_cont]" id="q_sep_cert_observacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_bnd_descargar_gt">BND_DESCARGAR</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_descargar_gt']) ?: '' }}" name="q[bnd_descargar_gt]" id="q_bnd_descargar_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_descargar_lt']) ?: '' }}" name="q[bnd_descargar_lt]" id="q_bnd_descargar_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_bnd_descargar_cont">BND_DESCARGAR</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_descargar_cont']) ?: '' }}" name="q[bnd_descargar_cont]" id="q_bnd_descargar_cont" />
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
            @if($sepCertificadoLs->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_certificado_id', 'title' => 'SEP_CERTIFICADO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cliente_id', 'title' => 'CLIENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'hacademica_id_id', 'title' => 'HACADEMICA_ID_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_cert_id', 'title' => 'SEP_CERT_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_expedicion', 'title' => 'FECHA_EXPEDICION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_carrera', 'title' => 'ID_CARRERA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_asignatura', 'title' => 'ID_ASIGNATURA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'numero_asignaturas_cursadas', 'title' => 'NUMERO_ASIGNATURAS_CURSADAS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'promedio_general', 'title' => 'PROMEDIO_GENERAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_cert_observacion_id', 'title' => 'SEP_CERT_OBSERVACION_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'bnd_descargar', 'title' => 'BND_DESCARGAR'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepCertificadoLs as $sepCertificadoL)
                            <tr>
                                <td><a href="{{ route('sepCertificadoLs.show', $sepCertificadoL->id) }}">{{$sepCertificadoL->id}}</a></td>
                                <td>{{$sepCertificadoL->sep_certificado_id}}</td>
                    <td>{{$sepCertificadoL->cliente_id}}</td>
                    <td>{{$sepCertificadoL->hacademica_id_id}}</td>
                    <td>{{$sepCertificadoL->sep_cert_id}}</td>
                    <td>{{$sepCertificadoL->fecha_expedicion}}</td>
                    <td>{{$sepCertificadoL->id_carrera}}</td>
                    <td>{{$sepCertificadoL->id_asignatura}}</td>
                    <td>{{$sepCertificadoL->numero_asignaturas_cursadas}}</td>
                    <td>{{$sepCertificadoL->promedio_general}}</td>
                    <td>{{$sepCertificadoL->sep_cert_observacion_id}}</td>
                    <td>{{$sepCertificadoL->bnd_descargar}}</td>
                    <td>{{$sepCertificadoL->usu_mod_id}}</td>
                    <td>{{$sepCertificadoL->usu_alta_id}}</td>
                                <td class="text-right">
                                    @permission('sepCertificadoLs.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepCertificadoLs.duplicate', $sepCertificadoL->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepCertificadoLs.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepCertificadoLs.edit', $sepCertificadoL->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepCertificadoLs.destroy')
                                    {!! Form::model($sepCertificadoL, array('route' => array('sepCertificadoLs.destroy', $sepCertificadoL->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepCertificadoLs->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection