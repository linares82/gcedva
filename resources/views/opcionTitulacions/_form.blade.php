   <div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
      <label for="name-field">Name</label>
      {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name-field']) !!}
      @if ($errors->has('name'))
         <span class="help-block">{{ $errors->first('name') }}</span>
      @endif
   </div>
   <div class="form-group col-md-4 @if ($errors->has('costo')) has-error @endif">
      <label for="name-field">Costo</label>
      {!! Form::text('costo', null, ['class' => 'form-control', 'id' => 'costo-field']) !!}
      @if ($errors->has('costo'))
         <span class="help-block">{{ $errors->first('costo') }}</span>
      @endif
   </div>
   <div class="form-group col-md-4 @if ($errors->has('sep_modalidad_titulacion_id')) has-error @endif">
      <label for="sep_modalidad_titulacion_id-field">Sep Modalidad</label>
      {!! Form::select('sep_modalidad_titulacion_id', $sep_modalidads, null, [
         'class' => 'form-control select_seguridad',
         'id' => 'sep_modalidad_titulacion_id-field',
      ]) !!}
      @if ($errors->has('sep_modalidad_titulacion_id'))
         <span class="help-block">{{ $errors->first('sep_modalidad_titulacion_id') }}</span>
      @endif
   </div>
