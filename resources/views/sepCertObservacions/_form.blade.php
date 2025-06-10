                <div class="form-group @if($errors->has('id_observacion')) has-error @endif">
                       <label for="id_observacion-field">Id_observacion</label>
                       {!! Form::text("id_observacion", null, array("class" => "form-control", "id" => "id_observacion-field")) !!}
                       @if($errors->has("id_observacion"))
                        <span class="help-block">{{ $errors->first("id_observacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion_corta')) has-error @endif">
                       <label for="descripcion_corta-field">Descripcion_corta</label>
                       {!! Form::text("descripcion_corta", null, array("class" => "form-control", "id" => "descripcion_corta-field")) !!}
                       @if($errors->has("descripcion_corta"))
                        <span class="help-block">{{ $errors->first("descripcion_corta") }}</span>
                       @endif
                    </div>