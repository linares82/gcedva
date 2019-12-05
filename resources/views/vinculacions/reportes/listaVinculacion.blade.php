@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
    <li class="active">Reporte de Vinculacion</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'vinculacions.listaVinculacionR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:</label>
            {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-3 @if($errors->has('especialidad')) has-error @endif">
            <label for="especialidad-field">Especialidad</label>
            {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
            @if($errors->has("especialidad"))
            <span class="help-block">{{ $errors->first("especialidad") }}</span>
            @endif
        </div>
        <div class="form-group col-md-2 @if($errors->has('nivel_id')) has-error @endif">
            <label for="nivel_id-field">Nivel</label>
            {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
            <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
            @if($errors->has("nivel_id"))
            <span class="help-block">{{ $errors->first("nivel_id") }}</span>
            @endif
        </div>
        <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
            <label for="grado_id-field">Grado</label>
            {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
            <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
            @if($errors->has("grado_id"))
            <span class="help-block">{{ $errors->first("grado_id") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
            <label for="estatus_f-field">Estatus de:</label>
            {!! Form::select("estatus_f", $estatus, null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field")) !!}
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
<script>
    $('#plantel_id-field').change(function(){
    getCmbEspecialidad();
    });
    $('#especialidad_id-field').change(function(){
    getCmbNivel();
    });
    $('#nivel_id-field').change(function(){
    getCmbGrado();
    });

    function getCmbEspecialidad(){
    //var $example = $("#especialidad_id-field").select2();
    var a = $('#frm_cliente').serialize();
    $.ajax({
    url: '{{ route("especialidads.getCmbEspecialidad") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
            dataType: 'json',
            beforeSend : function(){$("#loading10").show(); },
            complete : function(){$("#loading10").hide(); },
            success: function(data){
            //$example.select2("destroy");
            $('#especialidad_id-field').empty();
            $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#especialidad_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }
    
    function getCmbNivel(){
    //var $example = $("#especialidad_id-field").select2();
    //alert($('#especialidad_id-field option:selected').val());
    var a = $('#frm_cliente').serialize();
    $.ajax({
    url: '{{ route("nivels.getCmbNivels") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
            dataType: 'json',
            beforeSend : function(){$("#loading11").show(); },
            complete : function(){$("#loading11").hide(); },
            success: function(data){
            //alert(data);
            //$example.select2("destroy");
            $('#nivel_id-field').html('');
            //$('#especialidad_id-field').empty();
            $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#nivel_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }
    
    function getCmbGrado(){
    //var $example = $("#especialidad_id-field").select2();
    var a = $('#frm_cliente').serialize();
    $.ajax({
    url: '{{ route("grados.getCmbGrados") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "",
            dataType: 'json',
            beforeSend : function(){$("#loading12").show(); },
            complete : function(){$("#loading12").hide(); },
            success: function(data){
            //alert(data);
            //$example.select2("destroy");
            $('#grado_id-field').html('');
            //$('#especialidad_id-field').empty();
            $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
            //alert(data[i].name);
            $('#grado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
            }
    });
    }
    

</script>
    
@endpush