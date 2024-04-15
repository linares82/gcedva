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

        {!! Form::open(array('route' => 'inscripcions.sepEstadisticoR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:</label>
            {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>
        <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
            <label for="especialidad_f-field">Especialidad de:</label>
            {!! Form::select("especialidad_f", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field")) !!}
            @if($errors->has("especialidad_f"))
            <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
            @endif
        </div>
        <div class="form-group col-md-6 @if($errors->has('nivel_f')) has-error @endif">
            <label for="nivel_f-field">Nivel de:</label>
            {!! Form::select("nivel_f", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_f-field")) !!}
            @if($errors->has("nivel_f"))
            <span class="help-block">{{ $errors->first("nivel_f") }}</span>
            @endif
        </div>
        <div class="form-group col-md-6 @if($errors->has('grado_f')) has-error @endif">
            <label for="grado_f-field">Grado de:</label>
            {!! Form::select("grado_f", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_f-field")) !!}
            @if($errors->has("grado_f"))
            <span class="help-block">{{ $errors->first("grado_f") }}</span>
            @endif
        </div>

        <!--                <div class="form-group col-md-6 @if($errors->has('empleado_f')) has-error @endif">
                            <label for="empleado_f-field">Colaborador de:</label>
                            {!! Form::select("empleado_f", array(), null, array("class" => "form-control select_seguridad", "id" => "empleado_f-field")) !!}
                            @if($errors->has("empleado_f"))
                            <span class="help-block">{{ $errors->first("empleado_f") }}</span>
                            @endif
                        </div>-->
        <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
            <label for="lectivo_f-field">Lectivo:</label>
            {!! Form::select("lectivo_f", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
            @if($errors->has("lectivo_f"))
            <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
            @endif
        </div>
        
        <div class="row"></div>

        <div class="form-group col-md-4 @if($errors->has('grupo')) has-error @endif"
            <label for="grupo-field">Grupo</label> 
            {!! Form::text("grupo", null, array("class" => "form-control input-sm", "id" => "grupo")) !!}
            @if($errors->has("grupo"))
             <span class="help-block">{{ $errors->first("grupo") }}</span>
            @endif
         </div>
        
        <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif"
            <label for="fecha-field">Fecha</label> 
            {!! Form::text("fecha", null, array("class" => "form-control input-sm", "id" => "fecha")) !!}
            @if($errors->has("fecha"))
             <span class="help-block">{{ $errors->first("fecha") }}</span>
            @endif
         </div>
        
        <div class="form-group col-md-4 @if($errors->has('fecha_inicio')) has-error @endif"
            <label for="fecha_inicio-field">Fecha de Inicio</label> 
            {!! Form::text("fecha_inicio", null, array("class" => "form-control input-sm", "id" => "fecha_inicio")) !!}
            @if($errors->has("fecha_inicio"))
             <span class="help-block">{{ $errors->first("fecha_inicio") }}</span>
            @endif
         </div>
        
        <div class="form-group col-md-4 @if($errors->has('fecha_termino')) has-error @endif"
            <label for="fecha_termino-field">Fecha de Termino</label> 
            {!! Form::text("fecha_termino", null, array("class" => "form-control input-sm", "id" => "fecha_termino")) !!}
            @if($errors->has("fecha_termino"))
             <span class="help-block">{{ $errors->first("fecha_termino") }}</span>
            @endif
         </div>
        
        <div class="form-group col-md-4 @if($errors->has('duracion_horas')) has-error @endif"
            <label for="duracion_horas-field">Duracion en Horas</label> 
            {!! Form::text("duracion_horas", null, array("class" => "form-control input-sm", "id" => "duracion_horas")) !!}
            @if($errors->has("duracion_horas"))
             <span class="help-block">{{ $errors->first("duracion_horas") }}</span>
            @endif
         </div>
        
        <div class="form-group col-md-4 @if($errors->has('horario')) has-error @endif"
            <label for="horario-field">Horario</label> 
            {!! Form::text("horario", null, array("class" => "form-control input-sm", "id" => "horario")) !!}
            @if($errors->has("horario"))
             <span class="help-block">{{ $errors->first("horario") }}</span>
            @endif
         </div>
        
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
    $(document).ready(function () {

        $('#fecha_t-field').Zebra_DatePicker({
            days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
        });

        $('#plantel_f-field').change(function () {
            getCmbEspecialidad();
        });

        $('#especialidad_f-field').change(function () {
            getCmbNivel();
        });
        $('#nivel_f-field').change(function () {
            getCmbGrado();
        });

    });

    function getCmbEspecialidad() {
        //var $example = $("#especialidad_id-field").select2();
        $.ajax({
            url: '{{ route("especialidads.getCmbEspecialidad") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading10").show();
            },
            complete: function () {
                $("#loading10").hide();
            },
            success: function (data) {
                //$example.select2("destroy");
                $('#especialidad_f-field').empty();
                $('#especialidad_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#especialidad_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }

    function getCmbNivel() {
        
        $.ajax({
            url: '{{ route("nivels.getCmbNivels") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "&nivel_id=" + $('#nivel_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading11").show();
            },
            complete: function () {
                $("#loading11").hide();
            },
            success: function (data) {
                //alert(data);
                //$example.select2("destroy");
                $('#nivel_f-field').html('');
                //$('#especialidad_f-field').empty();
                $('#nivel_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#nivel_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }

    function getCmbGrado() {
        //var $example = $("#especialidad_id-field").select2();
        var a = $('#frm_cliente').serialize();
        $.ajax({
            url: '{{ route("grados.getCmbGrados") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "&nivel_id=" + $('#nivel_f-field option:selected').val() + "&grado_id=" + $('#grado_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading12").show();
            },
            complete: function () {
                $("#loading12").hide();
            },
            success: function (data) {
                //alert(data);
                //$example.select2("destroy");
                $('#grado_f-field').html('');
                //$('#especialidad_id-field').empty();
                $('#grado_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#grado_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }


</script>
@endpush

