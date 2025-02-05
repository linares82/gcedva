<div class="col-md-12">
   <div class="box box-primary">
      
      <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
         <label for="name-field">Grupo</label>
         {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
         @if($errors->has("name"))
         <span class="help-block">{{ $errors->first("name") }}</span>
         @endif
      </div>
      <div class="form-group col-md-4 @if($errors->has('secciones')) has-error @endif">
         <label for="secciones-field">Secciones(valores separados por "," y sin espacios)</label>
         {!! Form::text("secciones", null, array("class" => "form-control", "id" => "secciones-field")) !!}
         @if($errors->has("secciones"))
         <span class="help-block">{{ $errors->first("secciones") }}</span>
         @endif
      </div>
      <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
         <label for="plantel_id-field">Plantel</label>
         {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
         <div id="loading" style="visible:none;">Cargando Materias Sep...</div>
         @if($errors->has("plantel_id"))
         <span class="help-block">{{ $errors->first("plantel_id") }}</span>
         @endif
      </div>
   </div>

</div>
@if(isset($sepGrupo))
<div class="col-md-12">
   <div class="box box-primary">
      <div class="box-header with-border">
         <h3 class="box-title">Definir Materia Sep</h3>
      </div>

      <div class="form-group col-md-6 @if($errors->has('sep_materia_id')) has-error @endif" style="clear:left;">
         <label for="sep_materia_id-field">Materia Sep</label>
         {!! Form::select("sep_materia_id", $sepMaterias, null, array("class" => "form-control select_seguridad", "id" => "sep_materia_id-field")) !!}
         @if($errors->has("sep_materia_id"))
         <span class="help-block">{{ $errors->first("sep_materia_id") }}</span>
         @endif
      </div>
      <div class="form-group col-md-2 @if($errors->has('grado')) has-error @endif">
         <label for="grado-field">Grado</label>
         {!! Form::text("grado", null, array("class" => "form-control", "id" => "grado-field")) !!}
         @if($errors->has("grado"))
         <span class="help-block">{{ $errors->first("grado") }}</span>
         @endif
      </div>
      <div class="form-group col-md-2 @if($errors->has('duracion_horas')) has-error @endif">
         <label for="duracion_horas-field">Duracion Horas</label>
         {!! Form::text("duracion_horas", null, array("class" => "form-control", "id" => "duracion_horas-field")) !!}
         @if($errors->has("duracion_horas"))
         <span class="help-block">{{ $errors->first("duracion_horas") }}</span>
         @endif
      </div>
      <div class="form-group col-md-2 @if($errors->has('acuerdo')) has-error @endif">
         <label for="acuerdo-field">Acuerdo</label>
         {!! Form::text("acuerdo", null, array("class" => "form-control", "id" => "acuerdo-field")) !!}
         @if($errors->has("acuerdo"))
         <span class="help-block">{{ $errors->first("acuerdo") }}</span>
         @endif
      </div>
   </div>
</div>
@endif

@push('scripts')
<script type="text/javascript">
   
$(document).ready(function() {
   
   if($('#plantel_id-field').val()!=0){
      getMateriasSep();
   }
   

   $('#plantel_id-field').change(function(){
      getMateriasSep();
   });
   
});


   function getMateriasSep(){
//var $example = $("#especialidad_id-field").select2();
   


   //console.log($id_seleccionados);
$.ajax({
   url: '{{ route("sepMaterias.materias_sepXPlantel") }}',
   type: 'GET',
   data: {
      'plantel_id':$('#plantel_id-field option:selected').val(),
   },
   dataType: 'json',
   beforeSend : function(){$("#loading").show(); },
   complete : function(){$("#loading").hide(); },
   success: function(data){
      $('#sep_materia_id-field').empty();
      $('#sep_materia_id-field').append($('<option></option>').text('Seleccionar').val('0'));
      $.each(data, function(i) {
      //alert(data[i].selectec);
      $('#sep_materia_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
      });
      $('#sep_materia_id-field').change();
   }
});
}

</script>
@endpush            