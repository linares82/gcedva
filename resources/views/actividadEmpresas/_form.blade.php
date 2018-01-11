                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Actividad</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                <div class="form-group col-md-4 @if($errors->has('especialidad_id')) has-error @endif">
                    <label for="especialidad_id-field">Especialidad</label>
                    {!! Form::select("especialidad_id", $especialidadList, null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                    @if($errors->has("especialidad_id"))
                    <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                    @endif
                </div>