@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">Articulos</a></li>
	    <li class="active">Existencias</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i>Articulos / Existencias </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'muebles.resguardosR', 'id'=>'frm_reporte')) !!}
<!--
                
-->
                <div class="form-group col-md-4 @if($errors->has('empleado_id')) has-error @endif">
                       <label for="empleado_id-field">Responsable</label>
                       {!! Form::select("empleado_id", $empleados, null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}
                       @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                       @endif
                    </div>
                <!--
                <div class="form-group col-md-4 @if($errors->has('ubicacion_art_id')) has-error @endif">
                    <label for="ubicacion_art_id-field">Ubicacion</label>
                    {!! Form::select("ubicacion_art_id[]", array(), null, array("class" => "form-control select_seguridad", "id" => "ubicacion_art_id-field",'multiple'=>true)) !!}
                    @if($errors->has("ubicacion_art_id"))
                     <span class="help-block">{{ $errors->first("ubicacion_art_id") }}</span>
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
        @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        //$("#plantel_t-field").prop("disabled", true);
    @endpermission
   
    
      /*getUbicaciones();
      $('#plantel_f-field').change(function(){
         getUbicaciones();
         
      });*/
      
      $('#plantel_id-field').change(function(){
         //getEmpleados();
      });
    });

    function getEmpleados(){
      $.ajax({
                url: '{{ route("empleados.getEmpleadosXplantel") }}',
                type: 'GET',
                data: {
                   'empleado_id':$('#empleado_id-field option:selected').val(),
                   'plantel_id':$('#plantel_f-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(data){
                   
                      $('#empleado_id-field').html('');
                      $('#empleado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          $('#empleado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                      });
                      
                }
            });
   }

    function getUbicaciones(){
      $.ajax({
                url: '{{ route("ubicacionArts.getUbicacionesXPlantel") }}',
                type: 'GET',
                data: {
                   'plantel':$('#plantel_f-field option:selected').val(),
                   'ubicacion':$('#ubicacion_art_id-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(data){
                   console.log(data);
                      $('#ubicacion_art_id-field').html('');
                      
                      $('#ubicacion_art_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          $('#ubicacion_art_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      
                }
            });
   }
    
    </script>
@endpush