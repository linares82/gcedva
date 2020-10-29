                <div class="form-group @if($errors->has('factura_general_id')) has-error @endif">
                       <label for="factura_general_id-field">Factura_general_uuid</label>
                       {!! Form::select("factura_general_id", $list["FacturaGeneral"], null, array("class" => "form-control", "id" => "factura_general_id-field")) !!}
                       @if($errors->has("factura_general_id"))
                        <span class="help-block">{{ $errors->first("factura_general_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_nombre</label>
                       {!! Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('caja_id')) has-error @endif">
                       <label for="caja_id-field">Caja_fecha</label>
                       {!! Form::select("caja_id", $list["Caja"], null, array("class" => "form-control", "id" => "caja_id-field")) !!}
                       @if($errors->has("caja_id"))
                        <span class="help-block">{{ $errors->first("caja_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('pago_id')) has-error @endif">
                       <label for="pago_id-field">Pago_fecha</label>
                       {!! Form::select("pago_id", $list["Pago"], null, array("class" => "form-control", "id" => "pago_id-field")) !!}
                       @if($errors->has("pago_id"))
                        <span class="help-block">{{ $errors->first("pago_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_incluido')) has-error @endif">
                       <label for="bnd_incluido-field">Bnd_incluido</label>
                       {!! Form::text("bnd_incluido", null, array("class" => "form-control", "id" => "bnd_incluido-field")) !!}
                       @if($errors->has("bnd_incluido"))
                        <span class="help-block">{{ $errors->first("bnd_incluido") }}</span>
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