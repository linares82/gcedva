                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_nombre</label>
                       {!! Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_razon</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
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
                    <div class="form-group @if($errors->has('forma_pago_id')) has-error @endif">
                       <label for="forma_pago_id-field">Forma_pago_name</label>
                       {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control", "id" => "forma_pago_id-field")) !!}
                       @if($errors->has("forma_pago_id"))
                        <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('autorizacion_descuento')) has-error @endif">
                       <label for="autorizacion_descuento-field">Autorizacion_descuento</label>
                       {!! Form::text("autorizacion_descuento", null, array("class" => "form-control", "id" => "autorizacion_descuento-field")) !!}
                       @if($errors->has("autorizacion_descuento"))
                        <span class="help-block">{{ $errors->first("autorizacion_descuento") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
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