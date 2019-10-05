                <div class="form-group @if($errors->has('historia_cliente_id')) has-error @endif">
                       <label for="historia_cliente_id-field">Historia_cliente_id</label>
                       {!! Form::text("historia_cliente_id", null, array("class" => "form-control", "id" => "historia_cliente_id-field")) !!}
                       @if($errors->has("historia_cliente_id"))
                        <span class="help-block">{{ $errors->first("historia_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('inscripcion_id')) has-error @endif">
                       <label for="inscripcion_id-field">Inscripcion_id</label>
                       {!! Form::text("inscripcion_id", null, array("class" => "form-control", "id" => "inscripcion_id-field")) !!}
                       @if($errors->has("inscripcion_id"))
                        <span class="help-block">{{ $errors->first("inscripcion_id") }}</span>
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