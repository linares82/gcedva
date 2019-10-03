                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ubicacion')) has-error @endif">
                       <label for="ubicacion-field">Ubicacion</label>
                       {!! Form::text("ubicacion", null, array("class" => "form-control", "id" => "ubicacion-field")) !!}
                       @if($errors->has("ubicacion"))
                        <span class="help-block">{{ $errors->first("ubicacion") }}</span>
                       @endif
                    </div>
                    