@extends('plantillas.admin_template')

@include('adeudos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('adeudos.index') }}">@yield('adeudosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('adeudosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('adeudosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('adeudosAppTitle')
            @permission('adeudos.create')
            <a class="btn btn-success pull-right" href="{{ route('adeudos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Adeudo_search" id="search" action="{{ route('adeudos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_gt">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_gt']) ?: '' }}" name="q[clientes.nombre_gt]" id="q_clientes.nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_lt']) ?: '' }}" name="q[clientes.nombre_lt]" id="q_clientes.nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_cont">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_concepto_cobro_id_gt">CONCEPTO_COBRO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_cobro_id_gt']) ?: '' }}" name="q[concepto_cobro_id_gt]" id="q_concepto_cobro_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_cobro_id_lt']) ?: '' }}" name="q[concepto_cobro_id_lt]" id="q_concepto_cobro_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_concepto_cobro_id_cont">CONCEPTO_COBRO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_cobro_id_cont']) ?: '' }}" name="q[concepto_cobro_id_cont]" id="q_concepto_cobro_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_contables.name_gt">CUENTA_CONTABLE_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contables.name_gt']) ?: '' }}" name="q[cuenta_contables.name_gt]" id="q_cuenta_contables.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contables.name_lt']) ?: '' }}" name="q[cuenta_contables.name_lt]" id="q_cuenta_contables.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_contables.name_cont">CUENTA_CONTABLE_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_contables.name_cont']) ?: '' }}" name="q[cuenta_contables.name_cont]" id="q_cuenta_contables.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_recargo_id_gt">CUENTA_RECARGO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_recargo_id_gt']) ?: '' }}" name="q[cuenta_recargo_id_gt]" id="q_cuenta_recargo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_recargo_id_lt']) ?: '' }}" name="q[cuenta_recargo_id_lt]" id="q_cuenta_recargo_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_recargo_id_cont">CUENTA_RECARGO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_recargo_id_cont']) ?: '' }}" name="q[cuenta_recargo_id_cont]" id="q_cuenta_recargo_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_pago_gt">FECHA_PAGO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_pago_gt']) ?: '' }}" name="q[fecha_pago_gt]" id="q_fecha_pago_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_pago_lt']) ?: '' }}" name="q[fecha_pago_lt]" id="q_fecha_pago_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_pago_cont">FECHA_PAGO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_pago_cont']) ?: '' }}" name="q[fecha_pago_cont]" id="q_fecha_pago_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_gt">MONTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_gt']) ?: '' }}" name="q[monto_gt]" id="q_monto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_lt']) ?: '' }}" name="q[monto_lt]" id="q_monto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_cont">MONTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_cont']) ?: '' }}" name="q[monto_cont]" id="q_monto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_inicial_bnd_gt">INICIAL_BND</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['inicial_bnd_gt']) ?: '' }}" name="q[inicial_bnd_gt]" id="q_inicial_bnd_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['inicial_bnd_lt']) ?: '' }}" name="q[inicial_bnd_lt]" id="q_inicial_bnd_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_inicial_bnd_cont">INICIAL_BND</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['inicial_bnd_cont']) ?: '' }}" name="q[inicial_bnd_cont]" id="q_inicial_bnd_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plan_pago_lns.fecha_pago_gt">PLAN_PAGO_LN_FECHA_PAGO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plan_pago_lns.fecha_pago_gt']) ?: '' }}" name="q[plan_pago_lns.fecha_pago_gt]" id="q_plan_pago_lns.fecha_pago_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plan_pago_lns.fecha_pago_lt']) ?: '' }}" name="q[plan_pago_lns.fecha_pago_lt]" id="q_plan_pago_lns.fecha_pago_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plan_pago_lns.fecha_pago_cont">PLAN_PAGO_LN_FECHA_PAGO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plan_pago_lns.fecha_pago_cont']) ?: '' }}" name="q[plan_pago_lns.fecha_pago_cont]" id="q_plan_pago_lns.fecha_pago_cont" />
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
            @if($adeudos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre', 'title' => 'CLIENTE_NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'concepto_cobro_id', 'title' => 'CONCEPTO_COBRO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cuenta_contables.name', 'title' => 'CUENTA_CONTABLE_NAME'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cuenta_recargo_id', 'title' => 'CUENTA_RECARGO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_pago', 'title' => 'FECHA_PAGO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'monto', 'title' => 'MONTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'inicial_bnd', 'title' => 'INICIAL_BND'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plan_pago_lns.fecha_pago', 'title' => 'PLAN_PAGO_LN_FECHA_PAGO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($adeudos as $adeudo)
                            <tr>
                                <td><a href="{{ route('adeudos.show', $adeudo->id) }}">{{$adeudo->id}}</a></td>
                                <td>{{$adeudo->cliente->nombre}}</td>
                    <td>{{$adeudo->concepto_cobro_id}}</td>
                    <td>{{$adeudo->cuentaContable->name}}</td>
                    <td>{{$adeudo->cuenta_recargo_id}}</td>
                    <td>{{$adeudo->fecha_pago}}</td>
                    <td>{{$adeudo->monto}}</td>
                    <td>{{$adeudo->inicial_bnd}}</td>
                    <td>{{$adeudo->planPagoLn->fecha_pago}}</td>
                    <td>{{$adeudo->usu_alta_id}}</td>
                    <td>{{$adeudo->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('adeudos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('adeudos.duplicate', $adeudo->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('adeudos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('adeudos.edit', $adeudo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('adeudos.destroy')
                                    {!! Form::model($adeudo, array('route' => array('adeudos.destroy', $adeudo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $adeudos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection