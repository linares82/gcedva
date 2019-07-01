                <div class="form-group @if($errors->has('cuenta_efectivo_id')) has-error @endif">
                       <label for="cuenta_efectivo_id-field">Cuenta_efectivo_id</label>
                       {!! Form::text("cuenta_efectivo_id", null, array("class" => "form-control", "id" => "cuenta_efectivo_id-field")) !!}
                       @if($errors->has("cuenta_efectivo_id"))
                        <span class="help-block">{{ $errors->first("cuenta_efectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('saldo_inicial')) has-error @endif">
                       <label for="saldo_inicial-field">Saldo_inicial</label>
                       {!! Form::text("saldo_inicial", null, array("class" => "form-control", "id" => "saldo_inicial-field")) !!}
                       @if($errors->has("saldo_inicial"))
                        <span class="help-block">{{ $errors->first("saldo_inicial") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('saldo_actualizado')) has-error @endif">
                       <label for="saldo_actualizado-field">Saldo_actualizado</label>
                       {!! Form::text("saldo_actualizado", null, array("class" => "form-control", "id" => "saldo_actualizado-field")) !!}
                       @if($errors->has("saldo_actualizado"))
                        <span class="help-block">{{ $errors->first("saldo_actualizado") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_saldo_inicial')) has-error @endif">
                       <label for="fecha_saldo_inicial-field">Fecha_saldo_inicial</label>
                       {!! Form::text("fecha_saldo_inicial", null, array("class" => "form-control", "id" => "fecha_saldo_inicial-field")) !!}
                       @if($errors->has("fecha_saldo_inicial"))
                        <span class="help-block">{{ $errors->first("fecha_saldo_inicial") }}</span>
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