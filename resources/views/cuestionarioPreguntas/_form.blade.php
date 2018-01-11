                    <div class="form-group col-md-4 @if($errors->has('numero')) has-error @endif">
                       <label for="numero-field">Número</label>
                       {!! Form::text("numero", null, array("class" => "form-control", "id" => "numero-field")) !!}
                       @if($errors->has("numero"))
                        <span class="help-block">{{ $errors->first("numero") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Pregunta</label>
                       {!! Form::hidden("cuestionario_id", $cuestionario, array("class" => "form-control", "id" => "cuestionario_id-field")) !!}
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    