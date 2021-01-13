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
                    <div class="form-group @if($errors->has('bnd_fisica')) has-error @endif">
                       <label for="bnd_fisica-field">Bnd_fisica</label>
                       {!! Form::text("bnd_fisica", null, array("class" => "form-control", "id" => "bnd_fisica-field")) !!}
                       @if($errors->has("bnd_fisica"))
                        <span class="help-block">{{ $errors->first("bnd_fisica") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_moral')) has-error @endif">
                       <label for="bnd_moral-field">Bnd_moral</label>
                       {!! Form::text("bnd_moral", null, array("class" => "form-control", "id" => "bnd_moral-field")) !!}
                       @if($errors->has("bnd_moral"))
                        <span class="help-block">{{ $errors->first("bnd_moral") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has(' usu_alta_id')) has-error @endif">
                       <label for=" usu_alta_id-field"> usu_alta_id</label>
                       {!! Form::text(" usu_alta_id", null, array("class" => "form-control", "id" => " usu_alta_id-field")) !!}
                       @if($errors->has(" usu_alta_id"))
                        <span class="help-block">{{ $errors->first(" usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>