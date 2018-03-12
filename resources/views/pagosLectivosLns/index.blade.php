@extends('plantillas.admin_template')

@include('pagosLectivosLns._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('pagosLectivosLns.index') }}">@yield('pagosLectivosLnsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('pagosLectivosLnsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('pagosLectivosLnsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('pagosLectivosLnsAppTitle')
            @permission('pagosLectivosLns.create')
            <a class="btn btn-success pull-right" href="{{ route('pagosLectivosLns.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="PagosLectivosLn_search" id="search" action="{{ route('pagosLectivosLns.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_pagos_lectivo_id_gt">PAGOS_LECTIVO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['pagos_lectivo_id_gt']) ?: '' }}" name="q[pagos_lectivo_id_gt]" id="q_pagos_lectivo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['pagos_lectivo_id_lt']) ?: '' }}" name="q[pagos_lectivo_id_lt]" id="q_pagos_lectivo_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_pagos_lectivo_id_cont">PAGOS_LECTIVO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['pagos_lectivo_id_cont']) ?: '' }}" name="q[pagos_lectivo_id_cont]" id="q_pagos_lectivo_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clave_gt">CLAVE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clave_gt']) ?: '' }}" name="q[clave_gt]" id="q_clave_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clave_lt']) ?: '' }}" name="q[clave_lt]" id="q_clave_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clave_cont">CLAVE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clave_cont']) ?: '' }}" name="q[clave_cont]" id="q_clave_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_concepto_gt">CONCEPTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_gt']) ?: '' }}" name="q[concepto_gt]" id="q_concepto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_lt']) ?: '' }}" name="q[concepto_lt]" id="q_concepto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_concepto_cont">CONCEPTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_cont']) ?: '' }}" name="q[concepto_cont]" id="q_concepto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_corto_gt">NOMBRE_CORTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_corto_gt']) ?: '' }}" name="q[nombre_corto_gt]" id="q_nombre_corto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_corto_lt']) ?: '' }}" name="q[nombre_corto_lt]" id="q_nombre_corto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_corto_cont">NOMBRE_CORTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_corto_cont']) ?: '' }}" name="q[nombre_corto_cont]" id="q_nombre_corto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_mase_gt">MONTO_MASE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_mase_gt']) ?: '' }}" name="q[monto_mase_gt]" id="q_monto_mase_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_mase_lt']) ?: '' }}" name="q[monto_mase_lt]" id="q_monto_mase_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_mase_cont">MONTO_MASE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_mase_cont']) ?: '' }}" name="q[monto_mase_cont]" id="q_monto_mase_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_seriacion_id_gt">SERIACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['seriacion_id_gt']) ?: '' }}" name="q[seriacion_id_gt]" id="q_seriacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['seriacion_id_lt']) ?: '' }}" name="q[seriacion_id_lt]" id="q_seriacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_seriacion_id_cont">SERIACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['seriacion_id_cont']) ?: '' }}" name="q[seriacion_id_cont]" id="q_seriacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_contable_id_gt">CUENTA_CONTABLE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contable_id_gt']) ?: '' }}" name="q[cuenta_contable_id_gt]" id="q_cuenta_contable_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contable_id_lt']) ?: '' }}" name="q[cuenta_contable_id_lt]" id="q_cuenta_contable_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_contable_id_cont">CUENTA_CONTABLE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contable_id_cont']) ?: '' }}" name="q[cuenta_contable_id_cont]" id="q_cuenta_contable_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inicio_gt">FEC_INICIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inicio_gt']) ?: '' }}" name="q[fec_inicio_gt]" id="q_fec_inicio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inicio_lt']) ?: '' }}" name="q[fec_inicio_lt]" id="q_fec_inicio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inicio_cont">FEC_INICIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inicio_cont']) ?: '' }}" name="q[fec_inicio_cont]" id="q_fec_inicio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_contable_recargo_id_gt">CUENTA_CONTABLE_RECARGO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contable_recargo_id_gt']) ?: '' }}" name="q[cuenta_contable_recargo_id_gt]" id="q_cuenta_contable_recargo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contable_recargo_id_lt']) ?: '' }}" name="q[cuenta_contable_recargo_id_lt]" id="q_cuenta_contable_recargo_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_contable_recargo_id_cont">CUENTA_CONTABLE_RECARGO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contable_recargo_id_cont']) ?: '' }}" name="q[cuenta_contable_recargo_id_cont]" id="q_cuenta_contable_recargo_id_cont" />
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
            @if($pagosLectivosLns->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'pagos_lectivo_id', 'title' => 'PAGOS_LECTIVO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clave', 'title' => 'CLAVE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'concepto', 'title' => 'CONCEPTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre_corto', 'title' => 'NOMBRE_CORTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'monto_mase', 'title' => 'MONTO_MASE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'seriacion_id', 'title' => 'SERIACION_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cuenta_contable_id', 'title' => 'CUENTA_CONTABLE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fec_inicio', 'title' => 'FEC_INICIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cuenta_contable_recargo_id', 'title' => 'CUENTA_CONTABLE_RECARGO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pagosLectivosLns as $pagosLectivosLn)
                            <tr>
                                <td><a href="{{ route('pagosLectivosLns.show', $pagosLectivosLn->id) }}">{{$pagosLectivosLn->id}}</a></td>
                                <td>{{$pagosLectivosLn->pagos_lectivo_id}}</td>
                    <td>{{$pagosLectivosLn->clave}}</td>
                    <td>{{$pagosLectivosLn->concepto}}</td>
                    <td>{{$pagosLectivosLn->nombre_corto}}</td>
                    <td>{{$pagosLectivosLn->monto_mase}}</td>
                    <td>{{$pagosLectivosLn->seriacion_id}}</td>
                    <td>{{$pagosLectivosLn->cuenta_contable_id}}</td>
                    <td>{{$pagosLectivosLn->fec_inicio}}</td>
                    <td>{{$pagosLectivosLn->cuenta_contable_recargo_id}}</td>
                    <td>{{$pagosLectivosLn->usu_alta_id}}</td>
                    <td>{{$pagosLectivosLn->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('pagosLectivosLns.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('pagosLectivosLns.duplicate', $pagosLectivosLn->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('pagosLectivosLns.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('pagosLectivosLns.edit', $pagosLectivosLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('pagosLectivosLns.destroy')
                                    {!! Form::model($pagosLectivosLn, array('route' => array('pagosLectivosLns.destroy', $pagosLectivosLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $pagosLectivosLns->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection