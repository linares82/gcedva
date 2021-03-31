                <div class="form-group @if($errors->has('peticion_multipagos_id')) has-error @endif">
                       <label for="peticion_multipagos_id-field">Peticion_multipagos_id</label>
                       {!! Form::text("peticion_multipagos_id", null, array("class" => "form-control", "id" => "peticion_multipagos_id-field")) !!}
                       @if($errors->has("peticion_multipagos_id"))
                        <span class="help-block">{{ $errors->first("peticion_multipagos_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('campo')) has-error @endif">
                       <label for="campo-field">Campo</label>
                       {!! Form::text("campo", null, array("class" => "form-control", "id" => "campo-field")) !!}
                       @if($errors->has("campo"))
                        <span class="help-block">{{ $errors->first("campo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('valor_anterior')) has-error @endif">
                       <label for="valor_anterior-field">Valor_anterior</label>
                       {!! Form::text("valor_anterior", null, array("class" => "form-control", "id" => "valor_anterior-field")) !!}
                       @if($errors->has("valor_anterior"))
                        <span class="help-block">{{ $errors->first("valor_anterior") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('valor')) has-error @endif">
                       <label for="valor-field">Valor</label>
                       {!! Form::text("valor", null, array("class" => "form-control", "id" => "valor-field")) !!}
                       @if($errors->has("valor"))
                        <span class="help-block">{{ $errors->first("valor") }}</span>
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