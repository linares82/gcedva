                <div class="form-group @if($errors->has('prospecto_id')) has-error @endif">
                       <label for="prospecto_id-field">Prospecto_id</label>
                       {!! Form::text("prospecto_id", null, array("class" => "form-control", "id" => "prospecto_id-field")) !!}
                       @if($errors->has("prospecto_id"))
                        <span class="help-block">{{ $errors->first("prospecto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_prospecto_id')) has-error @endif">
                       <label for="st_prospecto_id-field">St_prospecto_id</label>
                       {!! Form::text("st_prospecto_id", null, array("class" => "form-control", "id" => "st_prospecto_id-field")) !!}
                       @if($errors->has("st_prospecto_id"))
                        <span class="help-block">{{ $errors->first("st_prospecto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>