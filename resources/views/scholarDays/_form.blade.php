                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Dias de la semana para el horario</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    