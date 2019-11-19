                <div class="form-group @if($errors->has('historia_cliente_id')) has-error @endif">
                       <label for="historia_cliente_id-field">Historia_cliente_id</label>
                       {!! Form::text("historia_cliente_id", null, array("class" => "form-control", "id" => "historia_cliente_id-field")) !!}
                       @if($errors->has("historia_cliente_id"))
                        <span class="help-block">{{ $errors->first("historia_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_historia_cliente_id')) has-error @endif">
                       <label for="st_historia_cliente_id-field">St_historia_cliente_id</label>
                       {!! Form::text("st_historia_cliente_id", null, array("class" => "form-control", "id" => "st_historia_cliente_id-field")) !!}
                       @if($errors->has("st_historia_cliente_id"))
                        <span class="help-block">{{ $errors->first("st_historia_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('comentario')) has-error @endif">
                       <label for="comentario-field">Comentario</label>
                       {!! Form::text("comentario", null, array("class" => "form-control", "id" => "comentario-field")) !!}
                       @if($errors->has("comentario"))
                        <span class="help-block">{{ $errors->first("comentario") }}</span>
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