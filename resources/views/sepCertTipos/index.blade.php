@extends('plantillas.admin_template')

@include('sepCertTipos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepCertTipos.index') }}">@yield('sepCertTiposAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepCertTiposAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepCertTiposAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepCertTiposAppTitle')
            @permission('sepCertTipos.create')
            <a class="btn btn-success pull-right" href="{{ route('sepCertTipos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepCertTipo_search" id="search" action="{{ route('sepCertTipos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_tipo_certificacion_gt">ID_TIPO_CERTIFICACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_tipo_certificacion_gt']) ?: '' }}" name="q[id_tipo_certificacion_gt]" id="q_id_tipo_certificacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_tipo_certificacion_lt']) ?: '' }}" name="q[id_tipo_certificacion_lt]" id="q_id_tipo_certificacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_tipo_certificacion_cont">ID_TIPO_CERTIFICACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_tipo_certificacion_cont']) ?: '' }}" name="q[id_tipo_certificacion_cont]" id="q_id_tipo_certificacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_certificacion_gt">TIPO_CERTIFICACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_certificacion_gt']) ?: '' }}" name="q[tipo_certificacion_gt]" id="q_tipo_certificacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_certificacion_lt']) ?: '' }}" name="q[tipo_certificacion_lt]" id="q_tipo_certificacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_certificacion_cont">TIPO_CERTIFICACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_certificacion_cont']) ?: '' }}" name="q[tipo_certificacion_cont]" id="q_tipo_certificacion_cont" />
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
            @if($sepCertTipos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_tipo_certificacion', 'title' => 'ID_TIPO_CERTIFICACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tipo_certificacion', 'title' => 'TIPO_CERTIFICACION'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepCertTipos as $sepCertTipo)
                            <tr>
                                <td><a href="{{ route('sepCertTipos.show', $sepCertTipo->id) }}">{{$sepCertTipo->id}}</a></td>
                                <td>{{$sepCertTipo->id_tipo_certificacion}}</td>
                    <td>{{$sepCertTipo->tipo_certificacion}}</td>
                                <td class="text-right">
                                    @permission('sepCertTipos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepCertTipos.duplicate', $sepCertTipo->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepCertTipos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepCertTipos.edit', $sepCertTipo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepCertTipos.destroy')
                                    {!! Form::model($sepCertTipo, array('route' => array('sepCertTipos.destroy', $sepCertTipo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepCertTipos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection