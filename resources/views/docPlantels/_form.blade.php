                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Documento</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_obligatorio')) has-error @endif">
                       <label for="bnd_obligatorio-field">Obligatorio</label>
                       {!! Form::checkbox("bnd_obligatorio", 1, null, [ "id" => "bnd_obligatorio-field"]) !!}
                       @if($errors->has("bnd_obligatorio"))
                        <span class="help-block">{{ $errors->first("bnd_obligatorio") }}</span>
                       @endif
                    </div>
                    