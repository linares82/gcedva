@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('inscripcions.index') }}">Reportes DGCFT</a></li>
    <li class="active">Reportes DGCFT</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> Reportes DGCFT </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'inscripcions.reportesDgcftR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('reportes')) has-error @endif">
            <label for="reportes-field">Plantel de:</label>
            {!! Form::select("reportes", $reportes, null, array("class" => "form-control select_seguridad", "id" => "reportes-field")) !!}
            @if($errors->has("reportes"))
            <span class="help-block">{{ $errors->first("reportes") }}</span>
            @endif
        </div>

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

        
        <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
            <label for="grupo_f-field">Grupo:</label>
            {!! Form::select("grupo_f[]", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field", 'multiple'=>true)) !!}
            @if($errors->has("grupo_f"))
            <span class="help-block">{{ $errors->first("grupo_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
            <label for="lectivo_f-field">Lectivo:</label>
            {!! Form::select("lectivo_f[]", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field",'multiple'=>true)) !!}
            @if($errors->has("lectivo_f"))
            <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('bnd_detalle')) has-error @endif">
            <label for="bnd_detalle-field">Detalle:</label>
            {!! Form::select("bnd_detalle[]", array(1=>'Si', 2=>"No"), 2, array("class" => "form-control select_seguridad", "id" => "bnd_detalle-field")) !!}
            @if($errors->has("bnd_detalle"))
            <span class="help-block">{{ $errors->first("bnd_detalle") }}</span>
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

        $('#grado_f-field').change(function () {
            getCmbGrupos();
            getCmbLectivos();
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

    function getCmbGrupos() {
        //var $example = $("#especialidad_id-field").select2();
        var a = $('#frm_cliente').serialize();
        $.ajax({
            url: '{{ route("grupos.getCmbGrupoXGrado") }}',
            type: 'GET',
            data:{
                'plantel_id':$('#plantel_f-field option:selected').val(),
                'especialidad_id':$('#especialidad_f-field option:selected').val(),
                'nivel_id':$('#nivel_f-field option:selected').val(),
                'grado_id':$('#grado_f-field option:selected').val()
            }, 
            //"plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "&nivel_id=" + $('#nivel_f-field option:selected').val() + "&grado_id=" + $('#grado_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading12").show();
            },
            complete: function () {
                $("#loading12").hide();
            },
            success: function (data) {
                
                //$example.select2("destroy");
                $('#grupo_f-field').html('');
                //$('#especialidad_id-field').empty();
                $('#grupo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#grupo_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                $('#grupo_f-field').trigger('change');
                //$example.select2();
            }
        });
    }

    function getCmbLectivos() {
        //var $example = $("#especialidad_id-field").select2();
        var a = $('#frm_cliente').serialize();
        $.ajax({
            url: '{{ route("lectivos.getLectivosXGrado") }}',
            type: 'GET',
            data:{
                'plantel_id':$('#plantel_f-field option:selected').val(),
                'especialidad_id':$('#especialidad_f-field option:selected').val(),
                'nivel_id':$('#nivel_f-field option:selected').val(),
                'grado_id':$('#grado_f-field option:selected').val()
            }, 
            //"plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "&nivel_id=" + $('#nivel_f-field option:selected').val() + "&grado_id=" + $('#grado_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading12").show();
            },
            complete: function () {
                $("#loading12").hide();
            },
            success: function (data) {
                
                //$example.select2("destroy");
                $('#lectivo_f-field').html('');
                //$('#especialidad_id-field').empty();
                $('#lectivo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#lectivo_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                $('#lectivo_f-field').trigger('change');
                //$example.select2();
            }
        });
    }


</script>
@endpush

