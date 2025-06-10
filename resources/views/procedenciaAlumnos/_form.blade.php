                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('institucion_procedencia')) has-error @endif">
                       <label for="institucion_procedencia-field">Institucion_procedencia</label>
                       {!! Form::text("institucion_procedencia", null, array("class" => "form-control", "id" => "institucion_procedencia-field")) !!}
                       @if($errors->has("institucion_procedencia"))
                        <span class="help-block">{{ $errors->first("institucion_procedencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('sep_t_estudio_antecedente_id')) has-error @endif">
                       <label for="sep_t_estudio_antecedente_id-field">Sep_t_estudio_antecedente_id</label>
                       {!! Form::text("sep_t_estudio_antecedente_id", null, array("class" => "form-control", "id" => "sep_t_estudio_antecedente_id-field")) !!}
                       @if($errors->has("sep_t_estudio_antecedente_id"))
                        <span class="help-block">{{ $errors->first("sep_t_estudio_antecedente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('estado_id')) has-error @endif">
                       <label for="estado_id-field">Estado_id</label>
                       {!! Form::text("estado_id", null, array("class" => "form-control", "id" => "estado_id-field")) !!}
                       @if($errors->has("estado_id"))
                        <span class="help-block">{{ $errors->first("estado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_inicio')) has-error @endif">
                       <label for="fecha_inicio-field">Fecha_inicio</label>
                       {!! Form::text("fecha_inicio", null, array("class" => "form-control", "id" => "fecha_inicio-field")) !!}
                       @if($errors->has("fecha_inicio"))
                        <span class="help-block">{{ $errors->first("fecha_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_terminacion')) has-error @endif">
                       <label for="fecha_terminacion-field">Fecha_terminacion</label>
                       {!! Form::text("fecha_terminacion", null, array("class" => "form-control", "id" => "fecha_terminacion-field")) !!}
                       @if($errors->has("fecha_terminacion"))
                        <span class="help-block">{{ $errors->first("fecha_terminacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('numero_cedula_string')) has-error @endif">
                       <label for="numero_cedula_string-field">Numero_cedula_string</label>
                       {!! Form::text("numero_cedula_string", null, array("class" => "form-control", "id" => "numero_cedula_string-field")) !!}
                       @if($errors->has("numero_cedula_string"))
                        <span class="help-block">{{ $errors->first("numero_cedula_string") }}</span>
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