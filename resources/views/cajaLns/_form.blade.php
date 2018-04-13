                <div class="form-group @if($errors->has('caja_id')) has-error @endif">
                       <label for="caja_id-field">Caja_cliente_id</label>
                       {!! Form::select("caja_id", $list["Caja"], null, array("class" => "form-control", "id" => "caja_id-field")) !!}
                       @if($errors->has("caja_id"))
                        <span class="help-block">{{ $errors->first("caja_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('concepto_id')) has-error @endif">
                       <label for="concepto_id-field">Concepto_id</label>
                       {!! Form::text("concepto_id", null, array("class" => "form-control", "id" => "concepto_id-field")) !!}
                       @if($errors->has("concepto_id"))
                        <span class="help-block">{{ $errors->first("concepto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('subtotal')) has-error @endif">
                       <label for="subtotal-field">Subtotal</label>
                       {!! Form::text("subtotal", null, array("class" => "form-control", "id" => "subtotal-field")) !!}
                       @if($errors->has("subtotal"))
                        <span class="help-block">{{ $errors->first("subtotal") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descuento')) has-error @endif">
                       <label for="descuento-field">Descuento</label>
                       {!! Form::text("descuento", null, array("class" => "form-control", "id" => "descuento-field")) !!}
                       @if($errors->has("descuento"))
                        <span class="help-block">{{ $errors->first("descuento") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('recargo')) has-error @endif">
                       <label for="recargo-field">Recargo</label>
                       {!! Form::text("recargo", null, array("class" => "form-control", "id" => "recargo-field")) !!}
                       @if($errors->has("recargo"))
                        <span class="help-block">{{ $errors->first("recargo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total')) has-error @endif">
                       <label for="total-field">Total</label>
                       {!! Form::text("total", null, array("class" => "form-control", "id" => "total-field")) !!}
                       @if($errors->has("total"))
                        <span class="help-block">{{ $errors->first("total") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('autorizacion_descuento')) has-error @endif">
                       <label for="autorizacion_descuento-field">Autorizacion_descuento</label>
                       {!! Form::text("autorizacion_descuento", null, array("class" => "form-control", "id" => "autorizacion_descuento-field")) !!}
                       @if($errors->has("autorizacion_descuento"))
                        <span class="help-block">{{ $errors->first("autorizacion_descuento") }}</span>
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