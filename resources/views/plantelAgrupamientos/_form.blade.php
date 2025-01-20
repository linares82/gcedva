<div class="form-group col-md-6 @if($errors->has('name')) has-error @endif">
   <label for="name-field">Agrupamiento Plantel</label>
   {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
   @if($errors->has("name"))
   <span class="help-block">{{ $errors->first("name") }}</span>
   @endif
</div>
<div class="form-group col-md-6 @if($errors->has('plantel_id')) has-error @endif">
   <label for="plantel_id-field">Planteles</label>
   {!! Form::select("plantel_id[]", $planteles, isset($plantelAgrupamiento) ? optional($plantelAgrupamiento)->plantels : null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'multiple'=>true)) !!}
   @if($errors->has("plantel_id"))
      <span class="help-block">{{ $errors->first("plantel_id") }}</span>
   @endif
</div>
                    