                <div class="form-group @if($errors->has('id_t_estudio_antecedente')) has-error @endif">
                       <label for="id_t_estudio_antecedente-field">Id_t_estudio_antecedente</label>
                       {!! Form::text("id_t_estudio_antecedente", null, array("class" => "form-control", "id" => "id_t_estudio_antecedente-field")) !!}
                       @if($errors->has("id_t_estudio_antecedente"))
                        <span class="help-block">{{ $errors->first("id_t_estudio_antecedente") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('t_estudio_antecedente')) has-error @endif">
                       <label for="t_estudio_antecedente-field">T_estudio_antecedente</label>
                       {!! Form::text("t_estudio_antecedente", null, array("class" => "form-control", "id" => "t_estudio_antecedente-field")) !!}
                       @if($errors->has("t_estudio_antecedente"))
                        <span class="help-block">{{ $errors->first("t_estudio_antecedente") }}</span>
                       @endif
                    </div>