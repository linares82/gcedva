                <div class="form-group @if($errors->has('grupo_id')) has-error @endif">
                       <label for="grupo_id-field">Grupo_id</label>
                       {!! Form::text("grupo_id", null, array("class" => "form-control input-sm", "id" => "grupo_id-field")) !!}
                       @if($errors->has("grupo_id"))
                        <span class="help-block">{{ $errors->first("grupo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('periodo_estudio_id')) has-error @endif">
                       <label for="periodo_estudio_id-field">Periodo_estudio_id</label>
                       {!! Form::text("periodo_estudio_id", null, array("class" => "form-control input-sm", "id" => "periodo_estudio_id-field")) !!}
                       @if($errors->has("periodo_estudio_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>