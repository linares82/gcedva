@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">CCXEP</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Becas / Becas </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'autorizacionBecas.becasAutorizadasR', 'id'=>'frm_reporte')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    <div id='loading_plantel' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <!--
                <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
                    <label for="especialidad_f-field">Especialidad de:</label>
                    @{!! Form::select("especialidad_f", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field")) !!}
                    <div id='loading_especialidad' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("especialidad_f"))
                    <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('nivel_f')) has-error @endif">
                    <label for="nivel_f-field">Nivel de:</label>
                    @{!! Form::select("nivel_f", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_f-field")) !!}
                    <div id='loading_nivel' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("nivel_f"))
                    <span class="help-block">{{ $errors->first("nivel_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('grado_f')) has-error @endif">
                    <label for="grado_f-field">Grado de:</label>
                    @{!! Form::select("grado_f", null, null, array("class" => "form-control select_seguridad", "id" => "grado_f-field")) !!}
                    @if($errors->has("grado_f"))
                    <span class="help-block">{{ $errors->first("grado_f") }}</span>
                    @endif
                </div>
            -->
                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo:</label>
                    {!! Form::select("lectivo_f", array(), null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                    <div id='loading_grupo' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
                    <label for="fecha_f-field">Fecha Vigencia de(Opcional):</label>
                    {!! Form::text("fecha_f", null, array("class" => "form-control input-sm fecha", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha Vigencia a(Opcional):</label>
                    {!! Form::text("fecha_t", null, array("class" => "form-control input-sm fecha", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                    @endif
                </div>


<!--
                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
                    <label for="fecha_f-field">Fecha de:</label>
                    @{!! Form::text("fecha_f", null, array("class" => "form-control input-sm", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha a:</label>
                    @{!! Form::text("fecha_t", null, array("class" => "form-control input-sm", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                    @endif
                </div>-->
                
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button id="submit_tbl" type="submit" class="btn btn-primary">Tabla</button>
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
      
      $('#plantel_f-field').change(function () {
            getCmbEspecialidad();
            getCmbLectivos();
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
                $("#loading_plantel").show();
            },
            complete: function () {
                $("#loading_plantel").hide();
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
                $("#loading_especialidad").show();
            },
            complete: function () {
                $("#loading_especialidad").hide();
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
                $("#loading_nivel").show();
            },
            complete: function () {
                $("#loading_nivel").hide();
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


    
    </script>
@endpush