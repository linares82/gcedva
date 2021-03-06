                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_activo')) has-error @endif">
                     <label for="bnd_activo-field">Activo</label>
                     {!! Form::checkbox("bnd_activo", 1, null, [ "id" => "bnd_activo-field"]) !!}
                     @if($errors->has("bnd_activo"))
                      <span class="help-block">{{ $errors->first("bnd_activo") }}</span>
                     @endif
                  </div>
                    