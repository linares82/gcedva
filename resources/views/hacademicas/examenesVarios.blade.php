@extends('plantillas.admin_template')

@include('hacademicas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hacademicas.index') }}">@yield('hacademicasAppTitle')</a></li>
	    <li class="active">Examenes</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('hacademicasAppTitle') / Examenes </h3>
    </div>

    <style>
      table tr:hover {
        background-color: #A9D0F5;
        cursor: pointer;
    }
    </style>
@endsection

@section('content')
    @include('error')
    
    <div class="alert alert-success">
        {{session('msj')}}
    </div>
    <div class="row">
        <div class="col-md-12">
            
            {!! Form::open(array('route' => 'hacademicas.examenesVariosR', "id"=>"frm_academica")) !!}
            
                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                    <label for="plantel_id-field">Plantel</label>
                    {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                    @if($errors->has("plantel_id"))
                    <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-4 @if($errors->has('especialidad')) has-error @endif">
                    <label for="especialidad-field">Especialidad</label>
                    {!! Form::hidden("combinacion", null, array("class" => "form-control input-sm", "id" => "combinacion-field")) !!}
                    {!! Form::select("especialidad_id", array(), null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("especialidad"))
                    <span class="help-block">{{ $errors->first("especialidad") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                    <label for="nivel_id-field">Nivel</label>
                    {!! Form::select("nivel_id", array(), null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                    <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("nivel_id"))
                    <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                    <label for="grado_id-field">Grado</label>
                    {!! Form::select("grado_id", array(), null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                    <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("grado_id"))
                    <span class="help-block">{{ $errors->first("grado_id") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                    <label for="lectivo_id-crear">Periodo Lectivo</label>
                    {!! Form::select("lectivo_id", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                    @if($errors->has("lectivo_id"))
                     <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                    @endif
                 </div>
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    
                    <button type="submit" class="btn btn-success" id="btnContarExtras">Consultar</button>
                </div>
                
            {!! Form::close() !!}
        </div>
    </div>
    
@endsection
@push('scripts')
<script type="text/javascript">
    
    $(document).ready(function() {
        $('#plantel_id-field').change(function(){
        getCmbEspecialidad();
        });
        $('#especialidad_id-field').change(function(){
        getCmbNivel();
        });
        $('#nivel_id-field').change(function(){
        getCmbGrado();
        });

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