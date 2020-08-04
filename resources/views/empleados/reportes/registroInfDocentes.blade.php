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

        {!! Form::open(array('route' => 'empleados.registroInfDocentesR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:</label>
            {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>
        <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
            <label for="lectivo_f-field">Lectivo de:</label>
            {!! Form::select("lectivo_f", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
            @if($errors->has("lectivo_f"))
            <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
            @endif
        </div>
        <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
            <label for="estatus_f-field">Estatus de:</label>
            {!! Form::select("estatus_f[]", $list["StEmpleado"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field", 'multiple'=>true)) !!}
            @if($errors->has("estatus_f"))
            <span class="help-block">{{ $errors->first("estatus_f") }}</span>
            @endif
        </div>
        
        <div class="row">
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Ver</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

