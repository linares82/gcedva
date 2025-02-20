@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('pagos.index') }}">@yield('pagosAppTitle')</a></li>
	    <li class="active">Pagos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('pagosAppTitle') / Pagos En Linea </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'planEstudios.egresadosTecnicaR', 'id'=>'frm_reporte')) !!}
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('plan_estudio_f')) has-error @endif">
                    <label for="plan_estudio_f-field">Plan Estudio:</label>
                    {!! Form::select("plan_estudio_f", array(), null, array("class" => "form-control select_seguridad", "id" => "plan_estudio_f-field")) !!}
                    @if($errors->has("plan_estudio_f"))
                    <span class="help-block">{{ $errors->first("plan_estudio_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('inicio_matricula')) has-error @endif">
                    <label for="inicio_matricula-field">Inicio Matricula (mmaa, separados por "," y sin espacios)</label>
                    {!! Form::text("inicio_matricula", null, array("class" => "form-control", "id" => "inicio_matricula-field")) !!}
                    @if($errors->has("inicio_matricula"))
                       <span class="help-block">{{ $errors->first("inicio_matricula") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-6 @if($errors->has('secciones')) has-error @endif">
                    <label for="secciones-field">Secciones (separados por "," y sin espacios)</label>
                    {!! Form::text("secciones", null, array("class" => "form-control", "id" => "secciones-field")) !!}
                    @if($errors->has("secciones"))
                       <span class="help-block">{{ $errors->first("secciones") }}</span>
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
    getPlanesEstudio();
   });
   
});


   function getPlanesEstudio(){
//var $example = $("#especialidad_id-field").select2();
   


   //console.log($id_seleccionados);
$.ajax({
   url: '{{ route("planEstudios.planesEstudioXPlantel") }}',
   type: 'GET',
   data: {
      'plantel_id':$('#plantel_f-field option:selected').val(),
   },
   dataType: 'json',
   beforeSend : function(){$("#loading").show(); },
   complete : function(){$("#loading").hide(); },
   success: function(data){
      $('#plan_estudio_f-field').empty();
      $('#plan_estudio_f-field').append($('<option></option>').text('Seleccionar').val('0'));
      $.each(data, function(i) {
      //alert(data[i].selectec);
      $('#plan_estudio_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
      });
      $('#plan_estudio_f-field').change();
   }
});
}

</script>
@endpush            
    
                     
                