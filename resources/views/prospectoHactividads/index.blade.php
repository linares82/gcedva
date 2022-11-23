@extends('plantillas.admin_template')

@include('prospectoHactividads._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('prospectoHactividads.index') }}">@yield('prospectoHactividadsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('prospectoHactividadsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('prospectoHactividadsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('prospectoHactividadsAppTitle')
            @permission('prospectoHactividads.create')
            <a class="btn btn-success pull-right" href="{{ route('prospectoHactividads.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="ProspectoHactividad_search" id="search" action="{{ route('prospectoHactividads.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_id_gt">PROSPECTO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_id_gt']) ?: '' }}" name="q[prospecto_id_gt]" id="q_prospecto_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_id_lt']) ?: '' }}" name="q[prospecto_id_lt]" id="q_prospecto_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_id_cont">PROSPECTO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_id_cont']) ?: '' }}" name="q[prospecto_id_cont]" id="q_prospecto_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_seguimiento_id_gt">PROSPECTO_SEGUIMIENTO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_seguimiento_id_gt']) ?: '' }}" name="q[prospecto_seguimiento_id_gt]" id="q_prospecto_seguimiento_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_seguimiento_id_lt']) ?: '' }}" name="q[prospecto_seguimiento_id_lt]" id="q_prospecto_seguimiento_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_seguimiento_id_cont">PROSPECTO_SEGUIMIENTO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_seguimiento_id_cont']) ?: '' }}" name="q[prospecto_seguimiento_id_cont]" id="q_prospecto_seguimiento_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tarea_gt">TAREA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tarea_gt']) ?: '' }}" name="q[tarea_gt]" id="q_tarea_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tarea_lt']) ?: '' }}" name="q[tarea_lt]" id="q_tarea_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tarea_cont">TAREA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tarea_cont']) ?: '' }}" name="q[tarea_cont]" id="q_tarea_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_gt">FECHA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_gt']) ?: '' }}" name="q[fecha_gt]" id="q_fecha_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_lt']) ?: '' }}" name="q[fecha_lt]" id="q_fecha_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_cont">FECHA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_cont']) ?: '' }}" name="q[fecha_cont]" id="q_fecha_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_hora_gt">HORA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['hora_gt']) ?: '' }}" name="q[hora_gt]" id="q_hora_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['hora_lt']) ?: '' }}" name="q[hora_lt]" id="q_hora_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_hora_cont">HORA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['hora_cont']) ?: '' }}" name="q[hora_cont]" id="q_hora_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asunto_gt">ASUNTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asunto_gt']) ?: '' }}" name="q[asunto_gt]" id="q_asunto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asunto_lt']) ?: '' }}" name="q[asunto_lt]" id="q_asunto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asunto_cont">ASUNTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asunto_cont']) ?: '' }}" name="q[asunto_cont]" id="q_asunto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_gt">DETALLE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_gt']) ?: '' }}" name="q[detalle_gt]" id="q_detalle_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_lt']) ?: '' }}" name="q[detalle_lt]" id="q_detalle_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_cont">DETALLE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_cont']) ?: '' }}" name="q[detalle_cont]" id="q_detalle_cont" />
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
            @if($prospectoHactividads->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'prospecto_id', 'title' => 'PROSPECTO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'prospecto_seguimiento_id', 'title' => 'PROSPECTO_SEGUIMIENTO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tarea', 'title' => 'TAREA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'hora', 'title' => 'HORA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'asunto', 'title' => 'ASUNTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'detalle', 'title' => 'DETALLE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prospectoHactividads as $prospectoHactividad)
                            <tr>
                                <td><a href="{{ route('prospectoHactividads.show', $prospectoHactividad->id) }}">{{$prospectoHactividad->id}}</a></td>
                                <td>{{$prospectoHactividad->prospecto_id}}</td>
                    <td>{{$prospectoHactividad->prospecto_seguimiento_id}}</td>
                    <td>{{$prospectoHactividad->tarea}}</td>
                    <td>{{$prospectoHactividad->fecha}}</td>
                    <td>{{$prospectoHactividad->hora}}</td>
                    <td>{{$prospectoHactividad->asunto}}</td>
                    <td>{{$prospectoHactividad->detalle}}</td>
                    <td>{{$prospectoHactividad->usu_alta_id}}</td>
                    <td>{{$prospectoHactividad->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('prospectoHactividads.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('prospectoHactividads.duplicate', $prospectoHactividad->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('prospectoHactividads.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('prospectoHactividads.edit', $prospectoHactividad->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('prospectoHactividads.destroy')
                                    {!! Form::model($prospectoHactividad, array('route' => array('prospectoHactividads.destroy', $prospectoHactividad->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $prospectoHactividads->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection