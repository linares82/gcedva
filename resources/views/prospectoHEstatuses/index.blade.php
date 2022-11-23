@extends('plantillas.admin_template')

@include('prospectoHEstatuses._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('prospectoHEstatuses.index') }}">@yield('prospectoHEstatusesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('prospectoHEstatusesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('prospectoHEstatusesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('prospectoHEstatusesAppTitle')
            @permission('prospectoHEstatuses.create')
            <a class="btn btn-success pull-right" href="{{ route('prospectoHEstatuses.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="ProspectoHEstatuse_search" id="search" action="{{ route('prospectoHEstatuses.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tabla_gt">TABLA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tabla_gt']) ?: '' }}" name="q[tabla_gt]" id="q_tabla_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tabla_lt']) ?: '' }}" name="q[tabla_lt]" id="q_tabla_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tabla_cont">TABLA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tabla_cont']) ?: '' }}" name="q[tabla_cont]" id="q_tabla_cont" />
                                </div>
                            </div>
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
                                <label class="col-sm-2 control-label" for="q_seguimiento_id_gt">SEGUIMIENTO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['seguimiento_id_gt']) ?: '' }}" name="q[seguimiento_id_gt]" id="q_seguimiento_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['seguimiento_id_lt']) ?: '' }}" name="q[seguimiento_id_lt]" id="q_seguimiento_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_seguimiento_id_cont">SEGUIMIENTO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['seguimiento_id_cont']) ?: '' }}" name="q[seguimiento_id_cont]" id="q_seguimiento_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatus_gt">ESTATUS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatus_gt']) ?: '' }}" name="q[estatus_gt]" id="q_estatus_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatus_lt']) ?: '' }}" name="q[estatus_lt]" id="q_estatus_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatus_cont">ESTATUS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatus_cont']) ?: '' }}" name="q[estatus_cont]" id="q_estatus_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatus_id_gt">ESTATUS_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatus_id_gt']) ?: '' }}" name="q[estatus_id_gt]" id="q_estatus_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatus_id_lt']) ?: '' }}" name="q[estatus_id_lt]" id="q_estatus_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estatus_id_cont">ESTATUS_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estatus_id_cont']) ?: '' }}" name="q[estatus_id_cont]" id="q_estatus_id_cont" />
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
            @if($prospectoHEstatuses->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tabla', 'title' => 'TABLA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'prospecto_id', 'title' => 'PROSPECTO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'seguimiento_id', 'title' => 'SEGUIMIENTO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'estatus', 'title' => 'ESTATUS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'estatus_id', 'title' => 'ESTATUS_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prospectoHEstatuses as $prospectoHEstatuse)
                            <tr>
                                <td><a href="{{ route('prospectoHEstatuses.show', $prospectoHEstatuse->id) }}">{{$prospectoHEstatuse->id}}</a></td>
                                <td>{{$prospectoHEstatuse->tabla}}</td>
                    <td>{{$prospectoHEstatuse->prospecto_id}}</td>
                    <td>{{$prospectoHEstatuse->seguimiento_id}}</td>
                    <td>{{$prospectoHEstatuse->estatus}}</td>
                    <td>{{$prospectoHEstatuse->estatus_id}}</td>
                    <td>{{$prospectoHEstatuse->fecha}}</td>
                    <td>{{$prospectoHEstatuse->usu_alta_id}}</td>
                    <td>{{$prospectoHEstatuse->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('prospectoHEstatuses.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('prospectoHEstatuses.duplicate', $prospectoHEstatuse->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('prospectoHEstatuses.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('prospectoHEstatuses.edit', $prospectoHEstatuse->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('prospectoHEstatuses.destroy')
                                    {!! Form::model($prospectoHEstatuse, array('route' => array('prospectoHEstatuses.destroy', $prospectoHEstatuse->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $prospectoHEstatuses->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection