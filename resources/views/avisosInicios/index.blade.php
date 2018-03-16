@extends('plantillas.admin_template')

@include('avisosInicios._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('avisosInicios.index') }}">@yield('avisosIniciosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('avisosIniciosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('avisosIniciosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('avisosIniciosAppTitle')
            @permission('avisosInicios.create')
            <a class="btn btn-success pull-right" href="{{ route('avisosInicios.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="AvisosInicio_search" id="search" action="{{ route('avisosInicios.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_orden_gt">ORDEN</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['orden_gt']) ?: '' }}" name="q[orden_gt]" id="q_orden_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['orden_lt']) ?: '' }}" name="q[orden_lt]" id="q_orden_lt" />
                                </div>
                            </div>
                            -->
                            
<!--                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_orden_cont">ORDEN</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['orden_cont']) ?: '' }}" name="q[orden_cont]" id="q_orden_cont" />
                                </div>
                            </div>-->
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asuntos.name_gt">ASUNTO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asuntos.name_gt']) ?: '' }}" name="q[asuntos.name_gt]" id="q_asuntos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asuntos.name_lt']) ?: '' }}" name="q[asuntos.name_lt]" id="q_asuntos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asuntos.name_cont">ASUNTO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asuntos.name_cont']) ?: '' }}" name="q[asuntos.name_cont]" id="q_asuntos.name_cont" />
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
                                <label class="col-sm-2 control-label" for="q_dias_despues_gt">DIAS_DESPUES</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dias_despues_gt']) ?: '' }}" name="q[dias_despues_gt]" id="q_dias_despues_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dias_despues_lt']) ?: '' }}" name="q[dias_despues_lt]" id="q_dias_despues_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_dias_despues_cont">DIAS_DESPUES</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['dias_despues_cont']) ?: '' }}" name="q[dias_despues_cont]" id="q_dias_despues_cont" />
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
            @if($avisosInicios->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'orden', 'title' => 'ORDEN'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'avisos_inicios.asuntos.name', 'title' => 'ASUNTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'detalle', 'title' => 'DETALLE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'dias_despues', 'title' => 'DIAS DESPUES'])</th>
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($avisosInicios as $avisosInicio)
                            <tr>
                                <td><a href="{{ route('avisosInicios.show', $avisosInicio->id) }}">{{$avisosInicio->id}}</a></td>
                                <td>{{$avisosInicio->orden}}</td>
                                <td>{{$avisosInicio->asunto->name}}</td>
                                <td>{{$avisosInicio->detalle}}</td>
                                <td>{{$avisosInicio->dias_despues}}</td>
                                <td class="text-right">
                                    @permission('avisosInicios.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('avisosInicios.duplicate', $avisosInicio->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('avisosInicios.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('avisosInicios.edit', $avisosInicio->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('avisosInicios.destroy')
                                    {!! Form::model($avisosInicio, array('route' => array('avisosInicios.destroy', $avisosInicio->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $avisosInicios->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection