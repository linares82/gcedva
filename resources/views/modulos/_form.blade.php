                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('depende_id')) has-error @endif">
                       <label for="depende_id-field">Depende_id</label>
                       {!! Form::text("depende_id", null, array("class" => "form-control input-sm", "id" => "depende_id-field")) !!}
                       @if($errors->has("depende_id"))
                        <span class="help-block">{{ $errors->first("depende_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control input-sm", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control input-sm", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>