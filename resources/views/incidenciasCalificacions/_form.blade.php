
<div class="form-group col-md-4 @if ($errors->has('calificacion_nueva')) has-error @endif">
   <label for="calificacion_nueva-field">Calificacion Nueva</label>
   {!! Form::hidden('calificacion_ponderacion_id', $calificacion_ponderacion_id, [
         'class' => 'form-control',
         'id' => 'calificacion_ponderacion_id-field',
   ]) !!}
   {!! Form::text('calificacion_nueva', null, ['class' => 'form-control', 'id' => 'calificacion_nueva-field']) !!}
   @if ($errors->has('calificacion_nueva'))
         <span class="help-block">{{ $errors->first('calificacion_nueva') }}</span>
   @endif
</div>
<div class="form-group col-md-8 @if ($errors->has('justificacion')) has-error @endif">
   <label for="justificacion-field">Justificacion</label>
   {!! Form::textArea('justificacion', null, [
         'class' => 'form-control',
         'id' => 'justificacion-field',
         'rows' => 3,
   ]) !!}
   @if ($errors->has('justificacion'))
         <span class="help-block">{{ $errors->first('justificacion') }}</span>
   @endif
</div>

   <input type="hidden" name="_token" id="_token" value="<?= csrf_token() ?>">
   <div class="form-group col-md-4">
      
         <div class="btn btn-default btn-file">
            <i class="fa fa-paperclip"></i> Adjuntar Evidencia
            <input type="file" id="file" name="file" class="email_archivo">
         </div>
         <p class="help-block">Max. 250Kb</p>
         <div id="texto_notificacion">
            @if(isset($incidenciasCalificacion->imagen))
            <img src="{{ asset('storage/grados/' . $incidenciasCalificacion->imagen) }}" alt="Logo" height="42"
               width="42">
            @endif
         </div>
   </div>

<div class="form-group col-md-8 @if ($errors->has('observacion')) has-error @endif">
   <label for="observacion-field">Observacion</label>
   {!! Form::textArea('observacion', null, ['class' => 'form-control', 'id' => 'observacion-field', 'rows' => 3]) !!}
   @if ($errors->has('observacion'))
         <span class="help-block">{{ $errors->first('observacion') }}</span>
   @endif
</div>
@push('scripts')
   <script>
         $(document).ready(function() {
            
         });
   </script>
@endpush
