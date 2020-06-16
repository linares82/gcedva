                <div class="form-group @if($errors->has('mp_account')) has-error @endif">
                       <label for="mp_account-field">Mp_account</label>
                       {!! Form::text("mp_account", null, array("class" => "form-control", "id" => "mp_account-field")) !!}
                       @if($errors->has("mp_account"))
                        <span class="help-block">{{ $errors->first("mp_account") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_product')) has-error @endif">
                       <label for="mp_product-field">Mp_product</label>
                       {!! Form::text("mp_product", null, array("class" => "form-control", "id" => "mp_product-field")) !!}
                       @if($errors->has("mp_product"))
                        <span class="help-block">{{ $errors->first("mp_product") }}</span>
                       @endif
                    </div>
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
                    <div class="form-group @if($errors->has('mp_node')) has-error @endif">
                       <label for="mp_node-field">Mp_node</label>
                       {!! Form::text("mp_node", null, array("class" => "form-control", "id" => "mp_node-field")) !!}
                       @if($errors->has("mp_node"))
                        <span class="help-block">{{ $errors->first("mp_node") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_concept')) has-error @endif">
                       <label for="mp_concept-field">Mp_concept</label>
                       {!! Form::text("mp_concept", null, array("class" => "form-control", "id" => "mp_concept-field")) !!}
                       @if($errors->has("mp_concept"))
                        <span class="help-block">{{ $errors->first("mp_concept") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_amount')) has-error @endif">
                       <label for="mp_amount-field">Mp_amount</label>
                       {!! Form::text("mp_amount", null, array("class" => "form-control", "id" => "mp_amount-field")) !!}
                       @if($errors->has("mp_amount"))
                        <span class="help-block">{{ $errors->first("mp_amount") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_customername')) has-error @endif">
                       <label for="mp_customername-field">Mp_customername</label>
                       {!! Form::text("mp_customername", null, array("class" => "form-control", "id" => "mp_customername-field")) !!}
                       @if($errors->has("mp_customername"))
                        <span class="help-block">{{ $errors->first("mp_customername") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_currency')) has-error @endif">
                       <label for="mp_currency-field">Mp_currency</label>
                       {!! Form::text("mp_currency", null, array("class" => "form-control", "id" => "mp_currency-field")) !!}
                       @if($errors->has("mp_currency"))
                        <span class="help-block">{{ $errors->first("mp_currency") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_signature')) has-error @endif">
                       <label for="mp_signature-field">Mp_signature</label>
                       {!! Form::text("mp_signature", null, array("class" => "form-control", "id" => "mp_signature-field")) !!}
                       @if($errors->has("mp_signature"))
                        <span class="help-block">{{ $errors->first("mp_signature") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_urlsuccess')) has-error @endif">
                       <label for="mp_urlsuccess-field">Mp_urlsuccess</label>
                       {!! Form::text("mp_urlsuccess", null, array("class" => "form-control", "id" => "mp_urlsuccess-field")) !!}
                       @if($errors->has("mp_urlsuccess"))
                        <span class="help-block">{{ $errors->first("mp_urlsuccess") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_urlfailure')) has-error @endif">
                       <label for="mp_urlfailure-field">Mp_urlfailure</label>
                       {!! Form::text("mp_urlfailure", null, array("class" => "form-control", "id" => "mp_urlfailure-field")) !!}
                       @if($errors->has("mp_urlfailure"))
                        <span class="help-block">{{ $errors->first("mp_urlfailure") }}</span>
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