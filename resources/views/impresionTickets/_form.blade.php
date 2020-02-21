                <div class="form-group @if($errors->has('caja_id')) has-error @endif">
                       <label for="caja_id-field">Caja_id</label>
                       {!! Form::text("caja_id", null, array("class" => "form-control", "id" => "caja_id-field")) !!}
                       @if($errors->has("caja_id"))
                        <span class="help-block">{{ $errors->first("caja_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('pago_id')) has-error @endif">
                       <label for="pago_id-field">Pago_id</label>
                       {!! Form::text("pago_id", null, array("class" => "form-control", "id" => "pago_id-field")) !!}
                       @if($errors->has("pago_id"))
                        <span class="help-block">{{ $errors->first("pago_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('toke_unico')) has-error @endif">
                       <label for="toke_unico-field">Toke_unico</label>
                       {!! Form::text("toke_unico", null, array("class" => "form-control", "id" => "toke_unico-field")) !!}
                       @if($errors->has("toke_unico"))
                        <span class="help-block">{{ $errors->first("toke_unico") }}</span>
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