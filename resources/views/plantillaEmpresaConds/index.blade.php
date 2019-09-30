@extends('plantillas.admin_template')

@include('plantillaEmpresaConds._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('plantillaEmpresaConds.index') }}">@yield('plantillaEmpresaCondsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('plantillaEmpresaCondsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('plantillaEmpresaCondsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('plantillaEmpresaCondsAppTitle')
            @permission('plantillaEmpresaConds.create')
            <a class="btn btn-success pull-right" href="{{ route('plantillaEmpresaConds.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="PlantillaEmpresaCond_search" id="search" action="{{ route('plantillaEmpresaConds.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantilla_empresas.nombre_gt">PLANTILLA_EMPRESA_NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantilla_empresas.nombre_gt']) ?: '' }}" name="q[plantilla_empresas.nombre_gt]" id="q_plantilla_empresas.nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantilla_empresas.nombre_lt']) ?: '' }}" name="q[plantilla_empresas.nombre_lt]" id="q_plantilla_empresas.nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantilla_empresas.nombre_cont">PLANTILLA_EMPRESA_NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantilla_empresas.nombre_cont']) ?: '' }}" name="q[plantilla_empresas.nombre_cont]" id="q_plantilla_empresas.nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_operador_condicion_gt">OPERADOR_CONDICION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['operador_condicion_gt']) ?: '' }}" name="q[operador_condicion_gt]" id="q_operador_condicion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['operador_condicion_lt']) ?: '' }}" name="q[operador_condicion_lt]" id="q_operador_condicion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_operador_condicion_cont">OPERADOR_CONDICION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['operador_condicion_cont']) ?: '' }}" name="q[operador_condicion_cont]" id="q_operador_condicion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantilla_empresa_campos.campo_gt">PLANTILLA_EMPRESA_CAMPO_CAMPO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantilla_empresa_campos.campo_gt']) ?: '' }}" name="q[plantilla_empresa_campos.campo_gt]" id="q_plantilla_empresa_campos.campo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantilla_empresa_campos.campo_lt']) ?: '' }}" name="q[plantilla_empresa_campos.campo_lt]" id="q_plantilla_empresa_campos.campo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantilla_empresa_campos.campo_cont">PLANTILLA_EMPRESA_CAMPO_CAMPO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantilla_empresa_campos.campo_cont']) ?: '' }}" name="q[plantilla_empresa_campos.campo_cont]" id="q_plantilla_empresa_campos.campo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_signo_comparacion_gt">SIGNO_COMPARACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['signo_comparacion_gt']) ?: '' }}" name="q[signo_comparacion_gt]" id="q_signo_comparacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['signo_comparacion_lt']) ?: '' }}" name="q[signo_comparacion_lt]" id="q_signo_comparacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_signo_comparacion_cont">SIGNO_COMPARACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['signo_comparacion_cont']) ?: '' }}" name="q[signo_comparacion_cont]" id="q_signo_comparacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_valor_condicion_gt">VALOR_CONDICION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['valor_condicion_gt']) ?: '' }}" name="q[valor_condicion_gt]" id="q_valor_condicion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['valor_condicion_lt']) ?: '' }}" name="q[valor_condicion_lt]" id="q_valor_condicion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_valor_condicion_cont">VALOR_CONDICION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['valor_condicion_cont']) ?: '' }}" name="q[valor_condicion_cont]" id="q_valor_condicion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_interpretacion_gt">INTERPRETACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['interpretacion_gt']) ?: '' }}" name="q[interpretacion_gt]" id="q_interpretacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['interpretacion_lt']) ?: '' }}" name="q[interpretacion_lt]" id="q_interpretacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_interpretacion_cont">INTERPRETACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['interpretacion_cont']) ?: '' }}" name="q[interpretacion_cont]" id="q_interpretacion_cont" />
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
            @if($plantillaEmpresaConds->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantilla_empresas.nombre', 'title' => 'PLANTILLA_EMPRESA_NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'operador_condicion', 'title' => 'OPERADOR_CONDICION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantilla_empresa_campos.campo', 'title' => 'PLANTILLA_EMPRESA_CAMPO_CAMPO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'signo_comparacion', 'title' => 'SIGNO_COMPARACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'valor_condicion', 'title' => 'VALOR_CONDICION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'interpretacion', 'title' => 'INTERPRETACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($plantillaEmpresaConds as $plantillaEmpresaCond)
                            <tr>
                                <td><a href="{{ route('plantillaEmpresaConds.show', $plantillaEmpresaCond->id) }}">{{$plantillaEmpresaCond->id}}</a></td>
                                <td>{{$plantillaEmpresaCond->plantillaEmpresa->nombre}}</td>
                    <td>{{$plantillaEmpresaCond->operador_condicion}}</td>
                    <td>{{$plantillaEmpresaCond->plantillaEmpresaCampo->campo}}</td>
                    <td>{{$plantillaEmpresaCond->signo_comparacion}}</td>
                    <td>{{$plantillaEmpresaCond->valor_condicion}}</td>
                    <td>{{$plantillaEmpresaCond->interpretacion}}</td>
                    <td>{{$plantillaEmpresaCond->usu_alta_id}}</td>
                    <td>{{$plantillaEmpresaCond->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('plantillaEmpresaConds.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('plantillaEmpresaConds.duplicate', $plantillaEmpresaCond->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('plantillaEmpresaConds.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('plantillaEmpresaConds.edit', $plantillaEmpresaCond->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('plantillaEmpresaConds.destroy')
                                    {!! Form::model($plantillaEmpresaCond, array('route' => array('plantillaEmpresaConds.destroy', $plantillaEmpresaCond->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $plantillaEmpresaConds->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection