@extends('plantillas.admin_template')

@include('facturaGLineas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('facturaGLineas.index') }}">@yield('facturaGLineasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('facturaGLineasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('facturaGLineasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('facturaGLineasAppTitle')
            @permission('facturaGLineas.create')
            <a class="btn btn-success pull-right" href="{{ route('facturaGLineas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="FacturaGLinea_search" id="search" action="{{ route('facturaGLineas.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_factura_gs.id_gt">FACTURA_G_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['factura_gs.id_gt']) ?: '' }}" name="q[factura_gs.id_gt]" id="q_factura_gs.id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['factura_gs.id_lt']) ?: '' }}" name="q[factura_gs.id_lt]" id="q_factura_gs.id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_factura_gs.id_cont">FACTURA_G_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['factura_gs.id_cont']) ?: '' }}" name="q[factura_gs.id_cont]" id="q_factura_gs.id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_operacion_gt">FECHA_OPERACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_operacion_gt']) ?: '' }}" name="q[fecha_operacion_gt]" id="q_fecha_operacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_operacion_lt']) ?: '' }}" name="q[fecha_operacion_lt]" id="q_fecha_operacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_operacion_cont">FECHA_OPERACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_operacion_cont']) ?: '' }}" name="q[fecha_operacion_cont]" id="q_fecha_operacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_concepto_gt">CONCEPTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_gt']) ?: '' }}" name="q[concepto_gt]" id="q_concepto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_lt']) ?: '' }}" name="q[concepto_lt]" id="q_concepto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_concepto_cont">CONCEPTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['concepto_cont']) ?: '' }}" name="q[concepto_cont]" id="q_concepto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_referencia_gt">REFERENCIA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['referencia_gt']) ?: '' }}" name="q[referencia_gt]" id="q_referencia_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['referencia_lt']) ?: '' }}" name="q[referencia_lt]" id="q_referencia_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_referencia_cont">REFERENCIA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['referencia_cont']) ?: '' }}" name="q[referencia_cont]" id="q_referencia_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_referencia_ampliada_gt">REFERENCIA_AMPLIADA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['referencia_ampliada_gt']) ?: '' }}" name="q[referencia_ampliada_gt]" id="q_referencia_ampliada_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['referencia_ampliada_lt']) ?: '' }}" name="q[referencia_ampliada_lt]" id="q_referencia_ampliada_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_referencia_ampliada_cont">REFERENCIA_AMPLIADA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['referencia_ampliada_cont']) ?: '' }}" name="q[referencia_ampliada_cont]" id="q_referencia_ampliada_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cargo_gt">CARGO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cargo_gt']) ?: '' }}" name="q[cargo_gt]" id="q_cargo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cargo_lt']) ?: '' }}" name="q[cargo_lt]" id="q_cargo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cargo_cont">CARGO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cargo_cont']) ?: '' }}" name="q[cargo_cont]" id="q_cargo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_abono_gt">ABONO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['abono_gt']) ?: '' }}" name="q[abono_gt]" id="q_abono_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['abono_lt']) ?: '' }}" name="q[abono_lt]" id="q_abono_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_abono_cont">ABONO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['abono_cont']) ?: '' }}" name="q[abono_cont]" id="q_abono_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_saldo_gt">SALDO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_gt']) ?: '' }}" name="q[saldo_gt]" id="q_saldo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_lt']) ?: '' }}" name="q[saldo_lt]" id="q_saldo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_saldo_cont">SALDO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['saldo_cont']) ?: '' }}" name="q[saldo_cont]" id="q_saldo_cont" />
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
            @if($facturaGLineas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'factura_gs.id', 'title' => 'FACTURA_G_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_operacion', 'title' => 'FECHA_OPERACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'concepto', 'title' => 'CONCEPTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'referencia', 'title' => 'REFERENCIA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'referencia_ampliada', 'title' => 'REFERENCIA_AMPLIADA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cargo', 'title' => 'CARGO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'abono', 'title' => 'ABONO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'saldo', 'title' => 'SALDO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($facturaGLineas as $facturaGLinea)
                            <tr>
                                <td><a href="{{ route('facturaGLineas.show', $facturaGLinea->id) }}">{{$facturaGLinea->id}}</a></td>
                                <td>{{$facturaGLinea->facturaG->id}}</td>
                    <td>{{$facturaGLinea->fecha_operacion}}</td>
                    <td>{{$facturaGLinea->concepto}}</td>
                    <td>{{$facturaGLinea->referencia}}</td>
                    <td>{{$facturaGLinea->referencia_ampliada}}</td>
                    <td>{{$facturaGLinea->cargo}}</td>
                    <td>{{$facturaGLinea->abono}}</td>
                    <td>{{$facturaGLinea->saldo}}</td>
                    <td>{{$facturaGLinea->usu_alta_id}}</td>
                    <td>{{$facturaGLinea->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('facturaGLineas.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('facturaGLineas.duplicate', $facturaGLinea->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('facturaGLineas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('facturaGLineas.edit', $facturaGLinea->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('facturaGLineas.destroy')
                                    {!! Form::model($facturaGLinea, array('route' => array('facturaGLineas.destroy', $facturaGLinea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $facturaGLineas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection