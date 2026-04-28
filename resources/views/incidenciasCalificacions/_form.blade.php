
<div class="form-group col-md-4 @if ($errors->has('calificacion_nueva')) has-error @endif">
   <label for="calificacion_nueva-field">Calificacion Nueva</label>
   {!! Form::hidden('calificacion_ponderacion_id', $calificacion_ponderacion_id, [
         'class' => 'form-control',
         'id' => 'calificacion_ponderacion_id-field',
   ]) !!}
   {!! Form::hidden('tpo_examen_id', $tpo_examen_id, [
         'class' => 'form-control',
         'id' => 'tpo_examen_id-field',
   ]) !!}
   {!! Form::text('calificacion_nueva', null, ['class' => 'form-control', 'id' => 'calificacion_nueva-field']) !!}
   @if ($errors->has('calificacion_nueva'))
         <span class="help-block">{{ $errors->first('calificacion_nueva') }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('incidencias_justificacion_id')) has-error @endif">
      <label for="incidencias_justificacion_id-field">Justificacion</label>
      {!! Form::select("incidencias_justificacion_id", $justificacion, null, array("class" => "form-control select_seguridad", "id" => "incidencias_justificacion_id-field")) !!}
      @if($errors->has("incidencias_justificacion_id"))
      <span class="help-block">{{ $errors->first("incidencias_justificacion_id") }}</span>
      @endif
</div>


   <input type="hidden" name="_token" id="_token" value="<?= csrf_token() ?>">
   @if($tpo_examen_id == 2)
   <div class="form-group col-md-4" >
      
         <div class="btn btn-default btn-file">
            <i class="fa fa-paperclip"></i> Adjuntar Evidencia
             {!! Form::file('imagen') !!}
         </div>
         <p class="help-block">Max. 250Kb</p>
         <div id="texto_notificacion">
            @if(isset($incidenciasCalificacion->imagen))
            <img src="{{ asset('storage/incidencias_calificacions/' . $incidenciasCalificacion->imagen) }}" alt="Logo" height="42"
               width="42">
            @endif
         </div>
   </div>
   @endif

   @permission('incidenciasCalificacions.observacion')
<div class="form-group col-md-8 @if ($errors->has('observacion')) has-error @endif">
   <label for="observacion-field">Observacion</label>
   {!! Form::textArea('observacion', null, ['class' => 'form-control', 'id' => 'observacion-field', 'rows' => 3]) !!}
   @if ($errors->has('observacion'))
         <span class="help-block">{{ $errors->first('observacion') }}</span>
   @endif
</div>
@endpermission
@push('scripts')
   <script>
         $(document).ready(function() {
            
         });
   </script>
@endpush
