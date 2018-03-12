                <div class="form-group @if($errors->has('pagos_lectivo_id')) has-error @endif">
                       <label for="pagos_lectivo_id-field">Pagos_lectivo_id</label>
                       {!! Form::text("pagos_lectivo_id", null, array("class" => "form-control", "id" => "pagos_lectivo_id-field")) !!}
                       @if($errors->has("pagos_lectivo_id"))
                        <span class="help-block">{{ $errors->first("pagos_lectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('clave')) has-error @endif">
                       <label for="clave-field">Clave</label>
                       {!! Form::text("clave", null, array("class" => "form-control", "id" => "clave-field")) !!}
                       @if($errors->has("clave"))
                        <span class="help-block">{{ $errors->first("clave") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('concepto')) has-error @endif">
                       <label for="concepto-field">Concepto</label>
                       {!! Form::text("concepto", null, array("class" => "form-control", "id" => "concepto-field")) !!}
                       @if($errors->has("concepto"))
                        <span class="help-block">{{ $errors->first("concepto") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nombre_corto')) has-error @endif">
                       <label for="nombre_corto-field">Nombre_corto</label>
                       {!! Form::text("nombre_corto", null, array("class" => "form-control", "id" => "nombre_corto-field")) !!}
                       @if($errors->has("nombre_corto"))
                        <span class="help-block">{{ $errors->first("nombre_corto") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('monto_mase')) has-error @endif">
                       <label for="monto_mase-field">Monto_mase</label>
                       {!! Form::text("monto_mase", null, array("class" => "form-control", "id" => "monto_mase-field")) !!}
                       @if($errors->has("monto_mase"))
                        <span class="help-block">{{ $errors->first("monto_mase") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('seriacion_id')) has-error @endif">
                       <label for="seriacion_id-field">Seriacion_id</label>
                       {!! Form::text("seriacion_id", null, array("class" => "form-control", "id" => "seriacion_id-field")) !!}
                       @if($errors->has("seriacion_id"))
                        <span class="help-block">{{ $errors->first("seriacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuenta_contable_id')) has-error @endif">
                       <label for="cuenta_contable_id-field">Cuenta_contable_id</label>
                       {!! Form::text("cuenta_contable_id", null, array("class" => "form-control", "id" => "cuenta_contable_id-field")) !!}
                       @if($errors->has("cuenta_contable_id"))
                        <span class="help-block">{{ $errors->first("cuenta_contable_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_inicio')) has-error @endif">
                       <label for="fec_inicio-field">Fec_inicio</label>
                       {!! Form::text("fec_inicio", null, array("class" => "form-control", "id" => "fec_inicio-field")) !!}
                       @if($errors->has("fec_inicio"))
                        <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuenta_contable_recargo_id')) has-error @endif">
                       <label for="cuenta_contable_recargo_id-field">Cuenta_contable_recargo_id</label>
                       {!! Form::text("cuenta_contable_recargo_id", null, array("class" => "form-control", "id" => "cuenta_contable_recargo_id-field")) !!}
                       @if($errors->has("cuenta_contable_recargo_id"))
                        <span class="help-block">{{ $errors->first("cuenta_contable_recargo_id") }}</span>
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