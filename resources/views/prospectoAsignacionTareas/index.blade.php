@extends('plantillas.admin_template')

@include('prospectoAsignacionTareas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('prospectoAsignacionTareas.index') }}">@yield('prospectoAsignacionTareasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('prospectoAsignacionTareasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('prospectoAsignacionTareasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('prospectoAsignacionTareasAppTitle')
            @permission('prospectoAsignacionTareas.create')
            <a class="btn btn-success pull-right" href="{{ route('prospectoAsignacionTareas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="ProspectoAsignacionTarea_search" id="search" action="{{ route('prospectoAsignacionTareas.index') }}" accept-charset="UTF-8" method="get">
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
                                <label class="col-sm-2 control-label" for="q_empleado_id_gt">EMPLEADO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleado_id_gt']) ?: '' }}" name="q[empleado_id_gt]" id="q_empleado_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleado_id_lt']) ?: '' }}" name="q[empleado_id_lt]" id="q_empleado_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleado_id_cont">EMPLEADO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleado_id_cont']) ?: '' }}" name="q[empleado_id_cont]" id="q_empleado_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_tarea_id_gt">PROSPECTO_TAREA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_tarea_id_gt']) ?: '' }}" name="q[prospecto_tarea_id_gt]" id="q_prospecto_tarea_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_tarea_id_lt']) ?: '' }}" name="q[prospecto_tarea_id_lt]" id="q_prospecto_tarea_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_tarea_id_cont">PROSPECTO_TAREA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_tarea_id_cont']) ?: '' }}" name="q[prospecto_tarea_id_cont]" id="q_prospecto_tarea_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_asunto_id_gt">PROSPECTO_ASUNTO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_asunto_id_gt']) ?: '' }}" name="q[prospecto_asunto_id_gt]" id="q_prospecto_asunto_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_asunto_id_lt']) ?: '' }}" name="q[prospecto_asunto_id_lt]" id="q_prospecto_asunto_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_prospecto_asunto_id_cont">PROSPECTO_ASUNTO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['prospecto_asunto_id_cont']) ?: '' }}" name="q[prospecto_asunto_id_cont]" id="q_prospecto_asunto_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_propecto_st_seg_id_gt">PROPECTO_ST_SEG_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['propecto_st_seg_id_gt']) ?: '' }}" name="q[propecto_st_seg_id_gt]" id="q_propecto_st_seg_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['propecto_st_seg_id_lt']) ?: '' }}" name="q[propecto_st_seg_id_lt]" id="q_propecto_st_seg_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_propecto_st_seg_id_cont">PROPECTO_ST_SEG_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['propecto_st_seg_id_cont']) ?: '' }}" name="q[propecto_st_seg_id_cont]" id="q_propecto_st_seg_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_obs_gt">OBS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['obs_gt']) ?: '' }}" name="q[obs_gt]" id="q_obs_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['obs_lt']) ?: '' }}" name="q[obs_lt]" id="q_obs_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_obs_cont">OBS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['obs_cont']) ?: '' }}" name="q[obs_cont]" id="q_obs_cont" />
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
            @if($prospectoAsignacionTareas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'prospecto_id', 'title' => 'PROSPECTO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'empleado_id', 'title' => 'EMPLEADO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'prospecto_tarea_id', 'title' => 'PROSPECTO_TAREA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'prospecto_asunto_id', 'title' => 'PROSPECTO_ASUNTO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'propecto_st_seg_id', 'title' => 'PROPECTO_ST_SEG_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'obs', 'title' => 'OBS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prospectoAsignacionTareas as $prospectoAsignacionTarea)
                            <tr>
                                <td><a href="{{ route('prospectoAsignacionTareas.show', $prospectoAsignacionTarea->id) }}">{{$prospectoAsignacionTarea->id}}</a></td>
                                <td>{{$prospectoAsignacionTarea->prospecto_id}}</td>
                    <td>{{$prospectoAsignacionTarea->empleado_id}}</td>
                    <td>{{$prospectoAsignacionTarea->prospecto_tarea_id}}</td>
                    <td>{{$prospectoAsignacionTarea->prospecto_asunto_id}}</td>
                    <td>{{$prospectoAsignacionTarea->propecto_st_seg_id}}</td>
                    <td>{{$prospectoAsignacionTarea->obs}}</td>
                    <td>{{$prospectoAsignacionTarea->usu_alta_id}}</td>
                    <td>{{$prospectoAsignacionTarea->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('prospectoAsignacionTareas.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('prospectoAsignacionTareas.duplicate', $prospectoAsignacionTarea->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('prospectoAsignacionTareas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('prospectoAsignacionTareas.edit', $prospectoAsignacionTarea->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('prospectoAsignacionTareas.destroy')
                                    {!! Form::model($prospectoAsignacionTarea, array('route' => array('prospectoAsignacionTareas.destroy', $prospectoAsignacionTarea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $prospectoAsignacionTareas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection