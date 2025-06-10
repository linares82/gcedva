@extends('plantillas.admin_template')

@include('sepCertObservacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepCertObservacions.index') }}">@yield('sepCertObservacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepCertObservacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepCertObservacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepCertObservacionsAppTitle')
            @permission('sepCertObservacions.create')
            <a class="btn btn-success pull-right" href="{{ route('sepCertObservacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepCertObservacion_search" id="search" action="{{ route('sepCertObservacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_observacion_gt">ID_OBSERVACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_observacion_gt']) ?: '' }}" name="q[id_observacion_gt]" id="q_id_observacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_observacion_lt']) ?: '' }}" name="q[id_observacion_lt]" id="q_id_observacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_observacion_cont">ID_OBSERVACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_observacion_cont']) ?: '' }}" name="q[id_observacion_cont]" id="q_id_observacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_gt">DESCRIPCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_gt']) ?: '' }}" name="q[descripcion_gt]" id="q_descripcion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_lt']) ?: '' }}" name="q[descripcion_lt]" id="q_descripcion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_cont">DESCRIPCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_cont']) ?: '' }}" name="q[descripcion_cont]" id="q_descripcion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_corta_gt">DESCRIPCION_CORTA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_corta_gt']) ?: '' }}" name="q[descripcion_corta_gt]" id="q_descripcion_corta_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_corta_lt']) ?: '' }}" name="q[descripcion_corta_lt]" id="q_descripcion_corta_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_corta_cont">DESCRIPCION_CORTA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_corta_cont']) ?: '' }}" name="q[descripcion_corta_cont]" id="q_descripcion_corta_cont" />
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
            @if($sepCertObservacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_observacion', 'title' => 'ID_OBSERVACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'descripcion', 'title' => 'DESCRIPCION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'descripcion_corta', 'title' => 'DESCRIPCION_CORTA'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepCertObservacions as $sepCertObservacion)
                            <tr>
                                <td><a href="{{ route('sepCertObservacions.show', $sepCertObservacion->id) }}">{{$sepCertObservacion->id}}</a></td>
                                <td>{{$sepCertObservacion->id_observacion}}</td>
                    <td>{{$sepCertObservacion->descripcion}}</td>
                    <td>{{$sepCertObservacion->descripcion_corta}}</td>
                                <td class="text-right">
                                    @permission('sepCertObservacions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepCertObservacions.duplicate', $sepCertObservacion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepCertObservacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepCertObservacions.edit', $sepCertObservacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepCertObservacions.destroy')
                                    {!! Form::model($sepCertObservacion, array('route' => array('sepCertObservacions.destroy', $sepCertObservacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepCertObservacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection