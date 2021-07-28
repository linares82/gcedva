@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
    <li class="active">Reporte de Seguimientos</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Listado Empleados </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'empleados.listadoColaboradoresR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:*<input type="checkbox" id="seleccionar_planteles">Seleccionar Todo</label>
            {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
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

@push('scripts')
<script type="text/javascript">

    $('#seleccionar_planteles').change(function(){
        if( $(this).is(':checked') ) {
        $("#plantel_f-field > option").prop("selected","selected");
                $("#plantel_f-field").trigger("change");
        }else{
        $("#plantel_f-field > option").prop("selected","selected");
                $('#plantel_f-field').val(null).trigger('change');
        }
    });

</script>
@endpush