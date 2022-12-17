@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
    <li class="active">Global Financiero</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> Global Financiero
 </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'adeudos.globalFinancieroR', 'id'=>'frm')) !!}
        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:</label>
            {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field",'multiple'=>"true")) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>

        @permission('globalFinanciero.dinero')
        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="bnd_suma_monetaria-field">Incluir Suma Monetaria:
                {!! Form::checkbox("bnd_suma_monetaria", 1, null, [ "id" => "bnd_suma_monetaria-field", 'class'=>'minimal']) !!}
            </label>
            
        </div>
        @endpermission
        <!--
        <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
            <label for="fecha_f-field">Fecha de:</label>
            {!! Form::text("fecha_f", null, array("class" => "form-control", "id" => "fecha_f-field")) !!}
            @if($errors->has("fecha_f"))
            <span class="help-block">{{ $errors->first("fecha_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
            <label for="fecha_t-field">Fecha a:</label>
            {!! Form::text("fecha_t", null, array("class" => "form-control", "id" => "fecha_t-field")) !!}
            @if($errors->has("fecha_t"))
            <span class="help-block">{{ $errors->first("fecha_t") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('concepto_f')) has-error @endif">
            <label for="concepto_f-field">Concepto de:</label>
            {!! Form::select("concepto_f[]", $conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_f-field", "multiple"=>"multiple")) !!}
            <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
            @if($errors->has("concepto_f"))
            <span class="help-block">{{ $errors->first("concepto_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
            <label for="estatus_f-field">Estatus de:</label>
            {!! Form::select("estatus_f[]", $estatus, null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field", "multiple"=>"multiple")) !!}
            <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
            @if($errors->has("estatus"))
            <span class="help-block">{{ $errors->first("estatus_f") }}</span>
            @endif
        </div>
-->



        <div class="row">
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Tabla</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {


        $('#concepto_f-field').select2();


        $('#fecha_f-field').Zebra_DatePicker({
            days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
        });
        $('#fecha_t-field').Zebra_DatePicker({
            days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
        });

    });
</script>
@endpush