                <div class="form-group @if($errors->has('plan_pago_ln_id')) has-error @endif">
                       <label for="plan_pago_ln_id-field">Plan_pago_ln_monto</label>
                       {!! Form::select("plan_pago_ln_id", $list["PlanPagoLn"], null, array("class" => "form-control", "id" => "plan_pago_ln_id-field")) !!}
                       @if($errors->has("plan_pago_ln_id"))
                        <span class="help-block">{{ $errors->first("plan_pago_ln_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_inicio')) has-error @endif">
                       <label for="fec_inicio-field">Fec_inicio</label>
                       {!! Form::text("fec_inicio", null, array("class" => "form-control", "id" => "fec_inicio-field")) !!}
                       @if($errors->has("fec_inicio"))
                        <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_fin')) has-error @endif">
                       <label for="fec_fin-field">Fec_fin</label>
                       {!! Form::text("fec_fin", null, array("class" => "form-control", "id" => "fec_fin-field")) !!}
                       @if($errors->has("fec_fin"))
                        <span class="help-block">{{ $errors->first("fec_fin") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descuento')) has-error @endif">
                       <label for="descuento-field">Descuento</label>
                       {!! Form::text("descuento", null, array("class" => "form-control", "id" => "descuento-field")) !!}
                       @if($errors->has("descuento"))
                        <span class="help-block">{{ $errors->first("descuento") }}</span>
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