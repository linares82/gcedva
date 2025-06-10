                <div class="form-group @if($errors->has('id_modalidad')) has-error @endif">
                       <label for="id_modalidad-field">Id_modalidad</label>
                       {!! Form::text("id_modalidad", null, array("class" => "form-control", "id" => "id_modalidad-field")) !!}
                       @if($errors->has("id_modalidad"))
                        <span class="help-block">{{ $errors->first("id_modalidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>