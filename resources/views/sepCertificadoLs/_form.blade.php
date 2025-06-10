                <div class="form-group @if($errors->has('sep_certificado_id')) has-error @endif">
                       <label for="sep_certificado_id-field">Sep_certificado_id</label>
                       {!! Form::text("sep_certificado_id", null, array("class" => "form-control", "id" => "sep_certificado_id-field")) !!}
                       @if($errors->has("sep_certificado_id"))
                        <span class="help-block">{{ $errors->first("sep_certificado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('hacademica_id_id')) has-error @endif">
                       <label for="hacademica_id_id-field">Hacademica_id_id</label>
                       {!! Form::text("hacademica_id_id", null, array("class" => "form-control", "id" => "hacademica_id_id-field")) !!}
                       @if($errors->has("hacademica_id_id"))
                        <span class="help-block">{{ $errors->first("hacademica_id_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('sep_cert_id')) has-error @endif">
                       <label for="sep_cert_id-field">Sep_cert_id</label>
                       {!! Form::text("sep_cert_id", null, array("class" => "form-control", "id" => "sep_cert_id-field")) !!}
                       @if($errors->has("sep_cert_id"))
                        <span class="help-block">{{ $errors->first("sep_cert_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_expedicion')) has-error @endif">
                       <label for="fecha_expedicion-field">Fecha_expedicion</label>
                       {!! Form::text("fecha_expedicion", null, array("class" => "form-control", "id" => "fecha_expedicion-field")) !!}
                       @if($errors->has("fecha_expedicion"))
                        <span class="help-block">{{ $errors->first("fecha_expedicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('id_carrera')) has-error @endif">
                       <label for="id_carrera-field">Id_carrera</label>
                       {!! Form::text("id_carrera", null, array("class" => "form-control", "id" => "id_carrera-field")) !!}
                       @if($errors->has("id_carrera"))
                        <span class="help-block">{{ $errors->first("id_carrera") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('id_asignatura')) has-error @endif">
                       <label for="id_asignatura-field">Id_asignatura</label>
                       {!! Form::text("id_asignatura", null, array("class" => "form-control", "id" => "id_asignatura-field")) !!}
                       @if($errors->has("id_asignatura"))
                        <span class="help-block">{{ $errors->first("id_asignatura") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('numero_asignaturas_cursadas')) has-error @endif">
                       <label for="numero_asignaturas_cursadas-field">Numero_asignaturas_cursadas</label>
                       {!! Form::text("numero_asignaturas_cursadas", null, array("class" => "form-control", "id" => "numero_asignaturas_cursadas-field")) !!}
                       @if($errors->has("numero_asignaturas_cursadas"))
                        <span class="help-block">{{ $errors->first("numero_asignaturas_cursadas") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('promedio_general')) has-error @endif">
                       <label for="promedio_general-field">Promedio_general</label>
                       {!! Form::text("promedio_general", null, array("class" => "form-control", "id" => "promedio_general-field")) !!}
                       @if($errors->has("promedio_general"))
                        <span class="help-block">{{ $errors->first("promedio_general") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('sep_cert_observacion_id')) has-error @endif">
                       <label for="sep_cert_observacion_id-field">Sep_cert_observacion_id</label>
                       {!! Form::text("sep_cert_observacion_id", null, array("class" => "form-control", "id" => "sep_cert_observacion_id-field")) !!}
                       @if($errors->has("sep_cert_observacion_id"))
                        <span class="help-block">{{ $errors->first("sep_cert_observacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_descargar')) has-error @endif">
                       <label for="bnd_descargar-field">Bnd_descargar</label>
                       {!! Form::text("bnd_descargar", null, array("class" => "form-control", "id" => "bnd_descargar-field")) !!}
                       @if($errors->has("bnd_descargar"))
                        <span class="help-block">{{ $errors->first("bnd_descargar") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>