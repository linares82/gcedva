                <div class="form-group @if($errors->has('mueble_id')) has-error @endif">
                       <label for="mueble_id-field">Mueble_id</label>
                       {!! Form::select("mueble_id", $list["Mueble"], null, array("class" => "form-control", "id" => "mueble_id-field")) !!}
                       @if($errors->has("mueble_id"))
                        <span class="help-block">{{ $errors->first("mueble_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_mueble_id')) has-error @endif">
                       <label for="st_mueble_id-field">St_mueble_name</label>
                       {!! Form::select("st_mueble_id", $list["StMueble"], null, array("class" => "form-control", "id" => "st_mueble_id-field")) !!}
                       @if($errors->has("st_mueble_id"))
                        <span class="help-block">{{ $errors->first("st_mueble_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('obs')) has-error @endif">
                       <label for="obs-field">Obs</label>
                       {!! Form::text("obs", null, array("class" => "form-control", "id" => "obs-field")) !!}
                       @if($errors->has("obs"))
                        <span class="help-block">{{ $errors->first("obs") }}</span>
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