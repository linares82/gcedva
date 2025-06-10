@extends('plantillas.admin_template')

@include('sepModalidadTitulacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepModalidadTitulacions.index') }}">@yield('sepModalidadTitulacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepModalidadTitulacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepModalidadTitulacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepModalidadTitulacionsAppTitle')
            @permission('sepModalidadTitulacions.create')
            <a class="btn btn-success pull-right" href="{{ route('sepModalidadTitulacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepModalidadTitulacion_search" id="search" action="{{ route('sepModalidadTitulacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_modalidad_gt">ID_MODALIDAD</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_modalidad_gt']) ?: '' }}" name="q[id_modalidad_gt]" id="q_id_modalidad_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_modalidad_lt']) ?: '' }}" name="q[id_modalidad_lt]" id="q_id_modalidad_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_modalidad_cont">ID_MODALIDAD</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_modalidad_cont']) ?: '' }}" name="q[id_modalidad_cont]" id="q_id_modalidad_cont" />
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
            @if($sepModalidadTitulacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_modalidad', 'title' => 'ID_MODALIDAD'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'descripcion', 'title' => 'DESCRIPCION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tipo_modalidad', 'title' => 'TIPO_MODALIDAD'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepModalidadTitulacions as $sepModalidadTitulacion)
                            <tr>
                                <td>{{$sepModalidadTitulacion->id}}</td>
                                <td>{{$sepModalidadTitulacion->id_modalidad}}</td>
                                <td>{{$sepModalidadTitulacion->descripcion}}</td>
                                <td>{{$sepModalidadTitulacion->tipo_modalidad}}</td>
                                <td class="text-right">
                                    @permission('sepModalidadTitulacions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepModalidadTitulacions.duplicate', $sepModalidadTitulacion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepModalidadTitulacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepModalidadTitulacions.edit', $sepModalidadTitulacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepModalidadTitulacions.destroy')
                                    {!! Form::model($sepModalidadTitulacion, array('route' => array('sepModalidadTitulacions.destroy', $sepModalidadTitulacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepModalidadTitulacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection