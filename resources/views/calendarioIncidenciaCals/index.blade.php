@extends('plantillas.admin_template')

@include('calendarioIncidenciaCals._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('calendarioIncidenciaCals.index') }}">@yield('calendarioIncidenciaCalsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('calendarioIncidenciaCalsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('calendarioIncidenciaCalsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('calendarioIncidenciaCalsAppTitle')
            @permission('calendarioIncidenciaCals.create')
            <a class="btn btn-success pull-right" href="{{ route('calendarioIncidenciaCals.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CalendarioIncidenciaCal_search" id="search" action="{{ route('calendarioIncidenciaCals.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_lectivo_id_gt">LECTIVO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['lectivo_id_gt']) ?: '' }}" name="q[lectivo_id_gt]" id="q_lectivo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['lectivo_id_lt']) ?: '' }}" name="q[lectivo_id_lt]" id="q_lectivo_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_lectivo_id_cont">LECTIVO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['lectivo_id_cont']) ?: '' }}" name="q[lectivo_id_cont]" id="q_lectivo_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacion_id_gt">PONDERACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ponderacion_id_gt']) ?: '' }}" name="q[ponderacion_id_gt]" id="q_ponderacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ponderacion_id_lt']) ?: '' }}" name="q[ponderacion_id_lt]" id="q_ponderacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacion_id_cont">PONDERACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ponderacion_id_cont']) ?: '' }}" name="q[ponderacion_id_cont]" id="q_ponderacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_ponderacion_id_gt">CARGA_PONDERACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_ponderacion_id_gt']) ?: '' }}" name="q[carga_ponderacion_id_gt]" id="q_carga_ponderacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_ponderacion_id_lt']) ?: '' }}" name="q[carga_ponderacion_id_lt]" id="q_carga_ponderacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_ponderacion_id_cont">CARGA_PONDERACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_ponderacion_id_cont']) ?: '' }}" name="q[carga_ponderacion_id_cont]" id="q_carga_ponderacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_inicio_gt">V_INICIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['v_inicio_gt']) ?: '' }}" name="q[v_inicio_gt]" id="q_v_inicio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['v_inicio_lt']) ?: '' }}" name="q[v_inicio_lt]" id="q_v_inicio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_inicio_cont">V_INICIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['v_inicio_cont']) ?: '' }}" name="q[v_inicio_cont]" id="q_v_inicio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_fin_gt">V_FIN</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['v_fin_gt']) ?: '' }}" name="q[v_fin_gt]" id="q_v_fin_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['v_fin_lt']) ?: '' }}" name="q[v_fin_lt]" id="q_v_fin_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_fin_cont">V_FIN</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['v_fin_cont']) ?: '' }}" name="q[v_fin_cont]" id="q_v_fin_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_id_gt">PLANTEL_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_gt']) ?: '' }}" name="q[plantel_id_gt]" id="q_plantel_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_lt']) ?: '' }}" name="q[plantel_id_lt]" id="q_plantel_id_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_id_cont">PLANTEL_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_cont']) ?: '' }}" name="q[plantel_id_cont]" id="q_plantel_id_cont" />
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
            @if($calendarioIncidenciaCals->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'lectivo_id', 'title' => 'LECTIVO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ponderacion_id', 'title' => 'PONDERACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'carga_ponderacion_id', 'title' => 'CARGA PONDERACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'v_inicio', 'title' => 'INICIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'v_fin', 'title' => 'FIN'])</th>
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($calendarioIncidenciaCals as $calendarioIncidenciaCal)
                            <tr>
                                <td><a href="{{ route('calendarioIncidenciaCals.show', $calendarioIncidenciaCal->id) }}">{{$calendarioIncidenciaCal->id}}</a></td>
                                <td>{{$calendarioIncidenciaCal->lectivo->name}}</td>
                    <td>{{$calendarioIncidenciaCal->ponderacion->name}}</td>
                    <td>{{$calendarioIncidenciaCal->cargaPonderacion->name}}</td>
                    <td>{{$calendarioIncidenciaCal->v_inicio}}</td>
                    <td>{{$calendarioIncidenciaCal->v_fin}}</td>
                    
                                <td class="text-right">
                                    @permission('calendarioIncidenciaCals.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('calendarioIncidenciaCals.edit', $calendarioIncidenciaCal->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('calendarioIncidenciaCals.destroy')
                                    {!! Form::model($calendarioIncidenciaCal, array('route' => array('calendarioIncidenciaCals.destroy', $calendarioIncidenciaCal->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $calendarioIncidenciaCals->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection