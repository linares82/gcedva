                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_baja')) has-error @endif">
                       <label for="bnd_baja-field">Bnd_baja</label>
                       {!! Form::text("bnd_baja", null, array("class" => "form-control", "id" => "bnd_baja-field")) !!}
                       @if($errors->has("bnd_baja"))
                        <span class="help-block">{{ $errors->first("bnd_baja") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_baja')) has-error @endif">
                       <label for="fecha_baja-field">Fecha_baja</label>
                       {!! Form::text("fecha_baja", null, array("class" => "form-control", "id" => "fecha_baja-field")) !!}
                       @if($errors->has("fecha_baja"))
                        <span class="help-block">{{ $errors->first("fecha_baja") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_alta')) has-error @endif">
                       <label for="bnd_alta-field">Bnd_alta</label>
                       {!! Form::text("bnd_alta", null, array("class" => "form-control", "id" => "bnd_alta-field")) !!}
                       @if($errors->has("bnd_alta"))
                        <span class="help-block">{{ $errors->first("bnd_alta") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_alta')) has-error @endif">
                       <label for="fecha_alta-field">Fecha_alta</label>
                       {!! Form::text("fecha_alta", null, array("class" => "form-control", "id" => "fecha_alta-field")) !!}
                       @if($errors->has("fecha_alta"))
                        <span class="help-block">{{ $errors->first("fecha_alta") }}</span>
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