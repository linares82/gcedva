@extends('plantillas.admin_template')

@include('correos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('correos.index') }}">@yield('correosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('correosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('correosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('correosAppTitle')
            @permission('correos.create')
            <a class="btn btn-success pull-right" href="{{ route('correos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Correo_search" id="search" action="{{ route('correos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_envio_id_gt">USU_ENVIO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_envio_id_gt']) ?: '' }}" name="q[usu_envio_id_gt]" id="q_usu_envio_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_envio_id_lt']) ?: '' }}" name="q[usu_envio_id_lt]" id="q_usu_envio_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_usu_envio_id_cont">USU_ENVIO_ID</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_envio_id_cont']) ?: '' }}" name="q[usu_envio_id_cont]" id="q_usu_envio_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_gt">CLIENTE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cliente_id_gt']) ?: '' }}" name="q[cliente_id_gt]" id="q_cliente_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cliente_id_lt']) ?: '' }}" name="q[cliente_id_lt]" id="q_cliente_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_cliente_id_cont">CLIENTE_ID</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cliente_id_cont']) ?: '' }}" name="q[cliente_id_cont]" id="q_cliente_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_envio_gt">FECHA_ENVIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fecha_envio_gt']) ?: '' }}" name="q[fecha_envio_gt]" id="q_fecha_envio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fecha_envio_lt']) ?: '' }}" name="q[fecha_envio_lt]" id="q_fecha_envio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_fecha_envio_cont">FECHA_ENVIO</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fecha_envio_cont']) ?: '' }}" name="q[fecha_envio_cont]" id="q_fecha_envio_cont" />
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
            @if($correos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'usu_envio_id', 'title' => 'USU_ENVIO_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'cliente_id', 'title' => 'CLIENTE_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'fecha_envio', 'title' => 'FECHA_ENVIO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($correos as $correo)
                            <tr>
                                <td><a href="{{ route('correos.show', $correo->id) }}">{{$correo->id}}</a></td>
                                <td>{{$correo->usu_envio_id}}</td>
                    <td>{{$correo->cliente_id}}</td>
                    <td>{{$correo->fecha_envio}}</td>
                    <td>{{$correo->usu_alta_id}}</td>
                    <td>{{$correo->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('correos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('correos.duplicate', $correo->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('correos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('correos.edit', $correo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('correos.destroy')
                                    {!! Form::model($correo, array('route' => array('correos.destroy', $correo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $correos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection