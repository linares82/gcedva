                <div class="form-group col-md-4 @if($errors->has('st_cuestionario_id')) has-error @endif">
                       <label for="st_cuestionario_id-field">Estatus</label>
                       {!! Form::select("st_cuestionario_id", $list["StCuestionario"], null, array("class" => "form-control select_seguridad", "id" => "st_cuestionario_id-field")) !!}
                       @if($errors->has("st_cuestionario_id"))
                        <span class="help-block">{{ $errors->first("st_cuestionario_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Cuestionario</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    