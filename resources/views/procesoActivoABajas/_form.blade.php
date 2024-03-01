                <div class="form-group @if($errors->has('orden')) has-error @endif">
                       <label for="orden-field">Orden</label>
                       {!! Form::text("orden", null, array("class" => "form-control", "id" => "orden-field")) !!}
                       @if($errors->has("orden"))
                        <span class="help-block">{{ $errors->first("orden") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_mensualidades')) has-error @endif">
                       <label for="bnd_mensualidades-field">Bnd_mensualidades</label>
                       {!! Form::text("bnd_mensualidades", null, array("class" => "form-control", "id" => "bnd_mensualidades-field")) !!}
                       @if($errors->has("bnd_mensualidades"))
                        <span class="help-block">{{ $errors->first("bnd_mensualidades") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cantidad_adeudos')) has-error @endif">
                       <label for="cantidad_adeudos-field">Cantidad_adeudos</label>
                       {!! Form::text("cantidad_adeudos", null, array("class" => "form-control", "id" => "cantidad_adeudos-field")) !!}
                       @if($errors->has("cantidad_adeudos"))
                        <span class="help-block">{{ $errors->first("cantidad_adeudos") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_cliente_id')) has-error @endif">
                       <label for="st_cliente_id-field">St_cliente_id</label>
                       {!! Form::text("st_cliente_id", null, array("class" => "form-control", "id" => "st_cliente_id-field")) !!}
                       @if($errors->has("st_cliente_id"))
                        <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('dias')) has-error @endif">
                       <label for="dias-field">Dias</label>
                       {!! Form::text("dias", null, array("class" => "form-control", "id" => "dias-field")) !!}
                       @if($errors->has("dias"))
                        <span class="help-block">{{ $errors->first("dias") }}</span>
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