                <div class="form-group @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nombre2')) has-error @endif">
                       <label for="nombre2-field">Nombre2</label>
                       {!! Form::text("nombre2", null, array("class" => "form-control", "id" => "nombre2-field")) !!}
                       @if($errors->has("nombre2"))
                        <span class="help-block">{{ $errors->first("nombre2") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ape_paterno')) has-error @endif">
                       <label for="ape_paterno-field">Ape_paterno</label>
                       {!! Form::text("ape_paterno", null, array("class" => "form-control", "id" => "ape_paterno-field")) !!}
                       @if($errors->has("ape_paterno"))
                        <span class="help-block">{{ $errors->first("ape_paterno") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ape_materno')) has-error @endif">
                       <label for="ape_materno-field">Ape_materno</label>
                       {!! Form::text("ape_materno", null, array("class" => "form-control", "id" => "ape_materno-field")) !!}
                       @if($errors->has("ape_materno"))
                        <span class="help-block">{{ $errors->first("ape_materno") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fel_fijo')) has-error @endif">
                       <label for="fel_fijo-field">Fel_fijo</label>
                       {!! Form::text("fel_fijo", null, array("class" => "form-control", "id" => "fel_fijo-field")) !!}
                       @if($errors->has("fel_fijo"))
                        <span class="help-block">{{ $errors->first("fel_fijo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mail')) has-error @endif">
                       <label for="mail-field">Mail</label>
                       {!! Form::text("mail", null, array("class" => "form-control", "id" => "mail-field")) !!}
                       @if($errors->has("mail"))
                        <span class="help-block">{{ $errors->first("mail") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_id</label>
                       {!! Form::text("plantel_id", null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('medio_id')) has-error @endif">
                       <label for="medio_id-field">Medio_id</label>
                       {!! Form::text("medio_id", null, array("class" => "form-control", "id" => "medio_id-field")) !!}
                       @if($errors->has("medio_id"))
                        <span class="help-block">{{ $errors->first("medio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('empleado_id')) has-error @endif">
                       <label for="empleado_id-field">Empleado_id</label>
                       {!! Form::text("empleado_id", null, array("class" => "form-control", "id" => "empleado_id-field")) !!}
                       @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('observaciones')) has-error @endif">
                       <label for="observaciones-field">Observaciones</label>
                       {!! Form::text("observaciones", null, array("class" => "form-control", "id" => "observaciones-field")) !!}
                       @if($errors->has("observaciones"))
                        <span class="help-block">{{ $errors->first("observaciones") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('estado_id')) has-error @endif">
                       <label for="estado_id-field">Estado_id</label>
                       {!! Form::text("estado_id", null, array("class" => "form-control", "id" => "estado_id-field")) !!}
                       @if($errors->has("estado_id"))
                        <span class="help-block">{{ $errors->first("estado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('municipio_id')) has-error @endif">
                       <label for="municipio_id-field">Municipio_id</label>
                       {!! Form::text("municipio_id", null, array("class" => "form-control", "id" => "municipio_id-field")) !!}
                       @if($errors->has("municipio_id"))
                        <span class="help-block">{{ $errors->first("municipio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_cliente_id')) has-error @endif">
                       <label for="st_cliente_id-field">St_cliente_id</label>
                       {!! Form::text("st_cliente_id", null, array("class" => "form-control", "id" => "st_cliente_id-field")) !!}
                       @if($errors->has("st_cliente_id"))
                        <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('especialidad_id')) has-error @endif">
                       <label for="especialidad_id-field">Especialidad_id</label>
                       {!! Form::text("especialidad_id", null, array("class" => "form-control", "id" => "especialidad_id-field")) !!}
                       @if($errors->has("especialidad_id"))
                        <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('especialidad_id')) has-error @endif">
                       <label for="especialidad_id-field">Especialidad_id</label>
                       {!! Form::text("especialidad_id", null, array("class" => "form-control", "id" => "especialidad_id-field")) !!}
                       @if($errors->has("especialidad_id"))
                        <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('especialidad2_id')) has-error @endif">
                       <label for="especialidad2_id-field">Especialidad2_id</label>
                       {!! Form::text("especialidad2_id", null, array("class" => "form-control", "id" => "especialidad2_id-field")) !!}
                       @if($errors->has("especialidad2_id"))
                        <span class="help-block">{{ $errors->first("especialidad2_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('especialidad3_id')) has-error @endif">
                       <label for="especialidad3_id-field">Especialidad3_id</label>
                       {!! Form::text("especialidad3_id", null, array("class" => "form-control", "id" => "especialidad3_id-field")) !!}
                       @if($errors->has("especialidad3_id"))
                        <span class="help-block">{{ $errors->first("especialidad3_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('especialidad4_id')) has-error @endif">
                       <label for="especialidad4_id-field">Especialidad4_id</label>
                       {!! Form::text("especialidad4_id", null, array("class" => "form-control", "id" => "especialidad4_id-field")) !!}
                       @if($errors->has("especialidad4_id"))
                        <span class="help-block">{{ $errors->first("especialidad4_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nivel_id')) has-error @endif">
                       <label for="nivel_id-field">Nivel_id</label>
                       {!! Form::text("nivel_id", null, array("class" => "form-control", "id" => "nivel_id-field")) !!}
                       @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('diplomado_id')) has-error @endif">
                       <label for="diplomado_id-field">Diplomado_id</label>
                       {!! Form::text("diplomado_id", null, array("class" => "form-control", "id" => "diplomado_id-field")) !!}
                       @if($errors->has("diplomado_id"))
                        <span class="help-block">{{ $errors->first("diplomado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('curso_id')) has-error @endif">
                       <label for="curso_id-field">Curso_id</label>
                       {!! Form::text("curso_id", null, array("class" => "form-control", "id" => "curso_id-field")) !!}
                       @if($errors->has("curso_id"))
                        <span class="help-block">{{ $errors->first("curso_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('otro_id')) has-error @endif">
                       <label for="otro_id-field">Otro_id</label>
                       {!! Form::text("otro_id", null, array("class" => "form-control", "id" => "otro_id-field")) !!}
                       @if($errors->has("otro_id"))
                        <span class="help-block">{{ $errors->first("otro_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('grado_id')) has-error @endif">
                       <label for="grado_id-field">Grado_id</label>
                       {!! Form::text("grado_id", null, array("class" => "form-control", "id" => "grado_id-field")) !!}
                       @if($errors->has("grado_id"))
                        <span class="help-block">{{ $errors->first("grado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('subdiplomado_id')) has-error @endif">
                       <label for="subdiplomado_id-field">Subdiplomado_id</label>
                       {!! Form::text("subdiplomado_id", null, array("class" => "form-control", "id" => "subdiplomado_id-field")) !!}
                       @if($errors->has("subdiplomado_id"))
                        <span class="help-block">{{ $errors->first("subdiplomado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('subotro_id')) has-error @endif">
                       <label for="subotro_id-field">Subotro_id</label>
                       {!! Form::text("subotro_id", null, array("class" => "form-control", "id" => "subotro_id-field")) !!}
                       @if($errors->has("subotro_id"))
                        <span class="help-block">{{ $errors->first("subotro_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('turno_id')) has-error @endif">
                       <label for="turno_id-field">Turno_id</label>
                       {!! Form::text("turno_id", null, array("class" => "form-control", "id" => "turno_id-field")) !!}
                       @if($errors->has("turno_id"))
                        <span class="help-block">{{ $errors->first("turno_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('turno2_id')) has-error @endif">
                       <label for="turno2_id-field">Turno2_id</label>
                       {!! Form::text("turno2_id", null, array("class" => "form-control", "id" => "turno2_id-field")) !!}
                       @if($errors->has("turno2_id"))
                        <span class="help-block">{{ $errors->first("turno2_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('turno3_id')) has-error @endif">
                       <label for="turno3_id-field">Turno3_id</label>
                       {!! Form::text("turno3_id", null, array("class" => "form-control", "id" => "turno3_id-field")) !!}
                       @if($errors->has("turno3_id"))
                        <span class="help-block">{{ $errors->first("turno3_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('turno4_id')) has-error @endif">
                       <label for="turno4_id-field">Turno4_id</label>
                       {!! Form::text("turno4_id", null, array("class" => "form-control", "id" => "turno4_id-field")) !!}
                       @if($errors->has("turno4_id"))
                        <span class="help-block">{{ $errors->first("turno4_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ofertum_id')) has-error @endif">
                       <label for="ofertum_id-field">Ofertum_id</label>
                       {!! Form::text("ofertum_id", null, array("class" => "form-control", "id" => "ofertum_id-field")) !!}
                       @if($errors->has("ofertum_id"))
                        <span class="help-block">{{ $errors->first("ofertum_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-field">Matricula</label>
                       {!! Form::text("matricula", null, array("class" => "form-control", "id" => "matricula-field")) !!}
                       @if($errors->has("matricula"))
                        <span class="help-block">{{ $errors->first("matricula") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ciclo_id')) has-error @endif">
                       <label for="ciclo_id-field">Ciclo_id</label>
                       {!! Form::text("ciclo_id", null, array("class" => "form-control", "id" => "ciclo_id-field")) !!}
                       @if($errors->has("ciclo_id"))
                        <span class="help-block">{{ $errors->first("ciclo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('empresa_id')) has-error @endif">
                       <label for="empresa_id-field">Empresa_id</label>
                       {!! Form::text("empresa_id", null, array("class" => "form-control", "id" => "empresa_id-field")) !!}
                       @if($errors->has("empresa_id"))
                        <span class="help-block">{{ $errors->first("empresa_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cve_cliente')) has-error @endif">
                       <label for="cve_cliente-field">Cve_cliente</label>
                       {!! Form::text("cve_cliente", null, array("class" => "form-control", "id" => "cve_cliente-field")) !!}
                       @if($errors->has("cve_cliente"))
                        <span class="help-block">{{ $errors->first("cve_cliente") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tel_cel')) has-error @endif">
                       <label for="tel_cel-field">Tel_cel</label>
                       {!! Form::text("tel_cel", null, array("class" => "form-control", "id" => "tel_cel-field")) !!}
                       @if($errors->has("tel_cel"))
                        <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('paise_id')) has-error @endif">
                       <label for="paise_id-field">Paise_id</label>
                       {!! Form::text("paise_id", null, array("class" => "form-control", "id" => "paise_id-field")) !!}
                       @if($errors->has("paise_id"))
                        <span class="help-block">{{ $errors->first("paise_id") }}</span>
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