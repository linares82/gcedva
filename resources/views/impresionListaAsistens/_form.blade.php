                <div class="form-group @if($errors->has('asignacion_id')) has-error @endif">
                       <label for="asignacion_id-field">Asignacion_id</label>
                       {!! Form::text("asignacion_id", null, array("class" => "form-control", "id" => "asignacion_id-field")) !!}
                       @if($errors->has("asignacion_id"))
                        <span class="help-block">{{ $errors->first("asignacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('inscritos')) has-error @endif">
                       <label for="inscritos-field">Inscritos</label>
                       {!! Form::text("inscritos", null, array("class" => "form-control", "id" => "inscritos-field")) !!}
                       @if($errors->has("inscritos"))
                        <span class="help-block">{{ $errors->first("inscritos") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_f')) has-error @endif">
                       <label for="fecha_f-field">Fecha_f</label>
                       {!! Form::text("fecha_f", null, array("class" => "form-control", "id" => "fecha_f-field")) !!}
                       @if($errors->has("fecha_f"))
                        <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_t')) has-error @endif">
                       <label for="fecha_t-field">Fecha_t</label>
                       {!! Form::text("fecha_t", null, array("class" => "form-control", "id" => "fecha_t-field")) !!}
                       @if($errors->has("fecha_t"))
                        <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('token')) has-error @endif">
                       <label for="token-field">Token</label>
                       {!! Form::text("token", null, array("class" => "form-control", "id" => "token-field")) !!}
                       @if($errors->has("token"))
                        <span class="help-block">{{ $errors->first("token") }}</span>
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