                <div class="form-group col-md-4 @if($errors->has('curso_id')) has-error @endif">
                       <label for="curso_id-field">Curso</label>
                       {!! Form::select("curso_id", $list["Curso"], null, array("class" => "form-control", "id" => "curso_id-field")) !!}
                       @if($errors->has("curso_id"))
                        <span class="help-block">{{ $errors->first("curso_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Subcurso</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    