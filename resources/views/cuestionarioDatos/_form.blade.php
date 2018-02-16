                <div class="form-group @if($errors->has('cuestionario_id')) has-error @endif">
                       <label for="cuestionario_id-field">Cuestionario_id</label>
                       {!! Form::text("cuestionario_id", null, array("class" => "form-control input-sm", "id" => "cuestionario_id-field")) !!}
                       @if($errors->has("cuestionario_id"))
                        <span class="help-block">{{ $errors->first("cuestionario_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuestionario_pregunta')) has-error @endif">
                       <label for="cuestionario_pregunta-field">Cuestionario_pregunta</label>
                       {!! Form::text("cuestionario_pregunta", null, array("class" => "form-control input-sm", "id" => "cuestionario_pregunta-field")) !!}
                       @if($errors->has("cuestionario_pregunta"))
                        <span class="help-block">{{ $errors->first("cuestionario_pregunta") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cuestionario_respuesta_id')) has-error @endif">
                       <label for="cuestionario_respuesta_id-field">Cuestionario_respuesta_id</label>
                       {!! Form::text("cuestionario_respuesta_id", null, array("class" => "form-control input-sm", "id" => "cuestionario_respuesta_id-field")) !!}
                       @if($errors->has("cuestionario_respuesta_id"))
                        <span class="help-block">{{ $errors->first("cuestionario_respuesta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control input-sm", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control input-sm", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>