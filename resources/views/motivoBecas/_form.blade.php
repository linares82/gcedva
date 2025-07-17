<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
   <label for="name-field">Name</label>
   {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
   @if($errors->has("name"))
   <span class="help-block">{{ $errors->first("name") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('bnd_solicitud_beca')) has-error @endif">
   <label for="bnd_solicitud_beca-field">Solicitud Beca</label>
   {!! Form::checkbox("bnd_solicitud_beca", 1, null, [ "id" => "bnd_solicitud_beca-field", 'class'=>'minimal']) !!}
   @if($errors->has("bnd_solicitud_beca"))
   <span class="help-block">{{ $errors->first("bnd_solicitud_beca") }}</span>
   @endif
</div>