                <div class="form-group @if($errors->has('id')) has-error @endif">
                       <label for="id-field">Id</label>
                       {!! Form::text("id", null, array("class" => "form-control", "id" => "id-field")) !!}
                       @if($errors->has("id"))
                        <span class="help-block">{{ $errors->first("id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('horario')) has-error @endif">
                       <label for="horario-field">Horario</label>
                       {!! Form::text("horario", null, array("class" => "form-control", "id" => "horario-field")) !!}
                       @if($errors->has("horario"))
                        <span class="help-block">{{ $errors->first("horario") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('materia')) has-error @endif">
                       <label for="materia-field">Materia</label>
                       {!! Form::text("materia", null, array("class" => "form-control", "id" => "materia-field")) !!}
                       @if($errors->has("materia"))
                        <span class="help-block">{{ $errors->first("materia") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('modulo')) has-error @endif">
                       <label for="modulo-field">Modulo</label>
                       {!! Form::text("modulo", null, array("class" => "form-control", "id" => "modulo-field")) !!}
                       @if($errors->has("modulo"))
                        <span class="help-block">{{ $errors->first("modulo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('instructor')) has-error @endif">
                       <label for="instructor-field">Instructor</label>
                       {!! Form::text("instructor", null, array("class" => "form-control", "id" => "instructor-field")) !!}
                       @if($errors->has("instructor"))
                        <span class="help-block">{{ $errors->first("instructor") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('clave')) has-error @endif">
                       <label for="clave-field">Clave</label>
                       {!! Form::text("clave", null, array("class" => "form-control", "id" => "clave-field")) !!}
                       @if($errors->has("clave"))
                        <span class="help-block">{{ $errors->first("clave") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('apellido_paterno')) has-error @endif">
                       <label for="apellido_paterno-field">Apellido_paterno</label>
                       {!! Form::text("apellido_paterno", null, array("class" => "form-control", "id" => "apellido_paterno-field")) !!}
                       @if($errors->has("apellido_paterno"))
                        <span class="help-block">{{ $errors->first("apellido_paterno") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('apellido_materno')) has-error @endif">
                       <label for="apellido_materno-field">Apellido_materno</label>
                       {!! Form::text("apellido_materno", null, array("class" => "form-control", "id" => "apellido_materno-field")) !!}
                       @if($errors->has("apellido_materno"))
                        <span class="help-block">{{ $errors->first("apellido_materno") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calif_final')) has-error @endif">
                       <label for="calif_final-field">Calif_final</label>
                       {!! Form::text("calif_final", null, array("class" => "form-control", "id" => "calif_final-field")) !!}
                       @if($errors->has("calif_final"))
                        <span class="help-block">{{ $errors->first("calif_final") }}</span>
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