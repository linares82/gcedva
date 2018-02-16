                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_nombre</label>
                       {!! Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ccuestionario_id')) has-error @endif">
                       <label for="ccuestionario_id-field">Ccuestionario_name</label>
                       {!! Form::select("ccuestionario_id", $list["Ccuestionario"], null, array("class" => "form-control", "id" => "ccuestionario_id-field")) !!}
                       @if($errors->has("ccuestionario_id"))
                        <span class="help-block">{{ $errors->first("ccuestionario_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ccuestionario_pregunta_id')) has-error @endif">
                       <label for="ccuestionario_pregunta_id-field">Ccuestionario_pregunta_id</label>
                       {!! Form::text("ccuestionario_pregunta_id", null, array("class" => "form-control", "id" => "ccuestionario_pregunta_id-field")) !!}
                       @if($errors->has("ccuestionario_pregunta_id"))
                        <span class="help-block">{{ $errors->first("ccuestionario_pregunta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ccuestionario_respuesta_id')) has-error @endif">
                       <label for="ccuestionario_respuesta_id-field">Ccuestionario_respuesta_id</label>
                       {!! Form::text("ccuestionario_respuesta_id", null, array("class" => "form-control", "id" => "ccuestionario_respuesta_id-field")) !!}
                       @if($errors->has("ccuestionario_respuesta_id"))
                        <span class="help-block">{{ $errors->first("ccuestionario_respuesta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('clave')) has-error @endif">
                       <label for="clave-field">Clave</label>
                       {!! Form::text("clave", null, array("class" => "form-control", "id" => "clave-field")) !!}
                       @if($errors->has("clave"))
                        <span class="help-block">{{ $errors->first("clave") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>