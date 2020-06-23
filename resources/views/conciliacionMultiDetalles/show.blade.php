@extends('plantillas.admin_template')

@include('conciliacionMultiDetalles._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('conciliacionMultiDetalles.index') }}">@yield('conciliacionMultiDetallesAppTitle')</a></li>
    <li class="active">{{ $conciliacionMultiDetalle->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('conciliacionMultiDetallesAppTitle') / Mostrar {{$conciliacionMultiDetalle->id}}

            {!! Form::model($conciliacionMultiDetalle, array('route' => array('conciliacionMultiDetalles.destroy', $conciliacionMultiDetalle->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('conciliacionMultiDetalle.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('conciliacionMultiDetalles.edit', $conciliacionMultiDetalle->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('conciliacionMultiDetalle.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$conciliacionMultiDetalle->id}}</p>
                </div>
                <div class="form-group">
                     <label for="conciliacion_multipago_id">CONCILIACION_MULTIPAGO_ID</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->conciliacion_multipago_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_pago">FECHA_PAGO</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->fecha_pago}}</p>
                </div>
                    <div class="form-group">
                     <label for="razon_social">RAZON_SOCIAL</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->razon_social}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_node">MP_NODE</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mp_node}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_concept">MP_CONCEPT</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mp_concept}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_paymentmethod">MP_PAYMENTMETHOD</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mp_paymentmethod}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_reference">MP_REFERENCE</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mp_reference}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_order">MP_ORDER</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mp_order}}</p>
                </div>
                    <div class="form-group">
                     <label for="no_aprobacion">NO_APROBACION</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->no_aprobacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="identificador_venta">IDENTIFICADOR_VENTA</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->identificador_venta}}</p>
                </div>
                    <div class="form-group">
                     <label for="ref_medio_pago">REF_MEDIO_PAGO</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->ref_medio_pago}}</p>
                </div>
                    <div class="form-group">
                     <label for="comicion">COMICION</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->comicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="iva_comision">IVA_COMISION</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->iva_comision}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_dispersion">FECHA_DISPERSION</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->fecha_dispersion}}</p>
                </div>
                    <div class="form-group">
                     <label for="periodo_financiamiento">PERIODO_FINANCIAMIENTO</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->periodo_financiamiento}}</p>
                </div>
                    <div class="form-group">
                     <label for="moneda">MONEDA</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->moneda}}</p>
                </div>
                    <div class="form-group">
                     <label for="banco_emisor">BANCO_EMISOR</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->banco_emisor}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_customername">MP_CUSTOMERNAME</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mp_customername}}</p>
                </div>
                    <div class="form-group">
                     <label for="mail">MAIL</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->mail}}</p>
                </div>
                    <div class="form-group">
                     <label for="tel_customername">TEL_CUSTOMERNAME</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->tel_customername}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$conciliacionMultiDetalle->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('conciliacionMultiDetalles.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection