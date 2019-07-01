                <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_id</label>
                       {!! Form::text("plantel_id", null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuenta_efectivo_id')) has-error @endif">
                       <label for="cuenta_efectivo_id-field">Cuenta_efectivo_id</label>
                       {!! Form::text("cuenta_efectivo_id", null, array("class" => "form-control", "id" => "cuenta_efectivo_id-field")) !!}
                       @if($errors->has("cuenta_efectivo_id"))
                        <span class="help-block">{{ $errors->first("cuenta_efectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('pago_id')) has-error @endif">
                       <label for="pago_id-field">Pago_id</label>
                       {!! Form::text("pago_id", null, array("class" => "form-control", "id" => "pago_id-field")) !!}
                       @if($errors->has("pago_id"))
                        <span class="help-block">{{ $errors->first("pago_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('egreso_id')) has-error @endif">
                       <label for="egreso_id-field">Egreso_id</label>
                       {!! Form::text("egreso_id", null, array("class" => "form-control", "id" => "egreso_id-field")) !!}
                       @if($errors->has("egreso_id"))
                        <span class="help-block">{{ $errors->first("egreso_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
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