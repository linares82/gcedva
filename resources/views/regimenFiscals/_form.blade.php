                <div class="form-group @if($errors->has('clave')) has-error @endif">
                       <label for="clave-field">Clave</label>
                       {!! Form::text("clave", null, array("class" => "form-control", "id" => "clave-field")) !!}
                       @if($errors->has("clave"))
                        <span class="help-block">{{ $errors->first("clave") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('activo')) has-error @endif">
                       <label for="activo-field">Activo</label>
                       {!! Form::text("activo", null, array("class" => "form-control", "id" => "activo-field")) !!}
                       @if($errors->has("activo"))
                        <span class="help-block">{{ $errors->first("activo") }}</span>
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