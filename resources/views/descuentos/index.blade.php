@extends('plantillas.admin_template')

@include('descuentos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('descuentos.index') }}">@yield('descuentosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('descuentosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('descuentosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('descuentosAppTitle')
            @permission('descuentos.create')
            <a class="btn btn-success pull-right" href="{{ route('descuentos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Descuento_search" id="search" action="{{ route('descuentos.index') }}" accept-charset="UTF-8" method="get">
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
                                <label class="col-sm-2 control-label" for="q_porcentaje_gt">PORCENTAJE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['porcentaje_gt']) ?: '' }}" name="q[porcentaje_gt]" id="q_porcentaje_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['porcentaje_lt']) ?: '' }}" name="q[porcentaje_lt]" id="q_porcentaje_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_porcentaje_cont">PORCENTAJE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['porcentaje_cont']) ?: '' }}" name="q[porcentaje_cont]" id="q_porcentaje_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_justificacion_gt">JUSTIFICACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['justificacion_gt']) ?: '' }}" name="q[justificacion_gt]" id="q_justificacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['justificacion_lt']) ?: '' }}" name="q[justificacion_lt]" id="q_justificacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_justificacion_cont">JUSTIFICACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['justificacion_cont']) ?: '' }}" name="q[justificacion_cont]" id="q_justificacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_autorizado_por_gt">AUTORIZADO_POR</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['autorizado_por_gt']) ?: '' }}" name="q[autorizado_por_gt]" id="q_autorizado_por_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['autorizado_por_lt']) ?: '' }}" name="q[autorizado_por_lt]" id="q_autorizado_por_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_autorizado_por_cont">AUTORIZADO_POR</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['autorizado_por_cont']) ?: '' }}" name="q[autorizado_por_cont]" id="q_autorizado_por_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_autorizado_el_gt">AUTORIZADO_EL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['autorizado_el_gt']) ?: '' }}" name="q[autorizado_el_gt]" id="q_autorizado_el_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['autorizado_el_lt']) ?: '' }}" name="q[autorizado_el_lt]" id="q_autorizado_el_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_autorizado_el_cont">AUTORIZADO_EL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['autorizado_el_cont']) ?: '' }}" name="q[autorizado_el_cont]" id="q_autorizado_el_cont" />
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
            @if($descuentos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'NAME'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'porcentaje', 'title' => 'PORCENTAJE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'justificacion', 'title' => 'JUSTIFICACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'autorizado_por', 'title' => 'AUTORIZADO_POR'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'autorizado_el', 'title' => 'AUTORIZADO_EL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($descuentos as $descuento)
                            <tr>
                                <td><a href="{{ route('descuentos.show', $descuento->id) }}">{{$descuento->id}}</a></td>
                                <td>{{$descuento->name}}</td>
                    <td>{{$descuento->porcentaje}}</td>
                    <td>{{$descuento->justificacion}}</td>
                    <td>{{$descuento->autorizado_por}}</td>
                    <td>{{$descuento->autorizado_el}}</td>
                    <td>{{$descuento->usu_alta_id}}</td>
                    <td>{{$descuento->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('descuentos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('descuentos.duplicate', $descuento->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('descuentos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('descuentos.edit', $descuento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('descuentos.destroy')
                                    {!! Form::model($descuento, array('route' => array('descuentos.destroy', $descuento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $descuentos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection