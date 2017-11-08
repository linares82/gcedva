                <div class="form-group @if($errors->has('asistencias_c_id')) has-error @endif">
                       <label for="asistencias_c_id-field">Asistencias_c_id</label>
                       {!! Form::text("asistencias_c_id", null, array("class" => "form-control", "id" => "asistencias_c_id-field")) !!}
                       @if($errors->has("asistencias_c_id"))
                        <span class="help-block">{{ $errors->first("asistencias_c_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('est_asistencia_id')) has-error @endif">
                       <label for="est_asistencia_id-field">Est_asistencia_id</label>
                       {!! Form::text("est_asistencia_id", null, array("class" => "form-control", "id" => "est_asistencia_id-field")) !!}
                       @if($errors->has("est_asistencia_id"))
                        <span class="help-block">{{ $errors->first("est_asistencia_id") }}</span>
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