<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
      <label for="name-field">Identificador</label>
      {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
      @if($errors->has("name"))
      <span class="help-block">{{ $errors->first("name") }}</span>
      @endif
   </div>

   <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
   <label for="plantel_id-field">Plantel</label>
   {!! Form::select("plantel_id", $list['Plantel'], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
   <div id="loading" style="visible:none;">Cargando Grupos...</div>
   @if(isset($formatoDgcft))
         @if($formatoDgcft->plantel_id==0)
         <code>*Campo requerido, seleccionar opcion</code>
         @endif
      @endif
   @if($errors->has("plantel_id"))
   <span class="help-block">{{ $errors->first("plantel_id") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('inicio_matricula')) has-error @endif">
   <label for="inicio_matricula-field">Inicio Matricula (mmaa, separados por "," y sin espacios)</label>
   {!! Form::text("inicio_matricula", null, array("class" => "form-control", "id" => "inicio_matricula-field")) !!}
   @if($errors->has("inicio_matricula"))
      <span class="help-block">{{ $errors->first("inicio_matricula") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('sep_grupo_id')) has-error @endif">
   <label for="sep_grupo_id-field">Grupo Sep</label>
   {!! Form::select("sep_grupo_id", $list['SepGrupo'], null, array("class" => "form-control select_seguridad", "id" => "sep_grupo_id-field")) !!}
   @if(isset($formatoDgcft))
         @if($formatoDgcft->plantel_id==0)
         <code>*Campo requerido, seleccionar opcion</code>
         @endif
      @endif
   @if($errors->has("sep_grupo_id"))
   <span class="help-block">{{ $errors->first("sep_grupo_id") }}</span>
   @endif
</div>
   <!--
<div class="form-group col-md-4 @if($errors->has('enlace_operativo')) has-error @endif">
   <label for="enlace_operativo-field">Enlace Operativo</label>
   {!! Form::text("enlace_operativo", null, array("class" => "form-control", "id" => "enlace_operativo-field")) !!}
   @if($errors->has("enlace_operativo"))
      <span class="help-block">{{ $errors->first("enlace_operativo") }}</span>
   @endif
</div>-->
<div class="form-group col-md-4 @if($errors->has('control_parte_fija')) has-error @endif">
      <label for="control_parte_fija-field">Parte Fija Control</label>
      {!! Form::text("control_parte_fija", null, array("class" => "form-control", "id" => "control_parte_fija-field")) !!}
      @if($errors->has("control_parte_fija"))
      <span class="help-block">{{ $errors->first("control_parte_fija") }}</span>
      @endif
   </div>
   <div class="form-group col-md-4 @if($errors->has('control_inicio')) has-error @endif">
      <label for="control_inicio-field">Inicio Control</label>
      {!! Form::text("control_inicio", null, array("class" => "form-control", "id" => "control_inicio-field")) !!}
      @if($errors->has("control_inicio"))
      <span class="help-block">{{ $errors->first("control_inicio") }}</span>
      @endif
   </div>
<!--
<div class="form-group col-md-4 @if($errors->has('directora_nombre')) has-error @endif">
   <label for="directora_nombre-field">Director</label>
   {!! Form::text("directora_nombre", null, array("class" => "form-control", "id" => "directora_nombre-field")) !!}
   @if($errors->has("directora_nombre"))
      <span class="help-block">{{ $errors->first("directora_nombre") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('sceo_nombre')) has-error @endif">
   <label for="sceo_nombre-field">SCEO</label>
   {!! Form::text("sceo_nombre", null, array("class" => "form-control", "id" => "sceo_nombre-field")) !!}
   @if($errors->has("sceo_nombre"))
      <span class="help-block">{{ $errors->first("sceo_nombre") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('cct')) has-error @endif">
   <label for="cct-field">CCT</label>
   {!! Form::text("cct", null, array("class" => "form-control", "id" => "cct-field")) !!}
   @if($errors->has("cct"))
      <span class="help-block">{{ $errors->first("cct") }}</span>
   @endif
</div>
-->  
<!--
<div class="form-group col-md-5 @if($errors->has('plantel')) has-error @endif">
   <label for="plantel-field">Plantel</label>
   {!! Form::text("plantel", null, array("class" => "form-control", "id" => "plantel-field")) !!}
   @if($errors->has("plantel"))
      <span class="help-block">{{ $errors->first("plantel") }}</span>
   @endif
</div>-->  

<!--
<div class="form-group col-md-6 @if($errors->has('direccion')) has-error @endif">
   <label for="direccion-field">Direccion</label>
   {!! Form::text("direccion", null, array("class" => "form-control", "id" => "direccion-field")) !!}
   @if($errors->has("direccion"))
      <span class="help-block">{{ $errors->first("direccion") }}</span>
   @endif
</div>
-->  
<div class="form-group col-md-3 @if($errors->has('especialidad')) has-error @endif">
   <label for="especialidad-field">Especialidad</label>
   {!! Form::text("especialidad", null, array("class" => "form-control", "id" => "especialidad-field")) !!}
   @if($errors->has("especialidad"))
      <span class="help-block">{{ $errors->first("especialidad") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('grupo')) has-error @endif">
   <label for="grupo-field">Grupo</label>
   {!! Form::text("grupo", null, array("class" => "form-control", "id" => "grupo-field")) !!}
   @if($errors->has("grupo"))
      <span class="help-block">{{ $errors->first("grupo") }}</span>
   @endif
</div> 

<div class="form-group col-md-3 @if($errors->has('fec_elaboracion')) has-error @endif">
   <label for="fec_elaboracion-field">F. Elaboracion</label>
   {!! Form::text("fec_elaboracion", null, array("class" => "form-control fecha", "id" => "fec_elaboracion-field")) !!}
   @if($errors->has("fec_elaboracion"))
      <span class="help-block">{{ $errors->first("fec_elaboracion") }}</span>
   @endif
</div>

<div class="form-group col-md-3 @if($errors->has('fec_inicio')) has-error @endif">
   <label for="fec_inicio-field">F. Inicio</label>
   {!! Form::text("fec_inicio", null, array("class" => "form-control fecha", "id" => "fec_inicio-field")) !!}
   @if($errors->has("fec_inicio"))
      <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
   @endif
</div> 
<div class="form-group col-md-3 @if($errors->has('duracion')) has-error @endif">
   <label for="duracion-field">Duracion Horas</label>
   {!! Form::text("duracion", null, array("class" => "form-control", "id" => "duracion-field", "onblur"=>"calculaFechaFin()")) !!}
   @if($errors->has("duracion"))
      <span class="help-block">{{ $errors->first("duracion") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('fec_fin')) has-error @endif">
   <label for="fec_fin-field">F. Fin</label>
   {!! Form::text("fec_fin", null, array("class" => "form-control fecha", "id" => "fec_fin-field")) !!}
   @if($errors->has("fec_fin"))
      <span class="help-block">{{ $errors->first("fec_fin") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('ciclo_escolar')) has-error @endif">
   <label for="ciclo_escolar-field">Ciclo Escolar</label>
   {!! Form::text("ciclo_escolar", null, array("class" => "form-control", "id" => "ciclo_escolar-field")) !!}
   @if($errors->has("ciclo_escolar"))
      <span class="help-block">{{ $errors->first("ciclo_escolar") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('fec_edad')) has-error @endif">
   <label for="fec_edad-field">F. Referencia Edad</label>
   {!! Form::text("fec_edad", null, array("class" => "form-control fecha", "id" => "fec_edad-field")) !!}
   @if($errors->has("fec_edad"))
      <span class="help-block">{{ $errors->first("fec_edad") }}</span>
   @endif
</div> 



<div class="form-group col-md-3 @if($errors->has('horario')) has-error @endif">
   <label for="horario-field">Horario</label>
   {!! Form::text("horario", null, array("class" => "form-control", "id" => "horario-field")) !!}
   @if($errors->has("horario"))
      <span class="help-block">{{ $errors->first("horario_inicio") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('horario_inicio')) has-error @endif">
   <label for="horario_inicio-field">Horario Inicio</label>
   {!! Form::text("horario_inicio", null, array("class" => "form-control", "id" => "horario_inicio-field")) !!}
   @if($errors->has("horario_inicio"))
      <span class="help-block">{{ $errors->first("horario_inicio") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('horario_fin')) has-error @endif">
   <label for="horario_fin-field">Horario Fin</label>
   {!! Form::text("horario_fin", null, array("class" => "form-control", "id" => "horario_fin-field")) !!}
   @if($errors->has("horario_fin"))
      <span class="help-block">{{ $errors->first("horario_fin") }}</span>
   @endif
</div> 

<!--
<div class="form-group col-md-3 @if($errors->has('cantidad_clientes')) has-error @endif">
   <label for="cantidad_clientes-field">Cantidad Clientes</label>
   {!! Form::text("cantidad_clientes", null, array("class" => "form-control", "id" => "cantidad_clientes-field")) !!}
   @if($errors->has("cantidad_clientes"))
      <span class="help-block">{{ $errors->first("cantidad_clientes") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('clientes')) has-error @endif">
   <label for="clientes-field">Clientes(separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->clientes))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("clientes", null, array("class" => "form-control", "id" => "clientes-field", 'rows'=>3)) !!}
   
   @if($errors->has("clientes"))
      <span class="help-block">{{ $errors->first("clientes") }}</span>
   @endif
</div>
-->
<!-- 
<div class="form-group col-md-4 @if($errors->has('control')) has-error @endif">
   <label for="control-field">No. Control (separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->control))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("control", null, array("class" => "form-control", "id" => "control-field", 'rows'=>3)) !!}
   @if($errors->has("control"))
      <span class="help-block">{{ $errors->first("control") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('escolaridad')) has-error @endif">
   <label for="escolaridad-field">Escolaridad (separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->escolaridad))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("escolaridad", null, array("class" => "form-control", "id" => "escolaridad-field", 'rows'=>3)) !!}
   @if($errors->has("escolaridad"))
      <span class="help-block">{{ $errors->first("escolaridad") }}</span>
   @endif
</div>
--> 
<!--
<div class="form-group col-md-4 @if($errors->has('beca')) has-error @endif">
   <label for="beca-field">Beca (separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->beca))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("beca", null, array("class" => "form-control", "id" => "beca-field", 'rows'=>3)) !!}
   @if($errors->has("beca"))
      <span class="help-block">{{ $errors->first("beca") }}</span>
   @endif
</div>
-->
<!--
<div class="form-group col-md-4 @if($errors->has('materias')) has-error @endif">
   <label for="materias-field">Materias(separados por ",")
   </label>
   {!! Form::textArea("materias", null, array("class" => "form-control", "id" => "materias-field", 'rows'=>3)) !!}
   @if($errors->has("materias"))
      <span class="help-block">{{ $errors->first("materias") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('grados')) has-error @endif">
   <label for="grados-field">Grados(separados por ",")
   </label>
   {!! Form::textArea("grados", null, array("class" => "form-control", "id" => "grados-field", 'rows'=>3)) !!}
   @if($errors->has("grados"))
      <span class="help-block">{{ $errors->first("grados") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('duracion_materias')) has-error @endif">
   <label for="duracion_materias-field">Duracion Horas por Materia(separados por ",")</label>
   {!! Form::textArea("duracion_materias", null, array("class" => "form-control", "id" => "duracion_materias-field", 'rows'=>3)) !!}
   @if($errors->has("duracion_materias"))
      <span class="help-block">{{ $errors->first("duracion_materias") }}</span>
   @endif
</div>
-->
<div class="form-group col-md-4 @if($errors->has('fechas_emision')) has-error @endif">
   <label for="fechas_emision-field">Fechas Emision(separados por ",")</label>
   {!! Form::textArea("fechas_emision", null, array("class" => "form-control", "id" => "fechas_emision-field", 'rows'=>3)) !!}
   
   @if($errors->has("fechas_emision"))
      <span class="help-block">{{ $errors->first("fechas_emision") }}</span>
   @endif
</div>
<!--
<div class="form-group col-md-4 @if($errors->has('calificaciones')) has-error @endif">
   <label for="calificaciones-field">Calificaciones(Series separadas por "-" y calificaciones separadas por ",")
   @if(isset($formatoDgcft))
         @php
            $calificacionesXmateria=explode('-',$formatoDgcft->calificaciones);
            //dd($calificacionesXmateria);
            $serie_contador=1;
            foreach($calificacionesXmateria as $serie){
               $contador_calificacion=0;
               $calificaciones=explode(',',$serie);
               foreach($calificaciones as $calificacion){
                  $contador_calificacion++;
               }
               //dd($contador_calificacion);
               if($contador_calificacion<>$formatoDgcft->cantidad_clientes){
                echo "<code>  *Cantidad de datos, diferente de Candidad Clientes y Materias</code>";
               }
               $serie_contador++;
            }
         @endphp
      @endif
   </label>
   {!! Form::textArea("calificaciones", null, array("class" => "form-control", "id" => "calificaciones-field", 'rows'=>3)) !!}
   @if($errors->has("calificaciones"))
      <span class="help-block">{{ $errors->first("calificaciones") }}</span>
   @endif
</div>
--> 
<!--
<div class="form-group col-md-4 @if($errors->has('resultados')) has-error @endif">
   <label for="resultados-field">Resultados(separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->resultados))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("resultados", null, array("class" => "form-control", "id" => "resultados-field", 'rows'=>3)) !!}
   @if($errors->has("resultados"))
      <span class="help-block">{{ $errors->first("resultados") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('final')) has-error @endif">
   <label for="final-field">Final(separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->final))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("final", null, array("class" => "form-control", "id" => "final-field", 'rows'=>3)) !!}
   @if($errors->has("final"))
      <span class="help-block">{{ $errors->first("final") }}</span>
   @endif
</div>
         --> 


@push('scripts')
<script src="
https://cdn.jsdelivr.net/npm/dayjs@1.11.13/dayjs.min.js
"></script>
<script type="text/javascript">
   
$(document).ready(function() {

   if($('#plantel_id-field').val()!=0){
      getGrupos();
   }
   

   $('#plantel_id-field').change(function(){
      getGrupos();
   });
   
});

function calculaFechaFin(){
      cantidad_semanas=$('#duracion-field').val()/25;
      //console.log(cantidad_semanas);
      //console.log($('#fec_inicio-field').val());
      ff=dayjs($('#fec_inicio-field').val()).add(cantidad_semanas, 'week').format('YYYY-MM-DD').toString();
      //console.log(ff);
      $('#fec_fin-field').val(ff);
   }

   function getGrupos(){
//var $example = $("#especialidad_id-field").select2();
   


   //console.log($id_seleccionados);
$.ajax({
   url: '{{ route("sepGrupos.gruposXPlantel") }}',
   type: 'GET',
   data: {
      'plantel_id':$('#plantel_id-field option:selected').val(),
      'grupo':$('#sep_grupo_id-field option:selected').val(),
   },
   dataType: 'json',
   beforeSend : function(){$("#loading").show(); },
   complete : function(){$("#loading").hide(); },
   success: function(data){
      $('#sep_grupo_id-field').empty();
      $('#sep_grupo_id-field').append($('<option></option>').text('Seleccionar').val('0'));
      $.each(data, function(i) {
      //alert(data[i].selectec);
      $('#sep_grupo_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
      });
      $('#sep_grupo_id-field').change();
   }
});
}

</script>
@endpush            