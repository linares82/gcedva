                <div class="form-group @if($errors->has('factura_g_id')) has-error @endif">
                       <label for="factura_g_id-field">Factura_g_id</label>
                       {!! Form::select("factura_g_id", $list["FacturaG"], null, array("class" => "form-control", "id" => "factura_g_id-field")) !!}
                       @if($errors->has("factura_g_id"))
                        <span class="help-block">{{ $errors->first("factura_g_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_operacion')) has-error @endif">
                       <label for="fecha_operacion-field">Fecha_operacion</label>
                       {!! Form::text("fecha_operacion", null, array("class" => "form-control", "id" => "fecha_operacion-field")) !!}
                       @if($errors->has("fecha_operacion"))
                        <span class="help-block">{{ $errors->first("fecha_operacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('concepto')) has-error @endif">
                       <label for="concepto-field">Concepto</label>
                       {!! Form::text("concepto", null, array("class" => "form-control", "id" => "concepto-field")) !!}
                       @if($errors->has("concepto"))
                        <span class="help-block">{{ $errors->first("concepto") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('referencia')) has-error @endif">
                       <label for="referencia-field">Referencia</label>
                       {!! Form::text("referencia", null, array("class" => "form-control", "id" => "referencia-field")) !!}
                       @if($errors->has("referencia"))
                        <span class="help-block">{{ $errors->first("referencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('referencia_ampliada')) has-error @endif">
                       <label for="referencia_ampliada-field">Referencia_ampliada</label>
                       {!! Form::text("referencia_ampliada", null, array("class" => "form-control", "id" => "referencia_ampliada-field")) !!}
                       @if($errors->has("referencia_ampliada"))
                        <span class="help-block">{{ $errors->first("referencia_ampliada") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cargo')) has-error @endif">
                       <label for="cargo-field">Cargo</label>
                       {!! Form::text("cargo", null, array("class" => "form-control", "id" => "cargo-field")) !!}
                       @if($errors->has("cargo"))
                        <span class="help-block">{{ $errors->first("cargo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('abono')) has-error @endif">
                       <label for="abono-field">Abono</label>
                       {!! Form::text("abono", null, array("class" => "form-control", "id" => "abono-field")) !!}
                       @if($errors->has("abono"))
                        <span class="help-block">{{ $errors->first("abono") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('saldo')) has-error @endif">
                       <label for="saldo-field">Saldo</label>
                       {!! Form::text("saldo", null, array("class" => "form-control", "id" => "saldo-field")) !!}
                       @if($errors->has("saldo"))
                        <span class="help-block">{{ $errors->first("saldo") }}</span>
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