                <div class="form-group @if($errors->has('adeudo_id')) has-error @endif">
                       <label for="adeudo_id-field">Adeudo_id</label>
                       {!! Form::text("adeudo_id", null, array("class" => "form-control", "id" => "adeudo_id-field")) !!}
                       @if($errors->has("adeudo_id"))
                        <span class="help-block">{{ $errors->first("adeudo_id") }}</span>
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
                    <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
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