
                    <div class="form-group col-md-4 @if($errors->has('clave')) has-error @endif">
                       <label for="clave-field">Clave</label>
                       {!! Form::hidden("ccuestionario_id", $cuestionario, array("class" => "form-control input-sm", "id" => "ccuestionario_id-field")) !!}
                       {!! Form::hidden("ccuestionario_preguntum_id", $pregunta, array("class" => "form-control input-sm", "id" => "ccuestionario_pregunta_id-field")) !!}
                       {!! Form::text("clave", null, array("class" => "form-control", "id" => "clave-field")) !!}
                       @if($errors->has("clave"))
                        <span class="help-block">{{ $errors->first("clave") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Respuesta</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    