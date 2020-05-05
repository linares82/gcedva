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

            {!! Form::open(array('route' => 'periodoEstudios.planEstudioR', 'id'=>'frm_reporte')) !!}

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
                    {!! Form::select("nivel_f", $list['Nivel'], null, array("class" => "form-control select_seguridad", "id" => "nivel_f-field")) !!}
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
            getCmbEspecialidad();
        }); 
        $('#especialidad_f-field').change(function(){
            getCmbNivel();
        });
       $('#nivel_f-field').change(function(){
            getCmbGrado();
        });
    });


    function getCmbEspecialidad(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_grados').serialize();
            $.ajax({
                url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: {
                    'plantel_id':$('#plantel_f-field option:selected').val(),
                    'especialidad_id':$('#especialidad_f-field option:selected').val()
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

    function getCmbNivel(){
                        //var $example = $("#especialidad_id-field").select2();
    //alert($('#especialidad_id-field option:selected').val());
    
    $.ajax({
    url: '{{ route("nivels.getCmbNivels") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "&nivel_id=" + $('#nivel_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend : function(){$("#loading11").show(); },
            complete : function(){$("#loading11").hide(); },
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

    function getCmbGrado(){
                        //var $example = $("#especialidad_id-field").select2();
    
    $.ajax({
    url: '{{ route("grados.getCmbGrados") }}',
            type: 'GET',
            data: "plantel_id=" + $('#plantel_f-field option:selected').val() + 
            "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + 
            "&nivel_id=" + $('#nivel_f-field option:selected').val() + 
            "&grado_f=" + $('#grado_f-field option:selected').val() + "",
            dataType: 'json',
            beforeSend : function(){$("#loading12").show(); },
            complete : function(){$("#loading12").hide(); },
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
                        
    
    
    </script>
@endpush