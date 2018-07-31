@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Lista </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inscripcions.lista', 'id'=>'frm')) !!}

<!--                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
                    <label for="fecha_f-field">Fecha de:</label>
                    {!! Form::text("fecha_f", null, array("class" => "form-control input-sm", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha a:</label>
                    {!! Form::text("fecha_t", null, array("class" => "form-control input-sm", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                    @endif
                </div>-->
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo de:</label>
                    {!! Form::select("lectivo_f", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
                    <label for="grupo_f-field">Grupo de:</label>
                    {!! Form::select("grupo_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    @if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("grupo_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('grupo_t')) has-error @endif">
                    <label for="grupo_t-field">Grupo a:</label>
                    {!! Form::select("grupo_t", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_t-field")) !!}
                    @if($errors->has("grupo_t"))
                    <span class="help-block">{{ $errors->first("grupo_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('grado_f')) has-error @endif">
                    <label for="grado_f-field">Grado de:</label>
                    {!! Form::select("grado_f", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "Grupo_f-field")) !!}
                    @if($errors->has("grado_f"))
                    <span class="help-block">{{ $errors->first("grado_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('grado_t')) has-error @endif">
                    <label for="grado_t-field">Grado a:</label>
                    {!! Form::select("grado_t", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_t-field")) !!}
                    @if($errors->has("grado_t"))
                    <span class="help-block">{{ $errors->first("grado_t") }}</span>
                    @endif
                </div>
                <!--
                <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
                    <label for="especialidad_f-field">Especialidad de:</label>
                    {!! Form::select("especialidad_f", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field")) !!}
                    @if($errors->has("especialidad_f"))
                    <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
                    @endif
                </div
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
    $('#fecha_f-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fecha_t-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    
    @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        $("#plantel_t-field").prop("disabled", true);
    @endpermission
        
    });
    
    </script>
@endpush