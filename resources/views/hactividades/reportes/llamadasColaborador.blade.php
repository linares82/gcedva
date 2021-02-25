@extends('plantillas.admin_template')

@include('asignacionAcademicas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li class="active">Llamadas por Colaborador</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i>  Tareas por Colaborador </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'hactividades.llamadasColaboradoresR', 'id'=>'frm_seguimiento')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel</label>
                    {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                    <div id='loading_plantel' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
                    <label for="fecha_f-field">Fecha de:</label>
                    {!! Form::text("fecha_f", null, array("class" => "form-control input-sm fecha", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha a:</label>
                    {!! Form::text("fecha_t", null, array("class" => "form-control input-sm fecha", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                    @endif
                </div>
                <!--
                <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
                    <label for="grupo_f-field">Grupo:</label>
                    @{!! Form::select("grupo_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    <div id='loading_materia' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("plantel_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('materia_f')) has-error @endif">
                    <label for="materia_f-field">Materia:</label>
                    @{!! Form::select("materia_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "materia_f-field")) !!}
                    <div id='loading_ponderacion' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("materia_f"))
                    <span class="help-block">{{ $errors->first("materia_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('ponderacion_f')) has-error @endif">
                    <label for="ponderacion_f-field">Ponderacion(Opera Identificador Numerico de la Descripcion):</label>
                    @{!! Form::select("ponderacion_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "ponderacion_f-field")) !!}
                    @if($errors->has("ponderacion_f"))
                    <span class="help-block">{{ $errors->first("materia_t") }}</span>
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
    
    </script>
@endpush