@extends('plantillas.admin_template')

@include('cargaPonderacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('cargaPonderacions.index') }}">@yield('cargaPonderacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('cargaPonderacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('cargaPonderacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('cargaPonderacionsAppTitle')
            @permission('cargaPonderacions.create')
            <a class="btn btn-success pull-right" href="{{ route('cargaPonderacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CargaPonderacion_search" id="search" action="{{ route('cargaPonderacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacion_id_gt">PONDERACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['ponderacion_id_gt']) ?: '' }}" name="q[ponderacion_id_gt]" id="q_ponderacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['ponderacion_id_lt']) ?: '' }}" name="q[ponderacion_id_lt]" id="q_ponderacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacion_id_cont">PONDERACION</label>
                                <div class=" col-sm-9">
                                    {!! Form::select("ponderacion_id", $list["Ponderacion"], "{{ @(Request::input('q')['carga_ponderacions.ponderacion_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[carga_ponderacions.ponderacion_id_lt]", "id"=>"q_carga_ponderacions.ponderacion_id_lt", "style"=>"width:100%;" )) !!}
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_gt']) ?: '' }}" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_lt']) ?: '' }}" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_cont">NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_porcentaje_gt">PORCENTAJE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['porcentaje_gt']) ?: '' }}" name="q[porcentaje_gt]" id="q_porcentaje_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['porcentaje_lt']) ?: '' }}" name="q[porcentaje_lt]" id="q_porcentaje_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_porcentaje_cont">PORCENTAJE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['porcentaje_cont']) ?: '' }}" name="q[porcentaje_cont]" id="q_porcentaje_cont" />
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
            @if($cargaPonderacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ponderacion_id', 'title' => 'PONDERACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'porcentaje', 'title' => 'PORCENTAJE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tiene_detalle', 'title' => 'TIENE DETALLE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tiene_detalle', 'title' => 'PADRE'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cargaPonderacions as $cargaPonderacion)
                            <tr>
                                <td><a href="{{ route('cargaPonderacions.show', $cargaPonderacion->id) }}">{{$cargaPonderacion->id}}</a></td>
                                <td>{{$cargaPonderacion->ponderacion->name}}</td>
                                <td>{{$cargaPonderacion->name}}</td>
                                <td>{{$cargaPonderacion->porcentaje}}</td>
                                <td>
                                    @if($cargaPonderacion->tiene_detalle==1)
                                    SI
                                    @else
                                    NO
                                    @endif
                                </td>
                                <td>
                                    @if($cargaPonderacion->padre_id>0)
                                    {{$cargaPonderacion->padre->name}}
                                    
                                    @endif
                                </td>
                                <td class="text-right">
                                    @permission('cargaPonderacions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('cargaPonderacions.duplicate', $cargaPonderacion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('cargaPonderacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('cargaPonderacions.edit', $cargaPonderacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('cargaPonderacions.destroy')
                                    {!! Form::model($cargaPonderacion, array('route' => array('cargaPonderacions.destroy', $cargaPonderacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $cargaPonderacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection