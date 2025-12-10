<div class="form-group col-md-4 @if($errors->has('nivel')) has-error @endif">
   <label for="nivel-field">Nivel</label>
   {!! Form::number("nivel", null, array("class" => "form-control", "id" => "nivel-field")) !!}
   @if($errors->has("nivel"))
   <span class="help-block">{{ $errors->first("nivel") }}</span>
   @endif
</div>
      
<div class="form-group col-md-4 @if($errors->has('orden')) has-error @endif">
   <label for="orden-field">Orden</label>
   {!! Form::number("orden", null, array("class" => "form-control", "id" => "orden-field")) !!}
   @if($errors->has("orden"))
   <span class="help-block">{{ $errors->first("orden") }}</span>
   @endif
</div>

<div class="form-group col-md-3 @if($errors->has('bnd_agrupador')) has-error @endif">
   <label for="bnd_agrupador-field">Agrupador</label>
   {!! Form::checkbox("bnd_agrupador", 1, null, [ "id" => "bnd_agrupador-field", 'class'=>'minimal']) !!}
   @if($errors->has("bnd_agrupador"))
   <span class="help-block">{{ $errors->first("bnd_agrupador") }}</span>
   @endif
</div>

<div class="form-group col-md-3 @if($errors->has('bnd_final')) has-error @endif">
   <label for="bnd_final-field">Final</label>
   {!! Form::checkbox("bnd_final", 1, null, [ "id" => "bnd_final-field", 'class'=>'minimal']) !!}
   @if($errors->has("bnd_final"))
   <span class="help-block">{{ $errors->first("bnd_final") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('padre')) has-error @endif">
   <label for="padre-field">Padre</label>
   {!! Form::select("padre", $padres, null, array("class" => "form-control select_seguridad", "id" => "padre-field")) !!}
   @if($errors->has("padre"))
   <span class="help-block">{{ $errors->first("padre") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
   <label for="name-field">Nombre</label>
   {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
   @if($errors->has("name"))
   <span class="help-block">{{ $errors->first("name") }}</span>
   @endif
</div>
                    