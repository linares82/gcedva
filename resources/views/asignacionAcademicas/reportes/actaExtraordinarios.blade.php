@extends('plantillas.admin_template')

@include('asignacionAcademicas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('asignacionAcademicas.index') }}">@yield('asignacionAcademicasAppTitle')</a></li>
	    <li class="active">Horario por Grupo</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('asignacionAcademicasAppTitle') / Acta Extraordinarios </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'asignacionAcademica.actaExtraordinariosR', 'id'=>'frm_seguimiento')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel</label>
                    {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    <div id='loading_plantel' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo:</label>
                    {!! Form::select("lectivo_f", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                    <div id='loading_grupo' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                    @endif
                </div>
                <!--
                <div class="form-group col-md-6 @@if($errors->has('grupo_f')) has-error @@endif">
                    <label for="grupo_f-field">Grupo:</label>
                    @{!! Form::select("grupo_f", $grupos, null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    <div id='loading_materia' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @@if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("plantel_t") }}</span>
                    @@endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('materia_f')) has-error @endif">
                    <label for="materia_f-field">Materia:</label>
                    @{!! Form::select("materia_f", $materias, null, array("class" => "form-control select_seguridad", "id" => "materia_f-field")) !!}
                    <div id='loading_ponderacion' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @@if($errors->has("materia_f"))
                    <span class="help-block">{{ $errors->first("materia_t") }}</span>
                    @@endif
                </div>-->
            
                
                
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
    $('#plantel_f-field').change(function(){
        getCmbLectivos();
    });
    $('#lectivo_f-field').change(function(){
        getCmbGrupos();
    });
    $('#grupo_f-field').change(function(){
        getCmbMaterias();
    });
    $('#materia_f-field').change(function(){
        getCmbPonderaciones();
    });


    });

    function getCmbLectivos() {
        //var $example = $("#especialidad_id-field").select2();
        $.ajax({
            url: '{{ route("lectivos.lectivoXplantelXasignacion") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&lectivo_id=" + $('#lectivo_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading_plantel").show();
            },
            complete: function () {
                $("#loading_plantel").hide();
            },
            success: function (data) {
                //$example.select2("destroy");
                $('#lectivo_f-field').empty();
                $('#lectivo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#lectivo_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }

    function getCmbGrupos() {
        //var $example = $("#especialidad_id-field").select2();
        $.ajax({
            url: '{{ route("grupos.gruposXplantelXasignacion") }}',
            type: 'GET',
            data: {
                'plantel_id':$('#plantel_f-field option:selected').val(),
                'lectivo_id':$('#lectivo_f-field option:selected').val(),
                'grupo_id':$('#grupo_f-field option:selected').val(),
            },
            dataType: 'json',
            beforeSend: function () {
                $("#loading_materia").show();
            },
            complete: function () {
                $("#loading_materia").hide();
            },
            success: function (data) {
                //console.log(data[0]);
                //$example.select2("destroy");
                $('#grupo_f-field').empty();
                $('#grupo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#grupo_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }

    function getCmbMaterias() {
        //var $example = $("#especialidad_id-field").select2();
        $.ajax({
            url: '{{ route("materias.materiasXplantelXasignacion") }}',
            type: 'GET',
            data: {
                'plantel_id':$('#plantel_f-field option:selected').val(),
                'lectivo_id':$('#lectivo_f-field option:selected').val(),
                'grupo_id':$('#grupo_f-field option:selected').val(),
                'materia_id':$('#materia_f-field option:selected').val(),
            },
            dataType: 'json',
            beforeSend: function () {
                $("#loading_ponderacion").show();
            },
            complete: function () {
                $("#loading_ponderacion").hide();
            },
            success: function (data) {
                console.log(data[0]);
                //$example.select2("destroy");
                $('#materia_f-field').empty();
                $('#materia_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#materia_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }

    function getCmbPonderaciones() {
        //var $example = $("#especialidad_id-field").select2();
        $.ajax({
            url: '{{ route("cargaPonderacions.ponderacionesXMateria") }}',
            type: 'GET',
            data: {
                'materia_id':$('#materia_f-field option:selected').val()
            },
            dataType: 'json',
            beforeSend: function () {
                $("#loading_materia").show();
            },
            complete: function () {
                $("#loading_materia").hide();
            },
            success: function (data) {
                console.log(data[0]);
                //$example.select2("destroy");
                $('#ponderacion_f-field').empty();
                $('#ponderacion_f-field').append($('<option>Todas</option>').text('Todas').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#ponderacion_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                
            }
        });
    }
    
    </script>
@endpush