@extends('plantillas.admin_template')

@include('hCuentasEfectivos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('hCuentasEfectivos.index') }}">@yield('hCuentasEfectivosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('hCuentasEfectivosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('hCuentasEfectivosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('hCuentasEfectivosAppTitle')
            @permission('hCuentasEfectivos.create')
            <a class="btn btn-success pull-right" href="{{ route('hCuentasEfectivos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="HCuentasEfectivo_search" id="search" action="{{ route('hCuentasEfectivos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_efectivo_id_gt">CUENTA_EFECTIVO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_efectivo_id_gt']) ?: '' }}" name="q[cuenta_efectivo_id_gt]" id="q_cuenta_efectivo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_efectivo_id_lt']) ?: '' }}" name="q[cuenta_efectivo_id_lt]" id="q_cuenta_efectivo_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_efectivo_id_cont">CUENTA_EFECTIVO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_efectivo_id_cont']) ?: '' }}" name="q[cuenta_efectivo_id_cont]" id="q_cuenta_efectivo_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_saldo_inicial_gt">SALDO_INICIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_inicial_gt']) ?: '' }}" name="q[saldo_inicial_gt]" id="q_saldo_inicial_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_inicial_lt']) ?: '' }}" name="q[saldo_inicial_lt]" id="q_saldo_inicial_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_saldo_inicial_cont">SALDO_INICIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_inicial_cont']) ?: '' }}" name="q[saldo_inicial_cont]" id="q_saldo_inicial_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_saldo_actualizado_gt">SALDO_ACTUALIZADO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_actualizado_gt']) ?: '' }}" name="q[saldo_actualizado_gt]" id="q_saldo_actualizado_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_actualizado_lt']) ?: '' }}" name="q[saldo_actualizado_lt]" id="q_saldo_actualizado_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_saldo_actualizado_cont">SALDO_ACTUALIZADO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_actualizado_cont']) ?: '' }}" name="q[saldo_actualizado_cont]" id="q_saldo_actualizado_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_saldo_inicial_gt">FECHA_SALDO_INICIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_saldo_inicial_gt']) ?: '' }}" name="q[fecha_saldo_inicial_gt]" id="q_fecha_saldo_inicial_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_saldo_inicial_lt']) ?: '' }}" name="q[fecha_saldo_inicial_lt]" id="q_fecha_saldo_inicial_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_saldo_inicial_cont">FECHA_SALDO_INICIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_saldo_inicial_cont']) ?: '' }}" name="q[fecha_saldo_inicial_cont]" id="q_fecha_saldo_inicial_cont" />
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
            @if($hCuentasEfectivos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cuenta_efectivo_id', 'title' => 'CUENTA_EFECTIVO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'saldo_inicial', 'title' => 'SALDO_INICIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'saldo_actualizado', 'title' => 'SALDO_ACTUALIZADO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_saldo_inicial', 'title' => 'FECHA_SALDO_INICIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($hCuentasEfectivos as $hCuentasEfectivo)
                            <tr>
                                <td><a href="{{ route('hCuentasEfectivos.show', $hCuentasEfectivo->id) }}">{{$hCuentasEfectivo->id}}</a></td>
                                <td>{{$hCuentasEfectivo->cuenta_efectivo_id}}</td>
                    <td>{{$hCuentasEfectivo->saldo_inicial}}</td>
                    <td>{{$hCuentasEfectivo->saldo_actualizado}}</td>
                    <td>{{$hCuentasEfectivo->fecha_saldo_inicial}}</td>
                    <td>{{$hCuentasEfectivo->usu_alta_id}}</td>
                    <td>{{$hCuentasEfectivo->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('hCuentasEfectivos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hCuentasEfectivos.duplicate', $hCuentasEfectivo->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('hCuentasEfectivos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('hCuentasEfectivos.edit', $hCuentasEfectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('hCuentasEfectivos.destroy')
                                    {!! Form::model($hCuentasEfectivo, array('route' => array('hCuentasEfectivos.destroy', $hCuentasEfectivo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $hCuentasEfectivos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection