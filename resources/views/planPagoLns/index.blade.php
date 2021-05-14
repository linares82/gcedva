@extends('plantillas.admin_template')

@include('planPagoLns._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('planPagoLns.index') }}">@yield('planPagoLnsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('planPagoLnsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('planPagoLnsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('planPagoLnsAppTitle')
            @permission('planPagoLns.create')
            <a class="btn btn-success pull-right" href="{{ route('planPagoLns.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="PlanPagoLn_search" id="search" action="{{ route('planPagoLns.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plan_pago_id_gt">PLAN_PAGO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plan_pago_id_gt']) ?: '' }}" name="q[plan_pago_id_gt]" id="q_plan_pago_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plan_pago_id_lt']) ?: '' }}" name="q[plan_pago_id_lt]" id="q_plan_pago_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plan_pago_id_cont">PLAN_PAGO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plan_pago_id_cont']) ?: '' }}" name="q[plan_pago_id_cont]" id="q_plan_pago_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_caja_conceptos.name_gt">CAJA_CONCEPTO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['caja_conceptos.name_gt']) ?: '' }}" name="q[caja_conceptos.name_gt]" id="q_caja_conceptos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['caja_conceptos.name_lt']) ?: '' }}" name="q[caja_conceptos.name_lt]" id="q_caja_conceptos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_caja_conceptos.name_cont">CAJA_CONCEPTO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['caja_conceptos.name_cont']) ?: '' }}" name="q[caja_conceptos.name_cont]" id="q_caja_conceptos.name_cont" />
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
            @if($planPagoLns->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'plan_pago_id', 'title' => 'PLAN_PAGO_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'caja_conceptos.name', 'title' => 'CAJA_CONCEPTO_NAME'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'cuenta_contables.name', 'title' => 'CUENTA_CONTABLE_NAME'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'cuenta_recargo_id', 'title' => 'CUENTA_RECARGO_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'fecha_pago', 'title' => 'FECHA_PAGO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'monto', 'title' => 'MONTO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'inicial_bnd', 'title' => 'INICIAL_BND'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($planPagoLns as $planPagoLn)
                            <tr>
                                <td><a href="{{ route('planPagoLns.show', $planPagoLn->id) }}">{{$planPagoLn->id}}</a></td>
                                <td>{{$planPagoLn->plan_pago_id}}</td>
                                <td>{{$planPagoLn->cajaConcepto->name}}</td>
                                <td>{{$planPagoLn->cuentaContable->name}}</td>
                                <td>{{$planPagoLn->cuenta_recargo_id}}</td>
                                <td>{{$planPagoLn->fecha_pago}}</td>
                                <td>{{$planPagoLn->monto}}
                                </td>
                                <td>{{$planPagoLn->inicial_bnd}}</td>
                                <td>{{$planPagoLn->usu_alta_id}}</td>
                                <td>{{$planPagoLn->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('planPagoLns.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('planPagoLns.duplicate', $planPagoLn->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('planPagoLns.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('planPagoLns.edit', $planPagoLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('planPagoLns.destroy')
                                    {!! Form::model($planPagoLn, array('route' => array('planPagoLns.destroy', $planPagoLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $planPagoLns->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection