                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_nombre</label>
                       {!! Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('concepto_cobro_id')) has-error @endif">
                       <label for="concepto_cobro_id-field">Concepto_cobro_id</label>
                       {!! Form::text("concepto_cobro_id", null, array("class" => "form-control", "id" => "concepto_cobro_id-field")) !!}
                       @if($errors->has("concepto_cobro_id"))
                        <span class="help-block">{{ $errors->first("concepto_cobro_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuenta_contable_id')) has-error @endif">
                       <label for="cuenta_contable_id-field">Cuenta_contable_name</label>
                       {!! Form::select("cuenta_contable_id", $list["CuentaContable"], null, array("class" => "form-control", "id" => "cuenta_contable_id-field")) !!}
                       @if($errors->has("cuenta_contable_id"))
                        <span class="help-block">{{ $errors->first("cuenta_contable_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuenta_recargo_id')) has-error @endif">
                       <label for="cuenta_recargo_id-field">Cuenta_recargo_id</label>
                       {!! Form::text("cuenta_recargo_id", null, array("class" => "form-control", "id" => "cuenta_recargo_id-field")) !!}
                       @if($errors->has("cuenta_recargo_id"))
                        <span class="help-block">{{ $errors->first("cuenta_recargo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_pago')) has-error @endif">
                       <label for="fecha_pago-field">Fecha_pago</label>
                       {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-field")) !!}
                       @if($errors->has("fecha_pago"))
                        <span class="help-block">{{ $errors->first("fecha_pago") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('inicial_bnd')) has-error @endif">
                       <label for="inicial_bnd-field">Inicial_bnd</label>
                       {!! Form::text("inicial_bnd", null, array("class" => "form-control", "id" => "inicial_bnd-field")) !!}
                       @if($errors->has("inicial_bnd"))
                        <span class="help-block">{{ $errors->first("inicial_bnd") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plan_pago_ln_id')) has-error @endif">
                       <label for="plan_pago_ln_id-field">Plan_pago_ln_fecha_pago</label>
                       {!! Form::select("plan_pago_ln_id", $list["PlanPagoLn"], null, array("class" => "form-control", "id" => "plan_pago_ln_id-field")) !!}
                       @if($errors->has("plan_pago_ln_id"))
                        <span class="help-block">{{ $errors->first("plan_pago_ln_id") }}</span>
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