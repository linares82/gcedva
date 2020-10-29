@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Altas por Usuario</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i>  / Sabana Calificaciones </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'periodoEstudios.sabanaCalificacionesR', 'id'=>'frm_reporte')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $planteles_validos, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    <div id='loading_plantel' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo de:</label>
                    {!! Form::select("lectivo_f", $list['Grado'], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
                    <label for="grupo_f-field">Grupo de:</label>
                    {!! Form::select("grupo_f", $list['Grado'], null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    @if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("grupo_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
                    <label for="especialidad_f-field">Especialidad de:</label>
                    {!! Form::select("especialidad_f", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field")) !!}
                    <div id='loading_especialidad' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("especialidad_f"))
                    <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
                    @endif
                </div>
            
                
                <div class="form-group col-md-6 @if($errors->has('nivel_f')) has-error @endif">
                    <label for="nivel_f-field">Nivel de:</label>
                    {!! Form::select("nivel_f", $list['Nivel'], null, array("class" => "form-control select_seguridad", "id" => "nivel_f-field")) !!}
                    <div id='loading_nivel' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("nivel_f"))
                    <span class="help-block">{{ $errors->first("nivel_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('grado_f')) has-error @endif">
                    <label for="grado_f-field">Grado de:</label>
                    {!! Form::select("grado_f", $list['Grado'], null, array("class" => "form-control select_seguridad", "id" => "grado_f-field")) !!}
                    @if($errors->has("grado_f"))
                    <span class="help-block">{{ $errors->first("grado_f") }}</span>
                    @endif
                </div>

                

                <!--<div class="form-group col-md-6 @if($errors->has('periodos_estudio')) has-error @endif">
                    <label for="periodos_estudio-field">Periodos Estudio:</label>
                    @{!! Form::select("periodos_estudio[]", $list['Grado'], null, array("class" => "form-control select_seguridad", "id" => "periodos_estudio-field",'multiple'=>true)) !!}
                    @if($errors->has("periodos_estudio"))
                    <span class="help-block">{{ $errors->first("periodos_estudio") }}</span>
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
        
        $('#plantel_f-field').change(function(){
            
            getCmbLectivo();
        }); 
        $('#especialidad_f-field').change(function(){
            getCmbNivelGrupoInscripcion();
        });
       $('#nivel_f-field').change(function(){
            getCmbGradoGrupoInscripcion();
        });
        $('#grado_f-field').change(function(){
            getCmbPeriodos();
        });
        $('#lectivo_f-field').change(function(){
            getCmbGrupo();
        });
        $('#grupo_f-field').change(function(){
            getCmbEspecialidadGrupoInscripcion();
        });
        
    });


    function getCmbEspecialidadGrupoInscripcion(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_grados').serialize();
            $.ajax({
                url: '{{ route("especialidads.getCmbEspecialidadGrupoInscripcion") }}',
                type: 'GET',
                data: {
                    'plantel_id':$('#plantel_f-field option:selected').val(),
                    'especialidad_id':$('#especialidad_f-field option:selected').val(),
                    'grupo_id':$('#grupo_f-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading_plantel").show();},
                complete : function(){$("#loading_plantel").hide();},
                success: function(data){
                    //$example.select2("destroy");
                    $('#especialidad_f-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#especialidad_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#especialidad_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    });
                    //$example.select2();
                }
            });       
    }

    function getCmbNivelGrupoInscripcion(){
                        //var $example = $("#especialidad_id-field").select2();
    //alert($('#especialidad_id-field option:selected').val());
    
    $.ajax({
    url: '{{ route("nivels.getCmbNivelsGrupoInscripcion") }}',
            type: 'GET',
            data: {
                    'plantel_id':$('#plantel_f-field option:selected').val(),
                    'especialidad_id':$('#especialidad_f-field option:selected').val(),
                    'nivel_id':$('#nivel_f-field option:selected').val(),
                    'grupo_id':$('#grupo_f-field option:selected').val()
                },
            dataType: 'json',
            beforeSend : function(){$("#loading_especialidad").show(); },
            complete : function(){$("#loading_especialidad").hide(); },
            success: function(data){
            //alert(data);
            //$example.select2("destroy");
            $('#nivel_f-field').html('');
            //$('#especialidad_id-field').empty();
            $('#nivel_f-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#nivel_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }

    function getCmbGradoGrupoInscripcion(){
                        //var $example = $("#especialidad_id-field").select2();
    
    $.ajax({
    url: '{{ route("grados.getCmbGradosGrupoInscripcion") }}',
            type: 'GET',
            data: {
                    'plantel_id':$('#plantel_f-field option:selected').val(),
                    'especialidad_id':$('#especialidad_f-field option:selected').val(),
                    'nivel_id':$('#nivel_f-field option:selected').val(),
                    'grado_f': $('#grado_f-field option:selected').val(),
                    'grupo_id':$('#grupo_f-field option:selected').val()
                },
            dataType: 'json',
            beforeSend : function(){$("#loading_nivel").show(); },
            complete : function(){$("#loading_nivel").hide(); },
            success: function(data){
            //alert(data);
            //$example.select2("destroy");
            $('#grado_f-field').html('');
            //$('#especialidad_id-field').empty();
            $('#grado_f-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#grado_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }

    function getCmbLectivo(){
                        //var $example = $("#especialidad_id-field").select2();
    
    $.ajax({
    url: '{{ route("lectivos.lectivosPorPlantel") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + 
            "&lectivo_id=" + $('#lectivof-field option:selected').val(),
            dataType: 'json',
            beforeSend : function(){$("#loading_plantel").show(); },
            complete : function(){$("#loading_plantel").hide(); },
            success: function(data){
            //alert(data);
            //$example.select2("destroy");
            $('#lectivo_f-field').html('');
            //$('#especialidad_id-field').empty();
            $('#lectivo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#lectivo_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }

    function getCmbPeriodos(){
                        //var $example = $("#especialidad_id-field").select2();
    
    $.ajax({
    url: '{{ route("periodoEstudios.cmbPeriodos") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + 
            "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + 
            "&nivel_id=" + $('#nivel_f-field option:selected').val() + 
            "&grado_id=" + $('#grado_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend : function(){$("#loading_plantel").show(); },
            complete : function(){$("#loading_plantel").hide(); },
            success: function(data){
            console.log(data);
            //$example.select2("destroy");
            $('#periodos_estudio-field').html('');
            //$('#especialidad_id-field').empty();
            $('#periodos_estudio-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#periodos_estudio-field').append("<option value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }

    function getCmbGrupo(){
    $.ajax({
    url: '{{ route("grupos.gruposXplantelXasignacion") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + 
            "&lectivo_id=" + $('#lectivo_f-field option:selected').val(),
            dataType: 'json',
            beforeSend : function(){$("#loading_plantel").show(); },
            complete : function(){$("#loading_plantel").hide(); },
            success: function(data){
            console.log(data);
            //$example.select2("destroy");
            $('#grupo_f-field').html('');
            //$('#especialidad_id-field').empty();
            $('#grupo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#grupo_f-field').append("<option value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }
                        
    
    
    </script>
@endpush