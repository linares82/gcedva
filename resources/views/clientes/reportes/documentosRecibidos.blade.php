@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
    <li class="active">Reporte de Seguimientos</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / SEP ICP08 </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'clientes.documentosRecibidosR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:</label>
            {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('inicio_matricula')) has-error @endif">
            <label for="inicio_matricula-field">Inicio Matricula:</label>
            {!! Form::text("inicio_matricula", null, array("class" => "form-control input-sm", "id" => "inicio_matricula-field")) !!}
            @if($errors->has("inicio_matricula"))
            <span class="help-block">{{ $errors->first("inicio_matricula") }}</span>
            @endif
        </div>

        <!--<div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
            <label for="estatus_f-field">Estatus Cliente:</label>
            {!! Form::select("estatus_f", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field")) !!}
            @if($errors->has("estatus_f"))
            <span class="help-block">{{ $errors->first("estatus_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('estatus_seguimiento_f')) has-error @endif">
            <label for="estatus_seguimiento_f-field">Estatus Seguimiento:</label>
            {!! Form::select("estatus_seguimiento_f", $stSeguimientos, null, array("class" => "form-control select_seguridad", "id" => "estatus_seguimiento_f-field")) !!}
            @if($errors->has("estatus_seguimiento_f"))
            <span class="help-block">{{ $errors->first("estatus_seguimiento_f") }}</span>
            @endif
        </div>
-->
        <div class="row">
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Ver</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection