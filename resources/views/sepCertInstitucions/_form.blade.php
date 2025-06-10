                <div class="form-group @if($errors->has('id_institucion')) has-error @endif">
                       <label for="id_institucion-field">Id_institucion</label>
                       {!! Form::text("id_institucion", null, array("class" => "form-control", "id" => "id_institucion-field")) !!}
                       @if($errors->has("id_institucion"))
                        <span class="help-block">{{ $errors->first("id_institucion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>