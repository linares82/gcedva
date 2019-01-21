                <div class="form-group col-md-3 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('tpo_examen_id')) has-error @endif">
                       <label for="tpo_examen_id-field">Tipo Examen</label>
                       {!! Form::select("tpo_examen_id", $tpoExamen, null, array("class" => "form-control select_seguridad", "id" => "tpo_examen_id-field")) !!}
                       @if($errors->has("tpo_examen_id"))
                        <span class="help-block">{{ $errors->first("tpo_examen_id") }}</span>
                       @endif
                    </div>
                    