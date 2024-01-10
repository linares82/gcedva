@extends('plantillas.admin_template')

@include('asignacionAcademicas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('asignacionAcademicas.index') }}">Prospectos</a></li>
	    <li class="active">Segmentos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Prospectos Segmentados </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'prospectos.prospectosSegmentadosR', 'id'=>'frm_seguimiento')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel</label>
                    <a href='#' id='select-all'>Seleccionar todos</a> / 
                    <a href='#' id='deselect-all'>Deseleccionar todos</a>
                    {!! Form::select("plantel_f[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                </div>

                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
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
    $(document).ready(function() {
        $('#select-all').click(function(){
            $('select#plantel_f-field').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function(){
            $('select#plantel_f-field').multiSelect('deselect_all');
            return false;
        });
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
        //getCmbLectivos();
    });
    $('#lectivo_f-field').change(function(){
        getCmbGrupos();
        getCmbMaterias();
    });
    $('#grupo_f-field').change(function(){
        
    });
    $('#materia_f-field').change(function(){
        getCmbPonderaciones();
    });


    });

    function getCmbLectivos() {
        //var $example = $("#especialidad_id-field").select2();
        //url: '{{ route("lectivos.lectivoOXplantelXasignacion") }}',
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
            url: '{{ route("materias.materiasExtraordinario") }}',
            type: 'GET',
            data: {
                'plantel_id':$('#plantel_f-field option:selected').val(),
                'lectivo_id':$('#lectivo_f-field option:selected').val(),
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