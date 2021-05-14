@extends('plantillas.admin_template')

@include('cotizacionLns._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('cotizacionLns.index') }}">@yield('cotizacionLnsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('cotizacionLnsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('cotizacionLnsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('cotizacionLnsAppTitle')
            @permission('cotizacionLns.create')
            <a class="btn btn-success pull-right" href="{{ route('cotizacionLns.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CotizacionLn_search" id="search" action="{{ route('cotizacionLns.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cotizacion_cursos.no_coti_gt">COTIZACION_CURSO_NO_COTI</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cotizacion_cursos.no_coti_gt']) ?: '' }}" name="q[cotizacion_cursos.no_coti_gt]" id="q_cotizacion_cursos.no_coti_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cotizacion_cursos.no_coti_lt']) ?: '' }}" name="q[cotizacion_cursos.no_coti_lt]" id="q_cotizacion_cursos.no_coti_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cotizacion_cursos.no_coti_cont">COTIZACION_CURSO_NO_COTI</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cotizacion_cursos.no_coti_cont']) ?: '' }}" name="q[cotizacion_cursos.no_coti_cont]" id="q_cotizacion_cursos.no_coti_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_consecutivo_gt">CONSECUTIVO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['consecutivo_gt']) ?: '' }}" name="q[consecutivo_gt]" id="q_consecutivo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['consecutivo_lt']) ?: '' }}" name="q[consecutivo_lt]" id="q_consecutivo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_consecutivo_cont">CONSECUTIVO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['consecutivo_cont']) ?: '' }}" name="q[consecutivo_cont]" id="q_consecutivo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cursos_empresas.name_gt">CURSOS_EMPRESA_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cursos_empresas.name_gt']) ?: '' }}" name="q[cursos_empresas.name_gt]" id="q_cursos_empresas.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cursos_empresas.name_lt']) ?: '' }}" name="q[cursos_empresas.name_lt]" id="q_cursos_empresas.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cursos_empresas.name_cont">CURSOS_EMPRESA_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cursos_empresas.name_cont']) ?: '' }}" name="q[cursos_empresas.name_cont]" id="q_cursos_empresas.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_precio_cotis.name_gt">TIPO_PRECIO_COTI_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_precio_cotis.name_gt']) ?: '' }}" name="q[tipo_precio_cotis.name_gt]" id="q_tipo_precio_cotis.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_precio_cotis.name_lt']) ?: '' }}" name="q[tipo_precio_cotis.name_lt]" id="q_tipo_precio_cotis.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_precio_cotis.name_cont">TIPO_PRECIO_COTI_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_precio_cotis.name_cont']) ?: '' }}" name="q[tipo_precio_cotis.name_cont]" id="q_tipo_precio_cotis.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cantidad_gt">CANTIDAD</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_gt']) ?: '' }}" name="q[cantidad_gt]" id="q_cantidad_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_lt']) ?: '' }}" name="q[cantidad_lt]" id="q_cantidad_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cantidad_cont">CANTIDAD</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_cont']) ?: '' }}" name="q[cantidad_cont]" id="q_cantidad_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_precio_gt">PRECIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['precio_gt']) ?: '' }}" name="q[precio_gt]" id="q_precio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['precio_lt']) ?: '' }}" name="q[precio_lt]" id="q_precio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_precio_cont">PRECIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['precio_cont']) ?: '' }}" name="q[precio_cont]" id="q_precio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_total_gt">TOTAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['total_gt']) ?: '' }}" name="q[total_gt]" id="q_total_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['total_lt']) ?: '' }}" name="q[total_lt]" id="q_total_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_total_cont">TOTAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['total_cont']) ?: '' }}" name="q[total_cont]" id="q_total_cont" />
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
            @if($cotizacionLns->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'cotizacion_cursos.no_coti', 'title' => 'COTIZACION_CURSO_NO_COTI'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'consecutivo', 'title' => 'CONSECUTIVO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'cursos_empresas.name', 'title' => 'CURSOS_EMPRESA_NAME'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'tipo_precio_cotis.name', 'title' => 'TIPO_PRECIO_COTI_NAME'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'cantidad', 'title' => 'CANTIDAD'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'precio', 'title' => 'PRECIO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'total', 'title' => 'TOTAL'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cotizacionLns as $cotizacionLn)
                            <tr>
                                <td><a href="{{ route('cotizacionLns.show', $cotizacionLn->id) }}">{{$cotizacionLn->id}}</a></td>
                                <td>{{$cotizacionLn->cotizacionCurso->no_coti}}</td>
                    <td>{{$cotizacionLn->consecutivo}}</td>
                    <td>{{$cotizacionLn->cursosEmpresa->name}}</td>
                    <td>{{$cotizacionLn->tipoPrecioCoti->name}}</td>
                    <td>{{$cotizacionLn->cantidad}}</td>
                    <td>{{$cotizacionLn->precio}}</td>
                    <td>{{$cotizacionLn->total}}</td>
                    <td>{{$cotizacionLn->usu_alta_id}}</td>
                    <td>{{$cotizacionLn->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('cotizacionLns.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('cotizacionLns.duplicate', $cotizacionLn->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('cotizacionLns.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('cotizacionLns.edit', $cotizacionLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('cotizacionLns.destroy')
                                    {!! Form::model($cotizacionLn, array('route' => array('cotizacionLns.destroy', $cotizacionLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $cotizacionLns->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection