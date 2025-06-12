                    <div class="form-group col-md-4 @if($errors->has('calificacion_nueva')) has-error @endif">
                       <label for="calificacion_nueva-field">Calificacion Nueva</label>
                       {!! Form::hidden("calificacion_ponderacion_id", $calificacion_ponderacion_id, array("class" => "form-control", "id" => "calificacion_ponderacion_id-field")) !!}
                       {!! Form::text("calificacion_nueva", null, array("class" => "form-control", "id" => "calificacion_nueva-field")) !!}
                       @if($errors->has("calificacion_nueva"))
                        <span class="help-block">{{ $errors->first("calificacion_nueva") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-8 @if($errors->has('justificacion')) has-error @endif">
                       <label for="justificacion-field">Justificacion</label>
                       {!! Form::textArea("justificacion", null, array("class" => "form-control", "id" => "justificacion-field",'rows'=>3)) !!}
                       @if($errors->has("justificacion"))
                        <span class="help-block">{{ $errors->first("justificacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-8 @if($errors->has('observacion')) has-error @endif">
                       <label for="observacion-field">Observacion</label>
                       {!! Form::textArea("observacion", null, array("class" => "form-control", "id" => "observacion-field",'rows'=>3)) !!}
                       @if($errors->has("observacion"))
                        <span class="help-block">{{ $errors->first("observacion") }}</span>
                       @endif
                    </div>