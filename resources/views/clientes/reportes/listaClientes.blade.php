@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Altas por Usuario</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i>  / Clientes - Lista </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.listaClientesR', 'id'=>'frm_reporte')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
            
                
            <!--
                <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
                    <label for="especialidad_f-field">Especialidad de:</label>
                    @{!! Form::select("especialidad_f", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field")) !!}
                    @if($errors->has("especialidad_f"))
                    <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
                    @endif
                </div>
            -->
                
            <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                <label for="lectivo_f-field">Lectivo de:</label>
                {!! Form::select("lectivo_f", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                @if($errors->has("lectivo_f"))
                <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                @endif
            </div>

                <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
                    <label for="grupo_f-field">Grupo de:</label>
                    {!! Form::select("grupo_f", $grupos, null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    @if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("grupo_f") }}</span>
                    @endif
                </div>
            
            
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
        getCmbLectivos();   
        getCmbGrupo();   
        $('#plantel_f-field').change(function(){
            getCmbLectivos();
            getCmbGrupo();
        }); 
    });

    function getCmbLectivos(){
        //var $example = $("#especialidad_id-field").select2();
        
            $.ajax({
                url: '{{ route("lectivos.lectivosPorPlantel") }}',
                type: 'GET',
                data: {
                    'lectivo_id':$('#lectivo_f-field option:selected').val(),
                    'plantel_id':$('#plantel_f-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(data){
                    //$example.select2("destroy");
                    $('#lectivo_f-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#ectivo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#lectivo_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    });
                    //$example.select2();
                }
            });       
    }

    function getCmbEspecialidad(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_grados').serialize();
            $.ajax({
                url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: {
                    'especialidad_id':$('#plantel_f-field option:selected').val(),
                    'plantel_id':$('#especialidad_f-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
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

    function getCmbGrupo(){
        //var $example = $("#especialidad_id-field").select2();
        
            $.ajax({
                url: '{{ route("grupos.getCmbGrupo") }}',
                type: 'GET',
                data: {
                    'grupo_id':$('#grupo_f-field option:selected').val(),
                    'plantel_id':$('#plantel_f-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(data){
                    //$example.select2("destroy");
                    $('#grupo_f-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#grupo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#grupo_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    });
                    //$example.select2();
                }
            });       
    }
    
    </script>
@endpush