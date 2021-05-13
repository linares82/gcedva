@extends('plantillas.admin_template')

@include('conciliacionMultiDetalles._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('conciliacionMultiDetalles.index') }}">@yield('conciliacionMultiDetallesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('conciliacionMultiDetallesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('conciliacionMultiDetallesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('conciliacionMultiDetallesAppTitle')
            @permission('conciliacionMultiDetalles.create')
            <a class="btn btn-success pull-right" href="{{ route('conciliacionMultiDetalles.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="ConciliacionMultiDetalle_search" id="search" action="{{ route('conciliacionMultiDetalles.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_conciliacion_multipagos.fecha_carga_gt">CONCILIACION_MULTIPAGO_FECHA_CARGA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['conciliacion_multipagos.fecha_carga_gt']) ?: '' }}" name="q[conciliacion_multipagos.fecha_carga_gt]" id="q_conciliacion_multipagos.fecha_carga_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['conciliacion_multipagos.fecha_carga_lt']) ?: '' }}" name="q[conciliacion_multipagos.fecha_carga_lt]" id="q_conciliacion_multipagos.fecha_carga_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_conciliacion_multipagos.fecha_carga_cont">CONCILIACION_MULTIPAGO_FECHA_CARGA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['conciliacion_multipagos.fecha_carga_cont']) ?: '' }}" name="q[conciliacion_multipagos.fecha_carga_cont]" id="q_conciliacion_multipagos.fecha_carga_cont" />
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
                                <label class="col-sm-2 control-label" for="q_razon_social_gt">RAZON_SOCIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['razon_social_gt']) ?: '' }}" name="q[razon_social_gt]" id="q_razon_social_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['razon_social_lt']) ?: '' }}" name="q[razon_social_lt]" id="q_razon_social_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_razon_social_cont">RAZON_SOCIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['razon_social_cont']) ?: '' }}" name="q[razon_social_cont]" id="q_razon_social_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_node_gt">MP_NODE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_node_gt']) ?: '' }}" name="q[mp_node_gt]" id="q_mp_node_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_node_lt']) ?: '' }}" name="q[mp_node_lt]" id="q_mp_node_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_node_cont">MP_NODE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_node_cont']) ?: '' }}" name="q[mp_node_cont]" id="q_mp_node_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_concept_gt">MP_CONCEPT</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_concept_gt']) ?: '' }}" name="q[mp_concept_gt]" id="q_mp_concept_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_concept_lt']) ?: '' }}" name="q[mp_concept_lt]" id="q_mp_concept_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_concept_cont">MP_CONCEPT</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_concept_cont']) ?: '' }}" name="q[mp_concept_cont]" id="q_mp_concept_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_paymentmethod_gt">MP_PAYMENTMETHOD</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_paymentmethod_gt']) ?: '' }}" name="q[mp_paymentmethod_gt]" id="q_mp_paymentmethod_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_paymentmethod_lt']) ?: '' }}" name="q[mp_paymentmethod_lt]" id="q_mp_paymentmethod_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_paymentmethod_cont">MP_PAYMENTMETHOD</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_paymentmethod_cont']) ?: '' }}" name="q[mp_paymentmethod_cont]" id="q_mp_paymentmethod_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_reference_gt">MP_REFERENCE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_reference_gt']) ?: '' }}" name="q[mp_reference_gt]" id="q_mp_reference_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_reference_lt']) ?: '' }}" name="q[mp_reference_lt]" id="q_mp_reference_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_reference_cont">MP_REFERENCE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_reference_cont']) ?: '' }}" name="q[mp_reference_cont]" id="q_mp_reference_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_order_gt">MP_ORDER</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_order_gt']) ?: '' }}" name="q[mp_order_gt]" id="q_mp_order_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_order_lt']) ?: '' }}" name="q[mp_order_lt]" id="q_mp_order_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_order_cont">MP_ORDER</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_order_cont']) ?: '' }}" name="q[mp_order_cont]" id="q_mp_order_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_aprobacion_gt">NO_APROBACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_aprobacion_gt']) ?: '' }}" name="q[no_aprobacion_gt]" id="q_no_aprobacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_aprobacion_lt']) ?: '' }}" name="q[no_aprobacion_lt]" id="q_no_aprobacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_aprobacion_cont">NO_APROBACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_aprobacion_cont']) ?: '' }}" name="q[no_aprobacion_cont]" id="q_no_aprobacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_identificador_venta_gt">IDENTIFICADOR_VENTA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['identificador_venta_gt']) ?: '' }}" name="q[identificador_venta_gt]" id="q_identificador_venta_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['identificador_venta_lt']) ?: '' }}" name="q[identificador_venta_lt]" id="q_identificador_venta_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_identificador_venta_cont">IDENTIFICADOR_VENTA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['identificador_venta_cont']) ?: '' }}" name="q[identificador_venta_cont]" id="q_identificador_venta_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ref_medio_pago_gt">REF_MEDIO_PAGO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ref_medio_pago_gt']) ?: '' }}" name="q[ref_medio_pago_gt]" id="q_ref_medio_pago_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ref_medio_pago_lt']) ?: '' }}" name="q[ref_medio_pago_lt]" id="q_ref_medio_pago_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ref_medio_pago_cont">REF_MEDIO_PAGO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ref_medio_pago_cont']) ?: '' }}" name="q[ref_medio_pago_cont]" id="q_ref_medio_pago_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_comicion_gt">COMICION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['comicion_gt']) ?: '' }}" name="q[comicion_gt]" id="q_comicion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['comicion_lt']) ?: '' }}" name="q[comicion_lt]" id="q_comicion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_comicion_cont">COMICION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['comicion_cont']) ?: '' }}" name="q[comicion_cont]" id="q_comicion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_iva_comision_gt">IVA_COMISION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['iva_comision_gt']) ?: '' }}" name="q[iva_comision_gt]" id="q_iva_comision_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['iva_comision_lt']) ?: '' }}" name="q[iva_comision_lt]" id="q_iva_comision_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_iva_comision_cont">IVA_COMISION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['iva_comision_cont']) ?: '' }}" name="q[iva_comision_cont]" id="q_iva_comision_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_dispersion_gt">FECHA_DISPERSION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_dispersion_gt']) ?: '' }}" name="q[fecha_dispersion_gt]" id="q_fecha_dispersion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_dispersion_lt']) ?: '' }}" name="q[fecha_dispersion_lt]" id="q_fecha_dispersion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_dispersion_cont">FECHA_DISPERSION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_dispersion_cont']) ?: '' }}" name="q[fecha_dispersion_cont]" id="q_fecha_dispersion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_periodo_financiamiento_gt">PERIODO_FINANCIAMIENTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['periodo_financiamiento_gt']) ?: '' }}" name="q[periodo_financiamiento_gt]" id="q_periodo_financiamiento_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['periodo_financiamiento_lt']) ?: '' }}" name="q[periodo_financiamiento_lt]" id="q_periodo_financiamiento_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_periodo_financiamiento_cont">PERIODO_FINANCIAMIENTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['periodo_financiamiento_cont']) ?: '' }}" name="q[periodo_financiamiento_cont]" id="q_periodo_financiamiento_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_moneda_gt">MONEDA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['moneda_gt']) ?: '' }}" name="q[moneda_gt]" id="q_moneda_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['moneda_lt']) ?: '' }}" name="q[moneda_lt]" id="q_moneda_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_moneda_cont">MONEDA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['moneda_cont']) ?: '' }}" name="q[moneda_cont]" id="q_moneda_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_banco_emisor_gt">BANCO_EMISOR</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['banco_emisor_gt']) ?: '' }}" name="q[banco_emisor_gt]" id="q_banco_emisor_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['banco_emisor_lt']) ?: '' }}" name="q[banco_emisor_lt]" id="q_banco_emisor_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_banco_emisor_cont">BANCO_EMISOR</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['banco_emisor_cont']) ?: '' }}" name="q[banco_emisor_cont]" id="q_banco_emisor_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_customername_gt">MP_CUSTOMERNAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_customername_gt']) ?: '' }}" name="q[mp_customername_gt]" id="q_mp_customername_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_customername_lt']) ?: '' }}" name="q[mp_customername_lt]" id="q_mp_customername_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_customername_cont">MP_CUSTOMERNAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_customername_cont']) ?: '' }}" name="q[mp_customername_cont]" id="q_mp_customername_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_gt">MAIL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_gt']) ?: '' }}" name="q[mail_gt]" id="q_mail_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_lt']) ?: '' }}" name="q[mail_lt]" id="q_mail_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_cont">MAIL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_cont']) ?: '' }}" name="q[mail_cont]" id="q_mail_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_customername_gt">TEL_CUSTOMERNAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_customername_gt']) ?: '' }}" name="q[tel_customername_gt]" id="q_tel_customername_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_customername_lt']) ?: '' }}" name="q[tel_customername_lt]" id="q_tel_customername_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_customername_cont">TEL_CUSTOMERNAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_customername_cont']) ?: '' }}" name="q[tel_customername_cont]" id="q_tel_customername_cont" />
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
            @if($conciliacionMultiDetalles->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'conciliacion_multipagos.fecha_carga', 'title' => 'CONCILIACION_MULTIPAGO_FECHA_CARGA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'fecha_pago', 'title' => 'FECHA_PAGO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'razon_social', 'title' => 'RAZON_SOCIAL'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_node', 'title' => 'MP_NODE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_concept', 'title' => 'MP_CONCEPT'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_paymentmethod', 'title' => 'MP_PAYMENTMETHOD'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_reference', 'title' => 'MP_REFERENCE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_order', 'title' => 'MP_ORDER'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'no_aprobacion', 'title' => 'NO_APROBACION'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'identificador_venta', 'title' => 'IDENTIFICADOR_VENTA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'ref_medio_pago', 'title' => 'REF_MEDIO_PAGO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'comicion', 'title' => 'COMICION'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'iva_comision', 'title' => 'IVA_COMISION'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'fecha_dispersion', 'title' => 'FECHA_DISPERSION'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'periodo_financiamiento', 'title' => 'PERIODO_FINANCIAMIENTO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'moneda', 'title' => 'MONEDA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'banco_emisor', 'title' => 'BANCO_EMISOR'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_customername', 'title' => 'MP_CUSTOMERNAME'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mail', 'title' => 'MAIL'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'tel_customername', 'title' => 'TEL_CUSTOMERNAME'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($conciliacionMultiDetalles as $conciliacionMultiDetalle)
                            <tr>
                                <td><a href="{{ route('conciliacionMultiDetalles.show', $conciliacionMultiDetalle->id) }}">{{$conciliacionMultiDetalle->id}}</a></td>
                                <td>{{$conciliacionMultiDetalle->conciliacionMultipago->fecha_carga}}</td>
                    <td>{{$conciliacionMultiDetalle->fecha_pago}}</td>
                    <td>{{$conciliacionMultiDetalle->razon_social}}</td>
                    <td>{{$conciliacionMultiDetalle->mp_node}}</td>
                    <td>{{$conciliacionMultiDetalle->mp_concept}}</td>
                    <td>{{$conciliacionMultiDetalle->mp_paymentmethod}}</td>
                    <td>{{$conciliacionMultiDetalle->mp_reference}}</td>
                    <td>{{$conciliacionMultiDetalle->mp_order}}</td>
                    <td>{{$conciliacionMultiDetalle->no_aprobacion}}</td>
                    <td>{{$conciliacionMultiDetalle->identificador_venta}}</td>
                    <td>{{$conciliacionMultiDetalle->ref_medio_pago}}</td>
                    <td>{{$conciliacionMultiDetalle->comicion}}</td>
                    <td>{{$conciliacionMultiDetalle->iva_comision}}</td>
                    <td>{{$conciliacionMultiDetalle->fecha_dispersion}}</td>
                    <td>{{$conciliacionMultiDetalle->periodo_financiamiento}}</td>
                    <td>{{$conciliacionMultiDetalle->moneda}}</td>
                    <td>{{$conciliacionMultiDetalle->banco_emisor}}</td>
                    <td>{{$conciliacionMultiDetalle->mp_customername}}</td>
                    <td>{{$conciliacionMultiDetalle->mail}}</td>
                    <td>{{$conciliacionMultiDetalle->tel_customername}}</td>
                    <td>{{$conciliacionMultiDetalle->usu_alta_id}}</td>
                    <td>{{$conciliacionMultiDetalle->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('conciliacionMultiDetalles.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('conciliacionMultiDetalles.duplicate', $conciliacionMultiDetalle->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('conciliacionMultiDetalles.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('conciliacionMultiDetalles.edit', $conciliacionMultiDetalle->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('conciliacionMultiDetalles.destroy')
                                    {!! Form::model($conciliacionMultiDetalle, array('route' => array('conciliacionMultiDetalles.destroy', $conciliacionMultiDetalle->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $conciliacionMultiDetalles->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection