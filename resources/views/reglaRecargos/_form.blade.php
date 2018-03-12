                <div class="form-group @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('dias')) has-error @endif">
                       <label for="dias-field">Dias</label>
                       {!! Form::text("dias", null, array("class" => "form-control", "id" => "dias-field")) !!}
                       @if($errors->has("dias"))
                        <span class="help-block">{{ $errors->first("dias") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('porcentaje')) has-error @endif">
                       <label for="porcentaje-field">Porcentaje</label>
                       {!! Form::text("porcentaje", null, array("class" => "form-control", "id" => "porcentaje-field")) !!}
                       @if($errors->has("porcentaje"))
                        <span class="help-block">{{ $errors->first("porcentaje") }}</span>
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