                <div class="form-group @if($errors->has('mp_order')) has-error @endif">
                       <label for="mp_order-field">Mp_order</label>
                       {!! Form::text("mp_order", null, array("class" => "form-control", "id" => "mp_order-field")) !!}
                       @if($errors->has("mp_order"))
                        <span class="help-block">{{ $errors->first("mp_order") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_reference')) has-error @endif">
                       <label for="mp_reference-field">Mp_reference</label>
                       {!! Form::text("mp_reference", null, array("class" => "form-control", "id" => "mp_reference-field")) !!}
                       @if($errors->has("mp_reference"))
                        <span class="help-block">{{ $errors->first("mp_reference") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_amount')) has-error @endif">
                       <label for="mp_amount-field">Mp_amount</label>
                       {!! Form::text("mp_amount", null, array("class" => "form-control", "id" => "mp_amount-field")) !!}
                       @if($errors->has("mp_amount"))
                        <span class="help-block">{{ $errors->first("mp_amount") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_response')) has-error @endif">
                       <label for="mp_response-field">Mp_response</label>
                       {!! Form::text("mp_response", null, array("class" => "form-control", "id" => "mp_response-field")) !!}
                       @if($errors->has("mp_response"))
                        <span class="help-block">{{ $errors->first("mp_response") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_responsemsg')) has-error @endif">
                       <label for="mp_responsemsg-field">Mp_responsemsg</label>
                       {!! Form::text("mp_responsemsg", null, array("class" => "form-control", "id" => "mp_responsemsg-field")) !!}
                       @if($errors->has("mp_responsemsg"))
                        <span class="help-block">{{ $errors->first("mp_responsemsg") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_authorization')) has-error @endif">
                       <label for="mp_authorization-field">Mp_authorization</label>
                       {!! Form::text("mp_authorization", null, array("class" => "form-control", "id" => "mp_authorization-field")) !!}
                       @if($errors->has("mp_authorization"))
                        <span class="help-block">{{ $errors->first("mp_authorization") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_signature')) has-error @endif">
                       <label for="mp_signature-field">Mp_signature</label>
                       {!! Form::text("mp_signature", null, array("class" => "form-control", "id" => "mp_signature-field")) !!}
                       @if($errors->has("mp_signature"))
                        <span class="help-block">{{ $errors->first("mp_signature") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has(' usu_alta_id')) has-error @endif">
                       <label for=" usu_alta_id-field"> usu_alta_id</label>
                       {!! Form::text(" usu_alta_id", null, array("class" => "form-control", "id" => " usu_alta_id-field")) !!}
                       @if($errors->has(" usu_alta_id"))
                        <span class="help-block">{{ $errors->first(" usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>