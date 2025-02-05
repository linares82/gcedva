<div class="form-group col-md-6 @if($errors->has('name')) has-error @endif">
<label for="name-field">Materia</label>
{!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
@if($errors->has("name"))
<span class="help-block">{{ $errors->first("name") }}</span>
@endif
</div>
<div class="form-group col-md-6 @if($errors->has('plantel_id')) has-error @endif" >
<label for="plantel_id-field">Plantel</label>
{!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
<div id="loading" style="visible:none;">Cargando Materias...</div>
@if($errors->has("plantel_id"))
<span class="help-block">{{ $errors->first("plantel_id") }}</span>
@endif
</div>
<div class="form-group col-md-6 @if($errors->has('cantidad_materias_para_aprobar')) has-error @endif" style="clear:left">
   <label for="cantidad_materias_para_aprobar-field">Cantidad Materias Para Aprobar</label>
   {!! Form::text("cantidad_materias_para_aprobar", null, array("class" => "form-control", "id" => "cantidad_materias_para_aprobar-field")) !!}
   @if($errors->has("cantidad_materias_para_aprobar"))
   <span class="help-block">{{ $errors->first("cantidad_materias_para_aprobar") }}</span>
   @endif
</div>
<div class="form-group col-md-6 @if($errors->has('materia_id')) has-error @endif">
<label for="materia_id-field">Materia</label>
{!! Form::select("materia_id[]", array(), isset($sepMaterium) ? optional($sepMaterium)->materias : null, array("class" => "form-control select_seguridad", "id" => "materia_id-field", 'multiple'=>true)) !!}

@if($errors->has("materia_id"))
<span class="help-block">{{ $errors->first("materia_id") }}</span>
@endif
</div>



@push('scripts')
<script type="text/javascript">
   
$(document).ready(function() {
   
   if($('#plantel_id-field').val()!=0){
      getMaterias();
   }
   

   $('#plantel_id-field').change(function(){
      getMaterias();
   });
   
});


   function getMaterias(){
//var $example = $("#especialidad_id-field").select2();
   
materias=[];
@if(isset($sepMaterium))
materias={{$sepMaterium->materias->pluck('id')}};
@endif
   //console.log($id_seleccionados);
$.ajax({
   url: '{{ route("materias.materiasXPlantel") }}',
   type: 'GET',
   data: {
      'plantel_id':$('#plantel_id-field option:selected').val(),
      'materias':materias
   },
   dataType: 'json',
   beforeSend : function(){$("#loading").show(); },
   complete : function(){$("#loading").hide(); },
   success: function(data){
      $('#materia_id-field').empty();
      $('#materia_id-field').append($('<option></option>').text('Seleccionar').val('0'));
      $.each(data, function(i) {
      //alert(data[i].selectec);
      $('#materia_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
      });
      $('#materia_id-field').change();
   }
});
}

</script>
@endpush