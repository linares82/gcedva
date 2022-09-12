@extends('plantillas.admin_template')

@include('titulacionGrupos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('titulacionGrupos.index') }}">@yield('titulacionGruposAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('titulacionGruposAppTitle')</li>
        @endif
        -->
    <li class="active">@yield('titulacionGruposAppTitle')</li>
</ol>

<div class="">
    <h3>
        <i class="glyphicon glyphicon-align-justify"></i> @yield('titulacionGruposAppTitle')
        @permission('titulacionGrupos.create')
        <a class="btn btn-success pull-right" href="{{ route('titulacionGrupos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                <form class="TitulacionGrupo_search" id="search" action="{{ route('titulacionGrupos.index') }}" accept-charset="UTF-8" method="get">
                    <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                    <div class="form-horizontal">

                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_gt']) ?: '' }}" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_lt']) ?: '' }}" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="q_name_cont">NAME</label>
                            <div class=" col-sm-9">
                                <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
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
        @if($titulacionGrupos->count())
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                    <th>@include('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'NAME'])</th>
                    <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                    <th>Egresos</th>
                    <th>Ingresos</th>
                    <th class="text-right">OPCIONES</th>
                </tr>
            </thead>

            <tbody>
                @foreach($titulacionGrupos as $titulacionGrupo)
                <tr>
                    <td><a href="{{ route('titulacionGrupos.show', $titulacionGrupo->id) }}">{{$titulacionGrupo->id}}</a></td>
                    <td>{{$titulacionGrupo->name}}</td>
                    <td>{{$titulacionGrupo->fecha}}</td>
                    <td>
                        @permission('titulacionEgresos.create')
                        <a class="btn btn-success btn-xs" target="_blank" href="{{ route('titulacionEgresos.create', array('titulacionGrupo'=>$titulacionGrupo->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
                        @endpermission
                        @permission('titulacionEgresos.index')
                        <a class="btn btn-xs btn-info" target="_blank" href="{{ route('titulacionEgresos.index',array('q[titulacion_grupo_id_lt]'=>$titulacionGrupo->id)) }}" target="_blank"><i class="glyphicon glyphicon-plus"></i> Egresos</a>
                        @endpermission
                        @permission('titulacionGrupos.reporte')
                        {!! Form::model($titulacionGrupo,
                        array(
                            'route' => array('titulacionGrupos.reporte', $titulacionGrupo->id),
                            'method' => 'get',
                            'style' => 'display: inline;'
                        )) !!}
                        <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                            <label for="plantel_id-field">Plantel</label>
                            {!! Form::select("plantel_id", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                            {!! Form::hidden("id", $titulacionGrupo->id, array("class" => "form-control", "id" => "id-field")) !!}
                            @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Reporte</button>
                        {!! Form::close() !!}

                        <!--<a class="btn btn-xs btn-warning" target="_blank" href="{{ route('titulacionGrupos.reporte', array('grupo'=>$titulacionGrupo->id)) }}" target="_blank"><i class="glyphicon glyphicon-plus"></i> Reporte</a>-->
                        @endpermission
                    </td>
                    <td>
                    @permission('titulacionGrupos.rptIngresos')
                        {!! Form::model($titulacionGrupo,
                        array(
                            'route' => array('titulacionGrupos.rptIngresos', $titulacionGrupo->id),
                            'method' => 'get',
                            'style' => 'display: inline;'
                        )) !!}
                        <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                            <label for="plantel_id-field">Plantel</label>
                            {!! Form::select("plantel_id", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                            {!! Form::hidden("id", $titulacionGrupo->id, array("class" => "form-control", "id" => "id-field")) !!}
                            @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Reporte</button>
                        {!! Form::close() !!}

                        <!--<a class="btn btn-xs btn-warning" target="_blank" href="{{ route('titulacionGrupos.reporte', array('grupo'=>$titulacionGrupo->id)) }}" target="_blank"><i class="glyphicon glyphicon-plus"></i> Reporte</a>-->
                        @endpermission
                    </td>
                    <td class="text-right">

                        @permission('titulacionGrupos.edit')
                        <a class="btn btn-xs btn-warning" href="{{ route('titulacionGrupos.edit', $titulacionGrupo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                        @endpermission
                        @permission('titulacionGrupos.destroy')
                        {!! Form::model($titulacionGrupo, array('route' => array('titulacionGrupos.destroy', $titulacionGrupo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                        {!! Form::close() !!}
                        @endpermission
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $titulacionGrupos->appends(Request::except('page'))->render() !!}
        @else
        <h3 class="text-center alert alert-info">Vacio!</h3>
        @endif

    </div>
</div>

@endsection