                <div class="form-group @if($errors->has('openpay_id')) has-error @endif">
                       <label for="openpay_id-field">Openpay_id</label>
                       {!! Form::text("openpay_id", null, array("class" => "form-control", "id" => "openpay_id-field")) !!}
                       @if($errors->has("openpay_id"))
                        <span class="help-block">{{ $errors->first("openpay_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                       <label for="type-field">Type</label>
                       {!! Form::text("type", null, array("class" => "form-control", "id" => "type-field")) !!}
                       @if($errors->has("type"))
                        <span class="help-block">{{ $errors->first("type") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('verification_code')) has-error @endif">
                       <label for="verification_code-field">Verification_code</label>
                       {!! Form::text("verification_code", null, array("class" => "form-control", "id" => "verification_code-field")) !!}
                       @if($errors->has("verification_code"))
                        <span class="help-block">{{ $errors->first("verification_code") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('event_date')) has-error @endif">
                       <label for="event_date-field">Event_date</label>
                       {!! Form::text("event_date", null, array("class" => "form-control", "id" => "event_date-field")) !!}
                       @if($errors->has("event_date"))
                        <span class="help-block">{{ $errors->first("event_date") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>