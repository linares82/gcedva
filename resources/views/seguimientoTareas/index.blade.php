@extends('plantillas.admin_template')

@include('seguimientoTareas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('seguimientoTareas.index') }}">@yield('seguimientoTareasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('seguimientoTareasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('seguimientoTareasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('seguimientoTareasAppTitle')
            @permission('seguimientoTareas.create')
            <a class="btn btn-success pull-right" href="{{ route('seguimientoTareas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SeguimientoTarea_search" id="search" action="{{ route('seguimientoTareas.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asignacion_tarea_id_gt">ASIGNACION_TAREA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['asignacion_tarea_id_gt']) ?: '' }}" name="q[asignacion_tarea_id_gt]" id="q_asignacion_tarea_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['asignacion_tarea_id_lt']) ?: '' }}" name="q[asignacion_tarea_id_lt]" id="q_asignacion_tarea_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_asignacion_tarea_id_cont">ASIGNACION_TAREA_ID</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['asignacion_tarea_id_cont']) ?: '' }}" name="q[asignacion_tarea_id_cont]" id="q_asignacion_tarea_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatus_id_gt">ESTATUS_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['estatus_id_gt']) ?: '' }}" name="q[estatus_id_gt]" id="q_estatus_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['estatus_id_lt']) ?: '' }}" name="q[estatus_id_lt]" id="q_estatus_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_estatus_id_cont">ESTATUS_ID</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['estatus_id_cont']) ?: '' }}" name="q[estatus_id_cont]" id="q_estatus_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_gt">DETALLE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['detalle_gt']) ?: '' }}" name="q[detalle_gt]" id="q_detalle_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['detalle_lt']) ?: '' }}" name="q[detalle_lt]" id="q_detalle_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_detalle_cont">DETALLE</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['detalle_cont']) ?: '' }}" name="q[detalle_cont]" id="q_detalle_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_usu_alta_id_cont">USU_ALTA_ID</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_cont']) ?: '' }}" name="q[usu_alta_id_cont]" id="q_usu_alta_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_gt">USU_MOD_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_mod_id_gt']) ?: '' }}" name="q[usu_mod_id_gt]" id="q_usu_mod_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_mod_id_lt']) ?: '' }}" name="q[usu_mod_id_lt]" id="q_usu_mod_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_usu_mod_id_cont">USU_MOD_ID</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_mod_id_cont']) ?: '' }}" name="q[usu_mod_id_cont]" id="q_usu_mod_id_cont" />
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
            @if($seguimientoTareas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'asignacion_tarea_id', 'title' => 'ASIGNACION_TAREA_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'estatus_id', 'title' => 'ESTATUS_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'detalle', 'title' => 'DETALLE'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($seguimientoTareas as $seguimientoTarea)
                            <tr>
                                <td><a href="{{ route('seguimientoTareas.show', $seguimientoTarea->id) }}">{{$seguimientoTarea->id}}</a></td>
                                <td>{{$seguimientoTarea->asignacion_tarea_id}}</td>
                    <td>{{$seguimientoTarea->estatus_id}}</td>
                    <td>{{$seguimientoTarea->detalle}}</td>
                    <td>{{$seguimientoTarea->usu_alta_id}}</td>
                    <td>{{$seguimientoTarea->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('seguimientoTareas.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('seguimientoTareas.duplicate', $seguimientoTarea->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('seguimientoTareas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('seguimientoTareas.edit', $seguimientoTarea->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('seguimientoTareas.destroy')
                                    {!! Form::model($seguimientoTarea, array('route' => array('seguimientoTareas.destroy', $seguimientoTarea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $seguimientoTareas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection